@extends('admin::layouts.master')

@section('page_title')
    {{ __('admin::app.organizations.title') }}
@stop

@section('content-wrapper')
    <div class="content full-page">
        <table-component data-src="{{ route('organizations.index') }}">
            <template v-slot:table-header>
                <h1>
                    {!! view_render_event('organizations.index.header.before') !!}

                    {{ Breadcrumbs::render('organizations') }}

                    {{ __('admin::app.organizations.title') }}

                    {!! view_render_event('organizations.index.header.after') !!}
                </h1>
            </template>

            @if (bouncer()->hasPermission('organizations.create'))
                <template v-slot:table-action>
                    <a href="{{ route('organizations.create') }}" class="btn btn-primary">{{ __('admin::app.organizations.create-title') }}</a>
                </template>
            @endif
        <table-component>
    </div>
@stop
