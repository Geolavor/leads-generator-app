<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">

<head>
    <title>@yield('page_title')</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="manifest" href="{{ asset('vendor/leadBrowser/admin/assets/images/favicon/manifest.json') }}">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">

    <link rel="stylesheet" href="{{ asset('vendor/leadBrowser/admin/assets/css/admin.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('vendor/leadBrowser/admin/assets/css/ui.css') }}" type="text/css">

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-3JC7BMR1B3"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-3JC7BMR1B3');

    </script>

    @yield('head')

    @yield('css')
    @stack('css')

    {!! view_render_event('layout.head') !!}

</head>

<body id="homeSection" class="position-relative" data-aos-easing="ease" data-aos-duration="650" data-aos-delay="0">

    {!! view_render_event('layout.nav-landing-top.before') !!}

    <x-core.landing.navbar />

    {!! view_render_event('layout.nav-landing-top.after') !!}

    <main id="app" role="main">
        {!! view_render_event('layout.content.before') !!}

        @yield('content-wrapper')

        {!! view_render_event('layout.content.after') !!}
    </main>

    {!! view_render_event('layout.footer-landing.before') !!}

    <x-core.landing.footer />

    {!! view_render_event('layout.footer-landing.after') !!}


</body>

</html>
