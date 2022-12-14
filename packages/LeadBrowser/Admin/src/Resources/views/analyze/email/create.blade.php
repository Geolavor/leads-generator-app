@extends('admin::layouts.master')

@section('page_title')
    {{ __('admin::app.analyze.create-email-title') }}
@stop

@section('content-wrapper')
    <div class="content full-page adjacent-center">
        {!! view_render_event('analyze.create.header.before') !!}

        <div class="page-header">
            <div class="page-title">
                <h1>{{ __('admin::app.analyze.create-email-title') }}</h1>
            </div>
        </div>

        {!! view_render_event('analyze.create.header.after') !!}

        <form method="POST" action="{{ route('analyze.email.store') }}" @submit.prevent="onSubmit" enctype="multipart/form-data">

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

                            <div class="form-group" :class="[errors.has('email') ? 'has-error' : '']">
                                <label for="email">{{ __('admin::app.analyze.email') }}</label>

                                <input
                                    type="text"
                                    name="email"
                                    class="control"
                                    id="email"
                                    v-validate.disable="'required|min:6'"
                                    data-vv-as="&quot;{{ __('admin::app.analyze.email') }}&quot;"
                                />

                                <span class="control-error" v-if="errors.has('email')">
                                    @{{ errors.first('email') }}
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
