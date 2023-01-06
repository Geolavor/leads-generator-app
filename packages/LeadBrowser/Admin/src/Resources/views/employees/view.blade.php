@extends('admin::layouts.dashboard')

@section('page_title')
    {{ $employee->title }}
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

        {!! view_render_event('employee.location.view.header.before', ['employee' => $employee]) !!}

        <div class="page-header">

            <div class="page-title">
                <h1>
                    {{ $employee->title }}
                </h1>
            </div>

        </div>

        <div class="page-content employee-view">

            <div class="employee-content-left">
                {!! view_render_event('employee.location.view.informations.details.before', ['employee' => $employee]) !!}

                <div class="panel">
                    <div class="panel-header" style="padding-top: 0">
                        {{ __('admin::app.employees.details') }}
                    </div>

                    <div class="panel-body">

                        <div class="custom-attribute-view">

                            @include('admin::common.custom-attributes.view', [
                                'customAttributes' => app('LeadBrowser\Attribute\Repositories\AttributeRepository')->findWhere([
                                    'entity_type' => 'employees',
                                ]),
                                'entity'           => $employee,
                            ])

                        </div>

                    </div>
                </div>
            </div>

            <div class="employee-content-right">

            </div>

        </div>

        {!! view_render_event('employee.location.view.informations.after', ['employee' => $employee]) !!}

    </div>

@stop