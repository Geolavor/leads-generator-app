@extends('admin::layouts.dashboard')

@section('page_title')
    {{ __('admin::app.marketing.campaigns.title') }}
@stop

@section('content-wrapper')
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h1>{{ __('admin::app.marketing.campaigns.title') }}</h1>
            </div>

            <div class="page-action">
                <a href="{{ route('campaigns.create') }}" class="btn btn-lg btn-primary">
                    {{ __('admin::app.marketing.campaigns.add-title') }}
                </a>
            </div>
        </div>

        <div class="page-content">
            <table-component data-src="{{ route('campaigns.index') }}"></table-component>
        </div>
    </div>
@stop
