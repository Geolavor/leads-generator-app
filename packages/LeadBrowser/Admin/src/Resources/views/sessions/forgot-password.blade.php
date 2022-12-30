@extends('admin::layouts.anonymous-master')

@section('page_title')
    {{ __('admin::app.sessions.forgot-password.title') }}
@stop

@section('content')
    <!-- Heading -->
    <div class="text-center mb-5 mb-md-7">
        <h1 class="h2">Forgot password?</h1>
        <!-- <p>Login to manage your account.</p> -->
    </div>
    <form class="js-validate needs-validation" method="POST" action="{{ route('forgot_password.store') }}" @submit.prevent="$root.onSubmit">
        
        {!! view_render_event('sessions.forgot_password.form_controls.before') !!}

        @csrf

        <!-- Form -->
        <div class="mb-4">
            <label class="form-label" for="signupModalFormLoginEmail">{{ __('admin::app.sessions.forgot-password.email') }}</label>
            <input type="email" class="form-control form-control-lg" :class="[errors.has('email') ? 'has-error' : '']" name="email" id="signupModalFormLoginEmail"
            v-validate.disable="'required|email'" data-vv-as="&quot;{{ __('admin::app.sessions.forgot-password.email') }}&quot;" placeholder="email@site.com" aria-label="email@site.com" required="">

            <span class="invalid-feedback" v-if="errors.has('email')">
                @{{ errors.first('email') }}
            </span>
        </div>
        <!-- End Form -->

        <div class="d-grid mb-3">
            {!! view_render_event('sessions.forgot_password.form_buttons.before') !!}

            <button type="submit" class="btn btn-xl btn-primary">
                {{ __('admin::app.sessions.forgot-password.title') }}
            </button>

            {!! view_render_event('sessions.forgot_password.form_buttons.after') !!}
        </div>

        <div class="text-center">
            <a href="{{ route('auth.login.create') }}">{{ __('admin::app.sessions.forgot-password.back-to-login') }}</a>
        </div>

        {!! view_render_event('sessions.forgot_password.form_controls.after') !!}

    </form>

@stop