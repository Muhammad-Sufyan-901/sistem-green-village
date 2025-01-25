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
              <p>Reset Password</p>
            </div>

            <form id="resetPasswordForm" class="mt-4 mb-3" action="{{ Route('auth.reset-password.store', $token) }}" method="POST">
              @csrf
              <div class="alert-message-box"></div>
              <div class="mb-3">
                <label class="form-label">New Password</label>
                <input type="password" class="form-control" name="password" placeholder="******" id="password" base_error="Err_new_password" />
                <div id="Err_new_password" class="text-danger"></div>
              </div>
              <div class="mb-3">
                <label class="form-label">Confirm Password</label>
                <input type="password" class="form-control" name="confirm_password" placeholder="******" base_error="Err_confirm_password" />
                <div id="Err_confirm_password" class="text-danger"></div>
              </div>
              <div class="mb-3">
                <button class="btn btn-primary d-grid w-100 btn-submit" type="submit">Reset Password</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('script')
  <script src="{{ asset('js/backend/functions/reset_password.js') }}"></script>
  <script defer="defer">
    window.addEventListener('DOMContentLoaded', function() {
      reset_password_store();
    });
  </script>
@endsection
