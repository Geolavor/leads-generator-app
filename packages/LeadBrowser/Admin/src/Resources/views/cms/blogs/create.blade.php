@extends('admin::layouts.master')

@section('page_title')
{{ __('admin::app.cms.blogs.add-title') }}
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

    <form method="POST" action="{{ route('cms.blogs.store') }}" @submit.prevent="onSubmit">

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

                        {!! view_render_event('cms.blogs.create_form_accordian.general.before') !!}

                        <accordian title="{{ __('admin::app.cms.blogs.general') }}" :active="true">
                            <div slot="body">

                                <upload-profile-image></upload-profile-image>
                                @{{ errors.first('image') }}

                                <div class="form-group" :class="[errors.has('blog_title') ? 'has-error' : '']">
                                    <label for="blog_title"
                                        class="required">{{ __('admin::app.cms.blogs.blog-title') }}</label>

                                    <input type="text" class="control" name="blog_title" v-validate="'required'"
                                        value="{{ old('blog_title') }}"
                                        data-vv-as="&quot;{{ __('admin::app.cms.blogs.blog-title') }}&quot;">

                                    <span class="control-error"
                                        v-if="errors.has('blog_title')">@{{ errors.first('blog_title') }}</span>
                                </div>

                                <div class="form-group" :class="[errors.has('html_content') ? 'has-error' : '']">
                                    <label for="html_content"
                                        class="required">{{ __('admin::app.cms.blogs.content') }}</label>

                                    <textarea type="text" class="control" id="content" name="html_content"
                                        v-validate="'required'"
                                        data-vv-as="&quot;{{ __('admin::app.cms.blogs.content') }}&quot;">{{ old('html_content') }}</textarea>

                                    <span class="control-error"
                                        v-if="errors.has('html_content')">@{{ errors.first('html_content') }}</span>
                                </div>
                            </div>
                        </accordian>

                        {!! view_render_event('cms.blogs.create_form_accordian.general.after') !!}


                        {!! view_render_event('cms.blogs.create_form_accordian.seo.before') !!}

                        <accordian title="{{ __('admin::app.cms.blogs.seo') }}" :active="true">
                            <div slot="body">
                                <div class="form-group">
                                    <label for="meta_title">{{ __('admin::app.cms.blogs.meta_title') }}</label>

                                    <input type="text" class="control" name="meta_title"
                                        value="{{ old('meta_title') }}">
                                </div>

                                <div class="form-group" :class="[errors.has('url_key') ? 'has-error' : '']">
                                    <label for="url-key"
                                        class="required">{{ __('admin::app.cms.blogs.url-key') }}</label>

                                    <input type="text" class="control" name="url_key" v-validate="'required'"
                                        value="{{ old('url_key') }}"
                                        data-vv-as="&quot;{{ __('admin::app.cms.blogs.url-key') }}&quot;" v-slugify>

                                    <span class="control-error"
                                        v-if="errors.has('url_key')">@{{ errors.first('url_key') }}</span>
                                </div>

                                <div class="form-group">
                                    <label for="meta_keywords">{{ __('admin::app.cms.blogs.meta_keywords') }}</label>

                                    <textarea type="text" class="control"
                                        name="meta_keywords">{{ old('meta_keywords') }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label
                                        for="meta_description">{{ __('admin::app.cms.blogs.meta_description') }}</label>

                                    <textarea type="text" class="control"
                                        name="meta_description">{{ old('meta_description') }}</textarea>

                                </div>
                            </div>
                        </accordian>

                        {!! view_render_event('cms.blogs.create_form_accordian.seo.after') !!}
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

<script type="text/x-template" id="upload-profile-image-template">
    <div class="form-group">

        <!-- <div class="image-upload-brick">
            <input
                type="file"
                name="image"
                id="upload-profile"
                ref="imageInput"
                @change="addImageView($event)"
            >
        </div> -->

        <div class="image-upload-brick">
            
            <label class="avatar avatar-xxl avatar-circle avatar-uploader" for="upload-profile">
                <img id="upload-profile-image" class="avatar-img" v-if="imageData.length > 0" :src="imageData" alt="Image Description">

                <input
                    type="file"
                    name="image"
                    class="js-file-attach avatar-uploader-input"
                    id="upload-profile"
                    @change="addImageView($event)"
                    ref="imageInput"
                >

                <span class="avatar-uploader-trigger">
                    <i class="bi-pencil-fill avatar-uploader-icon shadow-sm"></i>
                </span>
            </label>
        </div>

        <div class="image-info-brick">
            <span class="field-info">
                Upload a Profile Image (100px x 100px)<br> in PNG or JPG Format
            </span>
        </div>
    </div>
</script>

<script>
    Vue.component('upload-profile-image', {
        template: '#upload-profile-image-template',

        data: function() {
            return {
                imageData: "",
            }
        },

        methods: {
            addImageView () {
                var imageInput = this.$refs.imageInput;

                if (imageInput.files && imageInput.files[0]) {
                    if (imageInput.files[0].type.includes('image/')) {
                        var reader = new FileReader();

                        reader.onload = (e) => {
                            this.imageData = e.target.result;
                        }

                        reader.readAsDataURL(imageInput.files[0]);
                    } else {
                        imageInput.value = '';

                        alert('Only images (.jpeg, .jpg, .png, ..) are allowed.');
                    }
                }
            }
        }
    });
</script>
@endpush