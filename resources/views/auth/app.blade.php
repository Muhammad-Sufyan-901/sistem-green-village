<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>@yield('title')</title>
  <meta name="description" content="@yield('description')" />

  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="" />

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
  @yield('content')
  
  <!-- Core JS -->
  <!-- build:js assets/vendors/js/core.js -->
  <script src="{{ asset('vendors/backend/libs/jquery/jquery.js') }}"></script>
  <script src="{{ asset('vendors/backend/libs/popper/popper.js') }}"></script>
  <script src="{{ asset('vendors/backend/js/bootstrap.js') }}"></script>
  <script src="{{ asset('vendors/backend/js/menu.js') }}"></script>

  <!-- Main JS -->
  <script src="{{ asset('vendors/jquery-validation/jquery.validate.min.js') }}"></script>
  <script src="{{ asset('js/backend/main.js') }}"></script>

  @yield('script')
</body>
</html>