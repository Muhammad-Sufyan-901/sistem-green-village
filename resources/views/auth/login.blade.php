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
              <p>Login here to enter your dashboard</p>
            </div>

            <form id="loginForm" class="mt-4 mb-3" action="{{ Route('auth.login.store') }}" method="POST">
              <div class="alert-message-box"></div>
              <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="text" class="form-control" name="email" placeholder="Enter your email" base_error="Err_email" autofocus />
                <div id="Err_email" class="text-danger"></div>
              </div>
              <div class="mb-3 form-password-toggle">
                <label class="form-label" for="password">Password</label>
                <div class="input-group input-group-merge">
                  <input type="password" class="form-control" id="password" name="password" base_error="Err_password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password"/>
                  <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                </div>
                <div id="Err_password" class="text-danger"></div>
              </div>
              <div class="mb-3">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" name="remember_me" id="remember-me" />
                  <label class="form-check-label" for="remember-me"> Remember Me </label>
                </div>
              </div>
              <div class="mt-4 mb-2">
                <span><a href="{{ Route('auth.forgot-password') }}">Forgot password?</a></span>
              </div>
              <div class="mb-4">
                <span>Don't have an account? <a href="{{ Route('auth.register') }}">Register as a Driver</a></span>
              </div>
              <div class="mb-3">
                <button class="btn btn-primary d-grid w-100 btn-submit" type="submit">Sign in</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('script')
  <script src="{{ asset('js/backend/functions/login.js') }}"></script>
  <script defer="defer">
    window.addEventListener('DOMContentLoaded', function() {
      login_store();
    });
  </script>
@endsection