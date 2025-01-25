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
          <a href="{{ Route('backend.payment-request.index') }}">Payment Requests</a>
        </li>
        <li class="breadcrumb-item active">Edit</li>
      </ol>
    </nav>

    {{-- Form --}}
    <div class="alert-message-box"></div>
    <h5 class="mt-4 mb-4">Edit Payment Request</h5>
    <div class="global-variable" already-payment-proof="{{ isset($paymentRequest->payment_proof) ? true:false }}"></div>
    <form action="{{ Route('backend.payment-request.update', $paymentRequest->payment_request_id) }}" method="POST" id="editForm" enctype="multipart/form-data">
      @csrf
      {{ method_field('PATCH') }}
      <div class="card mb-4">
        <div class="card-body">
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">Select Trip <span class="text-danger">*</span></label>
              <select name="select_trip" class="form-select" base_error="Err_select_trip" {{ auth()->user()->roles != 'driver' ? 'disabled':'' }}>
                <option value="">-- Please Select --</option>
                @foreach ($trips as $key => $item)
                  @php
                    $totalAlreadyRequest = \App\Models\PaymentRequest::where('trip_id', $item->trip_id)
                    ->where('payment_request_id', '!=', $paymentRequest->payment_request_id)->where('status', '!=', 'cancel')->count();
                  @endphp
                  @if ($totalAlreadyRequest == 0)  
                    <option value="{{ $item->trip_id }}" {{ $item->trip_id == $paymentRequest->trip_id ? 'selected':'' }}>
                      {{ $item->name }}
                      {{ isset($item->re_type_trip) ? ' - '.$item->re_type_trip->name : '' }}
                    </option>
                  @endif
                @endforeach
              </select>
              <div id="Err_select_trip" class="text-danger"></div>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Requested By</label>
              <input class="form-control" type="text" name="requested_by" base_error="Err_requested_by" value="{{ isset($paymentRequest->re_user) ? $paymentRequest->re_user->name : '' }}" readonly>
              <div id="Err_requested_by" class="text-danger"></div>
            </div>
            <div class="col-md-12 mb-3">
              <label class="form-label d-block">Upload Proofs</label>
              @if(auth()->user()->roles == 'driver')
                <input class="form-control" type="file" name="proofs[]" base_error="Err_proofs" multiple="multiple" accept="image/png, image/jpg, image/jpeg">
              @endif
              @if (isset($decProofs))
                @php $num = 0; @endphp
                @foreach ($decProofs as $key => $item)
                  @php $num += 1; @endphp
                  <div class="d-inline-block mt-3 mb-4 " style="position:relative;margin-right:10px;">
                    <button type="button" class="btn btn-outline-primary text-decoration-none position-relative">
                      <a href="{{ asset('upload/proofs/'.$item->filename) }}" target="_blank" class="text-decoration-none text-reset">
                        <span>
                          Proofs 
                          <?= $num ?></span> <i class='bx bxs-file-pdf'></i>
                        </span>
                      </a>
                    </button>
                    @if (auth()->user()->roles == 'driver')
                      <br>
                      <a href="#" onClick="
                      var x = window.confirm('Confirm to delete this file');
                      if(x == true){
                        window.location='{{ route('backend.dash.payment-request.proof-destroy', $paymentRequest->payment_request_id) }}?key={{ $key }}&file={{ $item->filename }}';
                        }
                        " class="btn-delete-abs text-danger">Delete Item <i class='bx bx-x'></i></a>
                    @endif
                  </div>
                @endforeach
              @endif
              <div id="Err_proofs" class="text-danger"></div>
            </div>
            <div class="col-md-12 mb-3">
              <label class="form-label">Description</label>
              <textarea name="description" class="form-control" cols="30" rows="5" base_error="Err_description" {{ auth()->user()->roles != 'driver' ? 'readonly':'' }}>{!! $paymentRequest->description !!}</textarea>
              <div id="Err_description" class="text-danger"></div>
            </div>
            <div class="col-md-12 mb-3">
              <label class="form-label">Total Rates Amount <span class="text-danger">*</span></label>
              <input class="form-control kdef-rate-format" type="text" name="total_rates_amount" base_error="Err_total_rates_amount" value="{{ number_format($paymentRequest->total_rates_amount, 0, ',', '.') }}" {{ auth()->user()->roles != 'driver' ? 'readonly':'' }}>
              <div id="Err_total_rates_amount" class="text-danger"></div>
            </div>

            <hr class="mt-4 mb-4">

            <div class="col-md-12 mb-3">
              <label class="form-label">Select Status</label>
              <select name="status" class="form-select" base_error="Err_status">
                <option value="cancel" {{ $paymentRequest->status == 'cancel' ? 'selected':'' }}>Cancel</option>
                <option value="pending" {{ $paymentRequest->status == 'pending' ? 'selected':'' }}>Pending</option>
                <option value="done" {{ $paymentRequest->status == 'done' ? 'selected':'' }}>Done</option>
              </select>
              <div id="Err_status" class="text-danger"></div>
            </div>
            <div class="status-cancel-additional-form" style="{{ $paymentRequest->status == 'cancel' ? 'display: block;':'display: none;' }}">
              <div class="col-md-12 mb-3">
                <label class="form-label">Reason <span class="text-danger">*</span></label>
                <textarea name="reason" class="form-control" cols="30" rows="6" base_error="Err_reason">{!! isset($decReason->cancel) ? $decReason->cancel : '' !!}</textarea>
                <div id="Err_reason" class="text-danger"></div>
              </div>
            </div>
          </div>
          <div class="status-done-additional-form" style="{{ $paymentRequest->status == 'done' ? 'display: block;':'display: none;' }}">
            <div class="col-md-12 mb-3">
              <label class="form-label">Upload Payment Proof <span class="text-danger">*</span></label>
              <input type="hidden" name="current_payment_proof" value="{{ $paymentRequest->payment_proof }}">
              <input class="form-control" type="file" name="payment_proof" base_error="Err_payment_proof" accept="image/png, image/jpg, image/jpeg">
              @if ($paymentRequest->payment_proof)                            
                <div>
                  <a href="{{ asset('upload/payment_proofs/'.$paymentRequest->payment_proof) }}">
                    <img src="{{ asset('upload/payment_proofs/'.$paymentRequest->payment_proof) }}" alt="" style="width:200px;border:1px solid #cccccc;">
                  </a>
                </div>
              @endif
              <div id="Err_payment_proof" class="text-danger"></div>
            </div>
            <div class="col-md-12 mb-3">
              <label class="form-label">Total Payment Rates <span class="text-danger">*</span></label>
              <input class="form-control kdef-rate-format" type="text" name="total_payment_rates" base_error="Err_total_payment_rates" value="{{ isset($paymentRequest->re_has_invoices[0]) ? number_format($paymentRequest->re_has_invoices[0]->total_payment_rates, 0, ',', '.') : number_format($paymentRequest->total_rates_amount, 0, ',', '.') }}">
              <div id="Err_total_payment_rates" class="text-danger"></div>
            </div>
            <div class="col-md-12 mb-3">
              <label class="form-label">Remarks</label>
              <textarea name="remarks" class="form-control" cols="30" rows="5" base_error="Err_remarks">{!! isset($paymentRequest->re_has_invoices[0]) ? $paymentRequest->re_has_invoices[0]->remarks : '' !!}</textarea>
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
  <script src="{{ asset('js/backend/functions/payment_request.js') }}"></script>
  <script defer="defer">
    window.addEventListener('DOMContentLoaded', function() {
      payment_request_init();
      payment_request_update();
    });
  </script>
@endsection