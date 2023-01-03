@push('scripts')
    <script type="text/x-template" id="contact-component-template">
        <div class="contact-controls">
            
            <div class="form-group" :class="[errors.has('{!! $formScope ?? '' !!}employee[name]') ? 'has-error' : '']">
                <label for="employee[name]" class="required">{{ __('admin::app.leads.name') }}</label>

                <input
                    type="text"
                    name="employee[name]"
                    class="control"
                    id="employee[name]"
                    v-model="employee.name"
                    autocomplete="off"
                    placeholder="{{ __('admin::app.common.start-typing') }}"
                    v-validate="'required'"
                    data-vv-as="&quot;{{ __('admin::app.leads.name') }}&quot;"
                    v-on:keyup="search"
                />

                <input
                    type="hidden"
                    name="employee[id]"
                    v-model="employee.id"
                    v-validate="'required'"
                    data-vv-as="&quot;{{ __('admin::app.leads.name') }}&quot;"
                    v-if="employee.id"
                />

                <div class="lookup-results" v-if="state == ''">
                    <ul>
                        <li v-for='(employee, index) in employees' @click="addEmployee(employee)">
                            <span>@{{ employee.name }}</span>
                        </li>

                        <li v-if="! employees.length && employee['name'].length && ! is_searching">
                            <span>{{ __('admin::app.common.no-result-found') }}</span>
                        </li>

                        <li class="action" v-if="employee['name'].length && ! is_searching" @click="addAsNew()">
                            <span>
                                + {{ __('admin::app.common.add-as') }}
                            </span> 
                        </li>
                    </ul>
                </div>

                <span class="control-error" v-if="errors.has('{!! $formScope ?? '' !!}employee[name]')">
                    @{{ errors.first('{!! $formScope ?? '' !!}employee[name]') }}
                </span>
            </div>

            <div class="form-group email">
                <label for="employee[emails]" class="required">{{ __('admin::app.leads.email') }}</label>

                @include('admin::common.custom-attributes.edit.email', ['formScope' => $formScope ?? ''])
                    
                <email-component
                    :attribute="{'code': 'employee[emails]', 'name': 'Email'}"
                    :data="employee.emails"
                    validations="required|email"
                ></email-component>
            </div>

            <div class="form-group contact-numbers">
                <label for="employee[contact_numbers]">{{ __('admin::app.leads.contact-numbers') }}</label>

                @include('admin::common.custom-attributes.edit.phone', ['formScope' => $formScope ?? ''])
                    
                <phone-component
                    :attribute="{'code': 'employee[contact_numbers]', 'name': 'Contact Numbers'}"
                    :data="employee.contact_numbers"
                ></phone-component>
            </div>

            <div class="form-group organization">
                <label for="address">{{ __('admin::app.leads.organization') }}</label>

                @php
                    $organizationAttribute = app('LeadBrowser\Attribute\Repositories\AttributeRepository')->findOneWhere([
                        'entity_type' => 'employees',
                        'code'        => 'organization_id'
                    ]);

                    $organizationAttribute->code = 'employee[' . $organizationAttribute->code . ']';
                @endphp

                @include('admin::common.custom-attributes.edit.lookup')

                <lookup-component
                    :attribute='@json($organizationAttribute)'
                    :data="employee.organization"
                ></lookup-component>
            </div>
        </div>
    </script>

    <script>
        Vue.component('contact-component', {

            template: '#contact-component-template',
    
            props: ['data'],

            inject: ['$validator'],

            data: function () {
                return {
                    is_searching: false,

                    state: this.data ? 'old': '',

                    employee: this.data ? this.data : {
                        'name': ''
                    },

                    employees: [],
                }
            },

            methods: {
                search: debounce(function () {
                    this.state = '';

                    this.employee = {
                        'name': this.employee['name']
                    };

                    this.is_searching = true;

                    if (this.employee['name'].length < 2) {
                        this.employees = [];

                        this.is_searching = false;

                        return;
                    }

                    var self = this;
                    
                    this.$http.get("{{ route('employees.search') }}", {params: {query: this.employee['name']}})
                        .then (function(response) {
                            self.employees = response.data;

                            self.is_searching = false;
                        })
                        .catch (function (error) {
                            self.is_searching = false;
                        })
                }, 500),

                addEmployee: function(result) {
                    this.state = 'old';

                    this.employee = result;
                },

                addAsNew: function() {
                    this.state = 'new';
                }
            }
        });
    </script>
@endpush