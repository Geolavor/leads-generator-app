@extends('admin::layouts.master')

@section('page_title')
    {{ __('admin::app.settings.plan.create-title') }}
@stop

@section('content-wrapper')
    <div class="content full-page adjacent-center">
        {!! view_render_event('settings.plan.create.header.before') !!}

        <div class="page-header">
            <div class="page-title">
                <h1>{{ __('admin::app.settings.plan.create-title') }}</h1>
            </div>
        </div>

        {!! view_render_event('settings.plan.create.header.after') !!}

        <form method="POST" action="{{ route('settings.plan.store') }}" @submit.prevent="onSubmit">
            <div class="page-content">
                <div class="form-container">
                    <div class="panel">
                        <div class="panel-header">
                            {!! view_render_event('settings.plan.create.form_buttons.before') !!}

                            <button type="submit" class="btn btn-primary">
                                {{ __('admin::app.settings.plan.save-btn-title') }}
                            </button>

                            <a href="{{ route('settings.plans.index') }}">
                                {{ __('admin::app.layouts.back') }}
                            </a>

                            {!! view_render_event('settings.plan.create.form_buttons.after') !!}
                        </div>

                        <div class="panel-body">
                            {!! view_render_event('settings.plan.create.form_controls.before') !!}

                            @csrf()

                            <div class="form-group" :class="[errors.has('name') ? 'has-error' : '']">
                                <label class="required">
                                    {{ __('admin::app.settings.plan.name') }}
                                </label>

                                <input
                                    type="text"
                                    name="name"
                                    class="control"
                                    value="{{ old('name') }}"
                                    v-validate="'required'"
                                    data-vv-as="{{ __('admin::app.settings.plan.name') }}"
                                />

                                <span class="control-error" v-if="errors.has('name')">
                                    @{{ errors.first('name') }}
                                </span>
                            </div>

                            <div class="form-group" :class="[errors.has('description') ? 'has-error' : '']">
                                <label class="required">
                                    {{ __('admin::app.settings.plan.description') }}
                                </label>

                                <textarea
                                    type="text"
                                    name="description"
                                    class="control"
                                    value="{{ old('description') }}"
                                    v-validate="'required'"
                                    data-vv-as="{{ __('admin::app.settings.plan.description') }}"
                                ></textarea>

                                <span class="control-error" v-if="errors.has('description')">
                                    @{{ errors.first('description') }}
                                </span>
                            </div>

                            <div class="form-group" :class="[errors.has('price') ? 'has-error' : '']">
                                <label class="required">
                                    {{ __('admin::app.settings.plan.price') }}
                                </label>

                                <input
                                    type="text"
                                    name="price"
                                    class="control"
                                    value="{{ old('price') ?? 30 }}"
                                    v-validate="'required|numeric|min_value:1'"
                                    data-vv-as="{{ __('admin::app.settings.plan.price') }}"
                                />

                                <span class="control-error" v-if="errors.has('price')">
                                    @{{ errors.first('price') }}
                                </span>
                            </div>

                            <div class="form-group" :class="[errors.has('value') ? 'has-error' : '']">
                                <label class="required">
                                    {{ __('admin::app.settings.plan.value') }}
                                </label>

                                <input
                                    type="text"
                                    name="value"
                                    class="control"
                                    value="{{ old('value') ?? 30 }}"
                                    v-validate="'required|numeric|min_value:1'"
                                    data-vv-as="{{ __('admin::app.settings.plan.value') }}"
                                />

                                <span class="control-error" v-if="errors.has('value')">
                                    @{{ errors.first('value') }}
                                </span>
                            </div>

                            <div class="form-group">
                                <label>
                                    {{ __('admin::app.settings.plan.active') }}
                                </label>

                                <label class="switch">
                                    <input
                                        type="checkbox"
                                        name="active"
                                        class="control"
                                        id="active"
                                        value="{{ old('active') ? 'checked' : '' }}"
                                    />
                                    <span class="slider round"></span>
                                </label>
                            </div>

                            {!! view_render_event('settings.plan.create.form_controls.after') !!}
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@stop
