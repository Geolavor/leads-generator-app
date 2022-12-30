@if (isset($attribute))
    <types-component
        :attribute='@json($attribute)'
        :validations="'{{$validations}}'"
        :data='@json(old($attribute->code) ?: $value)'
    ></types-component>
@endif

@push('scripts')

    <script type="text/x-template" id="types-component-template">
        <div :class="[errors.has(attribute['code'])]">

            <div class="row">

                <div class="col-12">
                    <select
                        :name="attribute['code']"
                        class="control"
                        v-model="type"
                        v-validate="validations"
                        data-vv-as="&quot;{{ __('admin::app.common.type') }}&quot;"
                    >
                        <option value="">{{ __('admin::app.common.select-type') }}</option>

                        @foreach (core()->types() as $type)

                            <option value="{{ $type->id }}">{{ $type->name }}</option>

                        @endforeach
                    </select>
                </div>

            </div>

            <span class="control-error" v-if="errors.has(attribute['code'])">
                {{ __('admin::app.common.types-validation') }}
            </span>
        </div>
    </script>

    <script>
        Vue.component('types-component', {
            template: '#types-component-template',
    
            props: ['validations', 'attribute', 'data'],
            inject: ['$validator'],
            data: function () {
                return {
                    type: this.data ? this.data['type'] : '',
                }
            }
        });
    </script>
@endpush
