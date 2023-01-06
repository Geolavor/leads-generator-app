@extends('admin::layouts.dashboard')

@section('page_title')
    {{ __('admin::app.settings.users.title') }}
@stop

@section('content-wrapper')
    <div class="content full-page">
        <table-component data-src="{{ route('settings.users.index') }}">
            <template v-slot:table-header>
                <h1>
                    {!! view_render_event('settings.users.index.header.before') !!}

                    {{ Breadcrumbs::render('settings.users') }}

                    {{ __('admin::app.settings.users.title') }}

                    {!! view_render_event('settings.users.index.header.after') !!}
                </h1>
            </template>

            @if (bouncer()->hasPermission('settings.user.users.create'))
                <template v-slot:table-action>
                    <a href="{{ route('settings.users.create') }}" class="btn btn-primary">
                        {{ __('admin::app.settings.users.create-title') }}
                    </a>
                </template>
            @endif
        <table-component>
    </div>
@stop
