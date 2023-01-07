@extends('admin::layouts.dashboard')

@section('page_title')
    {{ __('admin::app.activities.title') }}
@stop

@section('content-wrapper')
    @php
        $viewType = request()->view_type ?? "table";
    @endphp

    @if ($viewType == "table")
        {!! view_render_event('activities.index.table.before') !!}

        @include('admin::activities.index.table')

        {!! view_render_event('activities.index.table.after') !!}
    @else
        {!! view_render_event('activities.index.calendar.before') !!}

        @include('admin::activities.index.calendar')

        {!! view_render_event('activities.index.calendar.after') !!}
    @endif
@stop
