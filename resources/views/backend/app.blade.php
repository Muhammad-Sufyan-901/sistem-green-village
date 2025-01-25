<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>{{ config('app.name') }} | Dashboard</title>
  <meta name="description" content="{{ config('app.name') }} | Dashboard" />

  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="{{ asset('img/logo.png') }}" />

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />

  <!-- Icons. Uncomment required icon fonts -->
  <link rel="stylesheet" href="{{ asset('vendors/backend/fonts/boxicons.css') }}" />

  <!-- Core CSS -->
  <link rel="stylesheet" href="{{ asset('vendors/backend/css/core.css') }}" class="template-customizer-core-css" />
  <link rel="stylesheet" href="{{ asset('vendors/backend/css/theme-default.css') }}" class="template-customizer-theme-css" />
  <link rel="stylesheet" href="{{ asset('css/backend/demo.css') }}" />

  <!-- Page CSS -->
  <!-- Page -->
  <link rel="stylesheet" href="{{ asset('vendors/backend/css/pages/page-auth.css') }}" />
  <!-- Helpers -->
  <script src="{{ asset('vendors/backend/js/helpers.js') }}"></script>
  <script src="{{ asset('js/backend/config.js') }}"></script>
</head>
<body>
  <div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
      {{-- Sidemenu --}}
      @include('backend.partials.sidemenu')

      {{-- Layout Container --}}
      <div class="layout-page">
        {{-- Navbar --}}
        @include('backend.partials.navbar')

        {{-- Content --}}
        <div class="content-wrapper">
          @yield('content')
        </div>

        {{-- Footer --}}
        @include('backend.partials.footer')

        <div class="content-backdrop fade"></div>
      </div>
    </div>

    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>
  </div>
  
  <!-- Core JS -->
  <!-- build:js assets/vendor/js/core.js -->
  <script src="{{ asset('vendors/backend/libs/jquery/jquery.js') }}"></script>
  <script src="{{ asset('vendors/backend/libs/popper/popper.js') }}"></script>
  <script src="{{ asset('vendors/backend/js/bootstrap.js') }}"></script>
  <script src="{{ asset('vendors/backend/js/menu.js') }}"></script>

  <!-- Main JS -->
  <script src="{{ asset('vendors/jquery-validation/jquery.validate.min.js') }}"></script>
  <script src="{{ asset('js/backend/main.js') }}"></script>

  <script>upload_transport_price_list();</script>
  @yield('script')
</body>
</html>