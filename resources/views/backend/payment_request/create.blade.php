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
                <li class="breadcrumb-item active">Create</li>
            </ol>
        </nav>

        {{-- Form --}}
        <div class="alert-message-box"></div>
        <h5 class="mt-4 mb-4">Create Payment Request</h5>
        <form action="{{ Route('backend.payment-request.store') }}" method="POST" id="addForm"
            enctype="multipart/form-data">
            @csrf
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Select Trip <span class="text-danger">*</span></label>
                            <select name="select_trip" class="form-select" base_error="Err_select_trip" id="trip-select">
                                <option value="">-- Please Select --</option>
                                @foreach ($trips as $key => $item)
                                    @php
                                        $totalAlreadyRequest = \App\Models\PaymentRequest::where(
                                            'trip_id',
                                            $item->trip_id,
                                        )
                                            ->where('status', '!=', 'cancel')
                                            ->count();
                                    @endphp
                                    @if ($totalAlreadyRequest == 0)
                                        <option value="{{ $item->trip_id }}"
                                            data-trip-type="{{ $item->re_type_trip->name ?? '' }}"
                                            data-amount="{{ $item->re_type_trip->name == 'Full Day' ? 500000 : ($item->re_type_trip->name == 'Half Day' ? 250000 : '') }}"
                                            data-is-tour={{ $item->re_type_trip->name == 'Tour' ? 1 : 0 }}>
                                            {{ $item->name }}
                                            {{ isset($item->re_type_trip) ? ' - ' . $item->re_type_trip->name : '' }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                            <div id="Err_select_trip" class="text-danger"></div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Upload Proofs <span class="text-danger">*</span></label>
                            <input class="form-control" type="file" name="proofs[]" base_error="Err_proofs"
                                multiple="multiple" accept="image/png, image/jpg, image/jpeg">
                            <div id="Err_proofs" class="text-danger"></div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" cols="30" rows="5" base_error="Err_description"></textarea>
                            <div id="Err_description" class="text-danger"></div>
                        </div>
                        <div class="col-md-12 mb-3" id="additional-charges" style="display: none">
                            <label class="form-label"> Additional Charges <span class="text-danger">*</span></label>
                            <input class="form-control kdef-rate-format" type="text" name="additional_charges"
                                base_error="Err_additional_charges">
                            <div id="Err_additional_charges" class="text-danger"></div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Total Rates Amount <span class="text-danger">*</span></label>
                            <input class="form-control kdef-rate-format" type="text" name="total_rates_amount"
                                base_error="Err_total_rates_amount">
                            <div id="Err_total_rates_amount" class="text-danger"></div>
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

{{-- @section('script')
    <script>
        console.log('payment_request_store');

        function payment_request_store() {
            console.log('payment_request_store');
        }
    </script>
    <script src="{{ asset('js/backend/functions/payment_request.js') }}"></script>
    <script defer="defer">
        window.addEventListener('DOMContentLoaded', function() {
            payment_request_store();
        });
    </script>
@endsection --}}

@push('js')
    <script src="{{ asset('js/backend/functions/payment_request.js') }}"></script>
@endpush

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tripSelect = document.getElementById('trip-select');
            const totalRatesAmountInput = document.querySelector('input[name="total_rates_amount"]');
            const additionalChargesInputField = document.querySelector('#additional-charges');

            if (tripSelect && totalRatesAmountInput) {
                tripSelect.addEventListener('change', function() {
                    const selectedOption = tripSelect.options[tripSelect.selectedIndex];
                    const amount = selectedOption.getAttribute('data-amount');
                    const isTour = selectedOption.getAttribute('data-is-tour');

                    if (amount) {
                        totalRatesAmountInput.value = amount;
                    } else {
                        totalRatesAmountInput.value = '';
                    }

                    if (isTour == 1) {
                        additionalChargesInputField.style.display = 'block';
                    } else {
                        additionalChargesInputField.style.display = 'none';
                    }
                });
            }
        });
    </script>
@endpush
