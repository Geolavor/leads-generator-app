@extends('admin::layouts.dashboard')

@section('page_title')
    {{ __('admin::app.customers.subscribers.title') }}
@stop

@section('content-wrapper')
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h1>{{ __('admin::app.customers.subscribers.title') }}</h1>
            </div>
        </div>

        <div class="page-content">
            <table-component data-src="{{ route('customers.subscribers.index') }}"></table-component>
        </div>
    </div>
@stop
