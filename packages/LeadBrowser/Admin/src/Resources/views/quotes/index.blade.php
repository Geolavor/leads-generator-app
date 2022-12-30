@extends('admin::layouts.master')

@section('page_title')
    {{ __('admin::app.quotes.title') }}
@stop

@section('content-wrapper')
    <div class="content full-page">
        <table-component data-src="{{ route('quotes.index') }}">
            <template v-slot:table-header>
                <h1>
                    {!! view_render_event('quotes.index.header.before') !!}

                    {{ Breadcrumbs::render('quotes') }}

                    {{ __('admin::app.quotes.title') }}

                    {!! view_render_event('quotes.index.header.after') !!}
                </h1>
            </template>

            @if (bouncer()->hasPermission('crm.quotes.create'))
                <template v-slot:table-action>
                    <a href="{{ route('quotes.create') }}" class="btn btn-primary">{{ __('admin::app.quotes.create-title') }}</a>
                </template>
            @endif
        <table-component>
    </div>
@stop
