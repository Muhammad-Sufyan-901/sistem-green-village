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
          <a href="{{ Route('backend.drivers.index') }}">Drivers</a>
        </li>
        <li class="breadcrumb-item active">Detail</li>
      </ol>
    </nav>

    {{-- Form --}}
    <div class="alert-message-box"></div>
    <h5 class="mt-4 mb-4">Detail Driver</h5>
    <div class="card mb-4">
      <div class="card-body">
        <div class="row">
          <div class="col-md-12 mb-3">
            <label class="form-label">User Profile</label>
            <br>
            @if ($user->avatar)                            
              <div>
                <a href="{{ asset('upload/user_profiles/'.$user->avatar) }}">
                  <img src="{{ asset('upload/user_profiles/'.$user->avatar) }}" alt="" style="width:200px;border:1px solid #cccccc;">
                </a>
              </div>
            @endif
          </div>
          <div class="col-md-12 mb-3">
            <label class="form-label">Full Name</label>
            <input class="form-control" type="text" name="fullname" base_error="Err_fullname" value="{{ $user->name }}" readonly>
            <div id="Err_fullname" class="text-danger"></div>
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label">Email</label>
            <input class="form-control" type="text" name="email" base_error="Err_email" value="{{ $user->email }}" readonly>
            <div id="Err_email" class="text-danger"></div>
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label">Phone Number</label>
            <input class="form-control" type="text" name="phone_number" base_error="Err_phone_number" value="{{ $user->phone }}" readonly>
            <div id="Err_phone_number" class="text-danger"></div>
          </div>
          <div class="col-md-12 mb-3">
            <label class="form-label">Address</label>
            <textarea name="address" class="form-control" cols="30" rows="2" base_error="Err_address" readonly>{!! $user->address !!}</textarea>
            <div id="Err_address" class="text-danger"></div>
          </div>
          <div class="col-md-12 mb-3">
            <label class="form-label">Select Status</label>
            <select name="status" class="form-select" base_error="Err_status" disabled>
              <option value="active" {{ $user->status == 'active' ? 'selected':'' }}>Active</option>
              <option value="inactive" {{ $user->status == 'inactive' ? 'selected':'' }}>Inactive</option>
            </select>
            <div id="Err_status" class="text-danger"></div>
          </div>
        </div>
        <hr class="mt-4 mb-4">
        <div class="row">
          <div class="col-md-4 mb-3">
            <label class="form-label">Bank Name</label>
            <input class="form-control" type="text" name="bank_name" base_error="Err_bank_name" value="{{ isset($decBankAccount) ? $decBankAccount->bank_name : '' }}" readonly>
            <div id="Err_bank_name" class="text-danger"></div>
          </div>
          <div class="col-md-4 mb-3">
            <label class="form-label">Bank Card Holder</label>
            <input class="form-control" type="text" name="bank_card_holder" base_error="Err_bank_card_holder" value="{{ isset($decBankAccount) ? $decBankAccount->bank_card_holder : '' }}" readonly>
            <div id="Err_bank_card_holder" class="text-danger"></div>
          </div>
          <div class="col-md-4 mb-3">
            <label class="form-label">Bank Account Number</label>
            <input class="form-control" type="text" name="bank_account_number" base_error="Err_bank_account_number" value="{{ isset($decBankAccount) ? $decBankAccount->bank_account_number : '' }}" readonly>
            <div id="Err_bank_account_number" class="text-danger"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection