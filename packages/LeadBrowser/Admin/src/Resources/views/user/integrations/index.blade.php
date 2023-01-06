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
            <x-core.account.sidebar />
        </div>
        <div class="col-9">
            <div class="d-grid gap-3 gap-lg-5">
                <!-- Card -->
                <div class="card">
                    <!-- Header -->
                    <div class="card-header d-flex justify-content-between align-items-center border-bottom">
                        <h5 class="card-header-title">Integrations</h5>
                    </div>
                    <!-- End Header -->

                    <!-- Body -->
                    <div class="card-body">
                        
                    </div>
                    <!-- End Body -->
                </div>
                <!-- End Card -->
            </div>
        </div>
    </div>
</div>
@stop
