<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>The Luck</title>
        <link rel="stylesheet" type="text/css" href="{{mix('css/app.css')}}">
        @routes
        <script src='{{mix('js/eager.js')}}'></script>
        <script src='{{mix('js/app.js')}}' defer></script>
        @stack('scripts')
        @stack('css')
    </head>
    <body>
        @yield('content')
        @stack('scripts_body')
    </body>
</html>
