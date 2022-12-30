@extends('admin::layouts.master')

@section('page_title')
    {{ __('admin::app.results.create-title') }}
@stop

@section('content-wrapper')
    <div class="content full-page adjacent-center">
        {!! view_render_event('results.create.header.before') !!}

        <div class="page-header">

            {{ Breadcrumbs::render('results.create') }}

            <div class="page-title">
                <h1>{{ __('admin::app.results.create-title') }}</h1>
            </div>
        </div>

        {!! view_render_event('results.create.header.after') !!}

        <form method="POST" action="{{ route('results.store') }}" @submit.prevent="onSubmit" enctype="multipart/form-data">

            <div class="page-content">
                <div class="form-container">

                    <div class="panel">
                        <div class="panel-header">
                            {!! view_render_event('results.create.form_buttons.before') !!}

                            <button type="submit" class="btn btn-primary">
                                {{ __('admin::app.results.save-btn-title') }}
                            </button>

                            <a href="{{ route('results.index') }}">{{ __('admin::app.results.back') }}</a>

                            {!! view_render_event('results.create.form_buttons.after') !!}
                        </div>
        
                        <div class="panel-body">
                            {!! view_render_event('results.create.form_controls.before') !!}

                            @csrf()

                            @include('admin::common.custom-attributes.edit', [
                                'customAttributes' => app('LeadBrowser\Attribute\Repositories\AttributeRepository')->findWhere([
                                    'entity_type' => 'results',
                                ]),
                            ])

                            {!! view_render_event('results.create.form_controls.after') !!}

                        </div>
                    </div>

                </div>

            </div>

        </form>

    </div>
@stop