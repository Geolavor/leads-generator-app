@extends('admin::layouts.master')

@section('page_title')
    {{ __('admin::app.analyze.create-website-title') }}
@stop

@section('content-wrapper')
    <div class="content full-page adjacent-center">
        {!! view_render_event('analyze.create.header.before') !!}

        <div class="page-header">
            <div class="page-title">
                <h1>{{ __('admin::app.analyze.create-website-title') }}</h1>
            </div>
        </div>

        {!! view_render_event('analyze.create.header.after') !!}

        <form method="POST" action="{{ route('analyze.website.store') }}" @submit.prevent="onSubmit" enctype="multipart/form-data">

            <div class="page-content">
                <div class="form-container">

                    <div class="panel">
                        <div class="panel-header">
                            {!! view_render_event('analyze.create.form_buttons.before') !!}

                            <a href="{{ route('search.location.index') }}">{{ __('admin::app.analyze.back') }}</a>

                            {!! view_render_event('analyze.create.form_buttons.after') !!}
                        </div>
        
                        <div class="panel-body">


                            @csrf()

                            <div class="form-group" :class="[errors.has('website') ? 'has-error' : '']">
                                <label for="website">{{ __('admin::app.analyze.website') }}</label>

                                <input
                                    type="text"
                                    name="website"
                                    class="control"
                                    id="website"
                                    v-validate.disable="'required|min:6'"
                                    data-vv-as="&quot;{{ __('admin::app.analyze.website') }}&quot;"
                                />

                                <span class="control-error" v-if="errors.has('website')">
                                    @{{ errors.first('website') }}
                                </span>
                            </div>

                            <button type="submit" class="btn btn-primary">
                                {{ __('admin::app.analyze.save-btn-title') }}
                            </button>

                        </div>
                    </div>

                </div>

            </div>

        </form>

    </div>
@stop

@push('scripts')
    <script>
        $(() => {
            $('input').keyup(({target}) => {
                if ($(target).parent('.has-error').length) {
                    $(target).parent('.has-error').addClass('hide-error');
                }
            });

            $('button').click(() => {
                $('.hide-error').removeClass('hide-error');
            });
        });
    </script>
@endpush
