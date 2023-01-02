@component('admin::emails.layouts.master')
    @slot('header')
        <div style="text-align: center;">
            <a href="{{ config('app.url') }}">
                <img src="{{ asset('vendor/leadBrowser/admin/assets/images/mini-black.png') }}" alt="{{ config('app.name') }}"/>
            </a>
        </div>
    @endslot

    <div style="padding: 30px;background: white;margin-top: 20px;border-radius: 5px;">
        <div style="font-size: 20px;color: #242424;line-height: 30px;margin-bottom: 34px;">
            <p style="font-size: 16px;color: #5E5E5E;line-height: 24px;">
                {{ __('admin::app.mail.search.dear', ['name' => $user_name]) }}
            </p>

            <p style="font-size: 16px;color: #5E5E5E;line-height: 24px;">
                {{ __('admin::app.mail.search.location-finish') }}
            </p>
        </div>
    </div>
@endcomponent