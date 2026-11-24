<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Invoice</title>

<style>
body { background:#fff; font-family: DejaVu Sans, sans-serif; font-size:13px; }
.invoice-box { width:600px; margin:20px auto; background:#fff; padding:30px; }
.title { color:#c0392b; font-size:18px; font-weight:bold; text-align:right; }
.label { color:#888; font-size:11px; }
.value { font-size:13px; color:#333; }
.table { width:100%; border-collapse:collapse; margin-top:15px; }
.table th { text-align:left; font-size:11px; color:#666; border-bottom:1px solid #ccc; padding:6px 0; }
.table td { padding:8px 0; border-bottom:1px solid #eee; font-size:12px; }
.total { text-align:right; font-weight:bold; font-size:13px; }
.footer-note { margin-top:25px; font-size:11px; color:#777; }
</style>

<div class="invoice-box">

    {{-- HEADER --}}
    <table width="100%">
        <tr>
            <td>
                @php $logo = public_path('web_dashboard/images/logo.png'); @endphp
                @if(file_exists($logo))
                <img src="{{ $logo }}" height="38">
                @endif
                <div style="margin-top:6px; font-size:11px; color:#666;">
                    {{ config('app.name') }}
                </div>
            </td>
            <td class="title">
                ORIGINAL FOR RECIPIENT
                <div class="label">INVOICE NO : {{ $invoice->invoice_number }}</div>
                <div class="label">INVOICE DATE : {{ $invoice->invoice_date }}</div>
            </td>
        </tr>
    </table>

    <br>

    {{-- STUDENT --}}
    <p class="value">
        <strong>{{ $invoice->student_name }}</strong>
    </p>

    <table width="100%" style="margin-top:15px;">
        <tr>
            <td width="50%">
                <div class="label">REGISTER NO</div>
                <div class="value">{{ $invoice->register_number }}</div>
            </td>
            <td width="50%" style="text-align:right;">
                <div class="label">MOBILE</div>
                <div class="value">{{ $invoice->student_mobile }}</div>
            </td>
        </tr>
    </table>

    {{-- ITEM TABLE --}}
    <table class="table">
        <thead>
            <tr>
                <th>Course</th>
                <th style="text-align:right;">Sub Total</th>
                <th style="text-align:right;">Discount</th>
                <th style="text-align:right;">Tax</th>
                <th style="text-align:right;">Total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $invoice->course_name ?? 'Course Payment' }}{{ !empty($invoice->offer_name) ? ' ('.$invoice->offer_name.')' : '' }}</td>
                <td style="text-align:right;">&#8377; {{ number_format($invoice->sub_total, 2) }}</td>
                <td style="text-align:right;">&#8377; {{ number_format($invoice->discount, 2) }}</td>
                <td style="text-align:right;">&#8377; {{ number_format($invoice->tax, 2) }}</td>
                <td style="text-align:right;">&#8377; {{ number_format($invoice->total_amount, 2) }}</td>
            </tr>
        </tbody>
    </table>

    {{-- TOTAL --}}
    <table width="100%" style="margin-top:8px;">
        <tr>
            <td class="total">Grand Total : &#8377; {{ number_format($invoice->total_amount, 2) }}</td>
        </tr>
    </table>

    {{-- INSTALLMENTS --}}
    @if(isset($installments) && count($installments))
    <table width="100%" style="margin-top:20px;">
        <tr>
            <td>
                <div class="label" style="font-size:12px; margin-bottom:8px;"><strong>INSTALLMENT SCHEDULE</strong></div>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th style="text-align:right;">Amount</th>
                            <th style="text-align:right;">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $paidTotal = 0; @endphp
                        @foreach($installments as $inst)
                            @php if($inst->is_paid) $paidTotal += $inst->amount; @endphp
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($inst->installment_date)->format('d M Y') }}</td>
                                <td style="text-align:right;">&#8377; {{ number_format($inst->amount, 2) }}</td>
                                <td style="text-align:right;">
                                    @if($inst->is_paid)
                                        <span style="color:green; font-weight:600;">PAID</span>
                                    @else
                                        <span style="color:#c0392b; font-weight:600;">PENDING</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <table width="100%" style="margin-top:8px;">
                    <tr>
                        <td class="label">Total Paid</td>
                        <td style="text-align:right;" class="value">&#8377; {{ number_format($paidTotal, 2) }}</td>
                    </tr>
                    <tr>
                        <td class="label">Balance Amount</td>
                        <td style="text-align:right;" class="value">&#8377; {{ number_format($invoice->total_amount - $paidTotal, 2) }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    @endif

    {{-- BANK DETAILS --}}
    @if(isset($account) && $account)
    <table width="100%" style="margin-top:20px;">
        <tr>
            <td width="65%">
                <div class="label"><strong>PAYMENT DETAILS</strong></div>
                <div class="value">
                    @if($account->account_name) Account Name : {{ $account->account_name }}<br> @endif
                    Account : {{ $account->account_number ?? '' }}<br>
                    IFSC : {{ $account->ifsc_code ?? '' }}<br>
                    @if($account->bank_name) Bank : {{ $account->bank_name }}<br> @endif
                    @if($account->branch) Branch : {{ $account->branch }} @endif
                </div>
            </td>
            @if($account->qr_image)
            <td width="35%" style="text-align:right;">
                @php $qr = public_path($account->qr_image); @endphp
                @if(file_exists($qr))
                <img src="{{ $qr }}" width="100">
                @endif
            </td>
            @endif
        </tr>
    </table>
    @endif

    <div class="footer-note">
        Have a nice day.<br>
        &copy; {{ config('app.name') }}
    </div>

</div>
