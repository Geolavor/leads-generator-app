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

    @include ('admin::layouts.nav-landing-top')

    {!! view_render_event('layout.nav-landing-top.after') !!}

    <main id="app" role="main">
        <div class="container content-space-1 content-space-md-3">
            <div class="row">

                <div class="col-md-4 col-lg-3 mb-3 mb-md-0">
                    <!-- Navbar -->
                    <div class="navbar-expand-md">
                        <!-- Navbar Toggle -->
                        <div class="d-grid">
                            <button type="button" class="navbar-toggler btn btn-white mb-3" data-bs-toggle="collapse"
                                data-bs-target="#navbarVerticalNavMenu" aria-label="Toggle navigation" aria-expanded="false"
                                aria-controls="navbarVerticalNavMenu">
                                <span class="d-flex justify-content-between align-items-center">
                                    <span class="text-dark">Menu</span>

                                    <span class="navbar-toggler-default">
                                        <i class="bi-list"></i>
                                    </span>

                                    <span class="navbar-toggler-toggled">
                                        <i class="bi-x"></i>
                                    </span>
                                </span>
                            </button>
                        </div>
                        <!-- End Navbar Toggle -->

                        <!-- Navbar Collapse -->
                        <div id="navbarVerticalNavMenu" class="collapse navbar-collapse">
                            <ul id="navbarSettings"
                                class="js-sticky-block js-scrollspy nav nav-tabs nav-link-gray nav-vertical">
                                <li class="nav-item">
                                    <a class="{{ (request()->is('terms')) ? 'nav-link active' : 'nav-link' }}" href="{{ route('terms.home') }}">Terms</a>
                                </li>
                                <li class="nav-item">
                                    <a class="{{ (request()->is('privacy')) ? 'nav-link active' : 'nav-link' }}" href="{{ route('privacy.home') }}">Private policy</a>
                                </li>
                                <li class="nav-item">
                                    <a class="{{ (request()->is('robot')) ? 'nav-link active' : 'nav-link' }}" href="{{ route('robot.home') }}">Robot</a>
                                </li>
                            </ul>
                        </div>
                        <!-- End Navbar Collapse -->
                    </div>
                    <!-- End Navbar -->
                </div>
                <div class="col-md-8 col-lg-9">
                    {!! view_render_event('layout.content.before') !!}

                    @yield('content-wrapper')

                    {!! view_render_event('layout.content.after') !!}
                </div>

            </div>
        </div>
    </main>

    {!! view_render_event('layout.footer-landing.before') !!}

    @include ('admin::layouts.footer-landing')

    {!! view_render_event('layout.footer-landing.after') !!}


</body>

</html>
