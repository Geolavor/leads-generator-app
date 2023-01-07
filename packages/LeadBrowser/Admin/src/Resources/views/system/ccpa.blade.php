@extends('admin::layouts.landing')

@section('page_title')
{{ __('admin::app.settings.sources.title') }}
@stop

@section('content-wrapper')
<div>
    <div class="bg-img-start" style="background-image: url(./assets/svg/components/card-11.svg);">
        <div class="container content-space-t-3 content-space-t-lg-5 content-space-b-2">
            <div class="w-md-75 w-lg-50 text-center mx-md-auto">
                <h1>LeadBrowser Terms &amp; Conditions</h1>
                <p>Effective date: 1 January 2022</p>
            </div>
        </div>
    </div>
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
                                <a class="nav-link active" href="#content">1. Accounts</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#linksToOtherWebsInfo">2. Links to other websites</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#terminationInfo">3. Termination</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#goveringLawInfo">4. Governing law</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#changesInfo">5. Changes</a>
                            </li>
                        </ul>
                    </div>
                    <!-- End Navbar Collapse -->
                </div>
                <!-- End Navbar -->
            </div>

            <div class="col-md-8 col-lg-9">
                <div class="mb-7">

                    <div id="accountInfo" class="mb-7">
                        <h4>1. General</h4>
                        <p>
                        </p>
                    </div>
                    
                </div>

            </div>
            <!-- End Col -->
        </div>
        <!-- End Row -->
    </div>
</div>
@stop
