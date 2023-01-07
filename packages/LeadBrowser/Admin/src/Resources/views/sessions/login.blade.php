@extends('admin::layouts.anonymous-master')

@section('page_title')
{{ __('admin::app.sessions.login.title') }}
@stop

@section('content')
    <!-- Heading -->
    <div class="text-center mb-5 mb-md-7">
        <h1 class="h2">Welcome back</h1>
        <p>Login to manage your account.</p>
    </div>
    <!-- End Heading -->
    <form class="js-validate needs-validation" method="POST" action="{{ route('auth.login.store') }}" @submit.prevent="$root.onSubmit">
        
        {!! view_render_event('sessions.login.form_controls.before') !!}

        @csrf

        <!-- Form -->
        <div class="mb-4">
            <label class="form-label" for="signupModalFormLoginEmail">{{ __('admin::app.sessions.login.email') }}</label>
            <input type="email" class="form-control form-control-lg" :class="[errors.has('email') ? 'has-error' : '']" name="email" id="signupModalFormLoginEmail"
            v-validate.disable="'required|email'" data-vv-as="&quot;{{ __('admin::app.sessions.login.email') }}&quot;" placeholder="email@site.com" aria-label="email@site.com" required="">

            <span class="invalid-feedback" v-if="errors.has('email')">
                @{{ errors.first('email') }}
            </span>
        </div>
        <!-- End Form -->

        <!-- Form -->
        <div class="mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <label class="form-label" for="signupModalFormLoginPassword">{{ __('admin::app.sessions.login.password') }}</label>

                <a class="form-label-link"
                    href="{{ route('forgot_password.create') }}">{{ __('admin::app.sessions.login.forgot-password') }}</a>
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

        <div class="d-grid mb-3">
            {!! view_render_event('sessions.login.form_buttons.before') !!}

            <button type="submit" class="btn btn-xl btn-primary">
                {{ __('admin::app.sessions.login.login') }}
            </button>

            {!! view_render_event('sessions.login.form_buttons.after') !!}
        </div>

        <div class="text-center">
            <p>Don't have an account yet? <a href="{{ route('auth.register.create') }}"
                    class="link">{{ __('admin::app.sessions.register.title') }}</a></p>
        </div>

        {!! view_render_event('sessions.login.form_controls.after') !!}

    </form>
@stop

@push('scripts')
<script>
    $(() => {
        $('input').keyup(({
            target
        }) => {
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
