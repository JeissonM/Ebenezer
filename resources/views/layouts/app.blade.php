<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Ebenezer') }}</title>
        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script><!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.7 -->
        <link rel="stylesheet" href="{{ asset('bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="{{ asset('bower_components/font-awesome/css/font-awesome.min.css') }}">
        <!-- Ionicons -->
        <link rel="stylesheet" href="{{ asset('bower_components/Ionicons/css/ionicons.min.css') }}">
        <!-- Theme style -->
        <link rel="stylesheet" href="{{ asset('dist/css/AdminLTE.min.css') }}">
        <!-- Material Design -->
        <link rel="stylesheet" href="{{ asset('dist/css/bootstrap-material-design.min.css') }}">
        <link rel="stylesheet" href="{{ asset('dist/css/ripples.min.css') }}">
        <link rel="stylesheet" href="{{ asset('dist/css/MaterialAdminLTE.min.css') }}">
        <!-- Fonts -->
        <link rel="dns-prefetch" href="https://fonts.gstatic.com"><!-- Google Font -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

        <!-- Styles -->
        <!--<link href="{{ asset('css/app.css') }}" rel="stylesheet">-->
    </head>
    <body class="hold-transition login-page" style="background-image: url('{{asset('images/banner01.jpg')}}'); background-position: center center; background-size: cover; background-repeat: no-repeat; background-attachment: fixed;">
        <div id="app">

            <div class="col-md-12">
                @yield('content') 
            </div>
        </div>

        <!-- jQuery 3 -->
        <script src="{{ asset('bower_components/jquery/dist/jquery.min.js')}}"></script>
        <!-- Bootstrap 3.3.7 -->
        <script src="{{ asset('bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
        <!-- Material Design -->
        <script src="{{ asset('dist/js/material.min.js')}}"></script>
        <script src="{{ asset('dist/js/ripples.min.js')}}"></script>
        <script>
            $.material.init();
        </script>
    </body>
</html>
