@if ($value)

    <a href="{{ route('settings.attributes.download', ['path' => $value]) }}" target="_blank">
        <i class="icon download-icon"></i>
    </a>

@else

    {{ __('admin::app.common.not-available') }}

@endif