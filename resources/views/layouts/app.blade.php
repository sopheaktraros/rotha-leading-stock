<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ mix('css/vendor.css') }}" rel="stylesheet">

    @stack('plugin')

    @stack('css')

</head>
<body>
    <div id="app">
        <div class="main-wrapper">
            <div class="navbar-bg"></div>
            <nav class="navbar navbar-expand-lg main-navbar">
                @include('partials.header')
            </nav>
            <div class="main-sidebar">
                @include('partials.sidebar')
            </div>

            <!-- Main Content -->
            <div class="main-content">
                @yield('content')
            </div>

            @yield('quick-sidebar')

            <footer class="main-footer d-none">
                @include('partials.footer')
            </footer>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ mix('js/vendor.js') }}"></script>
    <script src="{{ mix('js/api.js') }}"></script>

    @stack('scripts')

    @include('partials.toast')
</body>
</html>
