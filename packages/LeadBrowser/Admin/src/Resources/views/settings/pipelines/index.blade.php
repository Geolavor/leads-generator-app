@extends('admin::layouts.dashboard')

@section('page_title')
    {{ __('admin::app.settings.pipelines.title') }}
@stop

@section('content-wrapper')
    <div class="content full-page">
        <table-component data-src="{{ route('settings.pipelines.index') }}">
            <template v-slot:table-header>
                <h1>
                    {!! view_render_event('settings.pipelines.index.header.before') !!}

                    {{ Breadcrumbs::render('settings.pipelines') }}

                    {{ __('admin::app.settings.pipelines.title') }}

                    {!! view_render_event('settings.pipelines.index.header.after') !!}
                </h1>
            </template>

            @if (bouncer()->hasPermission('settings.lead.pipelines.create'))
                <template v-slot:table-action>
                    <a href="{{ route('settings.pipelines.create') }}" class="btn btn-primary">
                        {{ __('admin::app.settings.pipelines.create-title') }}
                    </button>
                </template>
            @endif
        <table-component>
    </div>
@stop
