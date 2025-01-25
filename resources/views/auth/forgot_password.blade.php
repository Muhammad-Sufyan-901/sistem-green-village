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
              <p>Forgot Password</p>
            </div>

            <form id="forgotPasswordForm" class="mt-4 mb-3" action="{{ Route('auth.forgot-password.store') }}" method="POST">
              @csrf
              <div class="alert-message-box"></div>
              <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="text" class="form-control" name="email" placeholder="Enter your email" base_error="Err_email" autofocus />
                <div id="Err_email" class="text-danger"></div>
              </div>
              <div class="mb-3">
                <button class="btn btn-primary d-grid w-100 btn-submit" type="submit">Reset Now</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('script')
  <script src="{{ asset('js/backend/functions/forgot_password.js') }}"></script>
  <script defer="defer">
    window.addEventListener('DOMContentLoaded', function() {
      forgot_password_store();
    });
  </script>
@endsection
