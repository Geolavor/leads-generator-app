@extends('admin::layouts.landing')

@section('page_title')
{{ __('admin::app.settings.sources.title') }}
@stop

@section('content-wrapper')
<div class="bg-dark wave-background">
    <div class="container content-space-t-3 content-space-t-lg-5 content-space-b-2">
        <div class="w-md-75 w-lg-50 text-center text-white mx-md-auto">
            <h1 class="text-white">Claim your email address</h1>
            <p>Once claimed, you'll receive an email with a confirmation code. As soon as your email address is
                confirmed, it will be automatically excluded from any mailing lists on the platform and will never
                appear in the search results in the future.</p>
        </div>
    </div>
</div>
<div class="container content-space-2 content-space-lg-3">
    <!-- Form -->
    <div class="mx-auto" style="max-width: 35rem;">
        <!-- Form -->
        <form action="{{ route('claim.store') }}" method="POST" id="payment-form">
            @csrf

            <div class="mb-4">
                <label class="form-label" for="email">{{ __('admin::app.sessions.register.email') }}</label>
                <input type="email" class="form-control form-control-lg" :class="[errors.has('email') ? 'has-error' : '']" name="email" id="email"
                v-validate.disable="'required|email'" data-vv-as="&quot;{{ __('admin::app.sessions.register.email') }}&quot;" placeholder="email@site.com" aria-label="email@site.com" required="">

                <span class="invalid-feedback" v-if="errors.has('email')">
                    @{{ errors.first('email') }}
                </span>
            </div>

            <!-- Form -->
            <div class="mb-4">
                <label class="form-label" for="additional">Details</label>
                <textarea class="form-control form-control-lg" name="additional" id="additional"
                    placeholder="Why do you want to do that?" aria-label="Why do you want to do that?"
                    rows="4"></textarea>
            </div>
            <!-- End Form -->

            <div class="d-grid mb-2">
                <button type="submit" class="btn btn-primary btn-lg">Claim email</button>
            </div>

            <div class="text-center">
                <span class="form-text">Claim your email address to edit or remove the information associated.</span>
            </div>
        </form>
        <!-- End Form -->
    </div>
    <!-- End Form -->
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
