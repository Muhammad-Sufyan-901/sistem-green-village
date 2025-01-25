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
        <li class="breadcrumb-item active">Edit</li>
      </ol>
    </nav>

    {{-- Form --}}
    <div class="alert-message-box"></div>
    <h5 class="mt-4 mb-4">Edit User</h5>
    <form action="{{ Route('backend.users.update', $user->user_id) }}" method="POST" id="editForm" enctype="multipart/form-data">
      @csrf
      {{ method_field('PATCH') }}
      <div class="card mb-4">
        <div class="card-body">
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">Select Roles <span class="text-danger">*</span></label>
              <select name="roles" class="form-select" base_error="Err_roles">
                <option value="">-- Please Select --</option>
                <option value="receptionist" {{ $user->roles == 'receptionist' ? 'selected':'' }}>Receptionist</option>
                <option value="accounting" {{ $user->roles == 'accounting' ? 'selected':'' }}>Accounting</option>
                <option value="admin" {{ $user->roles == 'admin' ? 'selected':'' }}>Admin</option>
              </select>
              <div id="Err_roles" class="text-danger"></div>
            </div>
            <div class="col-md-6 mb-3">
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
              <input class="form-control" type="text" name="email" base_error="Err_email" value="{{ $user->email }}">
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
            <div class="col-md-12 mb-3">
              <label class="form-label">Select Status <span class="text-danger">*</span></label>
              <select name="status" class="form-select" base_error="Err_status">
                <option value="active" {{ $user->status == 'active' ? 'selected':'' }}>Active</option>
                <option value="inactive" {{ $user->status == 'inactive' ? 'selected':'' }}>Inactive</option>
              </select>
              <div id="Err_status" class="text-danger"></div>
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
      user_update();
    });
  </script>
@endsection