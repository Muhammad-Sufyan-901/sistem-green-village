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
          <a href="{{ Route('backend.users.index') }}">Users</a>
        </li>
        <li class="breadcrumb-item active">Create</li>
      </ol>
    </nav>

    {{-- Form --}}
    <div class="alert-message-box"></div>
    <h5 class="mt-4 mb-4">Create User</h5>
    <form action="{{ Route('backend.users.store') }}" method="POST" id="addForm" enctype="multipart/form-data">
      @csrf
      <div class="card mb-4">
        <div class="card-body">
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">Select Roles <span class="text-danger">*</span></label>
              <select name="roles" class="form-select" base_error="Err_roles">
                <option value="">-- Please Select --</option>
                <option value="receptionist">Receptionist</option>
                <option value="accounting">Accounting</option>
                <option value="admin">Admin</option>
              </select>
              <div id="Err_roles" class="text-danger"></div>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">User Profile</label>
              <input class="form-control" type="file" name="user_profile" base_error="Err_user_profile" accept="image/png, image/jpg, image/jpeg">
              <div id="Err_user_profile" class="text-danger"></div>
            </div>
            <div class="col-md-12 mb-3">
              <label class="form-label">Full Name <span class="text-danger">*</span></label>
              <input class="form-control" type="text" name="fullname" base_error="Err_fullname">
              <div id="Err_fullname" class="text-danger"></div>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Email <span class="text-danger">*</span></label>
              <input class="form-control" type="text" name="email" base_error="Err_email">
              <div id="Err_email" class="text-danger"></div>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Phone Number <span class="text-danger">*</span></label>
              <input class="form-control" type="text" name="phone_number" base_error="Err_phone_number">
              <div id="Err_phone_number" class="text-danger"></div>
            </div>
            <div class="col-md-12 mb-3">
              <label class="form-label">Address</label>
              <textarea name="address" class="form-control" cols="30" rows="2" base_error="Err_address"></textarea>
              <div id="Err_address" class="text-danger"></div>
            </div>
            <div class="col-md-12 mb-3">
              <label class="form-label">Select Status <span class="text-danger">*</span></label>
              <select name="status" class="form-select" base_error="Err_status">
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
              </select>
              <div id="Err_status" class="text-danger"></div>
            </div>
            <div class="col-md-6 mb-3 form-password-toggle">
              <label class="form-label" for="password">Password <span class="text-danger">*</span></label>
              <div class="input-group input-group-merge">
                <input type="password" class="form-control" id="password" name="password" base_error="Err_password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password"/>
                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
              </div>
              <div id="Err_password" class="text-danger"></div>
            </div>
            <div class="col-md-6 mb-3 form-password-toggle">
              <label class="form-label" for="password">Confirm Password <span class="text-danger">*</span></label>
              <div class="input-group input-group-merge">
                <input type="password" class="form-control" name="confirm_password" base_error="Err_confirm_password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="confirm_password"/>
                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
              </div>
              <div id="Err_confirm_password" class="text-danger"></div>
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
  <script src="{{ asset('js/backend/functions/users.js') }}"></script>
  <script defer="defer">
    window.addEventListener('DOMContentLoaded', function() {
      user_store();
    });
  </script>
@endsection