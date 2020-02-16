<html>
    <head>
        <title>@yield('title')</title>
    </head>

    <body>
        <div class="container">
            @yield('content')
        </div>
    </body>

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <script src="{{ asset('js/app.js') }}"></script>

    @yield('scripts')
</html>
