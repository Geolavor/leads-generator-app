@extends('admin::layouts.master')

@section('page_title')
    {{ __('admin::app.user.account.my_account') }}
@stop

@section('css')
    <style>
        .panel-header,
        .panel-body {
            margin: 0 auto;
            max-width: 800px;
        }
    </style>
@stop

@section('content-wrapper')
<div class="content full-page adjacent-center">
    <div class="row">
        <div class="col-3">
            <div id="navbarVerticalNavMenuEg2">
                <ul id="navbarSettingsEg2" class="js-sticky-block js-scrollspy nav nav-tabs nav-link-gray nav-vertical">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('user.account.edit') }}">Account</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('user.account.billing.index') }}">Billing</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('user.account.current-plan.index') }}">Current plan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('user.account.api.index') }}">API</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-9">
            <div class="d-grid gap-3 gap-lg-5">
                <!-- Card -->
                <div class="card">
                    <!-- Header -->
                    <div class="card-header d-flex justify-content-between align-items-center border-bottom">
                        <h5 class="card-header-title">Api overview</h5>
                    </div>
                    <!-- End Header -->

                    <!-- Body -->
                    <div class="card-body">
                        @foreach($tokens as $token)
                            <div class="row mb-3">
                                <div class="col-md mb-4 mb-md-0">
                                    <div class="mb-4">
                                        <span class="card-subtitle">Token:</span>
                                        <h5>{{ $token->name }} - {{ core()->formatDate($token->created_at) }}</h5>
                                    </div>

                                    <div>
                                        <span class="card-subtitle">Private API token</span>
                                        <h3 class="text-primary">{{ $token->token }}</h3>
                                    </div>
                                </div>
                                <!-- End Col -->
                            </div>
                            <!-- End Row -->
                        @endforeach
                    </div>
                    <!-- End Body -->

                    <hr class="mb-3">

                </div>
                <!-- End Card -->

                <div class="panel">
                    <div class="panel-header">
                        Example code
                    </div>

                    <div class="panel-body">
                        <tabs>
                            <tab name="cURL" :selected="true">
                                cURL
                            </tab>

                            <tab name="PHP">
                                Tab 2 Content
                            </tab>

                            <tab name="Python">
                                Tab 3 Content
                            </tab>

                            <tab name="Javascript">
                                Tab 3 Content
                            </tab>
                        </tabs>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@stop
