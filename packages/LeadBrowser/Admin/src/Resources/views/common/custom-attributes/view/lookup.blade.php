@php
    $lookUpEntity = app('LeadBrowser\Attribute\Repositories\AttributeRepository')->getLookUpEntity($attribute->lookup_type, $value);
@endphp

{{ $lookUpEntity ? ($lookUpEntity->name ?? $lookUpEntity->title) : __('admin::app.common.not-available') }}