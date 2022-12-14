@if (is_array($value))

    @foreach ($value as $item)
        <span class="multi-value">
            {{ $item }}

            <span>{{ ' (' . $item . ')'}}</span>
        </span>
    @endforeach

@else

    {{ __('admin::app.common.not-available') }}
    
@endif