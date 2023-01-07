@extends('admin::layouts.dashboard')

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
            <x-core.account.sidebar />
        </div>
        <div class="col-9">
            <div class="d-grid gap-3 gap-lg-5">
                <!-- Card -->
                <div class="card">
                    <!-- Header -->
                    <div class="card-header d-flex justify-content-between align-items-center border-bottom">
                        <h5 class="card-header-title">Overview</h5>

                        <a class="btn btn-ghost-secondary btn-sm" href="#" v-if="false">
                            <i class="bi-file-earmark-arrow-down me-1"></i> Download .CSV
                        </a>
                    </div>
                    <!-- End Header -->

                    <!-- Body -->
                    <div class="card-body">
                        @foreach($subscriptions as $subscription)
                            <div class="row mb-3">
                                <div class="col-md mb-4 mb-md-0">
                                    <div class="mb-4">
                                        <span class="card-subtitle">Your plan:</span>
                                        <h5>{{ $subscription->name }} - {{ core()->formatDate($subscription->created_at) }}</h5>
                                    </div>

                                    {{ $subscription->ends_at }}


                                    <div>
                                        <span class="card-subtitle">Total per year</span>
                                        <h3 class="text-primary">$264 USD</h3>
                                    </div>
                                </div>
                                <!-- End Col -->

                                <div class="col-md-auto">
                                    <div class="d-grid d-md-flex gap-3">
                                        <form method="GET" action="{{ route('subscriptions.destroy', $subscription->name) }}" @submit.prevent="onSubmit" enctype="multipart/form-data">
                                            @csrf()
                                            <div class="page-action" style="display: inline-flex;">
                                                <button class="btn btn-white btn-sm">Cancel subscription</button>
                                            </div>
                                        </form>
                                        <a class="btn btn-primary btn-sm btn-transition" href="{{ route('plans.index') }}">Update plan</a>
                                    </div>
                                </div>
                                <!-- End Col -->
                            </div>
                            <!-- End Row -->
                        @endforeach
                    </div>
                    <!-- End Body -->

                    <hr class="mb-3">

                    <!-- Body -->
                    @if(false)
                    <div class="card-body">
                        <div class="row align-items-center flex-grow-1 mb-2">
                            <div class="col">
                                <h4 class="card-header-title">Storage usage</h4>
                            </div>
                            <!-- End Col -->

                            <div class="col-auto">
                                <span class="text-dark fw-semi-bold">4.27 GB</span> used of 6 GB
                            </div>
                            <!-- End Col -->
                        </div>
                        <!-- End Row -->

                        <!-- Progress -->
                        <div class="progress rounded-pill mb-3">
                            <div class="progress-bar" role="progressbar" style="width: 33%;" aria-valuenow="33"
                                aria-valuemin="0" aria-valuemax="100"></div>
                            <div class="progress-bar" role="progressbar" style="width: 25%; opacity: .6" aria-valuenow="25"
                                aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <!-- End Progress -->

                        <!-- Legend Indicators -->
                        <div class="list-inline">
                            <div class="list-inline-item">
                                <span class="legend-indicator bg-primary"></span>Employeeal usage space
                            </div>
                            <div class="list-inline-item">
                                <span class="legend-indicator bg-primary opacity"></span>Shared space
                            </div>
                            <div class="list-inline-item">
                                <span class="legend-indicator"></span>Unused space
                            </div>
                        </div>
                        <!-- End Legend Indicators -->
                    </div>
                    @endif
                    <!-- End Body -->
                </div>
                <!-- End Card -->
            </div>
        </div>
    </div>
</div>
@stop
