<div>

    @if($attribute->lookup_type)
        @php
            $options = $attribute->lookup_type
                ? app('LeadBrowser\Attribute\Repositories\AttributeRepository')->getLookUpOptions($attribute->lookup_type)
                : $attribute->options()->orderBy('sort_order')->get();

            $selectedOption = old($attribute->code) ?: $value;
        @endphp

        <option value=""></option>

        @foreach ($options as $option)
            <span class="checkbox">
                <input
                    type="checkbox"
                    name="{{ $attribute->code }}[]"
                    value="{{ $option->id }}"
                    {{ in_array($option->id, explode(',', $selectedOption)) ? 'checked' : ''}}
                />

                <label class="checkbox-view"></label>
                {{ $option->name }}
            </span>
        @endforeach
    @else

        <label class="switch">
            <input
                type="checkbox"
                name="{{ $attribute->code }}"
                class="control"
                id="is_default"
                {{ old('is_default') ? 'checked' : '' }}
            />
            <span class="slider round"></span>
        </label>

    @endif

</div>