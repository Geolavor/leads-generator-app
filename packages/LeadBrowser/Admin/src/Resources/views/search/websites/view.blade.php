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

        {!! view_render_event('search.websites.view.header.before', ['search' => $search]) !!}

        <div class="page-header">

            <div class="page-title">
                <h1>
                    Websites search
                </h1>
            </div>

            @if ($search->status_id == 3)
                <div class="page-action" style="display: inline-flex;">
                
                    <form method="POST" action="{{ route('results.export', ['class' => 'LeadBrowser\Search\Models\SearchWebsites', 'search_id' => $search->id]) }}" @submit.prevent="onSubmit" enctype="multipart/form-data">
                        @csrf()
                        <div class="page-action" style="display: inline-flex;">
                            <button class="btn btn-lg"> <i class="icon export-icon" style="vertical-align: middle;"></i> Export results</button>
                        </div>
                    </form>

                </div>
            @endif

        </div>

        @if($search->status_id == 3)

            <div class="page-content search-view">

                <div class="search-content-left">
                    {!! view_render_event('search.websites.view.informations.details.before', ['search' => $search]) !!}

                    <div class="panel">
                        <div class="panel-header" style="padding-top: 0">
                            {{ __('admin::app.search.details') }}
                        </div>

                        <div class="panel-body">

                            <div class="custom-attribute-view">

                                @include('admin::common.custom-attributes.view', [
                                    'customAttributes' => app('LeadBrowser\Attribute\Repositories\AttributeRepository')->findWhere([
                                        'entity_type' => 'search_websites',
                                    ]),
                                    'entity'           => $search,
                                ])

                            </div>

                        </div>
                    </div>
                </div>

                <div class="search-content-right">

                </div>

            </div>

            {!! view_render_event('search.websites.view.informations.after', ['search' => $search]) !!}
        
        @endif
        
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
            <table-component data-src="{{ route('results.index') }}" data-type="LeadBrowser\Search\Models\SearchWebsites" class="mt-5">
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