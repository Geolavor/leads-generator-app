@extends('admin::layouts.dashboard')

@section('page_title')
    {{ $search->title }}
@stop

@section('css')
    <style>
        .modal-container .modal-header {
            border: 0;
        }

        .modal-container .modal-body {
            padding: 0;
        }

        .content-container .content .page-header {
            margin-bottom: 30px;
        }
    </style>
@stop

@section('content-wrapper')

    <div class="content full-page">

        {!! view_render_event('search.phones.view.header.before', ['search' => $search]) !!}

        <div class="page-header">

            {{ Breadcrumbs::render('search.phones.view', $search) }}

            <div class="page-title">
                <h1>
                    {{ $search->title }}
                </h1>
            </div>

            <div class="page-action" style="display: inline-flex;">
                <button class="btn btn-warning btn-md">Remove</button>
            </div>
        </div>

        {!! view_render_event('search.phones.view.header.after', ['search' => $search]) !!}


        {!! view_render_event('search.phones.view.informations.before', ['search' => $search]) !!}

        <div class="page-content search-view">

            <div class="search-content-left">
                {!! view_render_event('search.phones.view.informations.details.before', ['search' => $search]) !!}

                <div class="panel">
                    <div class="panel-header" style="padding-top: 0">
                        {{ __('admin::app.search.details') }}
                    </div>

                    <div class="panel-body">

                        <div class="custom-attribute-view">
                            @include('admin::common.custom-attributes.view', [
                                'customAttributes' => app('LeadBrowser\Attribute\Repositories\AttributeRepository')->findWhere([
                                    'entity_type' => 'search',
                                ]),
                                'entity'           => $search,
                            ])

                            <div class="attribute-value-row">
                                <div class="label">Predicted market size</div>

                                <div class="value">
                                    {{ $search->market_size }} companies
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="search-content-right">

            </div>

        </div>

        {!! view_render_event('search.phones.view.informations.after', ['search' => $search]) !!}

        <!-- Results -->
        <table-component data-src="{{ route('results.index') }}">
        <table-component>

    </div>

@stop