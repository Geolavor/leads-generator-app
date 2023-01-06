@component('admin::emails.layouts.dashboard')
@slot('header')
<div style="text-align: center;">
    <a href="{{ config('app.url') }}">
        <img src="{{ asset('vendor/leadBrowser/admin/assets/images/mini-black.png') }}" alt="{{ config('app.name') }}" />
    </a>
</div>
@endslot

<div style="padding: 30px;background: white;margin-top: 20px;border-radius: 5px;">
    <div style="font-size: 20px;color: #242424;line-height: 30px;margin-bottom: 34px;">
        <p style="font-size: 16px;color: #5E5E5E;line-height: 24px;">
            Hi,
        </p>

        <p style="font-size: 16px;color: #5E5E5E;line-height: 24px;">
            Someone tried to hijack your email address {{ $email }}.

            If you were going to report your profile, please click the link below to continue. If you did not request this change, you can safely ignore this email.
        </p>
        <div style="text-align:center">
            <a href="{{ $url }}"
                style="text-decoration: none;color: #fff; background-color: #377dff; border-color: #377dff;display: inline-block; font-weight: 400; line-height: 1.5;text-align: center; vertical-align: middle; cursor: pointer; -webkit-user-select: none; -moz-user-select: none; -ms-user-select: none; user-select: none;border: 0.0625rem solid transparent; padding: 0.6125rem 1rem; font-size: 1rem; border-radius: 0.3125rem; transition: all 0.2s ease-in-out;"
                target="_blank">
                Claim this email address</a>
        </div>
        <br>
        <p style="font-size: 16px;color: #5E5E5E;line-height: 24px;">
            Thank you, The LeadBrowser team
        </p>
    </div>
</div>
@endcomponent
