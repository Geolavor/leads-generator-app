@extends('admin::layouts.master')

@section('page_title')
    {{ __('admin::app.organizations.edit-title') }}
@stop

@section('content-wrapper')
    <div class="content full-page adjacent-center">
        {!! view_render_event('organizations.edit.header.before', ['organization' => $organization]) !!}

        <div class="page-header">

            {{ Breadcrumbs::render('organizations.edit', $organization) }}

            <div class="page-title">
                <h1>{{ __('admin::app.organizations.edit-title') }}</h1>
            </div>
        </div>

        {!! view_render_event('organizations.edit.header.after', ['organization' => $organization]) !!}

        <form method="POST" action="{{ route('organizations.update', $organization->id) }}" @submit.prevent="onSubmit" enctype="multipart/form-data">

            <div class="page-content">
                <div class="form-container">

                    <div class="panel">
                        <div class="panel-header">
                            {!! view_render_event('organizations.edit.form_buttons.before', ['organization' => $organization]) !!}

                            <button type="submit" class="btn btn-primary">
                                {{ __('admin::app.organizations.save-btn-title') }}
                            </button>

                            <a href="{{ route('organizations.index') }}">{{ __('admin::app.organizations.back') }}</a>

                            {!! view_render_event('organizations.edit.form_buttons.after', ['organization' => $organization]) !!}
                        </div>
        
                        <div class="panel-body">
                            {!! view_render_event('organizations.edit.form_controls.before', ['organization' => $organization]) !!}

                            @csrf()

                            <input name="_method" type="hidden" value="PUT">
                
                            @include('admin::common.custom-attributes.edit', [
                                'customAttributes' => app('LeadBrowser\Attribute\Repositories\AttributeRepository')->findWhere([
                                    'entity_type' => 'organizations',
                                ]),
                                'entity'           => $organization,
                            ])

                            {!! view_render_event('organizations.edit.form_controls.after', ['organization' => $organization]) !!}

                        </div>
                    </div>

                </div>

            </div>

        </form>

    </div>
@stop