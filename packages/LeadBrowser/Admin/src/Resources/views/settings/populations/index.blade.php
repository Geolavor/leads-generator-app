@extends('admin::layouts.master')

@section('page_title')
    {{ __('admin::app.settings.populations.title') }}
@stop

@section('content-wrapper')
    <div class="content full-page">
        <table-component data-src="{{ route('settings.populations.index') }}">
            <template v-slot:table-header>
                <h1>
                    {!! view_render_event('settings.populations.index.header.before') !!}

                    {{ Breadcrumbs::render('settings.populations') }}

                    {{ __('admin::app.settings.populations.title') }}

                    {!! view_render_event('settings.populations.index.header.after') !!}
                </h1>
            </template>

            @if (bouncer()->hasPermission('settings.lead.populations.create'))
                <template v-slot:table-action>
                    <button class="btn btn-primary" @click="openModal('addSourceModal')">{{ __('admin::app.settings.populations.create-title') }}</button>
                </template>
            @endif
        <table-component>
    </div>

    <form action="{{ route('settings.populations.store') }}" method="POST" @submit.prevent="onSubmit">
        <modal id="addSourceModal" :is-open="modalIds.addSourceModal">
            <h3 slot="header-title">{{ __('admin::app.settings.populations.create-title') }}</h3>

            <div slot="header-actions">
                {!! view_render_event('settings.populations.create.form_buttons.before') !!}

                <button class="btn btn-sm btn-secondary-outline" @click="closeModal('addSourceModal')">{{ __('admin::app.settings.populations.cancel') }}</button>

                <button type="submit" class="btn btn-sm btn-primary">{{ __('admin::app.settings.populations.save-btn-title') }}</button>

                {!! view_render_event('settings.populations.create.form_buttons.after') !!}
            </div>

            <div slot="body">
                {!! view_render_event('settings.populations.create.form_controls.before') !!}

                @csrf()

                <div class="form-group" :class="[errors.has('name') ? 'has-error' : '']">
                    <label class="required">
                        {{ __('admin::app.layouts.name') }}
                    </label>

                    <input
                        type="text"
                        name="name"
                        class="control"
                        placeholder="{{ __('admin::app.layouts.name') }}"
                        v-validate="'required'"
                        data-vv-as="{{ __('admin::app.layouts.name') }}"
                    />

                    <span class="control-error" v-if="errors.has('name')">
                        @{{ errors.first('name') }}
                    </span>
                </div>

                <div class="form-group" :class="[errors.has('number') ? 'has-error' : '']">
                    <label class="required">
                        {{ __('admin::app.layouts.number') }}
                    </label>

                    <input
                        type="number"
                        name="number"
                        class="control"
                        placeholder="{{ __('admin::app.layouts.number') }}"
                        v-validate="'required'"
                        data-vv-as="{{ __('admin::app.layouts.number') }}"
                    />

                    <span class="control-error" v-if="errors.has('number')">
                        @{{ errors.first('number') }}
                    </span>
                </div>

                {!! view_render_event('settings.populations.create.form_controls.after') !!}
            </div>
        </modal>
    </form>
@stop
