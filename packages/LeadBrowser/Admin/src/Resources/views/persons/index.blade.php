@extends('admin::layouts.master')

@section('page_title')
    {{ __('admin::app.persons.title') }}
@stop

@section('content-wrapper')
    <div class="content full-page">
        <table-component data-src="{{ route('persons.index') }}">
            <template v-slot:table-header>
                <h1>
                    {!! view_render_event('persons.index.persons.before') !!}

                    {{ Breadcrumbs::render('persons') }}

                    {{ __('admin::app.persons.title') }}

                    {!! view_render_event('persons.index.persons.after') !!}
                </h1>
            </template>

            @if (bouncer()->hasPermission('persons.create'))
                <template v-slot:table-action>
                    <a href="{{ route('persons.create') }}" class="btn btn-primary">{{ __('admin::app.persons.create-title') }}</a>
                </template>
            @endif
        <table-component>
    </div>
@stop
