@extends('admin::layouts.anonymous-master')

@section('page_title')
    {{ __('admin::app.sessions.reset-password.title') }}
@stop

@section('content')
    <form class="js-validate needs-validation" method="POST" action="{{ route('reset_password.store') }}" @submit.prevent="onSubmit">
        {!! view_render_event('sessions.reset_password.form_controls.before') !!}

        @csrf

        <input type="hidden" name="token" value="{{ $token }}">

        <!-- Form -->
        <div class="mb-4">
            <label class="form-label" for="signupModalFormLoginEmail">{{ __('admin::app.sessions.reset-password.email') }}</label>
            <input type="email" class="form-control form-control-lg" :class="[errors.has('email') ? 'has-error' : '']" name="email" id="signupModalFormLoginEmail"
            v-validate.disable="'required|email'" data-vv-as="&quot;{{ __('admin::app.sessions.reset-password.email') }}&quot;" placeholder="email@site.com" aria-label="email@site.com" required="">

            <span class="invalid-feedback" v-if="errors.has('email')">
                @{{ errors.first('email') }}
            </span>
        </div>
        <!-- End Form -->

        <!-- Form -->
        <div class="mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <label class="form-label" for="signupModalFormLoginPassword">{{ __('admin::app.sessions.reset-password.password') }}</label>

                <a class="form-label-link"
                    href="{{ route('forgot_password.create') }}">{{ __('admin::app.sessions.reset-password.password') }}</a>
            </div>

            <div class="input-group input-group-merge" :class="[errors.has('password') ? 'has-error' : '']">
                <input type="password" class="js-toggle-password form-control form-control-lg" name="password"
                    id="signupModalFormLoginPassword" placeholder="8+ characters required"
                    aria-label="8+ characters required" required="" minlength="8" v-validate.disable="'required|min:6'"
                    data-vv-as="&quot;{{ __('admin::app.sessions.login.password') }}&quot;">
                <a id="changePassTarget" class="input-group-append input-group-text" href="javascript:;">
                    <i id="changePassIcon" class="bi bi-eye"></i>
                </a>

                <span class="control-error" v-if="errors.has('password')">
                    @{{ errors.first('password') }}
                </span>
            </div>

            <span class="invalid-feedback">Please enter a valid password.</span>
        </div>
        <!-- End Form -->

        <!-- Form -->
        <div class="mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <label class="form-label" for="signupModalFormLoginPassword">{{ __('admin::app.sessions.reset-password.password') }}</label>

                <a class="form-label-link"
                    href="{{ route('forgot_password.create') }}">{{ __('admin::app.sessions.reset-password.password') }}</a>
            </div>

            <div class="input-group input-group-merge" :class="[errors.has('password_confirmation') ? 'has-error' : '']">
                <input type="password" class="js-toggle-password form-control form-control-lg" name="password_confirmation"
                    id="password_confirmation" placeholder="8+ characters required"
                    aria-label="8+ characters required" required="" minlength="8" v-validate.disable="'required|min:6|confirmed:password'"
                    data-vv-as="&quot;{{ __('admin::app.sessions.reset-password.confirm-password') }}&quot;">
                <a id="changePassTarget" class="input-group-append input-group-text" href="javascript:;">
                    <i id="changePassIcon" class="bi bi-eye"></i>
                </a>

                <span class="control-error" v-if="errors.has('password_confirmation')">
                    @{{ errors.first('password_confirmation') }}
                </span>
            </div>

            <span class="invalid-feedback">Please enter a valid password.</span>
        </div>
        <!-- End Form -->

        {!! view_render_event('sessions.reset_password.form_controls.after') !!}
        
        <div class="button-group">
            {!! view_render_event('sessions.reset_password.form_buttons.before') !!}

            <button type="submit" class="btn btn-xl btn-primary">
                {{ __('admin::app.sessions.reset-password.reset-password') }}
            </button>

            {!! view_render_event('sessions.reset_password.form_buttons.after') !!}
        </div>
    </form>
@stop