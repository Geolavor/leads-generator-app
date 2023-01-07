@php
    $formScope = $formScope ?? '';
@endphp

<div class="row">

@foreach ($customAttributes as $attribute)

    @php
        if (isset($customValidations[$attribute->code])) {
            $validations = implode('|', $customValidations[$attribute->code]);
        } else {
            $validations = [];

            if ($attribute->code != 'sku') {
                if ($attribute->is_required) {
                    array_push($validations, 'required');
                }

                if ($attribute->type == 'price') {
                    array_push($validations, 'decimal');
                }

                array_push($validations, $attribute->validation);

                $validations = implode('|', array_filter($validations));
            } else {
                $validations = "{ ";

                if ($attribute->is_required) {
                    $validations .= "required: true, ";
                }

                $validations .= "regex: /^[a-zA-Z0-9]+(?:-[a-zA-Z0-9]+)*$/ }";
            }
        }
    @endphp

    @if (view()->exists($typeView = 'admin::common.custom-attributes.edit.' . $attribute->type))

        @if ($attribute->is_visible != 2)

            <div
                class="form-group {{ $attribute->type }} {{ $attribute->class }}"
                @if ($attribute->type == 'multiselect') :class="[errors.has('{{ $formScope . $attribute->code }}[]') ? 'has-error' : '']"
                @else :class="[errors.has('{{ $formScope . $attribute->code }}') ? 'has-error' : '']" @endif
            >

                <label for="{{ $attribute->code }}" {{ $attribute->is_required ? 'class=required' : '' }}>
                    {{ $attribute->name }}

                    @if ($attribute->info)
                        <a v-tooltip="'{{ $attribute->info }}'">
                            <i class="bi bi-info-circle"></i>
                        </a>
                    @endif

                    @if ($attribute->type == 'price')
                        <span class="currency-code">({{ core()->currencySymbol(config('app.currency')) }})</span>
                    @endif

                </label>

                @include ($typeView, ['value' => isset($entity) ? $entity[$attribute->code] : null])

                <span
                    class="control-error"
                    @if ($attribute->type == 'multiselect') v-if="errors.has('{{ $formScope . $attribute->code }}[]')"
                    @else  v-if="errors.has('{{ $formScope . $attribute->code }}')"  @endif
                >
                    
                    @if ($attribute->type == 'multiselect')
                        @{{ errors.first('{!! $formScope . $attribute->code !!}[]') }}
                    @else
                        @{{ errors.first('{!! $formScope . $attribute->code !!}') }}
                    @endif
                </span>
            </div>

            <modal id="modelId" :is-open="modalIds.modelId">
                <h3 slot="header-title">Modal Title</h3>
                
                <div slot="header-actions">
                    <button class="btn btn-sm btn-secondary-outline" @click="closeModal('modelId')">Cancel</button>

                    <button class="btn btn-sm btn-primary">Save</button>
                </div>

                <div slot="body">
                    Modal Content
                </div>
            </modal>

        @endif
    @endif

@endforeach

</div>