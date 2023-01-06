@extends('admin::layouts.dashboard')

@section('page_title')
    {{ __('admin::app.results.edit-title') }}
@stop

@section('content-wrapper')
    <div class="content full-page adjacent-center">
        {!! view_render_event('results.edit.header.before', ['result' => $result]) !!}

        <div class="page-header">

            {{ Breadcrumbs::render('results.edit', $result) }}

            <div class="page-title">
                <h1>{{ __('admin::app.results.edit-title') }}</h1>
            </div>
        </div>

        {!! view_render_event('results.edit.header.after', ['result' => $result]) !!}

        <form method="POST" action="{{ route('results.update', $result->id) }}" @submit.prevent="onSubmit" enctype="multipart/form-data">

            <div class="page-content">
                <div class="form-container">

                    <div class="panel">
                        <div class="panel-header">
                            {!! view_render_event('results.edit.form_buttons.before', ['result' => $result]) !!}

                            <button type="submit" class="btn btn-primary">
                                {{ __('admin::app.results.save-btn-title') }}
                            </button>

                            <a href="{{ route('results.index') }}">{{ __('admin::app.results.back') }}</a>

                            {!! view_render_event('results.edit.form_buttons.after', ['result' => $result]) !!}
                        </div>
        
                        <div class="panel-body">
                            {!! view_render_event('results.edit.form_controls.before', ['result' => $result]) !!}

                            @csrf()

                            <input name="_method" type="hidden" value="PUT">
                
                            @include('admin::common.custom-attributes.edit', [
                                'customAttributes' => app('LeadBrowser\Attribute\Repositories\AttributeRepository')->findWhere([
                                    'entity_type' => 'results',
                                ]),
                                'entity'           => $result,
                            ])

                            {!! view_render_event('results.edit.form_controls.after', ['result' => $result]) !!}

                        </div>
                    </div>

                </div>

            </div>

        </form>

    </div>
@stop