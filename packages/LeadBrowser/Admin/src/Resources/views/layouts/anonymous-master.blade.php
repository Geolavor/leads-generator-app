<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">

<head>
    <title>@yield('page_title')</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="apple-touch-icon" sizes="57x57"
        href="{{ asset('vendor/leadBrowser/admin/assets/images/favicon/apple-icon-57x57.png') }}">
    <link rel="apple-touch-icon" sizes="60x60"
        href="{{ asset('vendor/leadBrowser/admin/assets/images/favicon/apple-icon-60x60.png') }}">
    <link rel="apple-touch-icon" sizes="72x72"
        href="{{ asset('vendor/leadBrowser/admin/assets/images/favicon/apple-icon-72x72.png') }}">
    <link rel="apple-touch-icon" sizes="76x76"
        href="{{ asset('vendor/leadBrowser/admin/assets/images/favicon/apple-icon-76x76.png') }}">
    <link rel="apple-touch-icon" sizes="114x114"
        href="{{ asset('vendor/leadBrowser/admin/assets/images/favicon/apple-icon-114x114.png') }}">
    <link rel="apple-touch-icon" sizes="120x120"
        href="{{ asset('vendor/leadBrowser/admin/assets/images/favicon/apple-icon-120x120.png') }}">
    <link rel="apple-touch-icon" sizes="144x144"
        href="{{ asset('vendor/leadBrowser/admin/assets/images/favicon/apple-icon-144x144.png') }}">
    <link rel="apple-touch-icon" sizes="152x152"
        href="{{ asset('vendor/leadBrowser/admin/assets/images/favicon/apple-icon-152x152.png') }}">
    <link rel="apple-touch-icon" sizes="180x180"
        href="{{ asset('vendor/leadBrowser/admin/assets/images/favicon/apple-icon-180x180.png') }}">
    <link rel="icon" type="image/png" sizes="192x192"
        href="{{ asset('vendor/leadBrowser/admin/assets/images/favicon/android-icon-192x192.png') }}">
    <link rel="icon" type="image/png" sizes="32x32"
        href="{{ asset('vendor/leadBrowser/admin/assets/images/favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="96x96"
        href="{{ asset('vendor/leadBrowser/admin/assets/images/favicon/favicon-96x96.png') }}">
    <link rel="icon" type="image/png" sizes="16x16"
        href="{{ asset('vendor/leadBrowser/admin/assets/images/favicon/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('vendor/leadBrowser/admin/assets/images/favicon/manifest.json') }}">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">

    <link rel="stylesheet" href="{{ asset('vendor/leadBrowser/admin/assets/css/admin.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('vendor/leadBrowser/admin/assets/css/ui.css') }}" type="text/css">


    @yield('head')

    @yield('css')
    @stack('css')

    {!! view_render_event('anonymous-layout.head') !!}
</head>

<body class="d-flex align-items-center min-h-100" data-new-gr-c-s-check-loaded="14.1058.0" data-gr-ext-installed="">
    <!-- ========== HEADER ========== -->
    <header id="header" class="navbar navbar-expand navbar-light navbar-absolute-top">
        <div class="container-fluid">
            <nav class="navbar-nav-wrap">
                <!-- White Logo -->
                <a class="navbar-brand" href="{{ route('landing.home') }}">
                    <img class="navbar-brand-logo-mini logo-mini-border" src="{{ asset('vendor/leadBrowser/admin/assets/images/logotyp-mini.svg') }}" alt="{{ config('app.name') }}"/>
                </a>
                <!-- End White Logo -->

                <div class="ms-auto">
                    <a class="link link-sm link-secondary" href="{{ route('landing.home') }}">
                        <i class="bi-chevron-left small ms-1"></i> Go to main
                    </a>
                </div>
            </nav>
        </div>
    </header>
    <!-- ========== END HEADER ========== -->

    <!-- ========== MAIN CONTENT ========== -->
    <main id="app" role="main" class="flex-grow-1">
        <!-- Form -->
        <div class="container content-space-3 content-space-t-lg-4 content-space-b-lg-3">
            <div class="flex-grow-1 mx-auto" style="max-width: 28rem;">

                <spinner-meter :full-page="true" v-if="! pageLoaded"></spinner-meter>

                <flash-wrapper ref='flashes'></flash-wrapper>

                {!! view_render_event('anonymous-layout.content.before') !!}

                @yield('content')

                {!! view_render_event('layout.content.after') !!}

            </div>
        </div>
        <!-- End Form -->
    </main>
    <!-- ========== END MAIN CONTENT ========== -->
    <script type="text/javascript">
        window.flashMessages = [];

        @if($success = session('success'))
        window.flashMessages = [{
            'type': 'success',
            'message': "{{ $success }}"
        }];
        @elseif($warning = session('warning'))
        window.flashMessages = [{
            'type': 'warning',
            'message': "{{ $warning }}"
        }];
        @elseif($error = session('error'))
        window.flashMessages = [{
            'type': 'error',
            'message': "{{ $error }}"
        }];
        @endif


        window.serverErrors = [];

        @if(isset($errors) && count($errors))
            window.serverErrors = @json($errors->getMessages());
        @endif

    </script>

    <script type="text/javascript" src="{{ asset('vendor/leadBrowser/admin/assets/js/admin.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/leadBrowser/ui/assets/js/ui.js') }}"></script>

    @stack('scripts')

    {!! view_render_event('anonymous-layout.body.after') !!}

</body>

</html>
