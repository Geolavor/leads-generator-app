@component('admin::emails.layouts.master')
    @slot('header')
        <div>
            <a href="{{ config('app.url') }}">
                <img src="{{ asset('vendor/leadBrowser/admin/assets/images/logotyp.svg') }}" alt="{{ config('app.name') }}"/>
            </a>
        </div>
    @endslot

    <div style="padding: 30px;background: white;margin-top: 20px;border-radius: 5px;">
        <div style="font-size: 20px;color: #242424;line-height: 30px;margin-bottom: 34px;">
            <p style="font-size: 16px;color: #5E5E5E;line-height: 24px;">
                You have received a message from the email address: <b>{{ $email }}</b>
            </p>
            <p style="font-size: 16px;color: #5E5E5E;line-height: 24px;">
                Content: {{ $content }}
            </p>
        </div>
    </div>
@endcomponent