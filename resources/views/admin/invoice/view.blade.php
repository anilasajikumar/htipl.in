@extends('layouts.admin.layout')

@section('content')
<div class="content-header"><div class="container-fluid"><div class="row mb-2">
  <div class="col-sm-6"><h1 class="m-0">Invoice #{{ $invoice->invoice_number }}</h1></div>
  <div class="col-sm-6"><div class="float-sm-right">
    <a href="{{ route('invoice.download', $invoice->id) }}" class="btn btn-danger btn-sm">Download PDF</a>
    <a href="{{ route('invoice.send.mail', $invoice->id) }}" class="btn btn-primary btn-sm">Send Mail</a>
    <a href="{{ route('invoice.index') }}" class="btn btn-secondary btn-sm">Back</a>
  </div></div>
</div></div></div>

<section class="content"><div class="container-fluid">
  @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif

  <div class="row justify-content-center">
    <div class="col-md-9 col-lg-8">
      <div class="card">
        <div class="card-body p-4">

          {{-- HEADER --}}
          <table width="100%">
            <tr>
              <td>
                <img src="{{ asset('web_dashboard/images/logo.png') }}" height="40"
                     onerror="this.style.display='none'">
                <div style="margin-top:8px; font-size:12px; color:#666;">
                  {{ config('app.name') }}
                </div>
              </td>
              <td style="text-align:right;">
                <span style="color:#c0392b; font-size:18px; font-weight:bold;">INVOICE</span><br>
                <small class="text-muted">INVOICE NO: {{ $invoice->invoice_number }}</small><br>
                <small class="text-muted">DATE: {{ $invoice->invoice_date }}</small>
              </td>
            </tr>
          </table>

          <hr>

          {{-- STUDENT --}}
          <table width="100%">
            <tr>
              <td width="50%">
                <strong>{{ $invoice->student_name }}</strong><br>
                <small>{{ $invoice->register_number }}</small>
              </td>
              <td width="50%" style="text-align:right;">
                <small class="text-muted">Email: {{ $invoice->student_email }}</small><br>
                <small class="text-muted">Mobile: {{ $invoice->student_mobile }}</small>
              </td>
            </tr>
          </table>

          {{-- ITEM TABLE --}}
          <table class="table table-bordered mt-3">
            <thead class="thead-light">
              <tr>
                <th>Description</th>
                <th>Sub Total</th>
                <th>Discount</th>
                <th>Tax</th>
                <th class="text-right">Total</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Course Payment{{ !empty($invoice->offer_name) ? ' ('.$invoice->offer_name.')' : '' }}</td>
                <td>₹ {{ number_format($invoice->sub_total, 2) }}</td>
                <td>₹ {{ number_format($invoice->discount, 2) }}</td>
                <td>₹ {{ number_format($invoice->tax, 2) }}</td>
                <td class="text-right font-weight-bold">₹ {{ number_format($invoice->total_amount, 2) }}</td>
              </tr>
            </tbody>
          </table>

          <div class="text-right font-weight-bold">
            Grand Total: ₹ {{ number_format($invoice->total_amount, 2) }}
            &nbsp;&nbsp;
            <span class="badge badge-{{ $invoice->status=='paid' ? 'success' : ($invoice->status=='partial' ? 'warning' : 'danger') }}">
              {{ strtoupper($invoice->status) }}
            </span>
          </div>

          {{-- INSTALLMENTS --}}
          @if(isset($installments) && count($installments))
          <hr>
          <h6 class="font-weight-bold">Installment Schedule</h6>
          @php $paidTotal = 0; @endphp
          <table class="table table-sm table-bordered">
            <thead class="thead-light">
              <tr><th>Date</th><th class="text-right">Amount</th><th class="text-right">Status</th></tr>
            </thead>
            <tbody>
              @foreach($installments as $inst)
                @php if($inst->is_paid) $paidTotal += $inst->amount; @endphp
                <tr>
                  <td>{{ \Carbon\Carbon::parse($inst->installment_date)->format('d M Y') }}</td>
                  <td class="text-right">₹ {{ number_format($inst->amount, 2) }}</td>
                  <td class="text-right">
                    @if($inst->is_paid)
                      <span class="badge badge-success">PAID</span>
                    @else
                      <span class="badge badge-danger">PENDING</span>
                    @endif
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
          <div class="text-right">
            <small>Total Paid: <strong>₹ {{ number_format($paidTotal, 2) }}</strong></small><br>
            <small>Balance: <strong>₹ {{ number_format($invoice->total_amount - $paidTotal, 2) }}</strong></small>
          </div>
          @endif

          {{-- BANK DETAILS --}}
          @if(isset($account) && $account)
          <hr>
          <table width="100%">
            <tr>
              <td width="60%">
                <strong style="font-size:12px;">PAYMENT DETAILS</strong><br>
                <small>Account: {{ $account->account_number }}</small><br>
                <small>IFSC: {{ $account->ifsc_code }}</small><br>
                @if($account->bank_name)<small>Bank: {{ $account->bank_name }}</small>@endif
              </td>
              @if($account->qr_image)
              <td width="40%" class="text-right">
                <img src="{{ asset($account->qr_image) }}" width="100">
              </td>
              @endif
            </tr>
          </table>
          @endif

          <hr>
          <small class="text-muted">Have a nice day. &copy; {{ config('app.name') }}</small>

        </div>
      </div>
    </div>
  </div>
</div></section>
@endsection
