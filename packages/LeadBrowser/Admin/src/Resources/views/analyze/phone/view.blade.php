@extends('admin::layouts.master')

@section('page_title')
{{ __('admin::app.analyze.create-phone-title') }}
@stop

@section('content-wrapper')
<div class="content full-page adjacent-center">
    {!! view_render_event('search.location.create.header.before') !!}

    <div class="page-header">
        <div class="page-title">
            <h1>{{ __('admin::app.analyze.create-phone-title') }}</h1>
        </div>
    </div>

    {!! view_render_event('search.location.create.header.after') !!}

    <div class="page-content">
        <div class="form-container">

            <div class="panel">
                <div class="panel-header">
                    {!! view_render_event('analyze.create.form_buttons.before') !!}

                    <a href="{{ route('search.location.index') }}">{{ __('admin::app.analyze.back') }}</a>

                    {!! view_render_event('analyze.create.form_buttons.after') !!}
                </div>

                <div class="panel-body">

                    @if ($data && isset($data))
                        <div class="custom-attribute-view">

                            

                        </div>
                    @endif

                </div>
                
            </div>
        </div>
    </div>
</div>
@stop
