<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="env" content="{{ app('env') }}">
    <meta name="token" content="{{ csrf_token() }}">

    <!-- Mobile friendliness -->
    <meta name="HandheldFriendly" content="True">
    <meta name="MobileOptimized" content="320">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="description" content="@yield('description', trans('cachet.meta.description.overview', ['app' => $appName]))">

    <meta property="og:type" content="website">
    <meta property="og:title" content="@yield('title', $siteTitle)">
    <meta property="og:image" content=" {{ asset('/img/apple-touch-icon.png') }}">
    <meta property="og:description" content="@yield('description', trans('cachet.meta.description.overview', ['app' => $appName]))">

    <!-- Mobile IE allows us to activate ClearType technology for smoothing fonts for easy reading -->
    <meta http-equiv="cleartype" content="on">

    <meta name="msapplication-TileColor" content="{{ $themeGreens }}" />
    <meta name="msapplication-TileImage" content="{{ asset('/img/apple-touch-icon.png') }}" />

    <link href="{{ Request::fullUrl() }}" rel="canonical">

    @if (isset($favicon))
    <link rel="icon" href="{{ asset("/img/{$favicon}.ico") }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset("/img/{$favicon}.png") }}" type="image/png">
    @else
    <link rel="icon" href="{{ asset('/img/favicon.ico') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('/img/apple-touch-icon.png') }}" type="image/png">
    @endif

    <link rel="apple-touch-icon" href="{{ asset('/img/apple-touch-icon.png') }}">
    <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('/img/apple-touch-icon-57x57.png') }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('/img/apple-touch-icon-72x72.png') }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('/img/apple-touch-icon-114x114.png') }}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('/img/apple-touch-icon-120x120.png') }}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('/img/apple-touch-icon-144x144.png') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('/img/apple-touch-icon-152x152.png') }}">

    <title>@yield('title', $siteTitle)</title>

    @if($enableExternalDependencies)
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700&amp;subset={{ $fontSubset }}" rel="stylesheet" type="text/css">
    @endif
    <link rel="stylesheet" href="{{ asset(mix('dist/css/app.css')) }} ">

    @include('partials.stylesheet')

    @include('partials.crowdin')

    @if($appStylesheet)
    <style type="text/css">
    {!! $appStylesheet !!}
    </style>
    @endif

    <script type="text/javascript">
        var Global = {};
        var refreshRate = parseInt("{{ $appRefreshRate }}");

        function refresh() {
            window.location.reload(true);
        }

        if (refreshRate > 0) {
            setTimeout(refresh, refreshRate * 1000);
        }

        Global.locale = '{{ $appLocale }}';
    </script>
    <script src="{{ asset(mix('dist/js/manifest.js')) }}"></script>
    <script src="{{ asset(mix('dist/js/vendor.js')) }}"></script>
</head>
<body class="status-page @yield('bodyClass')">
    @yield('outer-content')

    @include('partials.banner')

    <div class="container" id="app">
        @yield('content')
    </div>

    @yield('bottom-content')
    <script src="{{ asset(mix('dist/js/all.js')) }}"></script>
</body>
</html>
