@extends('admin::layouts.master')

@section('page_title')
    {{ __('admin::app.employees.edit-title') }}
@stop

@section('content-wrapper')
    <div class="content full-page adjacent-center">

        {!! view_render_event('employees.edit.header.before', ['employee' => $employee]) !!}

        <div class="page-header">

            {{ Breadcrumbs::render('employees.edit', $employee) }}

            <div class="page-title">
                <h1>{{ __('admin::app.employees.edit-title') }}</h1>
            </div>
        </div>

        {!! view_render_event('employees.edit.header.after', ['employee' => $employee]) !!}

        <form method="POST" action="{{ route('employees.update', $employee->id) }}" @submit.prevent="onSubmit" enctype="multipart/form-data">

            <div class="page-content">
                <div class="form-container">

                    <div class="panel">
                        <div class="panel-header">
                            {!! view_render_event('employees.edit.form_buttons.before', ['employee' => $employee]) !!}

                            <button type="submit" class="btn btn-primary">
                                {{ __('admin::app.employees.save-btn-title') }}
                            </button>

                            <a href="{{ route('employees.index') }}">{{ __('admin::app.employees.back') }}</a>

                            {!! view_render_event('employees.edit.form_buttons.after', ['employee' => $employee]) !!}
                        </div>
        
                        <div class="panel-body">
                            {!! view_render_event('employees.edit.form_controls.before', ['employee' => $employee]) !!}

                            @csrf()
                            
                            <input name="_method" type="hidden" value="PUT">
                
                            @include('admin::common.custom-attributes.edit', [
                                'customAttributes' => app('LeadBrowser\Attribute\Repositories\AttributeRepository')->findWhere([
                                    'entity_type' => 'employees',
                                ]),
                                'entity'           => $employee,
                            ])

                            {!! view_render_event('employees.edit.form_controls.after', ['employee' => $employee]) !!}

                        </div>
                    </div>
                </div>
            </div>

        </form>
    </div>
@stop