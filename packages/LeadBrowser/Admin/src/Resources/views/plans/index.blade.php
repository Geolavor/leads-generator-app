@extends('admin::layouts.dashboard')

@section('page_title')
{{ __('admin::app.settings.sources.title') }}
@stop

@section('content-wrapper')
<div class="container content-space-t-2 content-space-t-lg-2 content-space-b-2">
    <pricing-cards
        :collection='@json($plans)'
        :is_user='@json(auth()->user())'
    ></pricing-cards>
</div>
@stop
