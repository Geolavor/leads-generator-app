@extends('admin::layouts.landing')

@section('page_title')
{{ __('admin::app.settings.sources.title') }}
@stop

@section('content-wrapper')
<div>
    <div class="position-relative bg-dark wave-background">
        <div class="container content-space-t-2 content-space-t-md-3 content-space-3 content-space-b-lg-5">
            <div class="w-lg-50">
                <h1 class="text-white">Pricing</h1>
                <h2 class="h2 text-white">Select the right plan for your business.</h2>
            </div>
        </div>

        <!-- Shape -->
        <div class="shape shape-bottom zi-1" style="margin-bottom: -.125rem">
            <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 1920 100.1">
                <path fill="#fff" d="M0,0c0,0,934.4,93.4,1920,0v100.1H0L0,0z"></path>
            </svg>
        </div>
        <!-- End Shape -->
    </div>
    <div class="container position-relative zi-2">
        <div class="row justify-content-center mt-n5">
            <div class="col-3 col-lg-2 d-none d-sm-inline-block mt-n10">
                <!-- Logo -->
                <div class="avatar avatar-xl avatar-circle shadow-sm p-4 mx-auto">
                    <img class="avatar-img" src="{{ asset('vendor/leadBrowser/admin/assets/images/tesla.svg') }}" alt="Image Description">
                </div>
                <!-- End Logo -->
            </div>

            <div class="col-lg-2 d-none d-lg-inline-block mt-lg-n8">
                <!-- Logo -->
                <div class="avatar avatar-xxl avatar-circle shadow-sm p-4 mx-auto">
                    <img class="avatar-img" src="{{ asset('vendor/leadBrowser/admin/assets/images/aws.svg') }}" alt="Image Description">
                </div>
                <!-- End Logo -->
            </div>

            <div class="col-3 col-lg-2 d-none d-sm-inline-block mt-n4">
                <!-- Logo -->
                <div class="avatar avatar-xl avatar-circle shadow-sm p-4 mx-auto">
                    <img class="avatar-img" src="{{ asset('vendor/leadBrowser/admin/assets/images/google.svg') }}" alt="Image Description">
                </div>
                <!-- End Logo -->
            </div>

            <div class="col-3 col-lg-2 d-none d-sm-inline-block mt-n7">
                <!-- Logo -->
                <div class="avatar avatar-xl avatar-circle shadow-sm p-4 mx-auto">
                    <img class="avatar-img" src="{{ asset('vendor/leadBrowser/admin/assets/images/rss.svg') }}" alt="Image Description">
                </div>
                <!-- End Logo -->
            </div>

            <div class="col-lg-2 d-none d-lg-inline-block mt-lg-n10">
                <!-- Logo -->
                <div class="avatar avatar-xxl avatar-circle shadow-sm p-4 mx-auto">
                    <img class="avatar-img" src="{{ asset('vendor/leadBrowser/admin/assets/images/linkedin.svg') }}" alt="Image Description">
                </div>
                <!-- End Logo -->
            </div>

            <div class="col-3 col-lg-2 d-none d-sm-inline-block">
                <!-- Logo -->
                <div class="avatar avatar-xl avatar-circle shadow-sm p-4 mx-auto">
                    <img class="avatar-img" src="{{ asset('vendor/leadBrowser/admin/assets/images/facebook.svg') }}" alt="Image Description">
                </div>
                <!-- End Logo -->
            </div>
        </div>
    </div>
</div>
<div class="overflow-hidden">
  <div class="container content-space-t-2 content-space-t-lg-2 content-space-b-2">
      <pricing-cards
          :collection='@json($plans)'
          :is_user='@json(auth()->user())'
      ></pricing-cards>
  </div>
</div>
@stop
