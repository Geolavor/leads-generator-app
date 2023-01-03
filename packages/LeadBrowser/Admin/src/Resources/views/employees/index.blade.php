@extends('admin::layouts.master')

@section('page_title')
    {{ __('admin::app.employees.title') }}
@stop

@section('content-wrapper')
    <div class="content full-page">
        <table-component data-src="{{ route('employees.index') }}">
            <template v-slot:table-header>
                <h1>
                    {!! view_render_event('employees.index.employees.before') !!}

                    {{ Breadcrumbs::render('employees') }}

                    {{ __('admin::app.employees.title') }}

                    {!! view_render_event('employees.index.employees.after') !!}
                </h1>
            </template>

            @if (bouncer()->hasPermission('employees.create'))
                <template v-slot:table-action>
                    <a href="{{ route('employees.create') }}" class="btn btn-primary">{{ __('admin::app.employees.create-title') }}</a>
                </template>
            @endif
        <table-component>
    </div>
@stop
