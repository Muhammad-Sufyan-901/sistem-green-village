@extends('auth.app')

@section('content')
  <div class="container-xxl">
    <div class="authentication-wrapper authentication-basic container-p-y">
      <div class="authentication-inner">
        <div class="card">
          <div class="card-body">
            <!-- Logo -->
            <div class="text-center">
              <a href="" class="app-brand-link gap-2" style="">
                <span style="font-size: 20px;
                display: block;
                width: 100%;
                text-align: center;
                margin-top: 10px;">SIM Driver Green Village</span>
              </a>
              <p>Register driver here to have an accessing your dashboard</p>
            </div>

            <form id="registerForm" class="mt-4 mb-3" action="{{ Route('auth.register.store') }}" method="POST">
              <div class="alert-message-box"></div>
              <div class="mb-3">
                <label class="form-label">Full Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="fullname" placeholder="Enter full name" base_error="Err_fullname" autofocus />
                <div id="Err_fullname" class="text-danger"></div>
              </div>
              <div class="mb-3">
                <label class="form-label">Email <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="email" placeholder="Enter your email" base_error="Err_email" />
                <div id="Err_email" class="text-danger"></div>
              </div>
              <div class="mb-3">
                <label class="form-label">Phone Number <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="phone" placeholder="Enter phone number" base_error="Err_phone" />
                <div id="Err_phone" class="text-danger"></div>
              </div>
              <div class="mb-3">
                <label class="form-label">Address</label>
                <input type="text" class="form-control" name="address" placeholder="Enter your address" base_error="Err_address" />
                <div id="Err_address" class="text-danger"></div>
              </div>
              <div class="mb-3 form-password-toggle">
                <label class="form-label" for="password">Password <span class="text-danger">*</span></label>
                <div class="input-group input-group-merge">
                  <input type="password" class="form-control" id="password" name="password" base_error="Err_password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password"/>
                  <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                </div>
                <div id="Err_password" class="text-danger"></div>
              </div>
              <div class="mb-3 form-password-toggle">
                <label class="form-label" for="password">Confirm Password <span class="text-danger">*</span></label>
                <div class="input-group input-group-merge">
                  <input type="password" class="form-control" name="confirm_password" base_error="Err_confirm_password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="confirm_password"/>
                  <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                </div>
                <div id="Err_confirm_password" class="text-danger"></div>
              </div>

              <div class="mb-4">
                <span>Already have an account? <a href="{{ Route('auth.login') }}">Login here</a></span>
              </div>
              <div class="mb-3">
                <button class="btn btn-primary d-grid w-100 btn-submit" type="submit">Sign up</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('script')
  <script src="{{ asset('js/backend/functions/register.js') }}"></script>
  <script defer="defer">
    window.addEventListener('DOMContentLoaded', function() {
      register_store();
    });
  </script>
@endsection