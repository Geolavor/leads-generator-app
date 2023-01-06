@extends('admin::layouts.dashboard')

@section('page_title')
    {{ __('admin::app.settings.attributes.title') }}
@stop

@section('content-wrapper')
    <div class="content full-page">
        <table-component data-src="{{ route('settings.attributes.index') }}">
            <template v-slot:table-header>
                <h1>
                    {!! view_render_event('settings.attributes.index.header.before') !!}

                    {{ Breadcrumbs::render('settings.attributes') }}

                    {{ __('admin::app.settings.attributes.title') }}

                    {!! view_render_event('settings.attributes.index.header.after') !!}
                </h1>
            </template>

            @if (bouncer()->hasPermission('settings.automation.attributes.create'))
                <template v-slot:table-action>
                    <a href="{{ route('settings.attributes.create') }}" class="btn btn-primary">
                        {{ __('admin::app.settings.attributes.create-title') }}
                    </a>
                </template>
            @endif
        <table-component>
    </div>
@stop
