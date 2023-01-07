@extends('admin::layouts.dashboard')

@section('page_title')
    {{ __('admin::app.search.title') }}
@stop

@section('content-wrapper')
    <div class="content full-page">
        <table-component data-src="{{ route('search.websites.index') }}">
            <template v-slot:table-header>
                <h1>
                    {!! view_render_event('search.websites.index.header.before') !!}

                    {{ Breadcrumbs::render('search') }}

                    {{ __('admin::app.search.title') }}

                    {!! view_render_event('search.websites.index.header.after') !!}
                </h1>
            </template>

            @if (bouncer()->hasPermission('search.location.websites.create'))
                <template v-slot:table-action>
                    <a href="{{ route('search.websites.create') }}" class="btn btn-primary">{{ __('admin::app.search.create-title') }}</a>
                </template>
            @endif
        <table-component>
    </div>
@stop
