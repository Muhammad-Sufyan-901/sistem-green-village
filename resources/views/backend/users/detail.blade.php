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
        <li class="breadcrumb-item active">Detail</li>
      </ol>
    </nav>

    {{-- Form --}}
    <div class="alert-message-box"></div>
    <h5 class="mt-4 mb-4">Detail User</h5>
      <div class="card mb-4">
        <div class="card-body">
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">Select Roles</label>
              <select name="roles" class="form-select" base_error="Err_roles" disabled>
                <option value="">-- Please Select --</option>
                <option value="receptionist" {{ $user->roles == 'receptionist' ? 'selected':'' }}>Receptionist</option>
                <option value="accounting" {{ $user->roles == 'accounting' ? 'selected':'' }}>Accounting</option>
                <option value="admin" {{ $user->roles == 'admin' ? 'selected':'' }}>Admin</option>
              </select>
              <div id="Err_roles" class="text-danger"></div>
            </div>
            <div class="col-md-6 mb-3">
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
        </div>
      </div>
  </div>
@endsection