@extends('admin::layouts.landing')

@section('page_title')
LeadBrowser - Prospects AI browser
@stop

@section('content-wrapper')
<div>
    <div class="position-relative bg-img-start">
        <div
            class="container content-space-t-3 content-space-t-lg-5 content-space-b-2 content-space-b-lg-3 position-relative zi-2">
            <div class="row justify-content-lg-between align-items-md-center">
                <div class="col-md-6 col-lg-5 mb-10 mb-md-0">

                    <div class="">
                        <h1 class="display-4">Prospects AI browser</h1>
                        <p class="lead">Unique AI tool to extract contact details from all over the Internet, from
                            all over the world in the real time.</p>
                    </div>
                    <div class="d-grid d-sm-flex gap-3">
                        <a class="btn btn-primary btn-transition"href="{{ route('auth.register.create') }}">Get started</a>
                        <a class="btn btn-link"href="{{ route('auth.register.create') }}">Let's Talk <i class="bi-chevron-right small ms-1"></i></a>
                    </div>
                    <p class="form-text small">Start free trial. * No credit card required.</p>
                </div>
                <!-- End Col -->

                <div class="col-md-6">
                    <div class="row justify-content-end">
                        <div class="col-3 mb-4">
                            <!-- Logo -->
                            <div class="d-block avatar avatar-lg rounded-circle shadow-sm p-3 mt-n3 ms-5 aos-init aos-animate"
                                data-aos="fade-up">
                                <img class="avatar-img"
                                    src="{{ asset('vendor/leadBrowser/admin/assets/images/aws.svg') }}" alt="Image AWS">
                            </div>
                            <!-- End Logo -->
                        </div>
                        <div class="col-4 mb-4">
                            <!-- Logo -->
                            <div class="d-block avatar avatar-xl rounded-circle shadow-sm p-4 mx-auto mt-5 aos-init aos-animate"
                                data-aos="fade-up" data-aos-delay="50">
                                <img class="avatar-img"
                                    src="{{ asset('vendor/leadBrowser/admin/assets/images/linkedin.svg') }}"
                                    alt="Image Linkedin">
                            </div>
                            <!-- End Logo -->
                        </div>
                        <div class="col-4 mb-4">
                            <!-- Logo -->
                            <div class="d-block avatar avatar-xl rounded-circle shadow-sm p-4 ms-auto aos-init aos-animate"
                                data-aos="fade-up" data-aos-delay="150">
                                <img class="avatar-img"
                                    src="{{ asset('vendor/leadBrowser/admin/assets/images/rss.svg') }}" alt="Image RSS">
                            </div>
                            <!-- End Logo -->
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-3 offset-1 my-4">
                            <!-- Logo -->
                            <div class="d-block avatar avatar-xl rounded-circle shadow-sm p-4 ms-auto aos-init aos-animate"
                                data-aos="fade-up" data-aos-delay="200">
                                <img class="avatar-img"
                                    src="{{ asset('vendor/leadBrowser/admin/assets/images/google.svg') }}"
                                    alt="Image Google">
                            </div>
                            <!-- End Logo -->
                        </div>
                        <div class="col-3 offset-2 my-4">
                            <!-- Logo -->
                            <div class="d-block avatar avatar-xl rounded-circle shadow-sm p-4 ms-auto aos-init aos-animate"
                                data-aos="fade-up" data-aos-delay="250">
                                <img class="avatar-img"
                                    src="{{ asset('vendor/leadBrowser/admin/assets/images/facebook.svg') }}"
                                    alt="Image Facebook">
                            </div>
                            <!-- End Logo -->
                        </div>
                    </div>

                    <div class="row d-none d-md-flex">
                        <div class="col-6">
                            <!-- Logo -->
                            <div class="d-block avatar avatar-lg rounded-circle shadow-sm p-3 ms-auto aos-init aos-animate"
                                data-aos="fade-up" data-aos-delay="300">
                                <img class="avatar-img"
                                    src="{{ asset('vendor/leadBrowser/admin/assets/images/tesla.svg') }}"
                                    alt="Image Tesla">
                            </div>
                            <!-- End Logo -->
                        </div>
                        <div class="col-6 mt-6">
                            <!-- Logo -->
                            <div class="d-block avatar avatar-xl rounded-circle shadow-sm p-4 ms-auto aos-init aos-animate"
                                data-aos="fade-up" data-aos-delay="350">
                                <img class="avatar-img"
                                    src="{{ asset('vendor/leadBrowser/admin/assets/images/hp.svg') }}" alt="Image HP">
                            </div>
                            <!-- End Logo -->
                        </div>
                    </div>
                </div>
                <!-- End Col -->
            </div>
            <!-- End Row -->
        </div>

        <!-- Shape -->
        <div class="shape shape-bottom zi-1">
            <svg width="3000" height="500" viewBox="0 0 3000 500" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 500H3000V0L0 500Z" fill="#fff"></path>
            </svg>
        </div>
        <!-- End Shape -->
    </div>

    <div id="featuresSection" class="container content-space-t-2 content-space-b-md-2 content-space-lg-3">
        <!-- Heading -->
        <div class="w-md-75 w-lg-50 text-center mx-md-auto mb-5 mb-md-9">
            <h2 class="h1">Key benefits</h2>
            <p>A revolutionary new way to obtain business contact details.</p>
        </div>
        <!-- End Heading -->

        <div class="row gx-3">
            <div class="col-sm-6 col-lg-3 mb-3 mb-lg-0">
                <!-- Card -->
                <a class="card card-sm card-transition h-100" href="#">
                    <div class="card-body">
                        <span class="svg-icon text-primary mb-3">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M6 21C6 21.6 6.4 22 7 22H17C17.6 22 18 21.6 18 21V20H6V21Z" fill="#035A4B">
                                </path>
                                <path opacity="0.3" d="M17 2H7C6.4 2 6 2.4 6 3V20H18V3C18 2.4 17.6 2 17 2Z"
                                    fill="#035A4B"></path>
                                <path d="M12 4C11.4 4 11 3.6 11 3V2H13V3C13 3.6 12.6 4 12 4Z" fill="#035A4B"></path>
                            </svg>

                        </span>

                        <h4 class="card-title">Live lead generator</h4>
                        <p class="card-text text-body">The innovative mechanism allows you to obtain data in real
                            time, so you can be 100% sure that the data is up-to-date.</p>
                    </div>

                    <div class="card-footer pt-0">
                        <span class="card-link">Learn more <i class="bi-chevron-right small ms-1"></i></span>
                    </div>
                </a>
                <!-- End Card -->
            </div>
            <!-- End Col -->

            <div class="col-sm-6 col-lg-3 mb-3 mb-lg-0">
                <!-- Card -->
                <a class="card card-sm card-transition h-100" href="#">
                    <div class="card-body">
                        <span class="svg-icon text-primary mb-3">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M17.5 11H6.5C4 11 2 9 2 6.5C2 4 4 2 6.5 2H17.5C20 2 22 4 22 6.5C22 9 20 11 17.5 11ZM15 6.5C15 7.9 16.1 9 17.5 9C18.9 9 20 7.9 20 6.5C20 5.1 18.9 4 17.5 4C16.1 4 15 5.1 15 6.5Z"
                                    fill="#035A4B"></path>
                                <path opacity="0.3"
                                    d="M17.5 22H6.5C4 22 2 20 2 17.5C2 15 4 13 6.5 13H17.5C20 13 22 15 22 17.5C22 20 20 22 17.5 22ZM4 17.5C4 18.9 5.1 20 6.5 20C7.9 20 9 18.9 9 17.5C9 16.1 7.9 15 6.5 15C5.1 15 4 16.1 4 17.5Z"
                                    fill="#035A4B"></path>
                            </svg>

                        </span>

                        <h4 class="card-title">Customizable</h4>
                        <p class="card-text text-body">Before generating new data, you choose what data you want to
                            obtain.</p>
                    </div>

                    <div class="card-footer pt-0">
                        <span class="card-link">Learn more <i class="bi-chevron-right small ms-1"></i></span>
                    </div>
                </a>
                <!-- End Card -->
            </div>
            <!-- End Col -->

            <div class="col-sm-6 col-lg-3 mb-3 mb-sm-0">
                <!-- Card -->
                <a class="card card-sm card-transition h-100" href="#">
                    <div class="card-body">
                        <span class="svg-icon text-primary mb-3">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path opacity="0.3" fill-rule="evenodd" clip-rule="evenodd"
                                    d="M4 4L11.6314 2.56911C11.875 2.52343 12.125 2.52343 12.3686 2.56911L20 4V11.9033C20 15.696 18.0462 19.2211 14.83 21.2313L12.53 22.6687C12.2057 22.8714 11.7943 22.8714 11.47 22.6687L9.17001 21.2313C5.95382 19.2211 4 15.696 4 11.9033L4 4Z"
                                    fill="#035A4B"></path>
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M11.175 14.75C10.9354 14.75 10.6958 14.6542 10.5042 14.4625L8.58749 12.5458C8.20415 12.1625 8.20415 11.5875 8.58749 11.2042C8.97082 10.8208 9.59374 10.8208 9.92915 11.2042L11.175 12.45L14.3375 9.2875C14.7208 8.90417 15.2958 8.90417 15.6792 9.2875C16.0625 9.67083 16.0625 10.2458 15.6792 10.6292L11.8458 14.4625C11.6542 14.6542 11.4146 14.75 11.175 14.75Z"
                                    fill="#035A4B"></path>
                            </svg>

                        </span>

                        <h4 class="card-title">Hyper validation <span
                                class="badge badge-success badge-pill ml-1">new</span></h4>
                        <p class="card-text text-body">The system adapts to the country of the customer and checks
                            all data like tax number and extracts the data that is readable for you.</p>
                    </div>

                    <div class="card-footer pt-0">
                        <span class="card-link">Learn more <i class="bi-chevron-right small ms-1"></i></span>
                    </div>
                </a>
                <!-- End Card -->
            </div>
            <!-- End Col -->

            <div class="col-sm-6 col-lg-3">
                <!-- Card -->
                <a class="card card-sm card-transition h-100" href="#">
                    <div class="card-body">
                        <span class="svg-icon text-primary mb-3">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path opacity="0.3" fill-rule="evenodd" clip-rule="evenodd"
                                    d="M4.85714 1H11.7364C12.0911 1 12.4343 1.12568 12.7051 1.35474L17.4687 5.38394C17.8057 5.66895 18 6.08788 18 6.5292V19.0833C18 20.8739 17.9796 21 16.1429 21H4.85714C3.02045 21 3 20.8739 3 19.0833V2.91667C3 1.12612 3.02045 1 4.85714 1ZM7 13C7 12.4477 7.44772 12 8 12H15C15.5523 12 16 12.4477 16 13C16 13.5523 15.5523 14 15 14H8C7.44772 14 7 13.5523 7 13ZM8 16C7.44772 16 7 16.4477 7 17C7 17.5523 7.44772 18 8 18H11C11.5523 18 12 17.5523 12 17C12 16.4477 11.5523 16 11 16H8Z"
                                    fill="#035A4B"></path>
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M6.85714 3H14.7364C15.0911 3 15.4343 3.12568 15.7051 3.35474L20.4687 7.38394C20.8057 7.66895 21 8.08788 21 8.5292V21.0833C21 22.8739 20.9796 23 19.1429 23H6.85714C5.02045 23 5 22.8739 5 21.0833V4.91667C5 3.12612 5.02045 3 6.85714 3ZM7 13C7 12.4477 7.44772 12 8 12H15C15.5523 12 16 12.4477 16 13C16 13.5523 15.5523 14 15 14H8C7.44772 14 7 13.5523 7 13ZM8 16C7.44772 16 7 16.4477 7 17C7 17.5523 7.44772 18 8 18H11C11.5523 18 12 17.5523 12 17C12 16.4477 11.5523 16 11 16H8Z"
                                    fill="#035A4B"></path>
                            </svg>

                        </span>

                        <h4 class="card-title">CRM</h4>
                        <p class="card-text text-body">Our CRM panel is integrated with data acquisition, so you can
                            handle the generated data in one click.</p>
                    </div>

                    <div class="card-footer pt-0">
                        <span class="card-link">Learn more <i class="bi-chevron-right small ms-1"></i></span>
                    </div>
                </a>
                <!-- End Card -->
            </div>
            <!-- End Col -->
        </div>
        <!-- End Row -->
    </div>

    <div class="container d-none d-md-block">
        <div class="bg-soft-primary p-4 pb-md-0 pe-md-0 pt-md-10 ps-md-7">
            <div class="position-relative overflow-hidden">
                <div class="row justify-content-lg-between">
                    <div class="col-md-4 py-5 pb-md-10">
                        <div class="mb-5">
                            <h2>You have a free CRM that will allow you to handle the obtained data</h2>
                        </div>

                        <a class="btn btn-outline-primary" href="{{ route('auth.register.create') }}">Sign up
                            today</a>
                    </div>
                    <!-- End Col -->

                    <div class="col-sm-6 col-lg-5">
                        <!-- Devices -->
                        <div class="devices position-absolute top-0 start-50">
                            <!-- Browser Device -->
                            <figure class="device-browser-frame rotated-3d-left">
                                <div class="device-browser-frame">
                                    <img class="device-browser-img"
                                        src="{{ asset('vendor/leadBrowser/admin/assets/images/screen.png') }}"
                                        alt="Image Description">
                                </div>
                            </figure>
                            <!-- End Browser Device -->
                        </div>
                        <!-- End Devices -->

                        <!-- Devices -->
                        <div class="devices position-absolute top-0 start-50 mt-10 ms-5">
                            <!-- Browser Device -->
                            <figure class="device-browser-frame rotated-3d-left">
                                <div class="device-browser-frame">
                                    <img class="device-browser-img"
                                        src="{{ asset('vendor/leadBrowser/admin/assets/images/screen.png') }}"
                                        alt="Image Description">
                                </div>
                            </figure>
                            <!-- End Browser Device -->
                        </div>
                        <!-- End Devices -->
                    </div>
                    <!-- End Col -->
                </div>
                <!-- End Row -->
            </div>
        </div>
    </div>

    <div id="pricingSection" class="container content-space-2 content-space-lg-3">
        <!-- Heading -->
        <div class="w-md-75 w-lg-50 text-center mx-md-auto mb-5 mb-md-9">
            <h2 class="h1">Pricing</h2>
            <p>No additional costs. Pay for what you use.</p>
        </div>
        <!-- End Heading -->

        <div class="row align-items-lg-center pb-5">
            <div class="col-sm-6 col-lg-5 mb-9 mb-sm-0">
                <pricing-box></pricing-box>
            </div>
            <!-- End Col -->

            <div class="col-sm-6 col-lg-7">
                <div class="ps-sm-6">
                    <div class="row">
                        <div class="col-sm-12 col-lg-6 mb-3 aos-init aos-animate" data-aos="fade-up"
                            data-aos-delay="100">
                            <span class="svg-icon text-primary mb-3">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path opacity="0.3"
                                        d="M21.25 18.525L13.05 21.825C12.35 22.125 11.65 22.125 10.95 21.825L2.75 18.525C1.75 18.125 1.75 16.725 2.75 16.325L4.04999 15.825L10.25 18.325C10.85 18.525 11.45 18.625 12.05 18.625C12.65 18.625 13.25 18.525 13.85 18.325L20.05 15.825L21.35 16.325C22.35 16.725 22.35 18.125 21.25 18.525ZM13.05 16.425L21.25 13.125C22.25 12.725 22.25 11.325 21.25 10.925L13.05 7.62502C12.35 7.32502 11.65 7.32502 10.95 7.62502L2.75 10.925C1.75 11.325 1.75 12.725 2.75 13.125L10.95 16.425C11.65 16.725 12.45 16.725 13.05 16.425Z"
                                        fill="#035A4B"></path>
                                    <path
                                        d="M11.05 11.025L2.84998 7.725C1.84998 7.325 1.84998 5.925 2.84998 5.525L11.05 2.225C11.75 1.925 12.45 1.925 13.15 2.225L21.35 5.525C22.35 5.925 22.35 7.325 21.35 7.725L13.05 11.025C12.45 11.325 11.65 11.325 11.05 11.025Z"
                                        fill="#035A4B"></path>
                                </svg>

                            </span>

                            <h4>CRM</h4>
                            <p>Free access to the CRM panel for managing the obtained data.</p>
                        </div>
                        <!-- End Col -->

                        <div class="col-sm-12 col-lg-6 mb-3 aos-init aos-animate" data-aos="fade-up"
                            data-aos-delay="150">
                            <span class="svg-icon text-primary mb-3">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path opacity="0.3" fill-rule="evenodd" clip-rule="evenodd"
                                        d="M5 15L3 21.5L9.5 19.5L5 15Z" fill="#035A4B"></path>
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M13.5 21C18.7467 21 23 16.7467 23 11.5C23 6.2533 18.7467 2 13.5 2C8.2533 2 4 6.2533 4 11.5C4 16.7467 8.2533 21 13.5 21ZM13.5 14.0061L11.5463 15.0332C11.3124 15.1562 11.0232 15.0663 10.9003 14.8324C10.8513 14.7393 10.8344 14.6326 10.8522 14.5289L11.2254 12.3533L9.6447 10.8126C9.4555 10.6282 9.45165 10.3254 9.63605 10.1362C9.7095 10.0609 9.8057 10.0118 9.9098 9.9967L12.0942 9.67925L13.0711 7.69985C13.1881 7.46295 13.4749 7.3657 13.7118 7.4826C13.8061 7.52915 13.8825 7.60555 13.9291 7.69985L14.9059 9.67925L17.0903 9.9967C17.3517 10.0347 17.5329 10.2774 17.4949 10.5388C17.4798 10.6429 17.4307 10.7392 17.3554 10.8126L15.7748 12.3533L16.1479 14.5289C16.1926 14.7893 16.0177 15.0366 15.7573 15.0813C15.6537 15.0991 15.5469 15.0822 15.4538 15.0332L13.5 14.0061Z"
                                        fill="#035A4B"></path>
                                </svg>

                            </span>

                            <h4>AI analyze</h4>
                            <p>Each result is processed with AI technology.</p>
                        </div>
                        <!-- End Col -->

                        <div class="col-sm-12 col-lg-6 mb-3 mb-sm-0 aos-init aos-animate" data-aos="fade-up"
                            data-aos-delay="200">
                            <span class="svg-icon text-primary mb-3">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path opacity="0.3"
                                        d="M12 10.6L14.8 7.8C15.2 7.4 15.8 7.4 16.2 7.8C16.6 8.2 16.6 8.80002 16.2 9.20002L13.4 12L12 10.6ZM10.6 12L7.8 14.8C7.4 15.2 7.4 15.8 7.8 16.2C8 16.4 8.3 16.5 8.5 16.5C8.7 16.5 8.99999 16.4 9.19999 16.2L12 13.4L10.6 12Z"
                                        fill="#035A4B"></path>
                                    <path
                                        d="M22 12C22 17.5 17.5 22 12 22C6.5 22 2 17.5 2 12C2 6.5 6.5 2 12 2C17.5 2 22 6.5 22 12ZM13.4 12L16.2 9.20001C16.6 8.80001 16.6 8.19999 16.2 7.79999C15.8 7.39999 15.2 7.39999 14.8 7.79999L12 10.6L9.2 7.79999C8.8 7.39999 8.2 7.39999 7.8 7.79999C7.4 8.19999 7.4 8.80001 7.8 9.20001L10.6 12L7.8 14.8C7.4 15.2 7.4 15.8 7.8 16.2C8 16.4 8.3 16.5 8.5 16.5C8.7 16.5 9 16.4 9.2 16.2L12 13.4L14.8 16.2C15 16.4 15.3 16.5 15.5 16.5C15.7 16.5 16 16.4 16.2 16.2C16.6 15.8 16.6 15.2 16.2 14.8L13.4 12Z"
                                        fill="#035A4B"></path>
                                </svg>

                            </span>

                            <h4>Cancel anytime</h4>
                            <p>If its not for you, just cancel, no hidden costs or fees.</p>
                        </div>
                        <!-- End Col -->

                        <div class="col-sm-12 col-lg-6 aos-init aos-animate" data-aos="fade-up" data-aos-delay="250">
                            <span class="svg-icon text-primary mb-3">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path opacity="0.3"
                                        d="M12.5 22C11.9 22 11.5 21.6 11.5 21V3C11.5 2.4 11.9 2 12.5 2C13.1 2 13.5 2.4 13.5 3V21C13.5 21.6 13.1 22 12.5 22Z"
                                        fill="#035A4B"></path>
                                    <path
                                        d="M17.8 14.7C17.8 15.5 17.6 16.3 17.2 16.9C16.8 17.6 16.2 18.1 15.3 18.4C14.5 18.8 13.5 19 12.4 19C11.1 19 10 18.7 9.10001 18.2C8.50001 17.8 8.00001 17.4 7.60001 16.7C7.20001 16.1 7 15.5 7 14.9C7 14.6 7.09999 14.3 7.29999 14C7.49999 13.8 7.80001 13.6 8.20001 13.6C8.50001 13.6 8.69999 13.7 8.89999 13.9C9.09999 14.1 9.29999 14.4 9.39999 14.7C9.59999 15.1 9.8 15.5 10 15.8C10.2 16.1 10.5 16.3 10.8 16.5C11.2 16.7 11.6 16.8 12.2 16.8C13 16.8 13.7 16.6 14.2 16.2C14.7 15.8 15 15.3 15 14.8C15 14.4 14.9 14 14.6 13.7C14.3 13.4 14 13.2 13.5 13.1C13.1 13 12.5 12.8 11.8 12.6C10.8 12.4 9.99999 12.1 9.39999 11.8C8.69999 11.5 8.19999 11.1 7.79999 10.6C7.39999 10.1 7.20001 9.39998 7.20001 8.59998C7.20001 7.89998 7.39999 7.19998 7.79999 6.59998C8.19999 5.99998 8.80001 5.60005 9.60001 5.30005C10.4 5.00005 11.3 4.80005 12.3 4.80005C13.1 4.80005 13.8 4.89998 14.5 5.09998C15.1 5.29998 15.6 5.60002 16 5.90002C16.4 6.20002 16.7 6.6 16.9 7C17.1 7.4 17.2 7.69998 17.2 8.09998C17.2 8.39998 17.1 8.7 16.9 9C16.7 9.3 16.4 9.40002 16 9.40002C15.7 9.40002 15.4 9.29995 15.3 9.19995C15.2 9.09995 15 8.80002 14.8 8.40002C14.6 7.90002 14.3 7.49995 13.9 7.19995C13.5 6.89995 13 6.80005 12.2 6.80005C11.5 6.80005 10.9 7.00005 10.5 7.30005C10.1 7.60005 9.79999 8.00002 9.79999 8.40002C9.79999 8.70002 9.9 8.89998 10 9.09998C10.1 9.29998 10.4 9.49998 10.6 9.59998C10.8 9.69998 11.1 9.90002 11.4 9.90002C11.7 10 12.1 10.1 12.7 10.3C13.5 10.5 14.2 10.7 14.8 10.9C15.4 11.1 15.9 11.4 16.4 11.7C16.8 12 17.2 12.4 17.4 12.9C17.6 13.4 17.8 14 17.8 14.7Z"
                                        fill="#035A4B"></path>
                                </svg>

                            </span>

                            <h4>Money back</h4>
                            <p>100% guaranteed money back. No questions asked.</p>
                        </div>
                        <!-- End Col -->
                    </div>
                    <!-- End Row -->
                </div>
            </div>
            <!-- End Col -->
        </div>
        <!-- End Row -->

        <div class="row align-items-lg-center pt-5">
            <div class="col-12">
                <faq-list></faq-list>
            </div>
        </div>
    </div>

    <!-- Clients -->
    <div class="position-relative overflow-hidden content-space-t-2">
        <div class="position-absolute top-50 start-50 translate-middle w-100">
            <div class="container-fluid px-lg-6">
                <div class="row justify-content-center">
                    <div class="col-3 my-4">
                        <div class="d-none d-md-block avatar avatar-xl rounded-circle shadow-sm p-4 mx-auto">
                            <img class="avatar-img" src="{{ asset('vendor/leadBrowser/admin/assets/images/hp.svg') }}"
                                alt="Logo">
                        </div>
                    </div>
                    <!-- End Col -->

                    <div class="col-3 mb-4">
                        <div class="d-block avatar avatar-xl rounded-circle shadow-sm p-4 mx-auto">
                            <img class="avatar-img" src="{{ asset('vendor/leadBrowser/admin/assets/images/aws.svg') }}"
                                alt="Logo">
                        </div>
                    </div>
                    <!-- End Col -->

                    <div class="col-3 my-4">
                        <div class="d-none d-md-block avatar avatar-xl rounded-circle shadow-sm p-4 mx-auto">
                            <img class="avatar-img"
                                src="{{ asset('vendor/leadBrowser/admin/assets/images/facebook.svg') }}" alt="Logo">
                        </div>
                    </div>
                    <!-- End Col -->
                </div>
                <!-- End Row -->

                <div class="row justify-content-between">
                    <div class="col-3 mb-4">
                        <div class="d-block avatar avatar-xl rounded-circle shadow-sm p-4">
                            <img class="avatar-img" src="{{ asset('vendor/leadBrowser/admin/assets/images/aws.svg') }}"
                                alt="Logo">
                        </div>
                    </div>
                    <!-- End Col -->

                    <div class="col-3 my-4">
                        <div class="d-block avatar avatar-xl rounded-circle shadow-sm p-4 ms-auto">
                            <img class="avatar-img" src="{{ asset('vendor/leadBrowser/admin/assets/images/aws.svg') }}"
                                alt="Logo">
                        </div>
                    </div>
                    <!-- End Col -->
                </div>
                <!-- End Row -->

                <div class="row">
                    <div class="col-3 offset-1 my-4">
                        <div class="d-none d-md-block avatar avatar-xl rounded-circle shadow-sm p-4 ms-auto">
                            <img class="avatar-img" src="{{ asset('vendor/leadBrowser/admin/assets/images/tesla.svg') }}"
                                alt="Logo">
                        </div>
                    </div>
                    <!-- End Col -->

                    <div class="col-3 offset-2 my-4">
                        <div class="d-none d-md-block avatar avatar-xl rounded-circle shadow-sm p-4 ms-auto">
                            <img class="avatar-img" src="{{ asset('vendor/leadBrowser/admin/assets/images/aws.svg') }}"
                                alt="Logo">
                        </div>
                    </div>
                    <!-- End Col -->
                </div>
                <!-- End Row -->

                <div class="row justify-content-between">
                    <div class="col-4">
                        <div class="d-block avatar avatar-xl rounded-circle shadow-sm p-4 mx-auto">
                            <img class="avatar-img"
                                src="{{ asset('vendor/leadBrowser/admin/assets/images/google.svg') }}" alt="Logo">
                        </div>
                    </div>
                    <!-- End Col -->

                    <div class="col-4 mt-6">
                        <div class="d-none d-sm-block avatar avatar-xl rounded-circle shadow-sm p-4 mx-auto">
                            <img class="avatar-img" src="{{ asset('vendor/leadBrowser/admin/assets/images/aws.svg') }}"
                                alt="Logo">
                        </div>
                    </div>
                    <!-- End Col -->

                    <div class="col-4 mt-6">
                        <div class="d-block avatar avatar-xl rounded-circle shadow-sm p-4 mx-auto">
                            <img class="avatar-img" src="{{ asset('vendor/leadBrowser/admin/assets/images/aws.svg') }}"
                                alt="Logo">
                        </div>
                    </div>
                    <!-- End Col -->
                </div>
                <!-- End Row -->
            </div>
        </div>

        <div class="container position-relative zi-1 content-space-3 content-space-sm-4">
            <!-- Heading -->
            <div class="w-md-75 w-lg-50 text-center mx-md-auto">
                <h2 class="h1">Unique technology</h2>
                <p>We search the internet in real time. We go from page to page, so that you do not have to download
                    data from ready databases, and you can decide what you want to download.</p>
                <a class="link" href="#">Check how we work <i class="bi-chevron-right small ms-1"></i></a>
            </div>
            <!-- End Heading -->
        </div>

        <div class="gradient-y-lg-white position-absolute top-0 start-0 w-100 h-100"></div>
    </div>
    <!-- End Clients -->

</div>
@stop
