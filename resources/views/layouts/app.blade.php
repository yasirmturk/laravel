<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body>
    <div id="app">
        <!-- Header -->
        @include('layouts.header')
        <!-- Sidebar -->
        @include('layouts.sidebar')
        <!-- Content Wrapper. Contains page content -->
        <main>
            <!-- Content Header (Page header) -->
            <section class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6"></div>
                    <!-- Errors -->
                    @include('components.flash')
                </div>
            </section><!-- /.container-fluid -->
            <!-- Main content -->
            <section class="container">
                @yield('content')
            </section>
        </main>
        <!-- Footer -->
        @include('layouts.footer')
    </div>
</body>

</html>
