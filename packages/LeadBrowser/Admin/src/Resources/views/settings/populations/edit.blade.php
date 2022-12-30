@extends('admin::layouts.master')

@section('page_title')
    {{ __('admin::app.settings.populations.edit-title') }}
@stop

@section('content-wrapper')
    <div class="content full-page adjacent-center">
        {!! view_render_event('settings.populations.edit.header.before', ['population' => $population]) !!}

        <div class="page-header">
            
            {{ Breadcrumbs::render('settings.populations.edit', $population) }}

            <div class="page-title">
                <h1>{{ __('admin::app.settings.populations.edit-title') }}</h1>
            </div>
        </div>

        {!! view_render_event('settings.populations.edit.header.after', ['population' => $population]) !!}

        <form method="POST" action="{{ route('settings.populations.update', ['id' => $population->id]) }}" @submit.prevent="onSubmit">
            <div class="page-content">
                <div class="form-container">
                    <div class="panel">
                        <div class="panel-header">
                            {!! view_render_event('settings.populations.edit.form_buttons.before', ['population' => $population]) !!}

                            <button type="submit" class="btn btn-primary">
                                {{ __('admin::app.settings.populations.save-btn-title') }}
                            </button>

                            <a href="{{ route('settings.populations.index') }}">
                                {{ __('admin::app.layouts.back') }}
                            </a>

                            {!! view_render_event('settings.populations.edit.form_buttons.after', ['population' => $population]) !!}
                        </div>

                        <div class="panel-body">
                            {!! view_render_event('settings.populations.edit.form_controls.before', ['population' => $population]) !!}

                            @csrf()

                            <input name="_method" type="hidden" value="PUT">
                            
                            <div class="form-group" :class="[errors.has('name') ? 'has-error' : '']">
                                <label class="required">
                                    {{ __('admin::app.layouts.name') }}
                                </label>

                                <input
                                    type="text"
                                    name="name"
                                    class="control"
                                    value="{{ $population->name }}"
                                    placeholder="{{ __('admin::app.layouts.name') }}"
                                    v-validate="'required'"
                                    data-vv-as="{{ __('admin::app.layouts.name') }}"
                                />

                                <span class="control-error" v-if="errors.has('name')">
                                    @{{ errors.first('name') }}
                                </span>
                            </div>

                            {!! view_render_event('settings.populations.edit.form_controls.after', ['population' => $population]) !!}
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@stop