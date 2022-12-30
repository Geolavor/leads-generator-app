{!! view_render_event('organizations.view.header.tags.before', ['organization' => $organization]) !!}

<tags-component></tags-component>

{!! view_render_event('organizations.view.header.tags.after', ['organization' => $organization]) !!}


@push('scripts')
    <script type="text/x-template" id="tags-component-template">
        <div class="tags-container">
            <i class="icon tags-icon" @click="is_dropdown_open = ! is_dropdown_open"></i>

            <ul class="tag-list">
                <li v-for='(tag, index) in tags' :style="'background-color: ' + (tag.color ? tag.color : '#546E7A')">
                    @{{ tag.name }}
                    
                    <i class="icon close-white-icon" @click="removeTag(tag)"></i>
                </li>
            </ul>

            <div class="tag-dropdown" v-if="is_dropdown_open">
                <div class="lookup-searches" v-if="! show_form">
                    <ul>
                        <li class="control-list-item">
                            <div class="form-group">
                                <input
                                    type="text"
                                    class="control"
                                    v-model="term"
                                    placeholder="{{ __('admin::app.leads.search-tag') }}"
                                    autocomplete="off"
                                    v-on:keyup="search"
                                />

                                <i class="icon loader-active-icon" v-if="is_searching"></i>
                            </div>
                        </li>

                        <li v-for='(tag, index) in search_searches' @click="addTag(tag)">
                            <span>@{{ tag.name }}</span>
                        </li>

                        <li v-if="! search_searches.length && term.length && ! is_searching">
                            <span>{{ __('admin::app.common.no-found') }}</span>
                        </li>

                        <li class="action" @click="show_form = true">
                            <span>
                                + {{ __('admin::app.leads.add-tag') }}
                            </span> 
                        </li>
                    </ul>
                </div>

                <div class="form-container" v-else>
                    <form data-vv-scope="tag-form">
                        <div class="form-group" :class="[errors.has('tag-form.name') ? 'has-error' : '']">
                            <label class="required">{{ __('admin::app.leads.name') }}</label>

                            <input
                                type="text"
                                name="name"
                                class="control"
                                v-model="tag.name"
                                v-validate="'required'"
                                data-vv-as="&quot;{{ __('admin::app.leads.name') }}&quot;"
                            />

                            <span class="control-error" v-if="errors.has('tag-form.name')">
                                @{{ errors.first('tag-form.name') }}
                            </span>
                        </div>

                        <div class="form-group">
                            <label>{{ __('admin::app.leads.color') }}</label>
                            
                            <div class="color-list">
                                <span
                                    v-for='color in colors'
                                    :style="'background:' + color"
                                    :class="{active: tag.color == color}"
                                    @click="tag.color = color"
                                >
                                </span>
                            </div>
                        </div>

                        <div class="form-group button-group">
                            <button type="button" class="btn btn-sm btn-secondary-outline" @click="show_form = false">
                                {{ __('admin::app.leads.cancel') }}
                            </button>

                            <button type="button" class="btn btn-sm btn-primary" @click="createTag">
                                {{ __('admin::app.leads.save') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </script>

    <script>
        Vue.component('tags-component', {

            template: '#tags-component-template',
    
            inject: ['$validator'],

            data: function() {
                return {
                    is_dropdown_open: false,

                    term: '',

                    is_searching: false,

                    tags: @json($organization->tags),

                    search_searches: [],

                    tag: {
                        name: '',

                        color: '',

                        organization_id: "{{ $organization->id }}",
                    },

                    colors: [
                        '#337CFF',
                        '#FEBF00',
                        '#E5549F',
                        '#27B6BB',
                        '#FB8A3F',
                        '#43AF52',
                    ],

                    show_form: false,
                }
            },

            methods: {
                search: debounce(function () {
                    this.is_searching = true;

                    if (this.term.length < 2) {
                        this.search_searches = [];

                        this.is_searching = false;

                        return;
                    }

                    var self = this;
                    
                    this.$http.get("{{ route('settings.tags.search') }}", {params: {query: this.term}})
                        .then (function(response) {
                            self.tags.forEach(function(addedTag) {
                                
                                response.data.forEach(function(tag, index) {
                                    if (tag.id == addedTag.id) {
                                        response.data.splice(index, 1);
                                    }
                                });

                            });

                            self.search_searches = response.data;

                            self.is_searching = false;
                        })
                        .catch (function (error) {
                            self.is_searching = false;
                        })
                }, 500),

                createTag: function() {
                    var self = this;

                    this.$validator.validateAll('tag-form').then(function (search) {
                        if (search) {
                            self.$http.post(`{{ route('settings.tags.store') }}`, self.tag)
                                .then(response => {
                                    self.addTag(response.data.tag);
                                })
                                .catch(error => {
                                    window.flashMessages = [{'type': 'error', 'message': error.response.data.errors['name'][0]}];

                                    self.$root.addFlashMessages()
                                });
                        }
                    });
                },

                addTag: function(tag) {
                    var self = this;

                    self.$http.post(`{{ route('organizations.tags.store', $organization->id) }}`, tag)
                        .then(response => {
                            self.is_dropdown_open = self.show_form = false;

                            self.search_searches = [];

                            self.term = '';

                            self.tags.push(tag);

                            window.flashMessages = [{'type': 'success', 'message': response.data.message}];

                            self.$root.addFlashMessages();
                        })
                        .catch(error => {
                            window.flashMessages = [{'type': 'error', 'message': error.response.data.message}];

                            self.$root.addFlashMessages()
                        });
                },

                removeTag: function(tag) {
                    var self = this;

                    this.$http.delete("{{ route('search.tags.delete', $organization->id) }}/" + tag['id'])
                        .then (function(response) {
                            const index = self.tags.indexOf(tag);

                            Vue.delete(self.tags, index);
                            
                            window.flashMessages = [{'type': 'success', 'message': response.data.message}];

                            self.$root.addFlashMessages();
                        })
                        .catch (function (error) {
                            window.flashMessages = [{'type': 'error', 'message': error.response.data.message}];

                            self.$root.addFlashMessages()
                        })
                }
            }
        });
    </script>
@endpush