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

                <div class="col-4">
                    <input
                        type="text"
                        :name="attribute['code'] + '[country]'"
                        class="control dropdown-toggle"
                        v-model="country_search"
                        placeholder="{{ __('admin::app.common.country') }}"
                        v-validate="validations"
                        data-vv-as="&quot;{{ __('admin::app.common.country') }}&quot;"
                    />
                    <div v-if="country_search" class="dropdown-list list dropdown-menu navbar-dropdown-menu-borderless w-100 overflow-auto" style="max-height: 16rem; display: block; opacity: 1.03;">
                        <div v-for="(country, index) in searchCountry()" :key="index" class="dropdown-item">
                            <a class="d-block link" href="#" @click="selectCountry(country)">
                                <span class="component text-dark">@{{ country.name }}</span>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-4" v-if="haveStates() && step >= 2">
                    <select
                        :name="attribute['code'] + '[state]'"
                        class="control"
                        v-model="state"
                        v-validate="validations"
                        data-vv-as="&quot;{{ __('admin::app.common.state') }}&quot;"
                    >
                        <option value="">{{ __('admin::app.common.select-state') }}</option>

                        <option v-for='(state, index) in countryStates[country.code]' :value="state.id">
                            @{{ state.name }}
                        </option>

                    </select>
                </div>

                <div class="col-3" v-if="haveCities() && step == 3">
                    <select
                        :name="attribute['code'] + '[city]'"
                        class="control"
                        v-model="city"
                        v-validate="validations"
                        data-vv-as="&quot;{{ __('admin::app.common.city') }}&quot;"
                    >
                        <option value="">{{ __('admin::app.common.select-city') }}</option>

                        <option v-for='(city, index) in stateCities[state]' :value="city.id">
                            @{{ city.name }}
                        </option>

                    </select>
                </div>

                <div class="col-1" v-if="haveStates()" style="display:flex;align-self: center;">
                    <div v-if="step > 1" @click="toggleState(false)" style="cursor:pointer;margin-top: 10px;">
                        <i class="icon arrow-left-icon"></i>
                    </div>
                    <div v-if="step < 3" @click="toggleState(true)" style="margin-left:10px;cursor:pointer;margin-top: 10px;">
                        <i class="icon arrow-right-icon"></i>
                    </div>
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
                    step: 1,
                    open_country_dropdown: true,
                    country: this.data ? this.data['country'] : '',
                    country_search: '',
                    countries: @json(core()->countries()),
                    state: this.data ? this.data['state'] : '',
                    countryStates: @json(core()->groupedStatesByCountries()),
                    city: this.data ? this.data['city'] : '',
                    stateCities: @json(core()->groupedCitiesByState()),
                }
            },
            methods: {
                toggleState(value) {
                    value ? this.step++ : this.step--

                    if (!value && this.step == 1) {
                        this.state = null
                    }

                    if (!value && this.step == 2) {
                        this.city = null
                    }
                },
                haveStates: function () {
                    if (this.countryStates[this.country.code] && this.countryStates[this.country.code].length) {
                        return true;
                    }
                    return false;
                },
                haveCities: function () {
                    if (this.stateCities[this.state] && this.stateCities[this.state].length) {
                        return true;
                    }
                    return false;
                },
                toggleCountryDropdown() {
                    this.open_country_dropdown = !this.open_country_dropdown
                },
                selectCountry: function(country) {
                    this.country_search = country.name;
                    this.country = country;
                    this.toggleCountryDropdown();
                },
                searchCountry() {
                    return this.countries.filter(item => {
                        return item.name.toLowerCase().indexOf(this.country_search.toLowerCase()) > -1
                    })
                }
            }
        });
    </script>
@endpush
