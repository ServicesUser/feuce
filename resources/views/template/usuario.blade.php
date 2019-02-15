<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{config('app.name')}} | @yield('titulo')</title>
    <meta name="csrf-token" content="{{csrf_token()}}">
    <link href="{{mix('css/app.css')}}" rel="stylesheet" type="text/css">
</head>
<body class="m-page--fluid m-page--loading-enabled m-page--loading m-header--fixed m-header--fixed-mobile m-aside-right--enabled m-aside--offcanvas-default">
    <div class="m-page-loader m-page-loader--base">
        <div class="m-spinner m-spinner--brand"></div>
    </div>
    <div class="m-grid m-grid--hor m-grid--root m-page" id="app">
    @yield('cuerpo')
    </div>
    <script src="{{mix('js/app.bundle.js')}}" type="text/javascript"></script>
    <script src="{{mix('js/app.js')}}" type="text/javascript"></script>
    @component('componentes.soporte')
    @endcomponent
    @yield('scripts')
</body>
</html>