<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <title>@yield('page_title')</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('vendor/leadBrowser/admin/assets/images/favicon/apple-icon-57x57.png') }}">
        <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('vendor/leadBrowser/admin/assets/images/favicon/apple-icon-60x60.png') }}">
        <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('vendor/leadBrowser/admin/assets/images/favicon/apple-icon-72x72.png') }}">
        <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('vendor/leadBrowser/admin/assets/images/favicon/apple-icon-76x76.png') }}">
        <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('vendor/leadBrowser/admin/assets/images/favicon/apple-icon-114x114.png') }}">
        <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('vendor/leadBrowser/admin/assets/images/favicon/apple-icon-120x120.png') }}">
        <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('vendor/leadBrowser/admin/assets/images/favicon/apple-icon-144x144.png') }}">
        <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('vendor/leadBrowser/admin/assets/images/favicon/apple-icon-152x152.png') }}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('vendor/leadBrowser/admin/assets/images/favicon/apple-icon-180x180.png') }}">
        <link rel="icon" type="image/png" sizes="192x192"  href="{{ asset('vendor/leadBrowser/admin/assets/images/favicon/android-icon-192x192.png') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('vendor/leadBrowser/admin/assets/images/favicon/favicon-32x32.png') }}">
        <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('vendor/leadBrowser/admin/assets/images/favicon/favicon-96x96.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('vendor/leadBrowser/admin/assets/images/favicon/favicon-16x16.png') }}">
        <link rel="manifest" href="{{ asset('vendor/leadBrowser/admin/assets/images/favicon/manifest.json') }}">

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
        
        <link rel="stylesheet" href="{{ asset('vendor/leadBrowser/ui/assets/css/ui.css') }}">
       
        <!-- TODO? -->
        <script src="https://js.pusher.com/7.0/pusher.min.js"></script>

        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-3JC7BMR1B3"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', 'G-3JC7BMR1B3');
        </script>
        
        @yield('head')

        @yield('css')
        @stack('css')

        {!! view_render_event('layout.head') !!}

    </head>

    <body class="has-navbar-vertical-aside navbar-vertical-aside-show-xl footer-offset">
        {!! view_render_event('layout.body.before') !!}

        <div id="app">
            <spinner-meter :full-page="true" v-if="!pageLoaded"></spinner-meter>

            <flash-wrapper ref='flashes'></flash-wrapper>

            {!! view_render_event('layout.nav-left.before') !!}

            @include ('admin::layouts.nav-left')

            {!! view_render_event('layout.nav-left.after') !!}

            <div id="content" role="main" class="main" v-bind:class="{'open-content': !isMenuOpen}">

                {!! view_render_event('layout.nav-top.before') !!}

                @include ('admin::layouts.nav-top')

                {!! view_render_event('layout.nav-top.after') !!}

                <div class="content content-dashboard container-fluid" v-bind:class="{'navbar-vertical-aside-mini-mode': isMenuOpen}">

                    <!-- <div class="alert alert-primary mt-5" role="alert">
                        <div class="d-flex">
                            <div class="flex-shrink-0">
                                <i class="bi-stars" style="font-size: 30px;"></i>
                            </div>
                            <div class="flex-grow-1 ms-2">
                                Data is directly retrieved from the internet in real time. We do not provide you with the data that we store in our database.
                                <br>Thanks to this, the received data is always up-to-date. <a href="#" style="color:#e0e0e0">More information about our technology.</a>
                            </div>
                        </div>
                    </div> -->

                    {!! view_render_event('layout.content.before') !!}

                    @yield('content-wrapper')

                    {!! view_render_event('layout.content.after') !!}

                    {!! view_render_event('layout.footer.before') !!}

                    @include ('admin::layouts.footer')

                    {!! view_render_event('layout.footer.after') !!}
                </div>
            </div>

        </div>

        <script type="text/javascript">
            window.flashMessages = [];

            @foreach (['success', 'warning', 'error', 'info'] as $key)
                @if ($value = session($key))
                    window.flashMessages.push({'type': '{{ $key }}', 'message': "{{ $value }}" });
                @endif
            @endforeach

            window.serverErrors = [];

            @if (isset($errors) && count($errors))
                window.serverErrors = @json($errors->getMessages());
            @endif

            window._translations = {};
            window._translations['ui'] = @json(app('LeadBrowser\Core\Helpers\Helper')->jsonTranslations("UI"));
            window.baseURL = '{{ url()->to('/') }}';
            window.params = @json(request()->route()->parameters());
        </script>

        <!-- Hotjar Tracking Code for https://konstelacja.co/ -->
        <script>
            (function(h,o,t,j,a,r){
                h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
                h._hjSettings={hjid:3070994,hjsv:6};
                a=o.getElementsByTagName('head')[0];
                r=o.createElement('script');r.async=1;
                r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
                a.appendChild(r);
            })(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=');
        </script>

        <script type="text/javascript" src="{{ asset('vendor/leadBrowser/admin/assets/js/admin.js') }}"></script>
        <script type="text/javascript" src="{{ asset('vendor/leadBrowser/ui/assets/js/ui.js') }}"></script>

        @stack('scripts')

        {!! view_render_event('layout.body.after') !!}

        <div class="modal-overlay"></div>

    </body>
</html>
