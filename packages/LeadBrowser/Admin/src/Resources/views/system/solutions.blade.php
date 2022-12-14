@extends('admin::layouts.landing')

@section('page_title')
{{ __('admin::app.settings.sources.title') }}
@stop

@section('content-wrapper')
<div>
    <div class="position-relative bg-img-start" style="background-image: url(./assets/img/1920x1080/img6.jpg);">
        <div class="container content-space-t-2 content-space-t-md-3 content-space-3 content-space-b-lg-5">
            <div class="w-lg-50">
                <h1>You're in good company.</h1>
                <h2 class="h1 text-primary">Join millions of businesses on Front.</h2>
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
<!-- Features -->
<div class="container content-space-2 content-space-lg-3">
  <!-- Heading -->
  <div class="w-md-75 w-lg-50 text-center mx-md-auto mb-5 mb-md-9">
    <h2>Front makes designing easy and performance fast</h2>
  </div>
  <!-- End Heading -->

  <!-- Nav Scroller -->
  <div class="js-nav-scroller hs-nav-scroller-horizontal">
    <span class="hs-nav-scroller-arrow-prev" style="display: none;">
      <a class="hs-nav-scroller-arrow-link" href="javascript:;">
        <i class="bi-chevron-left"></i>
      </a>
    </span>

    <span class="hs-nav-scroller-arrow-next" style="display: none;">
      <a class="hs-nav-scroller-arrow-link" href="javascript:;">
        <i class="bi-chevron-right"></i>
      </a>
    </span>

    <!-- Nav -->
    <ul class="nav nav-segment nav-pills nav-fill mx-auto mb-7" id="featuresEg1Tab" role="tablist" style="max-width: 30rem;">
      <li class="nav-item" role="presentation">
        <a class="nav-link active" href="#featuresOne" id="featuresEg1One-tab" data-bs-toggle="tab" data-bs-target="#featuresOne" role="tab" aria-controls="featuresEg1One" aria-selected="true">App Marketplace</a>
      </li>

      <li class="nav-item" role="presentation">
        <a class="nav-link" href="#featuresTwo" id="featuresEg1Two-tab" data-bs-toggle="tab" data-bs-target="#featuresTwo" role="tab" aria-controls="featuresEg1Two" aria-selected="false">Course</a>
      </li>

      <li class="nav-item" role="presentation">
        <a class="nav-link" href="#featuresThree" id="featuresEg1Three-tab" data-bs-toggle="tab" data-bs-target="#featuresThree" role="tab" aria-controls="featuresEg1Three" aria-selected="false">Account Dashboard</a>
      </li>
    </ul>
    <!-- End Nav -->
  </div>
  <!-- End Nav Scroller -->

  <!-- Tab Content -->
  <div class="tab-content" id="featuresEg1TabContent">
    <div class="tab-pane fade show active" id="featuresEg1One" role="tabpanel" aria-labelledby="featuresEg1One-tab">
      <!-- Devices -->
      <div class="devices">
        <!-- Mobile Device -->
        <figure class="device-mobile rotated-3d-right">
          <div class="device-mobile-frame">
            <img class="device-mobile-img" src="../assets/img/407x867/img1.jpg" alt="Image Description">
          </div>
        </figure>
        <!-- End Mobile Device -->

        <!-- Browser Device -->
        <figure class="device-browser">
          <div class="device-browser-header">
            <div class="device-browser-header-btn-list">
              <span class="device-browser-header-btn-list-btn"></span>
              <span class="device-browser-header-btn-list-btn"></span>
              <span class="device-browser-header-btn-list-btn"></span>
            </div>
            <div class="device-browser-header-browser-bar">www.htmlstream.com/front/</div>
          </div>

          <div class="device-browser-frame">
            <img class="device-browser-img" src="../assets/img/1618x1010/img1.jpg" alt="Image Description">
          </div>
        </figure>
        <!-- End Browser Device -->
      </div>
      <!-- End Devices -->
    </div>

    <div class="tab-pane fade" id="featuresEg1Two" role="tabpanel" aria-labelledby="featuresEg1Two-tab">
      <!-- Devices -->
      <div class="devices">
        <!-- Mobile Device -->
        <figure class="device-mobile rotated-3d-right">
          <div class="device-mobile-frame">
            <img class="device-mobile-img" src="../assets/img/407x867/img2.jpg" alt="Image Description">
          </div>
        </figure>
        <!-- End Mobile Device -->

        <!-- Browser Device -->
        <figure class="device-browser">
          <div class="device-browser-header">
            <div class="device-browser-header-btn-list">
              <span class="device-browser-header-btn-list-btn"></span>
              <span class="device-browser-header-btn-list-btn"></span>
              <span class="device-browser-header-btn-list-btn"></span>
            </div>
            <div class="device-browser-header-browser-bar">www.htmlstream.com/front/</div>
          </div>

          <div class="device-browser-frame">
            <img class="device-browser-img" src="../assets/img/1618x1010/img2.jpg" alt="Image Description">
          </div>
        </figure>
        <!-- End Browser Device -->
      </div>
      <!-- End Devices -->
    </div>

    <div class="tab-pane fade" id="featuresEg1Three" role="tabpanel" aria-labelledby="featuresEg1Three-tab">
      <!-- Devices -->
      <div class="devices">
        <!-- Mobile Device -->
        <figure class="device-mobile rotated-3d-right">
          <div class="device-mobile-frame">
            <img class="device-mobile-img" src="../assets/img/407x867/img4.jpg" alt="Image Description">
          </div>
        </figure>
        <!-- End Mobile Device -->

        <!-- Browser Device -->
        <figure class="device-browser">
          <div class="device-browser-header">
            <div class="device-browser-header-btn-list">
              <span class="device-browser-header-btn-list-btn"></span>
              <span class="device-browser-header-btn-list-btn"></span>
              <span class="device-browser-header-btn-list-btn"></span>
            </div>
            <div class="device-browser-header-browser-bar">www.htmlstream.com/front/</div>
          </div>

          <div class="device-browser-frame">
            <img class="device-browser-img" src="../assets/img/1618x1010/img4.jpg" alt="Image Description">
          </div>
        </figure>
        <!-- End Browser Device -->
      </div>
      <!-- End Devices -->
    </div>
  </div>
  <!-- End Tab Content -->
</div>
<!-- End Features -->
@stop
