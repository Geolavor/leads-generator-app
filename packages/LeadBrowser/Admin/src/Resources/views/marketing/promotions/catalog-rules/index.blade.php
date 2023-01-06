@extends('admin::layouts.dashboard')

@section('page_title')
    {{ __('admin::app.promotions.catalog-rules.title') }}
@stop

@section('content-wrapper')
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h1>{{ __('admin::app.promotions.catalog-rules.title') }}</h1>
            </div>

            <div class="page-action">
                <a href="{{ route('catalog-rules.create') }}" class="btn btn-lg btn-primary">
                    {{ __('admin::app.promotions.catalog-rules.add-title') }}
                </a>
            </div>
        </div>

        <div class="page-content">
            <table-component data-src="{{ route('catalog-rules.index') }}"></table-component>
        </div>
    </div>
@endsection
