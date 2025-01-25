@extends('backend.app')

@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="{{ Route('backend.dash.home') }}">Home</a>
        </li>
        <li class="breadcrumb-item active">Edit Profile</li>
      </ol>
    </nav>

    {{-- Form --}}
    <div class="alert-message-box"></div>
    <div class="card mb-4">
      <h5 class="card-header">Edit Profile</h5>
      <form action="{{ Route('backend.dash.edit-profile.update') }}" method="POST" id="editForm" enctype="multipart/form-data">
        @csrf
        <div class="card-body">
          <div class="row">
            <div class="col-md-12 mb-3">
              <label class="form-label">User Profile</label>
              <input type="hidden" name="current_user_profile" value="{{ $user->avatar }}">
              <input class="form-control" type="file" name="user_profile" base_error="Err_user_profile" accept="image/png, image/jpg, image/jpeg">
              <div id="Err_user_profile" class="text-danger"></div>
              @if ($user->avatar)                            
                <div>
                  <a href="{{ asset('upload/user_profiles/'.$user->avatar) }}">
                    <img src="{{ asset('upload/user_profiles/'.$user->avatar) }}" alt="" style="width:200px;border:1px solid #cccccc;">
                  </a>
                </div>
              @endif
            </div>
            <div class="col-md-12 mb-3">
              <label class="form-label">Full Name <span class="text-danger">*</span></label>
              <input class="form-control" type="text" name="fullname" base_error="Err_fullname" value="{{ $user->name }}">
              <div id="Err_fullname" class="text-danger"></div>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Email <span class="text-danger">*</span></label>
              <input class="form-control" type="text" name="email" base_error="Err_email" value="{{ $user->email }}" readonly>
              <div id="Err_email" class="text-danger"></div>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Phone Number <span class="text-danger">*</span></label>
              <input class="form-control" type="text" name="phone_number" base_error="Err_phone_number" value="{{ $user->phone }}">
              <div id="Err_phone_number" class="text-danger"></div>
            </div>
            <div class="col-md-12 mb-3">
              <label class="form-label">Address</label>
              <textarea name="address" class="form-control" cols="30" rows="2" base_error="Err_address">{!! $user->address !!}</textarea>
              <div id="Err_address" class="text-danger"></div>
            </div>
          </div>

          @if (auth()->user()->roles == 'driver')
            <hr class="mt-4 mb-4">
            <div class="row">
              <div class="col-md-4 mb-3">
                <label class="form-label">Bank Name</label>
                <input class="form-control" type="text" name="bank_name" base_error="Err_bank_name" value="{{ isset($decBankAccount) ? $decBankAccount->bank_name : '' }}">
                <div id="Err_bank_name" class="text-danger"></div>
              </div>
              <div class="col-md-4 mb-3">
                <label class="form-label">Bank Card Holder</label>
                <input class="form-control" type="text" name="bank_card_holder" base_error="Err_bank_card_holder" value="{{ isset($decBankAccount) ? $decBankAccount->bank_card_holder : '' }}">
                <div id="Err_bank_card_holder" class="text-danger"></div>
              </div>
              <div class="col-md-4 mb-3">
                <label class="form-label">Bank Account Number</label>
                <input class="form-control" type="text" name="bank_account_number" base_error="Err_bank_account_number" value="{{ isset($decBankAccount) ? $decBankAccount->bank_account_number : '' }}">
                <div id="Err_bank_account_number" class="text-danger"></div>
              </div>
            </div>
          @endif
        </div>
        <div class="card-footer">
          <button class="btn rounded-pill btn-primary btn-submit">Submit</button>
        </div>
      </form>
    </div>
  </div>
@endsection

@section('script')
  <script src="{{ asset('js/backend/functions/edit_profile.js') }}"></script>
  <script defer="defer">
    window.addEventListener('DOMContentLoaded', function() {
      update_profile();
    });
  </script>
@endsection