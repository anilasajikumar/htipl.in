<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\InvoiceInstallment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Yajra\Datatables\Datatables;
use PDF;

class InvoiceController extends Controller
{
    public function index()
    {
        return view('admin.invoice.index');
    }

    public function studentInvoiceData(Request $request)
    {
        $query = DB::table('student_courses')
            ->leftJoin('invoices', 'student_courses.id', '=', 'invoices.student_course_id')
            ->select([
                'student_courses.id',
                'student_courses.name',
                'student_courses.register_number',
                'student_courses.email',
                'student_courses.mobile',
                'invoices.id as invoice_id',
                'invoices.invoice_date',
                'invoices.total_amount',
                'invoices.status',
            ]);

        if ($request->month) {
            $query->whereMonth('invoices.invoice_date', $request->month);
        }
        if ($request->year) {
            $query->whereYear('invoices.invoice_date', $request->year);
        }

        return Datatables::of($query)
            ->addColumn('invoice_action', function ($row) {
                if ($row->invoice_id) {
                    return '
                        <a href="'.route('invoice.view', $row->invoice_id).'" class="btn btn-info btn-sm">View</a>
                        <a href="'.route('invoice.edit', $row->invoice_id).'" class="btn btn-warning btn-sm">Edit</a>
                        <a href="'.route('invoice.download', $row->invoice_id).'" class="btn btn-danger btn-sm">Download</a>
                        <a href="'.route('invoice.send.mail', $row->invoice_id).'" class="btn btn-primary btn-sm">Send Mail</a>
                    ';
                }
                return '<a href="'.route('invoice.create', $row->id).'" class="btn btn-success btn-sm">Create Invoice</a>';
            })
            ->rawColumns(['invoice_action'])
            ->make(true);
    }

    public function create($id)
    {
        $student = DB::table('student_courses as sc')
            ->leftJoin('online_courses as oc', 'oc.id', '=', 'sc.center_online_courses_id')
            ->select('sc.id', 'sc.name', 'sc.register_number', 'sc.email', 'sc.mobile', 'oc.course_name', 'oc.course_fee')
            ->where('sc.id', $id)->first();

        if (!$student) {
            return redirect()->back()->with('error', 'Student not found');
        }
        return view('admin.invoice.create', compact('student'));
    }

    public function store(Request $request)
    {
        DB::transaction(function () use ($request) {
            $invoice = Invoice::create([
                'student_course_id' => $request->student_course_id,
                'invoice_number'    => 'INV' . time(),
                'invoice_date'      => $request->invoice_date,
                'sub_total'         => $request->sub_total,
                'discount'          => $request->discount ?? 0,
                'tax'               => $request->tax ?? 0,
                'total_amount'      => $request->total_amount,
                'offer_name'        => $request->offer_name,
                'status'            => $request->status,
            ]);

            if ($request->has('installments')) {
                $dates   = $request->installments['date'] ?? [];
                $amounts = $request->installments['amount'] ?? [];
                $paid    = $request->installments['is_paid'] ?? [];

                foreach ($dates as $key => $date) {
                    if (!empty($date) && !empty($amounts[$key])) {
                        InvoiceInstallment::create([
                            'invoice_id'       => $invoice->id,
                            'installment_date' => $date,
                            'amount'           => $amounts[$key],
                            'is_paid'          => $paid[$key] ?? 0,
                        ]);
                    }
                }
            }
        });

        return redirect()->route('invoice.index')->with('success', 'Invoice Created');
    }

    public function view($id)
    {
        $invoice = DB::table('invoices')
            ->leftJoin('student_courses', 'student_courses.id', '=', 'invoices.student_course_id')
            ->select('invoices.*', 'student_courses.name as student_name', 'student_courses.email as student_email',
                'student_courses.mobile as student_mobile', 'student_courses.register_number')
            ->where('invoices.id', $id)->first();

        $installments = DB::table('invoice_installments')->where('invoice_id', $id)->orderBy('installment_date')->get();
        $account      = DB::table('invoice_account_settings')->first();

        return view('admin.invoice.view', compact('invoice', 'account', 'installments'));
    }

    public function download($id)
    {
        $invoice = DB::table('invoices')
            ->leftJoin('student_courses', 'student_courses.id', '=', 'invoices.student_course_id')
            ->leftJoin('online_courses', 'online_courses.id', '=', 'student_courses.center_online_courses_id')
            ->select('invoices.*', 'student_courses.name as student_name', 'student_courses.email as student_email',
                'student_courses.mobile as student_mobile', 'student_courses.register_number', 'online_courses.course_name')
            ->where('invoices.id', $id)->first();

        if (!$invoice) return redirect()->back()->with('error', 'Invoice not found');

        $installments = DB::table('invoice_installments')->where('invoice_id', $id)->get();
        $account      = DB::table('invoice_account_settings')->first();

        $pdf = Pdf::loadView('admin.invoice.download', compact('invoice', 'installments', 'account'));
        return $pdf->download('Invoice_' . $invoice->invoice_number . '.pdf');
    }

    public function export(Request $request)
    {
        $query = Invoice::leftJoin('student_courses', 'student_courses.id', '=', 'invoices.student_course_id')
            ->select('student_courses.register_number', 'student_courses.name', 'student_courses.email',
                'student_courses.mobile', 'invoices.invoice_date', 'invoices.total_amount', 'invoices.status');

        if ($request->month) $query->whereMonth('invoices.invoice_date', $request->month);
        if ($request->year)  $query->whereYear('invoices.invoice_date', $request->year);

        $data = $query->get();

        $response = new StreamedResponse(function () use ($data) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Reg No', 'Name', 'Email', 'Mobile', 'Invoice Date', 'Total Amount', 'Status']);
            foreach ($data as $row) {
                fputcsv($handle, [$row->register_number, $row->name, $row->email, $row->mobile, $row->invoice_date, $row->total_amount, $row->status]);
            }
            fclose($handle);
        });

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename=invoices.csv');
        return $response;
    }

    public function sendMail($id)
    {
        $invoice = DB::table('invoices')
            ->leftJoin('student_courses', 'student_courses.id', '=', 'invoices.student_course_id')
            ->select('invoices.*', 'student_courses.name', 'student_courses.email', 'student_courses.mobile', 'student_courses.register_number')
            ->where('invoices.id', $id)->first();

        if (!$invoice) return redirect()->back()->with('error', 'Invoice not found');

        $installments = DB::table('invoice_installments')->where('invoice_id', $id)->get();
        $account      = DB::table('invoice_account_settings')->first();

        $html = view('admin.invoice.download', compact('invoice', 'installments', 'account'))->render();

        Mail::send('email.invoice_mail', compact('invoice', 'installments', 'account'), function ($message) use ($invoice, $html) {
            $message->to($invoice->email);
            $message->subject('Your Invoice - ' . $invoice->invoice_number);
            $message->attachData($html, 'Invoice_' . $invoice->invoice_number . '.html', ['mime' => 'text/html']);
        });

        return redirect()->back()->with('success', 'Invoice Sent Successfully');
    }

    public function edit($id)
    {
        $invoice = DB::table('invoices')
            ->leftJoin('student_courses', 'student_courses.id', '=', 'invoices.student_course_id')
            ->select('invoices.*', 'student_courses.id as student_id', 'student_courses.name', 'student_courses.email',
                'student_courses.mobile', 'student_courses.register_number')
            ->where('invoices.id', $id)->first();

        if (!$invoice) return redirect()->back()->with('error', 'Invoice not found');

        $invoiceModel = Invoice::with('installments')->findOrFail($id);

        $student = (object)[
            'id' => $invoice->student_id, 'name' => $invoice->name,
            'email' => $invoice->email, 'mobile' => $invoice->mobile,
            'register_number' => $invoice->register_number,
        ];

        return view('admin.invoice.create', ['student' => $student, 'invoice' => $invoiceModel]);
    }

    public function update(Request $request, $id)
    {
        DB::transaction(function () use ($request, $id) {
            $invoice = Invoice::findOrFail($id);
            $invoice->update([
                'invoice_number' => $request->invoice_number,
                'invoice_date'   => $request->invoice_date,
                'sub_total'      => $request->sub_total,
                'discount'       => $request->discount ?? 0,
                'tax'            => $request->tax ?? 0,
                'total_amount'   => $request->total_amount,
                'offer_name'     => $request->offer_name,
                'status'         => $request->status,
            ]);

            InvoiceInstallment::where('invoice_id', $id)->delete();

            if ($request->has('installments')) {
                $dates   = $request->installments['date'] ?? [];
                $amounts = $request->installments['amount'] ?? [];
                $paid    = $request->installments['is_paid'] ?? [];

                foreach ($dates as $key => $date) {
                    if (!empty($date) && !empty($amounts[$key])) {
                        InvoiceInstallment::create([
                            'invoice_id'       => $id,
                            'installment_date' => $date,
                            'amount'           => $amounts[$key],
                            'is_paid'          => $paid[$key] ?? 0,
                        ]);
                    }
                }
            }
        });

        return redirect()->route('invoice.index')->with('success', 'Invoice Updated');
    }
}
