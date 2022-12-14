@extends('admin::layouts.master')

@section('page_title')
    {{ $person->title }}
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

        {!! view_render_event('person.location.view.header.before', ['person' => $person]) !!}

        <div class="page-header">

            <div class="page-title">
                <h1>
                    {{ $person->title }}
                </h1>
            </div>

        </div>

        <div class="page-content person-view">

            <div class="person-content-left">
                {!! view_render_event('person.location.view.informations.details.before', ['person' => $person]) !!}

                <div class="panel">
                    <div class="panel-header" style="padding-top: 0">
                        {{ __('admin::app.persons.details') }}
                    </div>

                    <div class="panel-body">

                        <div class="custom-attribute-view">

                            @include('admin::common.custom-attributes.view', [
                                'customAttributes' => app('LeadBrowser\Attribute\Repositories\AttributeRepository')->findWhere([
                                    'entity_type' => 'persons',
                                ]),
                                'entity'           => $person,
                            ])

                        </div>

                    </div>
                </div>
            </div>

            <div class="person-content-right">

            </div>

        </div>

        {!! view_render_event('person.location.view.informations.after', ['person' => $person]) !!}

    </div>

@stop