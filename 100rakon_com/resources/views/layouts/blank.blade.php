<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>주소록 - 백락온(百樂ON)</title>
    <meta charset="utf-8">
    <link rel="shortcut" href="favicon.ico" />
    <meta http-equiv="CACHE-CONTROL" content="no-store" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=2, user-scalable=yes">
    <!-- CSRF Token --><meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Scripts --><script src="{{ asset('js/app.js') }}" defer></script>
    <!-- Scripts --><script src="{{ asset('js/gen.js') }}" defer></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/boxicons@2.1.1/dist/boxicons.js"></script>
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://ssl.daumcdn.net/dmaps/map_js_init/postcode.v2.js?autoload=false"></script>
    <!-- Styles --><link href="{{ asset('css/mall.css') }}" rel="stylesheet">
    <style>
        body { padding: 0px; margin: 0px; }
    </style>
</head>
<body id="app">
    <div class="content">
        @yield('content')
    </div>
</body>
</html>
