@extends('admin::layouts.master')

@section('page_title')
    {{ __('admin::app.results.title') }}
@stop

@section('content-wrapper')
    <div class="content full-page">
        <table-component data-src="{{ route('results.index') }}">
            <template v-slot:table-header>
                <h1>
                    {!! view_render_event('results.index.header.before') !!}

                    {{ Breadcrumbs::render('results') }}

                    {{ __('admin::app.results.title') }}

                    {!! view_render_event('results.index.header.after') !!}
                </h1>
            </template>
        <table-component>
    </div>
@stop
