@if (isset($attribute))
    <address-component
        :attribute='@json($attribute)'
        :validations="'{{$validations}}'"
        :data='@json(old($attribute->code) ?: $value)'
    ></address-component>
@endif

@push('scripts')

    <script type="text/x-template" id="address-component-template">
        <div :class="[errors.has(attribute['code'] + '[country]') || errors.has(attribute['code'] + '[state]') ? 'has-error' : '']">


            <div class="row">
                <div class="col-12">
                    <input
                        type="text"
                        :name="attribute['code'] + '[city]'"
                        class="control"
                        v-model="city"
                        placeholder="{{ __('admin::app.common.city') }}"
                        v-validate="validations"
                        data-vv-as="&quot;{{ __('admin::app.common.city') }}&quot;"
                    />
                </div>
            </div>

            <div class="row">

                <div class="col-12" v-if="haveStates()">
                    <span class="badge badge-primary" @click="toggleState" style="cursor:pointer">
                        <small>@{{ toggle_state ? 'Only in country' : 'Add state' }}</small>
                    </span>
                </div>

                <div :class="toggle_state ? 'col-6' : 'col-12'">
                    <select
                        :name="attribute['code'] + '[country]'"
                        class="control"
                        v-model="country"
                        v-validate="validations"
                        data-vv-as="&quot;{{ __('admin::app.common.country') }}&quot;"
                    >
                        <option value="">{{ __('admin::app.common.select-country') }}</option>

                        @foreach (core()->countries() as $country)

                            <option value="{{ $country->code }}">{{ $country->name }}</option>

                        @endforeach
                    </select>
                </div>

                <div class="col-6" v-if="toggle_state">
                    <select
                        :name="attribute['code'] + '[state]'"
                        class="control"
                        v-model="state"
                        v-validate="validations"
                        data-vv-as="&quot;{{ __('admin::app.common.state') }}&quot;"
                        v-if="haveStates()"
                    >

                        <option value="">{{ __('admin::app.common.select-state') }}</option>

                        <option v-for='(state, index) in countryStates[country]' :value="state.id">
                            @{{ state.name }}
                        </option>

                    </select>

                    <input
                        type="text"
                        :name="attribute['code'] + '[state]'"
                        class="control"
                        v-model="state"
                        placeholder="{{ __('admin::app.common.state') }}"
                        v-validate="validations"
                        data-vv-as="&quot;{{ __('admin::app.common.state') }}&quot;"
                        v-else
                    />
                </div>

            </div>

            <span class="control-error" v-if="errors.has(attribute['code']) || errors.has(attribute['code'] + '[country]') || errors.has(attribute['code'] + '[state]') || errors.has(attribute['code'])">
                {{ __('admin::app.common.address-validation') }}
            </span>
        </div>
    </script>

    <script>
        Vue.component('address-component', {
            template: '#address-component-template',
    
            props: ['validations', 'attribute', 'data'],
            inject: ['$validator'],
            data: function () {
                return {
                    country: this.data ? this.data['country'] : '',
                    toggle_state: false,
                    state: this.data ? this.data['state'] : '',
                    countryStates: @json(core()->groupedStatesByCountries()),
                    city: this.data ? this.data['city'] : ''
                }
            },
            methods: {
                toggleState() {
                    this.toggle_state = !this.toggle_state

                    if(this.toggle_state == false) {
                        this.state = false
                    }
                },
                haveStates: function () {
                    if (this.countryStates[this.country] && this.countryStates[this.country].length) {
                        return true;
                    }
                    return false;
                }
            }
        });
    </script>
@endpush
