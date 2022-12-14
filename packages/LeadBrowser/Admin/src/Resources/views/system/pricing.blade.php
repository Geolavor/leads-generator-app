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
<div class="container content-space-2 content-space-lg-3">
  <!-- Heading -->
  <div class="w-md-75 w-lg-50 text-center mx-md-auto mb-5 mb-md-9">
    <h2>Why choose LeadBrowser over Hunter.io and Snov.io?</h2>
    <p>We are going to compare multiple parameters like price, verification methods, APIs, browser extensions, tech support, additional tools and bonuses.</p>
  </div>
  <!-- End Heading -->

  <!-- Table -->
  <div class="table-responsive-lg">
    <table class="table table-lg table-striped table-borderless table-nowrap table-vertical-border-striped">
      <thead class="table-text-center">
        <tr>
          <th scope="col" style="width: 40%;"></th>

          <th scope="col" style="width: 20%;">
            <img src="{{ asset('vendor/leadBrowser/admin/assets/images/hunter.png') }}" style="max-width:150px"/>
          </th>

          <th scope="col" style="width: 20%;">
            <img src="{{ asset('vendor/leadBrowser/admin/assets/images/snovio.png') }}" style="max-width:100px"/>
          </th>

          <th scope="col" style="width: 20%;">
            <img src="{{ asset('vendor/leadBrowser/admin/assets/images/logotyp.svg') }}" style="max-width:150px"/>
          </th>
        </tr>
      </thead>

      <tbody>

        <tr>
          <th scope="row" class="text-dark">Live search*</th>
          <td class="table-text-center"><i class="bi-x-circle text-warning"></i></td>
          <td class="table-text-center"><i class="bi-x-circle text-warning"></i></td>
          <td class="table-text-center"><i class="bi-check-circle text-success"></i></td>
        </tr>

        <tr>
          <th scope="row" class="text-dark">Geo search*</th>
          <td class="table-text-center"><i class="bi-x-circle text-warning"></i></td>
          <td class="table-text-center"><i class="bi-x-circle text-warning"></i></td>
          <td class="table-text-center"><i class="bi-check-circle text-success"></i></td>
        </tr>

        <tr>
          <th scope="row" class="text-dark">Free e-mail verifications</th>
          <td class="table-text-center">50</td>
          <td class="table-text-center"><i class="bi-x-circle text-warning"></i></td>
          <td class="table-text-center"><span class="badge bg-soft-primary text-primary rounded-pill">Unlimited</span></td>
        </tr>

        <tr>
          <th scope="row" class="text-dark">Free monthly searches</th>
          <td class="table-text-center">25</td>
          <td class="table-text-center">0</td>
          <td class="table-text-center">50</td>
        </tr>

        <tr>
          <th scope="row" class="text-dark">Free trial</th>
          <td class="table-text-center">25 credits/mo</td>
          <td class="table-text-center"><i class="bi-check-circle text-success me-2"></i>50 credits/mo</td>
          <td class="table-text-center"><i class="bi-check-circle text-success me-2"></i>100 credits/mo</td>
        </tr>

        <tr>
          <th scope="row" class="text-dark">Price per email*</th>
          <td class="table-text-center">$0.0133</td>
          <td class="table-text-center">$0.0085</td>
          <td class="table-text-center">$0</td>
        </tr>

        <tr>
          <th scope="row" class="text-dark">Tax numbers search*</th>
          <td class="table-text-center"><i class="bi-x-circle text-warning"></i></td>
          <td class="table-text-center"><i class="bi-x-circle text-warning"></i></td>
          <td class="table-text-center"><i class="bi-check-circle text-success"></i></td>
        </tr>

        <tr>
          <th scope="row" class="text-dark">Social network search*</th>
          <td class="table-text-center"><i class="bi-x-circle text-warning"></i></td>
          <td class="table-text-center"><i class="bi-check-circle text-success"></i></td>
          <td class="table-text-center"><i class="bi-check-circle text-success"></i></td>
        </tr>
        
        <tr>
          <th scope="row" class="text-dark">Social URL search*</th>
          <td class="table-text-center"><i class="bi-x-circle text-warning"></i></td>
          <td class="table-text-center"><i class="bi-check-circle text-success"></i></td>
          <td class="table-text-center"><i class="bi-check-circle text-success"></i></td>
        </tr>

        <tr>
          <th scope="row" class="text-dark">Company profile search</th>
          <td class="table-text-center"><i class="bi-x-circle text-warning"></i></td>
          <td class="table-text-center"><i class="bi-check-circle text-success"></i></td>
          <td class="table-text-center"><i class="bi-check-circle text-success"></i></td>
        </tr>

        <tr>
          <th scope="row" class="text-dark">Bulk domain search</th>
          <td class="table-text-center"><i class="bi-check-circle text-success"></i></td>
          <td class="table-text-center"><i class="bi-check-circle text-success"></i></td>
          <td class="table-text-center"><i class="bi-check-circle text-success"></i></td>
        </tr>

        <tr>
          <th scope="row" class="text-dark">Domain search*</th>
          <td class="table-text-center"><i class="bi-check-circle text-success"></i></td>
          <td class="table-text-center"><i class="bi-check-circle text-success"></i></td>
          <td class="table-text-center"><i class="bi-check-circle text-success"></i></td>
        </tr>

        <tr>
          <th scope="row" class="text-dark">Data export</th>
          <td class="table-text-center">CSV, TXT</td>
          <td class="table-text-center">CSV, XLSX, Google Sheets</td>
          <td class="table-text-center">CSV, XLSX, Google Sheets</td>
        </tr>

        <tr>
          <th scope="row" class="text-dark">Charging for duplicates</th>
          <td class="table-text-center"><i class="bi-x-circle text-warning"></i></td>
          <td class="table-text-center"><i class="bi-x-circle text-warning"></i></td>
          <td class="table-text-center"><i class="bi-x-circle text-warning"></i></td>
        </tr>

        <tr>
          <th scope="row" class="text-dark">Social network search*</th>
          <td class="table-text-center"><i class="bi-x-circle text-warning"></i></td>
          <td class="table-text-center"><i class="bi-check-circle text-success"></i></td>
          <td class="table-text-center"><i class="bi-check-circle text-success"></i></td>
        </tr>

        <tr>
          <th scope="row" class="text-dark">Free email verification</th>
          <td class="table-text-center"><i class="bi-x-circle text-warning"></i></td>
          <td class="table-text-center"><i class="bi-x-circle text-warning"></i></td>
          <td class="table-text-center"><i class="bi-check-circle text-success"></i></td>
        </tr>

        <tr>
          <th scope="row" class="text-dark">Social network search*</th>
          <td class="table-text-center"><i class="bi-x-circle text-warning"></i></td>
          <td class="table-text-center"><i class="bi-check-circle text-success"></i></td>
          <td class="table-text-center"><i class="bi-check-circle text-success"></i></td>
        </tr>

        <tr>
          <th scope="row" class="text-dark">How much you save using LeadBrowser</th>
          <td class="table-text-center">$97</td>
          <td class="table-text-center">$61</td>
          <td class="text-center">
            <a type="button" class="btn btn-primary btn-sm btn-transition" href="{{ route('auth.register.create') }}">Get free data</a>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
  <!-- End Table -->
</div>
@stop
