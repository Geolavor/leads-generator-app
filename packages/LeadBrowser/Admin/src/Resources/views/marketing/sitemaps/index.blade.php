@extends('admin::layouts.dashboard')

@section('page_title')
    {{ __('admin::app.marketing.sitemaps.title') }}
@stop

@section('content-wrapper')
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h1>{{ __('admin::app.marketing.sitemaps.title') }}</h1>
            </div>

            <div class="page-action">
                <a href="{{ route('sitemaps.create') }}" class="btn btn-lg btn-primary">
                    {{ __('admin::app.marketing.sitemaps.add-title') }}
                </a>
            </div>
        </div>

        <div class="page-content">
            <table-component data-src="{{ route('sitemaps.index') }}"></table-component>
        </div>
    </div>
@endsection
