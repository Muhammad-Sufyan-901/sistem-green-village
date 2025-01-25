@extends('backend.app')

@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="{{ Route('backend.dash.home') }}">Home</a>
        </li>
        <li class="breadcrumb-item">
          <a href="{{ Route('backend.invoice.index') }}">Invoices</a>
        </li>
        <li class="breadcrumb-item active">Detail</li>
      </ol>
    </nav>

    <div class="mb-3">
      <a href="{{ route('backend.payment-request.show', $invoice->payment_request_id) }}" class="btn btn-info"><i class='bx bxs-info-circle'></i> Go to Payment Request</a>
    </div>

    {{-- Form --}}
    <div class="alert-message-box"></div>
    <h5 class="mt-4 mb-4">Detail Invoice</h5>
    <div class="card mb-4">
      <div class="card-body">
        <div class="row">
          <div class="col-md-12 mb-3">
            <label class="form-label">Reference Code</label>
            <input class="form-control" type="text" name="reference_code" base_error="Err_reference_code" value="{{ $invoice->reference_code }}" readonly>
            <div id="Err_reference_code" class="text-danger"></div>
          </div>
          <div class="col-md-12 mb-3">
            <label class="form-label">Upload Payment Proof</label>
            @if ($invoice->re_payment_request->payment_proof)
              <div>
                <a href="{{ asset('upload/payment_proofs/'.$invoice->re_payment_request->payment_proof) }}">
                  <img src="{{ asset('upload/payment_proofs/'.$invoice->re_payment_request->payment_proof) }}" alt="" style="width:200px;border:1px solid #cccccc;">
                </a>
              </div>
            @endif
            <div id="Err_payment_proof" class="text-danger"></div>
          </div>
          <div class="col-md-12 mb-3">
            <label class="form-label">Total Payment Rates</label>
            <input class="form-control kdef-rate-format" type="text" name="total_payment_rates" base_error="Err_total_payment_rates" value="{{ number_format($invoice->total_payment_rates, 0, ',', '.') }}" readonly>
            <div id="Err_total_payment_rates" class="text-danger"></div>
          </div>
          <div class="col-md-12 mb-3">
            <label class="form-label">Remarks</label>
            <textarea name="remarks" class="form-control" cols="30" rows="5" base_error="Err_remarks" readonly>{!! $invoice->remarks !!}</textarea>
            <div id="Err_remarks" class="text-danger"></div>
          </div>

          <div class="col-md-6 mb-3">
            <label class="form-label">Requested By</label>
            <br>
            @if (isset($invoice->re_payment_request->re_user))
              <h4 class="text-success">{{ $invoice->re_payment_request->re_user->name }}</h4>
            @endif
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label">Released By</label>
            <br>
            @if (isset($invoice->re_created_by))
              <h4 class="text-success">{{ $invoice->re_created_by->name }}</h4>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection