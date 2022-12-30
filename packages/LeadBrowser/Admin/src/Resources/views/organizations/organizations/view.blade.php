@extends('admin::layouts.master')

@section('page_title')
    {{ $organization->title }}
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

        {!! view_render_event('organization.location.view.header.before', ['organization' => $organization]) !!}

        <div class="page-header">

            <div class="page-title">
                <h1>
                    {{ $organization->title }}
                </h1>
            </div>

        </div>

        <div class="page-content organization-view">

            <div class="organization-content-left">
                {!! view_render_event('organization.location.view.informations.details.before', ['organization' => $organization]) !!}

                <div class="panel">
                    <div class="panel-header" style="padding-top: 0">
                        {{ __('admin::app.organization.details') }}
                    </div>

                    <div class="panel-body">

                        <div class="custom-attribute-view">

                            @include('admin::common.custom-attributes.view', [
                                'customAttributes' => app('LeadBrowser\Attribute\Repositories\AttributeRepository')->findWhere([
                                    'entity_type' => 'organizations',
                                ]),
                                'entity'           => $organization,
                            ])

                        </div>

                    </div>
                </div>
            </div>

            <div class="organization-content-right">

            </div>

        </div>

        {!! view_render_event('organization.location.view.informations.after', ['organization' => $organization]) !!}

    </div>

@stop