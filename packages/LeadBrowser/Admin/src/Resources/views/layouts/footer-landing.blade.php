<footer>
        <div class="container pb-1 pb-lg-7">
            <div class="row content-space-t-2">
                <div class="col-lg-3 mb-7 mb-lg-0">
                    <!-- Logo -->
                    <div class="mb-5">
                        <a class="navbar-brand" href="{{ route('landing.home') }}">
                            <img class="navbar-brand-logo-mini logo-mini-border" src="{{ asset('vendor/leadBrowser/admin/assets/images/logotyp-mini.svg') }}" alt="{{ config('app.name') }}"/>
                        </a>
                    </div>
                    <!-- End Logo -->

                    <!-- List -->
                    <ul class="list-unstyled list-py-1">
                        <li>
                            <p>
                                Unique AI tool to extract contact details from all over the Internet, from all over the
                                world in the real time.
                            </p>
                        </li>
                    </ul>
                    <!-- End List -->

                </div>
                <!-- End Col -->

                <div class="col-sm mb-7 mb-sm-0">
                    <h5 class="mb-3">Company</h5>

                    <!-- List -->
                    <ul class="list-unstyled list-py-1 mb-0">
                        <li><a class="link-sm link-secondary" href="#">About</a></li>
                        <li><a class="link-sm link-secondary" href="{{ route('cms.blogs') }}">Blog</a></li>
                        <li><a class="link-sm link-secondary" href="{{ route('contact.create') }}">Contact <i class="bi-box-arrow-up-right small ms-1"></i></a></li>
                    </ul>
                    <!-- End List -->
                </div>
                <!-- End Col -->

                <div class="col-sm mb-7 mb-sm-0">
                    <h5 class="mb-3">Features</h5>

                    <!-- List -->
                    <ul class="list-unstyled list-py-1 mb-0">
                        <li><a class="link-sm link-secondary" href="#">Press <i class="bi-box-arrow-up-right small ms-1"></i></a></li>
                        <li><a class="link-sm link-secondary" href="#">Integrations</a></li>
                        <li><a class="link-sm link-secondary" href="{{ route('pricing.home') }}">Pricing</a></li>
                        <li><a class="link-sm link-secondary" href="{{ route('compare.home') }}">Compare</a></li>
                    </ul>
                    <!-- End List -->
                </div>
                <!-- End Col -->

                <div class="col-sm">
                    <h5 class="mb-3">Documentation</h5>

                    <!-- List -->
                    <ul class="list-unstyled list-py-1 mb-0">
                        <li><a class="link-sm link-secondary" href="#">Support</a></li>
                        <li><a class="link-sm link-secondary" href="#">Status</a></li>
                        <li><a class="link-sm link-secondary" href="https://mariuszmalek.notion.site/API-v1-5a61fbeb57f54b72adc81b4f9af62acd" target="_blank">API Reference</a></li>
                    </ul>
                    <!-- End List -->
                </div>
                <!-- End Col -->

                <div class="col-sm">
                    <h5 class="mb-3">Resources</h5>

                    <!-- List -->
                    <ul class="list-unstyled list-py-1 mb-5">
                        <li><a class="link-sm link-secondary" href="#"><i class="bi-question-circle-fill me-1"></i>
                                Help</a></li>
                        <li><a class="link-sm link-secondary" href="{{ route('claim.create') }}"><i class="bi-employee-circle me-1"></i> Claim</a></li>
                    </ul>
                    <!-- End List -->
                </div>
                <!-- End Col -->
            </div>
            <!-- End Row -->

            <div class="border-top my-7"></div>

            <div class="row mb-7">
                <div class="col-sm mb-3 mb-sm-0">
                    <!-- Socials -->
                    <ul class="list-inline list-separator mb-0">
                        <li class="list-inline-item">
                            <a class="text-body" href="{{ route('privacy.home') }}">Privacy &amp; Policy</a>
                        </li>
                        <li class="list-inline-item">
                            <a class="text-body" href="{{ route('terms.home') }}">Terms</a>
                        </li>
                    </ul>
                    <!-- End Socials -->
                </div>

                <div class="col-sm-auto">
                    <!-- Socials -->
                    <ul class="list-inline mb-0">
                        <li class="list-inline-item">
                            <a class="btn btn-soft-secondary btn-xs btn-icon" href="https://www.facebook.com/konstelacja.co/">
                                <i class="bi-facebook"></i>
                            </a>
                        </li>

                        <li class="list-inline-item">
                            <a class="btn btn-soft-secondary btn-xs btn-icon" href="https://www.linkedin.com/company/konstelacja/">
                                <i class="bi-linkedin"></i>
                            </a>
                        </li>

                        <li class="list-inline-item">
                            <a class="btn btn-soft-secondary btn-xs btn-icon" href="#">
                                <i class="bi-twitter"></i>
                            </a>
                        </li>

                        <li class="list-inline-item">
                            <a class="btn btn-soft-secondary btn-xs btn-icon" href="#">
                                <i class="bi-github"></i>
                            </a>
                        </li>
                    </ul>
                    <!-- End Socials -->
                </div>
            </div>

            <!-- Copyright -->
            <div class="w-md-85 text-lg-center mx-lg-auto">
                <p class="text-muted small">© LeadBrowser 2022. All rights reserved.</p>
            </div>
            <!-- End Copyright -->
        </div>
    </footer>

    {{ \TawkTo::widgetCode() }}

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

    <script type="text/javascript" src="{{ asset('vendor/leadBrowser/admin/assets/js/admin.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/leadBrowser/ui/assets/js/ui.js') }}"></script>

    @stack('scripts')

    {!! view_render_event('layout.body.after') !!}

    <div class="modal-overlay"></div>