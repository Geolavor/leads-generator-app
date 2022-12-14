@extends('admin::layouts.landing')

@section('page_title')
{{ __('admin::app.settings.sources.title') }}
@stop

@section('content-wrapper')

<!-- Pricing -->
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
          <th scope="row" class="text-dark">Domain search*</th>
          <td class="table-text-center"><i class="bi-check-circle text-success"></i></td>
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
          <th scope="row" class="text-dark">CRM</th>
          <td class="table-text-center"><i class="bi-check-circle text-success"></i></td>
          <td class="table-text-center"><i class="bi-check-circle text-success"></i></td>
          <td class="table-text-center"><i class="bi-check-circle text-success"></i></td>
        </tr>

        <tr>
          <th scope="row" class="text-dark">Free trial</th>
          <td class="table-text-center">25 credits/mo</td>
          <td class="table-text-center"><i class="bi-check-circle text-success me-2"></i>50 credits/mo</td>
          <td class="table-text-center"><i class="bi-check-circle text-success me-2"></i>100 credits/mo</td>
        </tr>

        <tr>
          <th scope="row" class="text-dark">Data export</th>
          <td class="table-text-center">CSV, TXT</td>
          <td class="table-text-center">CSV, XLSX, Google Sheets</td>
          <td class="table-text-center">CSV, XLSX, Google Sheets</td>
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
<!-- End Pricing -->
@stop
