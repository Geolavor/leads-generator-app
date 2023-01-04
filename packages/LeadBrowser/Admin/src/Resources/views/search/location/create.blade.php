@extends('admin::layouts.master')

@section('page_title')
    {{ __('admin::app.search.create-title') }}
@stop

@section('content-wrapper')
    <div class="content full-page adjacent-center">
        
        {!! view_render_event('search.location.create.header.before') !!}

        <div class="page-header">

            {{ Breadcrumbs::render('search.location.create') }}

            <div class="page-title">
                <h1>{{ __('admin::app.search.create-title') }}</h1>
            </div>
        </div>

        {!! view_render_event('search.location.create.header.after') !!}

        <form id="form" method="POST" action="{{ route('search.location.store') }}" @submit.prevent="onSubmit" enctype="multipart/form-data">

            <div class="page-content">
                <div class="form-container">

                    <div class="panel">

                        <div class="panel-body">

                            <div class="row">
                                <div class="col-6 col-sm-12 col-md-6 col-lg-6">
                                    @csrf()

                                    @include('admin::common.custom-attributes.edit', [
                                        'customAttributes' => app('LeadBrowser\Attribute\Repositories\AttributeRepository')->findWhere([
                                            'entity_type' => 'search_locations',
                                        ]),
                                    ])

                                    <workflow-component></workflow-component>

                                    <div class="collapse navbar-collapse" id="collapseExample">
                                        <div class="card card-body">
                                            Some placeholder content for the collapse component. This panel is hidden by default but revealed when the user activates the relevant trigger.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-12 col-md-6 col-lg-6">
                                    <div class="row text-center">
                                        <div class="col-12">
                                            <calculator-component></calculator-component>
                                        </div>
                                        <div class="col-12 pt-3">
                                            <small>
                                                <a href="{{ route('search.location.index') }}">Show search history</a>
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>


                </div>

            </div>

        </form>

    </div>
@stop

