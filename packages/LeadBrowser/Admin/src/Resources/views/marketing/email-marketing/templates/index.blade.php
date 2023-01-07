@extends('admin::layouts.dashboard')

@section('page_title')
    {{ __('admin::app.marketing.templates.title') }}
@stop

@section('content-wrapper')
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h1>{{ __('admin::app.marketing.templates.title') }}</h1>
            </div>

            <div class="page-action">
                <a href="{{ route('email-templates.create') }}" class="btn btn-lg btn-primary">
                    {{ __('admin::app.marketing.templates.add-title') }}
                </a>
            </div>
        </div>

        <div class="page-content">
            <table-component data-src="{{ route('email-templates.index') }}"></table-component>
        </div>
    </div>
@stop
