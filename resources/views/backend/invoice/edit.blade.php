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
        <li class="breadcrumb-item active">Edit</li>
      </ol>
    </nav>

    <div class="mb-3">
      <a href="{{ route('backend.payment-request.show', $invoice->payment_request_id) }}" class="btn btn-info"><i class='bx bxs-info-circle'></i> Go to Payment Request</a>
    </div>

    {{-- Form --}}
    <div class="alert-message-box"></div>
    <h5 class="mt-4 mb-4">Edit Invoice</h5>
    <form action="{{ Route('backend.invoice.update', $invoice->invoice_id) }}" method="POST" id="editForm" enctype="multipart/form-data">
      @csrf
      {{ method_field('PATCH') }}
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
              <input type="hidden" name="current_payment_proof" value="{{ $invoice->re_payment_request->payment_proof }}">
              <input class="form-control" type="file" name="payment_proof" base_error="Err_payment_proof" accept="image/png, image/jpg, image/jpeg">
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
              <label class="form-label">Total Payment Rates <span class="text-danger">*</span></label>
              <input class="form-control kdef-rate-format" type="text" name="total_payment_rates" base_error="Err_total_payment_rates" value="{{ number_format($invoice->total_payment_rates, 0, ',', '.') }}">
              <div id="Err_total_payment_rates" class="text-danger"></div>
            </div>
            <div class="col-md-12 mb-3">
              <label class="form-label">Remarks</label>
              <textarea name="remarks" class="form-control" cols="30" rows="5" base_error="Err_remarks">{!! $invoice->remarks !!}</textarea>
              <div id="Err_remarks" class="text-danger"></div>
            </div>
          </div>
        </div>
        <div class="card-footer">
          <button class="btn rounded-pill btn-primary btn-submit">Submit</button>
        </div>
      </div>
    </form>
  </div>
@endsection

@section('script')
  <script src="{{ asset('js/backend/functions/invoice.js') }}"></script>
  <script defer="defer">
    window.addEventListener('DOMContentLoaded', function() {
      invoice_update();
    });
  </script>
@endsection