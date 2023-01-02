@extends('admin::layouts.master')

@section('page_title')
    {{ __('admin::app.analyze.create-phone-title') }}
@stop

@section('content-wrapper')
    <div class="content full-page adjacent-center">
        {!! view_render_event('analyze.create.header.before') !!}

        <div class="page-header">
            <div class="page-title">
                <h1>{{ __('admin::app.analyze.create-phone-title') }}</h1>
            </div>
        </div>

        {!! view_render_event('analyze.create.header.after') !!}

        <form method="POST" action="{{ route('analyze.phone.store') }}" @submit.prevent="onSubmit" enctype="multipart/form-data">

            <div class="page-content">
                <div class="form-container">

                    <div class="panel">
                        <div class="panel-header">
                            {!! view_render_event('analyze.create.form_buttons.before') !!}

                            <a href="{{ route('search.location.index') }}">{{ __('admin::app.analyze.back') }}</a>

                            {!! view_render_event('analyze.create.form_buttons.after') !!}
                        </div>
        
                        <div class="panel-body">

                            <div style="padding-bottom:15px">
                                <h4>Remember</h4>
                                <p>The phone number must include the country code. For example, if you want to check a phone code from Poland, you have to add a special code <b>+48</b> before the phone number.</p>
                                <hr>
                            </div>

                            @csrf()

                            <div class="form-group" :class="[errors.has('phone') ? 'has-error' : '']">
                                <label for="phone">{{ __('admin::app.analyze.phone') }}</label>

                                <input
                                    type="text"
                                    name="phone"
                                    class="control"
                                    id="phone"
                                    v-validate.disable="'required|min:6'"
                                    data-vv-as="&quot;{{ __('admin::app.analyze.phone') }}&quot;"
                                />

                                <span class="control-error" v-if="errors.has('phone')">
                                    @{{ errors.first('phone') }}
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
