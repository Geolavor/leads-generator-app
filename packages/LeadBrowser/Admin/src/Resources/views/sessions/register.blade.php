@extends('admin::layouts.anonymous-master')

@section('page_title')
    {{ __('admin::app.sessions.register.title') }}
@stop

@section('content')
<!-- Heading -->
<div class="text-center mb-5 mb-md-7">
    <h1 class="h2">Create a free account</h1>
    <p>Sign up and grow your business with LeadBrowser<br><b>for free, forever.</b></p>
</div>
<!-- End Heading -->
<form class="js-validate needs-validation" method="POST" action="{{ route('auth.register.store') }}" @submit.prevent="$root.onSubmit">
    
    {!! view_render_event('sessions.register.form_controls.before') !!}

    @csrf

    <!-- Form -->
    <div class="mb-4">
        <label class="form-label" for="signupModalFormregisterName">{{ __('admin::app.sessions.register.name') }}</label>
        <input type="text" class="form-control form-control-lg" :class="[errors.has('name') ? 'has-error' : '']" name="name" id="signupModalFormregisterName"
        v-validate.disable="'required'" data-vv-as="&quot;{{ __('admin::app.sessions.register.name') }}&quot;" placeholder="Nicolas" aria-label="Nicolas" required="">

        <span class="invalid-feedback" v-if="errors.has('name')">
            @{{ errors.first('name') }}
        </span>
    </div>

    <div class="mb-4">
        <label class="form-label" for="email">{{ __('admin::app.sessions.register.email') }}</label>
        <input type="email" class="form-control form-control-lg" :class="[errors.has('email') ? 'has-error' : '']" name="email" id="email"
        v-validate.disable="'required|email'" data-vv-as="&quot;{{ __('admin::app.sessions.register.email') }}&quot;" placeholder="email@site.com" aria-label="email@site.com" required="">

        <span class="invalid-feedback" v-if="errors.has('email')">
            @{{ errors.first('email') }}
        </span>
    </div>

    <div class="mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <label class="form-label" for="password">{{ __('admin::app.sessions.register.password') }}</label>
        </div>

        <div class="input-group input-group-merge" :class="[errors.has('password') ? 'has-error' : '']">
            <input type="password" class="js-toggle-password form-control form-control-lg" name="password"
                id="password" placeholder="8+ characters required"
                aria-label="8+ characters required" required="" minlength="8" v-validate.disable="'required|min:6'"
                data-vv-as="&quot;{{ __('admin::app.sessions.register.password') }}&quot;">
            <a id="changePassTarget" class="input-group-append input-group-text" href="javascript:;">
                <i id="changePassIcon" class="bi bi-eye"></i>
            </a>
        </div>

        <span class="invalid-feedback">Please enter a valid password.</span>
    </div>

    <div class="mb-3">
        <div class="small">
            By signing up, you agree to our <a href="./page-privacy.html">Terms of Service</a> and our <a href="./page-privacy.html">Privacy Policy.</a>
        </div>
    </div>

    <div class="d-grid mb-3">
        {!! view_render_event('sessions.register.form_buttons.before') !!}

        <button type="submit" class="btn btn-xl btn-primary">
            {{ __('admin::app.sessions.register.title') }}
        </button>

        {!! view_render_event('sessions.register.form_buttons.after') !!}
    </div>

    <div class="text-center">
        <p>Already have an account? <a href="{{ route('auth.login.create') }}"
                class="link">{{ __('admin::app.sessions.login.title') }}</a></p>
    </div>

    {!! view_render_event('sessions.register.form_controls.after') !!}

</form>
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
