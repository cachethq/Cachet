<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="apple-mobile-web-app-capable" content="yes">

    <meta name="env" content="{{ app('env') }}">
    <meta name="token" content="{{ csrf_token() }}">

    <link rel="icon" type="image/png" href="{{ asset('/img/favicon.ico') }}">
    <link rel="shortcut icon" href="{{ asset('/img/apple-touch-icon.png') }}" type="image/x-icon">

    <link rel="apple-touch-icon" href="{{ asset('/img/apple-touch-icon.png') }}">
    <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('/img/apple-touch-icon-57x57.png') }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('/img/apple-touch-icon-72x72.png') }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('/img/apple-touch-icon-114x114.png') }}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('/img/apple-touch-icon-120x120.png') }}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('/img/apple-touch-icon-144x144.png') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('/img/apple-touch-icon-152x152.png') }}">

    <title>{{ $pageTitle ?? $siteTitle }}</title>

    @if($enableExternalDependencies)
    {{-- <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700&subset={{ $fontSubset }}" rel="stylesheet" type="text/css"> --}}
    @endif
    <link rel="stylesheet" href="{{ asset(mix('dist/css/dashboard/dashboard.css')) }}">
    @yield('css')

    @include('partials.crowdin')

    <script type="text/javascript">
        var Global = {};
        Global.locale = '{{ $appLocale }}';
    </script>

    <script src="{{ asset(mix('dist/js/manifest.js')) }}"></script>
    <script src="{{ asset(mix('dist/js/vendor.js')) }}"></script>
</head>

<body class="@yield('bodyClass')">
    <div class="content" id="app">
        @yield('content')
    </div>
</body>
@yield('js')
<script src="{{ asset(mix('dist/js/all.js')) }}"></script>
</html>
