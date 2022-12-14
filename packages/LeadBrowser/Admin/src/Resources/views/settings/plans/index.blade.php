@extends('admin::layouts.master')

@section('page_title')
    {{ __('admin::app.settings.plans.title') }}
@stop

@section('content-wrapper')
    <div class="content full-page">
        <table-component data-src="{{ route('settings.plans.index') }}">
            <template v-slot:table-header>
                <h1>
                    {!! view_render_event('settings.plans.index.header.before') !!}

                    {{ Breadcrumbs::render('settings.types') }}

                    {{ __('admin::app.settings.plans.title') }}

                    {!! view_render_event('settings.plans.index.header.after') !!}
                </h1>
            </template>

            @if (bouncer()->hasPermission('settings.plans.create'))
                <template v-slot:table-action>
                    <a href="{{ route('settings.plan.create') }}" class="btn btn-primary">
                        {{ __('admin::app.settings.plans.create-title') }}
                    </a>
                </template>
            @endif
        <table-component>
    </div>
@stop
