<html>
    <head>
        <title>@yield('title')</title>
    </head>

    <body>
        <div class="container">
            @yield('content')
        </div>
    </body>

    <link href="{{ secure_asset('css/app.css') }}" rel="stylesheet">

    <script src="{{ secure_asset('js/app.js') }}"></script>

    @yield('scripts')
</html>
