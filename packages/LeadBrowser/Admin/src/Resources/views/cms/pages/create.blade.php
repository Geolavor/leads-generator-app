@extends('admin::layouts.dashboard')

@section('page_title')
{{ __('admin::app.cms.pages.add-title') }}
@stop

@section('content-wrapper')
<div class="content full-page adjacent-center">
    {!! view_render_event('quotes.create.header.before') !!}

    <div class="page-header">

        {{ Breadcrumbs::render('quotes.create') }}

        <div class="page-title">
            <h1>{{ __('admin::app.quotes.create-title') }}</h1>
        </div>
    </div>

    {!! view_render_event('quotes.create.header.after') !!}

    <form method="POST" action="{{ route('cms.pages.store') }}" @submit.prevent="onSubmit">

        <div class="page-content">
            <div class="form-container">

                <div class="panel">

                    <div class="panel-header">
                        {!! view_render_event('quotes.create.form_buttons.before') !!}

                        <button type="submit" class="btn btn-primary">
                            {{ __('admin::app.quotes.save-btn-title') }}
                        </button>

                        <a href="{{ route('quotes.index') }}">{{ __('admin::app.quotes.back') }}</a>

                        {!! view_render_event('quotes.create.form_buttons.after') !!}
                    </div>

                    <div class="panel-body">

                        {!! view_render_event('quotes.create.form_controls.before') !!}

                        @csrf()

                        {!! view_render_event('cms.pages.create_form_accordian.general.before') !!}

                        <accordian title="{{ __('admin::app.cms.pages.general') }}" :active="true">
                            <div slot="body">
                                <div class="form-group" :class="[errors.has('page_title') ? 'has-error' : '']">
                                    <label for="page_title"
                                        class="required">{{ __('admin::app.cms.pages.page-title') }}</label>

                                    <input type="text" class="control" name="page_title" v-validate="'required'"
                                        value="{{ old('page_title') }}"
                                        data-vv-as="&quot;{{ __('admin::app.cms.pages.page-title') }}&quot;">

                                    <span class="control-error"
                                        v-if="errors.has('page_title')">@{{ errors.first('page_title') }}</span>
                                </div>

                                <div class="form-group" :class="[errors.has('html_content') ? 'has-error' : '']">
                                    <label for="html_content"
                                        class="required">{{ __('admin::app.cms.pages.content') }}</label>

                                    <textarea type="text" class="control" id="content" name="html_content"
                                        v-validate="'required'"
                                        data-vv-as="&quot;{{ __('admin::app.cms.pages.content') }}&quot;">{{ old('html_content') }}</textarea>

                                    <span class="control-error"
                                        v-if="errors.has('html_content')">@{{ errors.first('html_content') }}</span>
                                </div>
                            </div>
                        </accordian>

                        {!! view_render_event('cms.pages.create_form_accordian.general.after') !!}


                        {!! view_render_event('cms.pages.create_form_accordian.seo.before') !!}

                        <accordian title="{{ __('admin::app.cms.pages.seo') }}" :active="true">
                            <div slot="body">
                                <div class="form-group">
                                    <label for="meta_title">{{ __('admin::app.cms.pages.meta_title') }}</label>

                                    <input type="text" class="control" name="meta_title"
                                        value="{{ old('meta_title') }}">
                                </div>

                                <div class="form-group" :class="[errors.has('url_key') ? 'has-error' : '']">
                                    <label for="url-key"
                                        class="required">{{ __('admin::app.cms.pages.url-key') }}</label>

                                    <input type="text" class="control" name="url_key" v-validate="'required'"
                                        value="{{ old('url_key') }}"
                                        data-vv-as="&quot;{{ __('admin::app.cms.pages.url-key') }}&quot;" v-slugify>

                                    <span class="control-error"
                                        v-if="errors.has('url_key')">@{{ errors.first('url_key') }}</span>
                                </div>

                                <div class="form-group">
                                    <label for="meta_keywords">{{ __('admin::app.cms.pages.meta_keywords') }}</label>

                                    <textarea type="text" class="control"
                                        name="meta_keywords">{{ old('meta_keywords') }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label
                                        for="meta_description">{{ __('admin::app.cms.pages.meta_description') }}</label>

                                    <textarea type="text" class="control"
                                        name="meta_description">{{ old('meta_description') }}</textarea>

                                </div>
                            </div>
                        </accordian>

                        {!! view_render_event('cms.pages.create_form_accordian.seo.after') !!}
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@stop

@push('scripts')
@include('admin::layouts.tinymce')

<script>
    $(document).ready(function () {
        tinyMCEHelper.initTinyMCE({
            selector: 'textarea#content',
            height: 200,
            width: "100%",
            plugins: 'image imagetools media wordcount save fullscreen code table lists link hr',
            toolbar1: 'formatselect | bold italic strikethrough forecolor backcolor alignleft aligncenter alignright alignjustify | link hr |numlist bullist outdent indent  | removeformat | code | table',
            image_advtab: true,
            valid_elements: '*[*]',
        });
    });

</script>
@endpush
