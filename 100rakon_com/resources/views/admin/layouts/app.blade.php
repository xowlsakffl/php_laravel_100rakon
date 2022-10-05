<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="preload-transitions">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=1280, initial-scale=1, minimum-scale=0.5, maximum-scale=2, user-scalable=yes">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', '') }}</title>

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!--   Core JS Files   -->
    <script src="{{ asset('js/app.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/admin/popper.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/admin/menu.js') }}"></script>
    <script src="https://unpkg.com/boxicons@2.0.9/dist/boxicons.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- chart.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@100;300;400;500;700&family=Roboto:wght@100;300;400;500;700&display=swap" rel="stylesheet">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin/reset.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin/main.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin/subpage.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin/login.css') }}" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
    @media (max-width: 1280px) {
        body { width: 1280px; }
    }
    .col-sm-1 { width: 8%; }
    .col-sm-2 { width: 16%; }
    .col-sm-3 { width: 24%; }
    .col-sm-4 { width: 32%; }
    .col-sm-5 { width: 40%; }
    .col-sm-6 { width: 48%; }
    .col-sm-7 { width: 56%; }
    .col-sm-8 { width: 64%; }
    .col-sm-9 { width: 72%; }
    .col-sm-10 { width: 80%; }
    .col-sm-11 { width: 88%; }
    .col-sm-12 { width: 96%; }
    </style>
    <script type="text/javascript">
      document.addEventListener("DOMContentLoaded",function(){
        let node = document.querySelector('.preload-transitions');
        node.classList.remove('preload-transitions');
      });
    </script>
</head>
<body class="preload-transitions">

  @guest
    @yield('auth')
  @endguest

  @auth
    @include('admin.layouts.header')

    @include('admin.layouts.menu_m')
    @include('admin.layouts.menu')

    <main class="main" id="app">
      @include('flash::message')
      @yield('content')
      @yield('page-script')
    </main>

    @include('admin.layouts.footer')
  @endauth
</body>
</html>