@push('scripts')
    @parent

    <script type="text/x-template" id="calculator-template">
        <div>
            <div class="card card-lg zi-2" data-aos="fade-up">
                <div class="card-body">
                    <form>
                        <!-- Radio Button Group -->
                        <div class="text-center mb-5">
                        
                        </div>
                        <!-- End Radio Button Group -->

                        <!-- Range Slider -->
                        <div class="display-4 text-dark text-center">
                            Cost: @{{ value }} search coins
                        </div>
                        <div class="d-flex justify-content-center mb-5">
                            Approximate time to acquire all data:
                            <span class="text-primary ms-1">10 minutes</span>
                        </div>
                        <!-- End Range Slider -->
                    </form>
                <!-- End Row -->
                </div>

                <div class="card-footer">
                    <button class="btn btn-primary w-100" type="submit">
                        <i class="bi bi-search"></i> Start live search
                    </button>
                </div>
            </div>
        </div>
    </script>

    <script type="text/x-template" id="workflow-component-template">

        <div class="workflow-panel">

            <button type="button" class="btn btn-success" @click="addCondition">
                <i class="bi bi-plus"></i> {{ __('admin::app.settings.workflows.add-condition') }}
            </button>

            <div class="table table-container workflow-conditions" style="overflow-x: unset;">
                <table>
                    <tbody>

                        <workflow-condition-item
                            v-for='(condition, index) in conditions'
                            :entityType="entityType"
                            :condition="condition"
                            :key="index"
                            :index="index"
                            @onRemoveCondition="removeCondition($event)">
                        </workflow-condition-item>

                    </tbody>
                </table>
            </div>

        </div>

    </script>

    <script type="text/x-template" id="workflow-condition-item-template">
        <tr>

            <td class="attribute">
                <div class="form-group">
                    <select :name="['conditions[' + index + '][attribute]']" class="control" v-model="condition.attribute">
                        <option value="">{{ __('admin::app.settings.workflows.choose-condition-to-add') }}</option>

                        <option v-for='attribute in conditions[entityType]' :value="attribute.id">
                            @{{ attribute.name }}
                        </option>
                    </select>

                </div>
            </td>

            <td class="operator">
                <div class="form-group" v-if="matchedAttribute">
                    <select :name="['conditions[' + index + '][operator]']" class="control" v-model="condition.operator">
                        <option v-for='operator in condition_operators[matchedAttribute.type]' :value="operator.operator">
                            @{{ operator.name }}
                        </option>
                    </select>
                </div>
            </td>

            <td class="value">
                <div v-if="matchedAttribute">
                    <input type="hidden" :name="['conditions[' + index + '][attribute_type]']" v-model="matchedAttribute.type">

                    <div class="form-group" v-if="matchedAttribute.type == 'text' || matchedAttribute.type == 'price' || matchedAttribute.type == 'decimal' || matchedAttribute.type == 'integer' || matchedAttribute.type == 'email' || matchedAttribute.type == 'phone'">
                        <input class="control" :name="['conditions[' + index + '][value]']" v-model="condition.value"/>
                    </div>

                    <div class="form-group date" v-if="matchedAttribute.type == 'date'">
                        <date>
                            <input class="control" :name="['conditions[' + index + '][value]']" v-model="condition.value"/>
                        </date>
                    </div>

                    <div class="form-group date" v-if="matchedAttribute.type == 'datetime'">
                        <datetime>
                            <input class="control" :name="['conditions[' + index + '][value]']" v-model="condition.value"/>
                        </datetime>
                    </div>

                    <div class="form-group" v-if="matchedAttribute.type == 'boolean'">
                        <select :name="['conditions[' + index + '][value]']" class="control" v-model="condition.value">
                            <option value="1">{{ __('admin::app.settings.workflows.yes') }}</option>
                            <option value="0">{{ __('admin::app.settings.workflows.no') }}</option>
                        </select>
                    </div>

                    <div class="form-group" v-if="matchedAttribute.type == 'select' || matchedAttribute.type == 'radio' || matchedAttribute.type == 'lookup'">
                        <select :name="['conditions[' + index + '][value]']" class="control" v-model="condition.value">
                            <option v-for='option in matchedAttribute.options' :value="option.id">
                                @{{ option.name }}
                            </option>
                        </select>
                    </div>

                    <div class="form-group" v-if="matchedAttribute.type == 'multiselect'">
                        <select :name="['conditions[' + index + '][value][]']" class="control" v-model="condition.value" multiple>
                            <option v-for='option in matchedAttribute.options' :value="option.id">
                                @{{ option.name }}
                            </option>
                        </select>
                    </div>
                    
                </div>
            </td>

            <td class="actions" style="width: 15% !important;">
                <i class="icon trash-icon" @click="removeCondition" style="float: right;"></i>
            </td>
        </tr>
    </script>

    <script>
        Vue.component('calculator-component', {
            template: '#calculator-template',
            inject: ['$validator'],
            data: function() {
                return {
                    value: 0,
                }
            },
            mounted: function() {
                console.log(123);
                // var this_this = this;
                // $(document).ready(function(){
                    // var target = document.getElementById('expected_items');
                    // this_this.value = target.value
                //     console.log(target.value)
                // });
            },
            computed: {
                getInputValue() {
                    var target = document.getElementById('expected_items');
                    return target.value
                }
            }
        })

        Vue.component('workflow-component', {
            template: '#workflow-component-template',
            inject: ['$validator'],
            data: function() {
                return {
                    event: '',
                    condition_type: 'and',
                    conditions: []
                }
            },
            computed: {
                entityType: function () {
                    // if (this.event == '') {
                    //     return '';
                    // }

                    // var entityType = '';

                    // var self = this;

                    // for (let id in this.events) {
                    //     this.events[id].events.forEach(function (eventTemp) {
                    //         if (eventTemp.event == self.event) {
                    //             entityType = id;
                    //         }
                    //     });
                    // }

                    entityType = 'search';

                    return entityType;
                }
            },

            watch: {
                entityType: function(newValue, oldValue) {
                    this.conditions = [];
                }
            },

            methods: {
                addCondition: function() {
                    this.conditions.push({
                        'attribute': '',
                        'operator': '==',
                        'value': '',
                    });
                },

                removeCondition: function(condition) {
                    let index = this.conditions.indexOf(condition)

                    this.conditions.splice(index, 1)
                },

                onSubmit: function(e) {
                    this.$root.onSubmit(e)
                },
            }
        });

        Vue.component('workflow-condition-item', {

            template: '#workflow-condition-item-template',

            props: ['index', 'entityType', 'condition'],

            data: function() {
                return {
                    conditions: @json(app('\LeadBrowser\Workflow\Helpers\Entity')->getConditions()),

                    condition_operators: {
                        'price': [{
                                'operator': '==',
                                'name': '{{ __('admin::app.settings.workflows.is-equal-to') }}'
                            }, {
                                'operator': '!=',
                                'name': '{{ __('admin::app.settings.workflows.is-not-equal-to') }}'
                            }, {
                                'operator': '>=',
                                'name': '{{ __('admin::app.settings.workflows.equals-or-greater-than') }}'
                            }, {
                                'operator': '<=',
                                'name': '{{ __('admin::app.settings.workflows.equals-or-less-than') }}'
                            }, {
                                'operator': '>',
                                'name': '{{ __('admin::app.settings.workflows.greater-than') }}'
                            }, {
                                'operator': '<',
                                'name': '{{ __('admin::app.settings.workflows.less-than') }}'
                            }],
                        'decimal': [{
                                'operator': '==',
                                'name': '{{ __('admin::app.settings.workflows.is-equal-to') }}'
                            }, {
                                'operator': '!=',
                                'name': '{{ __('admin::app.settings.workflows.is-not-equal-to') }}'
                            }, {
                                'operator': '>=',
                                'name': '{{ __('admin::app.settings.workflows.equals-or-greater-than') }}'
                            }, {
                                'operator': '<=',
                                'name': '{{ __('admin::app.settings.workflows.equals-or-less-than') }}'
                            }, {
                                'operator': '>',
                                'name': '{{ __('admin::app.settings.workflows.greater-than') }}'
                            }, {
                                'operator': '<',
                                'name': '{{ __('admin::app.settings.workflows.less-than') }}'
                            }],
                        'number': [{
                                'operator': '==',
                                'name': '{{ __('admin::app.settings.workflows.is-equal-to') }}'
                            }, {
                                'operator': '!=',
                                'name': '{{ __('admin::app.settings.workflows.is-not-equal-to') }}'
                            }, {
                                'operator': '>=',
                                'name': '{{ __('admin::app.settings.workflows.equals-or-greater-than') }}'
                            }, {
                                'operator': '<=',
                                'name': '{{ __('admin::app.settings.workflows.equals-or-less-than') }}'
                            }, {
                                'operator': '>',
                                'name': '{{ __('admin::app.settings.workflows.greater-than') }}'
                            }, {
                                'operator': '<',
                                'name': '{{ __('admin::app.settings.workflows.less-than') }}'
                            }],
                            'integer': [{
                                'operator': '==',
                                'name': '{{ __('admin::app.settings.workflows.is-equal-to') }}'
                            }, {
                                'operator': '!=',
                                'name': '{{ __('admin::app.settings.workflows.is-not-equal-to') }}'
                            }, {
                                'operator': '>=',
                                'name': '{{ __('admin::app.settings.workflows.equals-or-greater-than') }}'
                            }, {
                                'operator': '<=',
                                'name': '{{ __('admin::app.settings.workflows.equals-or-less-than') }}'
                            }, {
                                'operator': '>',
                                'name': '{{ __('admin::app.settings.workflows.greater-than') }}'
                            }, {
                                'operator': '<',
                                'name': '{{ __('admin::app.settings.workflows.less-than') }}'
                            }],
                        'text': [{
                                'operator': '==',
                                'name': '{{ __('admin::app.settings.workflows.is-equal-to') }}'
                            }, {
                                'operator': '!=',
                                'name': '{{ __('admin::app.settings.workflows.is-not-equal-to') }}'
                            }, {
                                'operator': '{}',
                                'name': '{{ __('admin::app.settings.workflows.contain') }}'
                            }, {
                                'operator': '!{}',
                                'name': '{{ __('admin::app.settings.workflows.does-not-contain') }}'
                            }],
                        'boolean': [{
                                'operator': '==',
                                'name': '{{ __('admin::app.settings.workflows.is-equal-to') }}'
                            }, {
                                'operator': '!=',
                                'name': '{{ __('admin::app.settings.workflows.is-not-equal-to') }}'
                            }],
                        'date': [{
                                'operator': '==',
                                'name': '{{ __('admin::app.settings.workflows.is-equal-to') }}'
                            }, {
                                'operator': '!=',
                                'name': '{{ __('admin::app.settings.workflows.is-not-equal-to') }}'
                            }, {
                                'operator': '>=',
                                'name': '{{ __('admin::app.settings.workflows.equals-or-greater-than') }}'
                            }, {
                                'operator': '<=',
                                'name': '{{ __('admin::app.settings.workflows.equals-or-less-than') }}'
                            }, {
                                'operator': '>',
                                'name': '{{ __('admin::app.settings.workflows.greater-than') }}'
                            }, {
                                'operator': '<',
                                'name': '{{ __('admin::app.settings.workflows.less-than') }}'
                            }],
                        'datetime': [{
                                'operator': '==',
                                'name': '{{ __('admin::app.settings.workflows.is-equal-to') }}'
                            }, {
                                'operator': '!=',
                                'name': '{{ __('admin::app.settings.workflows.is-not-equal-to') }}'
                            }, {
                                'operator': '>=',
                                'name': '{{ __('admin::app.settings.workflows.equals-or-greater-than') }}'
                            }, {
                                'operator': '<=',
                                'name': '{{ __('admin::app.settings.workflows.equals-or-less-than') }}'
                            }, {
                                'operator': '>',
                                'name': '{{ __('admin::app.settings.workflows.greater-than') }}'
                            }, {
                                'operator': '<',
                                'name': '{{ __('admin::app.settings.workflows.less-than') }}'
                            }],
                        'select': [{
                                'operator': '==',
                                'name': '{{ __('admin::app.settings.workflows.is-equal-to') }}'
                            }, {
                                'operator': '!=',
                                'name': '{{ __('admin::app.settings.workflows.is-not-equal-to') }}'
                            }],
                        'radio': [{
                                'operator': '==',
                                'name': '{{ __('admin::app.settings.workflows.is-equal-to') }}'
                            }, {
                                'operator': '!=',
                                'name': '{{ __('admin::app.settings.workflows.is-not-equal-to') }}'
                            }],
                        'multiselect': [{
                                'operator': '{}',
                                'name': '{{ __('admin::app.settings.workflows.contains') }}'
                            }, {
                                'operator': '!{}',
                                'name': '{{ __('admin::app.settings.workflows.does-not-contain') }}'
                            }],
                        'checkbox': [
                            {
                                'operator': '==',
                                'name': '{{ __('admin::app.settings.workflows.contains') }}'
                            }, {
                                'operator': '!==',
                                'name': '{{ __('admin::app.settings.workflows.does-not-contain') }}'
                            }],
                        'email': [{
                                'operator': '{}',
                                'name': '{{ __('admin::app.settings.workflows.contains') }}'
                            }, {
                                'operator': '!{}',
                                'name': '{{ __('admin::app.settings.workflows.does-not-contain') }}'
                            }],
                        'phone': [{
                                'operator': '{}',
                                'name': '{{ __('admin::app.settings.workflows.contains') }}'
                            }, {
                                'operator': '!{}',
                                'name': '{{ __('admin::app.settings.workflows.does-not-contain') }}'
                            }],
                        'lookup': [{
                                'operator': '==',
                                'name': '{{ __('admin::app.settings.workflows.is-equal-to') }}'
                            }, {
                                'operator': '!=',
                                'name': '{{ __('admin::app.settings.workflows.is-not-equal-to') }}'
                            }],
                    }
                }
            },

            computed: {
                matchedAttribute: function () {
                    if (this.condition.attribute == '') {
                        return;
                    }

                    var self = this;

                    matchedAttribute = this.conditions[this.entityType].filter(function (attribute) {
                        return attribute.id == self.condition.attribute;
                    });

                    if (matchedAttribute[0]['type'] == 'multiselect' || matchedAttribute[0]['type'] == 'checkbox') {
                        this.condition.operator = '{}';

                        this.condition.value = [];
                    } else if (matchedAttribute[0]['type'] == 'email' || matchedAttribute[0]['type'] == 'phone') {
                        this.condition.operator = '{}';
                    }

                    return matchedAttribute[0];
                }
            },

            methods: {
                removeCondition: function() {
                    this.$emit('onRemoveCondition', this.condition)
                },
            }
        });
    </script>

@endpush