@extends('admin::layouts.master')

@section('page_title')
    {{ $search->title }}
@stop

@section('css')
    <style>
        .modal-container .modal-header {
            border: 0;
        }

        .modal-container .modal-body {
            padding: 0;
        }

        .content-container .content .page-header {
            margin-bottom: 30px;
        }
    </style>
@stop

@section('content-wrapper')

    <div class="content full-page">

        {!! view_render_event('search.location.view.header.before', ['search' => $search]) !!}

        <div class="page-header">

            {{ Breadcrumbs::render('search.location.view', $search) }}

            <div class="page-title">
                <h1>
                    {{ $search->title }}
                    @include('admin::search.view.tags')
                </h1>
            </div>

            @if ($search->status_id == 3)
                <div class="page-action" style="display: inline-flex;">
                
                    <form method="POST" action="{{ route('results.export', ['class' => 'LeadBrowser\Search\Models\SearchLocations', 'search_id' => $search->id]) }}" @submit.prevent="onSubmit" enctype="multipart/form-data">
                        @csrf()
                        <div class="page-action" style="display: inline-flex;">
                            <button class="btn btn-primary btn-lg">Export results</button>
                        </div>
                    </form>

                    <button class="btn btn-primary btn-lg mx-2" @click="openModal('modelId')">Search more</button>
                    
                    <form method="POST" action="{{ route('search.location.more', ['search_id' => $search->id]) }}" @submit.prevent="onSubmit" enctype="multipart/form-data">
                        <modal id="modelId" :is-open="modalIds.modelId">
                            <h3 slot="header-title">Search more</h3>
                            
                            <div slot="header-actions">
                                <button class="btn btn-sm btn-secondary-outline" @click="closeModal('modelId')">Cancel</button>

                                <button class="btn btn-sm btn-primary">Search</button>
                            </div>

                            <div slot="body" class="tabs-content">

                                @csrf()

                                <div class="form-group">
                                    <label>{{ __('admin::app.leads.quantity') }}</label>

                                    <input type="number" name="expected_items" class="control" />
                                </div>

                            </div>
                        </modal>
                    </form>
                </div>
            @endif

        </div>

        @if($search->status_id == 3)
            <div class="page-content search-view">

                <div class="search-content-left">
                    {!! view_render_event('search.location.view.informations.details.before', ['search' => $search]) !!}

                    <div class="panel">
                        <div class="panel-header" style="padding-top: 0">
                            {{ __('admin::app.search.details') }}
                        </div>

                        <div class="panel-body">

                            <div class="custom-attribute-view">

                                <div class="attribute-value-row">
                                    <div class="label">Results count</div>

                                    <div class="value">
                                        {{ $search->has_items }} / {{ $search->expected_items }}
                                    </div>
                                </div>

                                @include('admin::common.custom-attributes.view', [
                                    'customAttributes' => app('LeadBrowser\Attribute\Repositories\AttributeRepository')->findWhere([
                                        'entity_type' => 'search',
                                    ]),
                                    'entity'           => $search,
                                ])

                                <div class="attribute-value-row">
                                    <div class="label">Search in</div>

                                    <div class="value">
                                        {{ $search->country ? $search->country->name : '' }}, {{ $search->state ? $search->state->name : '' }}
                                    </div>
                                </div>

                                <div class="attribute-value-row">
                                    <div class="label">Cities</div>

                                    <div>
                                        <cities
                                            :last_city_id='@json($search->last_city_id)'
                                            :data='@json(isset($search->cities) ? $search->cities : [])'
                                        ></cities>
                                    </div>
                                </div>

                                @if ($search->conditions)
                                    <div class="attribute-value-row">
                                        <div class="label">Conditions</div>

                                        <div class="value">
                                            @foreach ($search->conditions as $condition)

                                                <div style="background: aliceblue;border-radius: 6px;width: fit-content;padding: 5px;margin-bottom: 5px;">
                                                    @if (isset($condition['operator']))
                                                        Operator {{ $condition['operator'] }}
                                                    @endif

                                                    @if (isset($condition['attribute']))
                                                        attribute "{{ $condition['attribute'] }}"
                                                    @endif

                                                    @if (isset($condition['value']))
                                                        value "{{ $condition['value'] }}"
                                                    @endif
                                                </div>

                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                <div class="attribute-value-row">
                                    <div class="label">Database</div>

                                    <div class="value">
                                        We found {{ $search->all_items }} results
                                    </div>
                                </div>

                                <div class="attribute-value-row">
                                    <div class="label">Predicted market size</div>

                                    <div class="value">
                                        {{ $search->market_size }} companies
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="search-content-right">

                </div>

            </div>
        @endif

        {!! view_render_event('search.location.view.informations.after', ['search' => $search]) !!}

        @if ($search->status_id < 3)

            <div class="d-flex">
                <div class="container d-flex align-items-center py-5">
                    <div class="w-sm-75 w-lg-50 text-center mx-sm-auto">
                    <div class="mb-7">
                        <!-- <lottie></lottie> -->
                        <img src="https://d33wubrfki0l68.cloudfront.net/27c26e2bf8c23385c439e1eca76750ed73d6d878/7cc1c/assets/images/illustrations/maintenance-illustration.svg" alt="..." class="img-fluid mb-4" width="160" height="160">
                    </div>

                    <!-- <spinner-meter :classes="'spinner-container spinner-container-small'"></spinner-meter> -->
                    
                    <h1 class="h2">Approximate search time {{ $search->time }}</h1>
                    <p>You will receive an e-mail that the search is complete.</p>
                    </div>
                </div>
            </div>
        
        @else

        <!-- Results -->
        <table-component data-src="{{ route('results.index' ) }}" class="mt-5">
            <template v-slot:table-header>
                <div class="panel-header">
                    {!! view_render_event('results.index.header.before') !!}

                    {{ __('admin::app.results.title') }}

                    {!! view_render_event('results.index.header.after') !!}
                </div>
            </template>
        <table-component>

        @endif

    </div>

@stop

@once
    @push('scripts')
        <script type="text/x-template" id="cities-template">
            <div class="value">
                <span class="multi-value" @click="toggleSliceItems" v-if="cities.length > slice_items" style="background:white">
                    <a href="#">
                        <i class="bi bi-plus"></i>
                        @{{ show_more ? 'Show less' : 'Show more' }}
                    </a>
                </span>
                <span
                    v-for="(city, index) in getCities"
                    :key="index"
                    class="multi-value me-1"
                    :class="last_city_id >= city ? 'success-value' : ''"
                >@{{ city }}</span>
                <span class="multi-value" v-if="!show_more && cities.length > slice_items">+ @{{ cities.length - 12 }} results</span>
            </div>
        </script>

        <script>
            Vue.component('cities', {
                template: '#cities-template',

                props: ['last_city_id', 'data'],

                data: function () {
                    return {
                        cities: this.data ? this.data : [],
                        slice_items: 12,
                        show_more: false
                    }
                },
                computed: {
                    getCities() {
                        const count = this.cities.length

                        if(count > this.slice_items) {
                            return this.show_more ? this.cities : this.cities.slice(0, this.slice_items);
                        }

                        return this.cities
                    }
                },
                methods: {
                    toggleSliceItems() {
                        this.show_more = !this.show_more
                    }
                }
            })
        </script>
    @endpush
@endonce