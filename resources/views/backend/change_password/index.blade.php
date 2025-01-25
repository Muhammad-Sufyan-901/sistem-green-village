@extends('backend.app')

@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="{{ Route('backend.dash.home') }}">Home</a>
        </li>
        <li class="breadcrumb-item active">Change Password</li>
      </ol>
    </nav>

    {{-- Form --}}
    <div class="alert-message-box"></div>
    <div class="card mb-4">
      <h5 class="card-header">Change Password</h5>
      <form action="{{ Route('backend.dash.change-password.update') }}" method="POST" id="editForm" enctype="multipart/form-data">
        @csrf
        <div class="card-body">
          <div class="mb-3">
            <label class="form-label">Current Password <span class="text-danger">*</span></label>
            <input type="password" name="current_password" base_error="Err_current_password" class="form-control">
            <div id="Err_current_password" class="text-danger"></div>
          </div>
          <div class="mb-3">
            <label class="form-label">New Password <span class="text-danger">*</span></label>
            <input type="password" name="password" base_error="Err_password" id="password" class="form-control">
            <div id="Err_password" class="text-danger"></div>
          </div>
          <div class="mb-3">
            <label class="form-label">Confirm Password <span class="text-danger">*</span></label>
            <input type="password" name="confirm_password" base_error="Err_confirm_password" class="form-control">
            <div id="Err_confirm_password" class="text-danger"></div>
          </div>
        </div>
        <div class="card-footer">
          <button class="btn rounded-pill btn-primary btn-submit">Submit</button>
        </div>
      </form>
    </div>
  </div>
@endsection

@section('script')
  <script src="{{ asset('js/backend/functions/change_password.js') }}"></script>
  <script defer="defer">
    window.addEventListener('DOMContentLoaded', function() {
      update_password();
    });
  </script>
@endsection