@extends('admin::layouts.master')

@section('page_title')
    {{ __('admin::app.cms.blogs.edit-title') }}
@stop

@push('css')
    <style>
    @media only screen and (max-width: 768px){
        .content-container .content .page-header .page-action button {
            position: relative;
            right: 0px !important;
            top: 0px !important;
        }

        .content-container .content .page-header .page-title .form-group {
            margin-top: 20px!important;
            width: 100%!important;
            margin-left: 0!important;
        }
    }
    </style>
@endpush

@section('content-wrapper')
    <div class="content">
        @php
            $locale = core()->getRequestedLocaleCode();
        @endphp

        <form method="POST" id="page-form" action="" @submit.prevent="onSubmit">

            <div class="page-header">
                <div class="page-title">
                    <h1>
                        <i class="icon angle-left-icon back-link" onclick="window.location = '{{ route('cms.blogs.index') }}'"></i>

                        {{ __('admin::app.cms.blogs.edit-title') }}
                    </h1>

                    <div class="form-group">
                        <select class="control" id="locale-switcher" onChange="window.location.href = this.value">
                       
                        </select>
                    </div>
                </div>

                <div class="page-action">
                    <button type="submit" class="btn btn-lg btn-primary">
                        {{ __('admin::app.cms.blogs.edit-btn-title') }}
                    </button>
                </div>
            </div>

            <div class="page-content">

                <div class="form-container">
                    @csrf()
                    <accordian title="{{ __('admin::app.cms.blogs.general') }}" :active="true">
                        <div slot="body">

                            <upload-profile-image></upload-profile-image>

                            <div class="form-group" :class="[errors.has('{{$locale}}[page_title]') ? 'has-error' : '']">
                                <label for="page_title" class="required">{{ __('admin::app.cms.blogs.blog-title') }}</label>

                                <input type="text" class="control" name="{{$locale}}[blog_title]" v-validate="'required'" value="{{ old($locale)['blog_title'] ?? ($blog->translate($locale)['blog_title'] ?? '') }}" data-vv-as="&quot;{{ __('admin::app.cms.blogs.blog-title') }}&quot;">

                                <span class="control-error" v-if="errors.has('{{$locale}}[blog_title]')">@{{ errors.first('{!!$locale!!}[blog_title]') }}</span>
                            </div>

                            <div class="form-group" :class="[errors.has('{{$locale}}[html_content]') ? 'has-error' : '']">
                                <label for="html_content" class="required">{{ __('admin::app.cms.blogs.content') }}</label>

                                <textarea type="text" class="control" id="content" name="{{$locale}}[html_content]" v-validate="'required'" data-vv-as="&quot;{{ __('admin::app.cms.blogs.content') }}&quot;">{{ old($locale)['html_content'] ?? ($blog->translate($locale)['html_content'] ?? '') }}</textarea>

                                <span class="control-error" v-if="errors.has('{{$locale}}[html_content]')">@{{ errors.first('{!!$locale!!}[html_content]') }}</span>
                            </div>
                        </div>
                    </accordian>

                    <accordian title="{{ __('admin::app.cms.blogs.seo') }}" :active="true">
                        <div slot="body">
                            <div class="form-group">
                                <label for="meta_title">{{ __('admin::app.cms.blogs.meta_title') }}</label>

                                <input type="text" class="control" name="{{$locale}}[meta_title]" value="{{ old($locale)['meta_title'] ?? ($blog->translate($locale)['meta_title'] ?? '') }}">
                            </div>

                            <div class="form-group" :class="[errors.has('{{$locale}}[url_key]') ? 'has-error' : '']">
                                <label for="url-key" class="required">{{ __('admin::app.cms.blogs.url-key') }}</label>

                                <input type="text" class="control" name="{{$locale}}[url_key]" v-validate="'required'" value="{{ old($locale)['url_key'] ?? ($blog->translate($locale)['url_key'] ?? '') }}" data-vv-as="&quot;{{ __('admin::app.cms.blogs.url-key') }}&quot;">

                                <span class="control-error" v-if="errors.has('{{$locale}}[url_key]')">@{{ errors.first('{!!$locale!!}[url_key]') }}</span>
                            </div>

                            <div class="form-group">
                                <label for="meta_keywords">{{ __('admin::app.cms.blogs.meta_keywords') }}</label>

                                <textarea type="text" class="control" name="{{$locale}}[meta_keywords]">{{ old($locale)['meta_keywords'] ?? ($blog->translate($locale)['meta_keywords'] ?? '') }}</textarea>

                            </div>

                            <div class="form-group">
                                <label for="meta_description">{{ __('admin::app.cms.blogs.meta_description') }}</label>

                                <textarea type="text" class="control" name="{{$locale}}[meta_description]">{{ old($locale)['meta_description'] ?? ($blog->translate($locale)['meta_description'] ?? '') }}</textarea>

                            </div>
                        </div>
                    </accordian>
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
                toolbar1: 'formatselect | bold italic strikethrough forecolor backcolor alignleft aligncenter alignright alignjustify | link hr | numlist bullist outdent indent  | removeformat | code | table',
                image_advtab: true,
                valid_elements : '*[*]',
            });
        });
    </script>

    <script>
        Vue.component('upload-profile-image', {
            template: '#upload-profile-image-template',

            data: function() {
                return {
                    imageData: "{{ $blog ? $blog->image_url : '' }}",
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