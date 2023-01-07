@foreach ($value as $item)
    <span class="multi-value">
        <a href="{{ $item['url'] }}" target="_blank">
            <img class="avatar avatar-xss ms-1"
                src="{{ asset('vendor/leadBrowser/admin/assets/images/' . $item['type'] . '.svg') }}"
                alt="Top rating" data-toggle="tooltip" data-placement="top"
                title="Top profile"
            >
            {{ $item['url'] }}
        </a>
    </span>
@endforeach