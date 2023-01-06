@extends('admin::layouts.master')

@section('page_title')
{{ $organization->title }}
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

    {!! view_render_event('organizations.view.header.before', ['organization' => $organization]) !!}

    <div class="page-header">
        {{ Breadcrumbs::render('organizations.view', $organization) }}
    </div>

    <div class="page-header">
        <div class="d-flex">
            @if ($organization->icon)
            <!-- Avatar -->
            <div class="flex-shrink-0">
                <div class="avatar avatar-lg avatar-4x3">
                    <img class="avatar-img" src="{{ $organization->icon }}" alt="Image Description">
                </div>
            </div>
            <!-- End Avatar -->
            @endif
            <div class="flex-grow-1 ms-4">
                <div class="row">
                    <div class="col-lg mb-3 mb-lg-0">
                        <h1 class="page-header-title">{{ $organization->title }}</h1>

                        <!-- <img class="avatar avatar-xss ms-1"
                src="{{ asset('vendor/leadBrowser/admin/assets/images/top-vendor.svg') }}" alt="Top rating"
                data-toggle="tooltip" data-organizationment="top" title="Top profile"> -->

                        <div class="row align-items-center">

                            @if ($organization->website)
                            <div class="col-auto">
                                <span>Website:</span>
                                <a href="{{ $organization->website }}" target="_blank">{{ $organization->website }}</a>
                            </div>
                            <!-- End Col -->
                            @endif

                            <div class="col-auto">
                                <span><i class="bi bi-info-circle"></i> Category:</span>
                                <a href="#">{{ $organization->category }}</a>
                            </div>
                            <!-- End Col -->

                            <div class="col-auto">
                                <span>Stage:</span>
                                <a href="#">{{ $organization->stage_id == 1 ? 'Downloaded' : 'Finished' }}</a>
                            </div>
                            <!-- End Col -->

                            <div class="col-auto">
                                @include('admin::organizations.view.tags')
                            </div>
                            <!-- End Col -->
                        </div>
                        <!-- End Row -->
                    </div>
                    <!-- End Col -->

                    <div class="col-lg-auto">
                        <div class="d-flex">
                            <form action="{{ route('organizations.buy', ['organization_id' => $organization->id]) }}" method="post"
                                @submit.prevent="onSubmit" enctype="multipart/form-data">
                                @csrf()
                                <button class="btn btn-danger btn-md">Buy this result</button>
                            </form>
                        </div>
                    </div>
                    <!-- End Col -->
                </div>
                <!-- End Row -->
            </div>
        </div>
        <!-- End Media -->
    </div>


    {!! view_render_event('organizations.view.header.after', ['organization' => $organization]) !!}


    {!! view_render_event('organizations.view.informations.before', ['organization' => $organization]) !!}

    <div class="row">
        <div class="col-sm-6 col-lg-3 mb-3 mb-lg-5">
            <!-- Card -->
            <div class="card h-100">
                <div class="card-body">
                    <h6 class="card-subtitle mb-2">Total employees</h6>

                    <div class="row align-items-center gx-2">
                        <div class="col">
                            <span class="js-counter display-4 text-dark" data-value="24">{{ $organization->count_employees }}</span>
                            <!-- <span class="text-body fs-5 ms-1">from 22</span> -->
                        </div>
                        <!-- End Col -->

                        <div class="col-auto">
                            <div class="flex-shrink-0">
                                <!-- Avatar Group -->
                                <div class="avatar-group avatar-group-xs">
                                    <div class="avatar avatar-xs avatar-circle">
                                        <img class="avatar-img"
                                            src="https://htmlstream.com/front/assets/img/160x160/img1.jpg"
                                            alt="Image Description">
                                    </div>
                                    <div class="avatar avatar-xs avatar-circle">
                                        <img class="avatar-img"
                                            src="https://htmlstream.com/front/assets/img/160x160/img1.jpg"
                                            alt="Image Description">
                                    </div>
                                </div>
                                <!-- End Avatar Group -->
                            </div>
                            <!-- <span class="badge bg-soft-success text-success p-1">
                                <i class="bi-graph-up"></i> 5.0%
                            </span> -->
                        </div>
                    </div>
                    <!-- End Row -->
                </div>
            </div>
            <!-- End Card -->
        </div>

        <div class="col-sm-6 col-lg-3 mb-3 mb-lg-5">
            <!-- Card -->
            <div class="card h-100">
                <div class="card-body">
                    <h6 class="card-subtitle mb-2">Total emails</h6>

                    <div class="row align-items-center gx-2">
                        <div class="col">
                            <span class="js-counter display-4 text-dark"
                                data-value="12">{{ $organization->count_emails }}</span>
                            <!-- <span class="text-body fs-5 ms-1">from 11</span> -->
                        </div>

                        <!-- <div class="col-auto">
                            <span class="badge bg-soft-success text-success p-1">
                                <i class="bi-graph-up"></i> 1.2%
                            </span>
                        </div> -->
                    </div>
                    <!-- End Row -->
                </div>
            </div>
            <!-- End Card -->
        </div>

        <div class="col-sm-6 col-lg-3 mb-3 mb-lg-5">
            <!-- Card -->
            <div class="card h-100">
                <div class="card-body">
                    <h6 class="card-subtitle mb-2">Total tax numbers</h6>

                    <div class="row align-items-center gx-2">
                        <div class="col">
                            <span class="js-counter display-4 text-dark" data-value="56">{{ $organization->count_taxs }}</span>
                            <!-- <span class="display-4 text-dark">%</span> -->
                            <!-- <span class="text-body fs-5 ms-1">from 48.7</span> -->
                        </div>

                        <!-- <div class="col-auto">
                            <span class="badge bg-soft-danger text-danger p-1">
                                <i class="bi-graph-down"></i> 2.8%
                            </span>
                        </div> -->
                    </div>
                    <!-- End Row -->
                </div>
            </div>
            <!-- End Card -->
        </div>

        <div class="col-sm-6 col-lg-3 mb-3 mb-lg-5">
            <!-- Card -->
            <div class="card h-100">
                <div class="card-body">
                    <h6 class="card-subtitle mb-2">Risk value</h6>
                    <div class="row align-items-center gx-2">
                        <div class="col blur-text">
                            <span class="js-counter display-4 text-dark" data-value="28">28</span>
                            <span class="display-4 text-dark">%</span>
                            <span class="text-body fs-5 ms-1">matching</span>
                        </div>

                        <div class="col-auto">
                            <span class="badge badge-success p-1 blur-text">Low</span>
                        </div>
                    </div>
                    <!-- End Row -->
                </div>
            </div>
            <!-- End Card -->
        </div>

    </div>

    <div class="page-content organization-view">

        <div class="organization-content-left">
            {!! view_render_event('organizations.view.informations.details.before', ['organization' => $organization]) !!}

            <div class="panel">
                <tabs>

                    <tab name="{{ __('admin::app.leads.details') }}" :selected="true">
                        <div>
                            <div class="custom-attribute-view">

                                @if($organization->description)
                                <div class="attribute-value-row">
                                    <div class="label">Description</div>

                                    <div class="value">
                                        {{ $organization->description }}
                                    </div>
                                </div>
                                @endif

                                <div class="attribute-value-row">
                                    <div class="label">Ads</div>

                                    <div class="value">
                                        {{ $organization->is_sponsored ? 'Yes' : 'No' }}
                                    </div>
                                </div>

                                @if ($organization->price)
                                <div class="attribute-value-row">
                                    <div class="label">Price</div>

                                    <div class="value">
                                        {{ $organization->price }}
                                    </div>
                                </div>
                                @endif

                                @if ($organization->formatted_address)
                                <div class="attribute-value-row">
                                    <div class="label">Address</div>

                                    <div class="value">
                                        {{ $organization->formatted_address }}
                                    </div>
                                </div>
                                @endif

                                @if ($organization->international_phone_number)
                                <div class="attribute-value-row">
                                    <div class="label">Phone number</div>

                                    <div class="value blur-text">
                                        +48 201928492
                                    </div>
                                </div>
                                @endif

                                @if ($organization->count_taxs > 0)
                                <div class="attribute-value-row">
                                    <div class="label">Tax numbers</div>

                                    <div class="value">
                                        @foreach (range(0, $organization->count_taxs) as $item)
                                        <span class="multi-value">
                                            <span class="blur-text"
                                                style="cursor:pointer">{{ '42014210' . $item }}</span>
                                        </span>
                                        @endforeach
                                    </div>
                                </div>
                                @endif

                                @if ($organization->year_founded)
                                <div class="attribute-value-row">
                                    <div class="label">Year founded</div>

                                    <div class="value">
                                        {{ $organization->year_founded }}
                                    </div>
                                </div>
                                @endif

                                <div class="attribute-value-row">
                                    <div class="label">{{ __('admin::app.datagrid.ecommerce') }}?</div>

                                    <div class="value">
                                        {{ $organization->is_ecommerce == 1 ? 'Yes' : 'No' }}
                                    </div>
                                </div>

                                @if ($organization->count_emails)
                                <div class="attribute-value-row">
                                    <div class="label">Emails</div>

                                    <div class="value">
                                        @foreach (range(0, $organization->count_emails) as $item)
                                        <span class="multi-value">
                                            <v-menu>
                                                <span class="email-status email-status-sm email-status-primary"
                                                    style="width: 10px;height: 10px;background: #00cd00;display: inline-block;border-radius: 50%;"></span>

                                                <span class="blur-text" style="cursor:pointer">example@domain.com</span>
                                                <span class="blur-text">{{ ' (office)'}}</span>

                                                <template #popper>
                                                    <ul class="list-unstyled list-py-1 mb-0 p-2">
                                                        <li>{{ __('admin::app.emails.rfc_validation') }}? Yes</li>
                                                        <li>{{ __('admin::app.emails.no_rfc_validation') }}? Yes
                                                        </li>
                                                        <li>{{ __('admin::app.emails.dns_check') }}?
                                                            Yes</li>
                                                        <li>{{ __('admin::app.emails.free_email_provider') }}?
                                                            Yes</li>
                                                        <li>{{ __('admin::app.emails.disposable_email_provider') }}?
                                                            Yes</li>
                                                        <li>{{ __('admin::app.emails.role_or_business_email') }}?
                                                            Yes</li>
                                                        <li>{{ __('admin::app.emails.spoof_check') }}? Yes</li>
                                                    </ul>
                                                </template>
                                            </v-menu>
                                        </span>
                                        @endforeach
                                    </div>
                                </div>
                                @endif

                                @if(!empty($organization->categories))
                                <div class="attribute-value-row">
                                    <div class="label">Categories</div>

                                    <div class="value">
                                        @include ('admin::common.custom-attributes.view.types', ['value' =>
                                        $organization->categories])
                                    </div>
                                </div>
                                @endif

                                @if(count($organization->socials) > 0)
                                <div class="attribute-value-row">
                                    <div class="label">Social-media</div>

                                    <div class="value">
                                        @include ('admin::common.custom-attributes.view.socials', ['value' =>
                                        $organization->socials])
                                    </div>
                                </div>
                                @endif

                                <div class="attribute-value-row">
                                    <div class="label">Technology</div>

                                    <div class="value">
                                        @foreach ($organization->technologies as $technology)
                                            <span class="multi-value">
                                                <img class="avatar avatar-xss ms-1"
                                                    src="{{ asset('vendor/leadBrowser/admin/assets/images/' . $technology->type . '.svg') }}"
                                                    alt="Top rating" data-toggle="tooltip" data-organizationment="top"
                                                    title="Top profile"
                                                >
                                                <span style="cursor:pointer">{{ $technology->type }}</span>
                                            </span>
                                        @endforeach
                                    </div>
                                </div>

                                @if($organization->keywords)
                                <div class="attribute-value-row">
                                    <div class="label">Keywords</div>

                                    <div class="value">
                                        {{ $organization->keywords }}
                                    </div>
                                </div>
                                @endif

                                <div class="attribute-value-row">
                                    <div class="label">{{ __('admin::app.datagrid.domain_created') }}</div>

                                    <div class="value">
                                        {{ date('d-m-Y', strtotime($organization->domain_created)) }}
                                    </div>
                                </div>

                                <div class="attribute-value-row">
                                    <div class="label">{{ __('admin::app.datagrid.domain_expires') }}</div>

                                    <div class="value">
                                        {{ date('d-m-Y', strtotime($organization->domain_expires)) }}
                                    </div>
                                </div>

                                <div class="attribute-value-row">
                                    <div class="label">{{ __('admin::app.datagrid.domain_owner') }}</div>

                                    <div class="value">
                                        {{ $organization->domain_owner }}
                                    </div>
                                </div>

                                @if (isset($organization->external_urls))
                                    <div class="attribute-value-row">
                                        <div class="label">{{ __('admin::app.datagrid.external_urls') }}</div>

                                        <div class="value">
                                            @foreach (json_decode($organization->external_urls) as $url)
                                                <span class="multi-value">
                                                    <a href="{{ $url }}" target="_blank" style="cursor:pointer">{{ $url }}</a>
                                                </span>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                <!-- @include('admin::common.custom-attributes.view', [
                                    'customAttributes' =>
                                        app('LeadBrowser\Attribute\Repositories\AttributeRepository')->findWhere([
                                        'entity_type' => 'organizations',
                                    ]),
                                    'entity' => $organization,
                                ]) -->
                            </div>
                        </div>
                    </tab>

                    <tab name="{{ __('admin::app.organizations.employees') }}" :selected="false">
                        <div>

                            @for ($i = 0; $i < count($organization->employees); $i++)
                                <div class="col">
                                    <div class="card card-transition h-100">
                                        <div class="card-body">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0">
                                                    <div class="avatar avatar-lg avatar-circle mb-4 blur-text">
                                                        <img class="avatar-img"
                                                            src="{{ asset('vendor/leadBrowser/admin/assets/images/noavatar.png') }}"
                                                            alt="Worker avatar">
                                                    </div>
                                                </div>

                                                <div class="flex-grow-1">
                                                    <div class="d-flex align-items-center" style="float: right;">

                                                        <span class="small me-2">Correct data?</span>

                                                        <div class="d-flex gap-1">
                                                            <a class="btn btn-white btn-xs" href="javascript:;">
                                                                <i class="bi-hand-thumbs-up me-1"></i> Yes
                                                            </a>
                                                            <a class="btn btn-white btn-xs" href="javascript:;">
                                                                <i class="bi-hand-thumbs-down me-1"></i> No
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <span class="card-subtitle blur-text">Owner</span>
                                            <h4 class="card-title blur-text">Name</h4>
                                            <p class="card-text blur-text">Desc</p>
                                        </div>

                                        <div class="card-footer pt-0" style="border-top:none">

                                            <v-menu>
                                                <span class="email-status email-status-sm email-status-primary"
                                                    style="width: 10px;height: 10px;background: #00cd00;display: inline-block;border-radius:60%"></span>

                                                <span class="blur-text" style="cursor:pointer">{{ rand(10000, 50000) }}</span>
                                                <span class="blur-text">{{ ' (private)'}}</span>

                                                <template #popper>
                                                    <ul class="list-unstyled list-py-1 mb-0 p-2">
                                                        <li>{{ __('admin::app.emails.rfc_validation') }}? Yes</li>
                                                        <li>{{ __('admin::app.emails.no_rfc_validation') }}? Yes
                                                        </li>
                                                        <li>{{ __('admin::app.emails.dns_check') }}?
                                                            Yes</li>
                                                        <li>{{ __('admin::app.emails.free_email_provider') }}?
                                                            Yes</li>
                                                        <li>{{ __('admin::app.emails.disposable_email_provider') }}?
                                                            Yes</li>
                                                        <li>{{ __('admin::app.emails.role_or_business_email') }}?
                                                            Yes</li>
                                                        <li>{{ __('admin::app.emails.spoof_check') }}? Yes</li>
                                                    </ul>
                                                </template>
                                            </v-menu>
                                        </div>
                                    </div>
                                </div>
                            @endfor
                        </div>
                    </tab>

                    <tab name="{{ __('admin::app.organizations.similar') }}" :selected="false">
                        @foreach ($similars as $organization)
                            <div class="col mb-5">
                                <div class="card card-bordered h-100">
                                    <!-- Card Body -->
                                    <div class="card-body">
                                        <div class="row mb-3">
                                            <div class="col">
                                                <!-- Media -->
                                                <div class="d-flex align-items-center">
                                                    @if ($organization->icon && isset($organization->icon))
                                                    <div class="flex-shrink-0">
                                                        <img class="avatar avatar-sm avatar-4x3" src="{{ $organization->icon }}"
                                                            alt="{{ $organization->title }}">
                                                    </div>
                                                    @endif

                                                    <div class="flex-grow-1 <?php echo $organization->icon ? 'ms-3' : '' ?>">
                                                        <h6 class="card-title">
                                                            <a class="text-dark"
                                                                href="/organizations/view/{{ $organization->id }}">{{ $organization->title }}</a>
                                                            <img class="avatar avatar-xss ms-1"
                                                                src="{{ asset('vendor/leadBrowser/admin/assets/images/top-vendor.svg') }}"
                                                                alt="Top rating" data-toggle="tooltip" data-organizationment="top"
                                                                title="Top profile">
                                                        </h6>
                                                    </div>
                                                </div>
                                                <!-- End Media -->
                                            </div>
                                            <!-- End Col -->

                                            <div class="col-auto">
                                                <form action="{{ route('organizations.buy', ['organization_id' => $organization->id]) }}"
                                                    method="post" @submit.prevent="onSubmit" enctype="multipart/form-data">
                                                    @csrf()
                                                    <button class="btn btn-danger btn-md">Buy</button>
                                                </form>
                                            </div>
                                            <!-- End Col -->
                                        </div>
                                        <!-- End Row -->

                                        <h3 class="card-title">
                                            <a class="text-dark"
                                                href="/organizations/view/{{ $organization->id }}">{{ $organization->title }}</a>
                                        </h3>

                                        <span class="d-block small text-body mb-1">
                                            {{ $organization->description }}
                                        </span>

                                        <!-- <span class="badge bg-soft-info text-info me-2">
                                            <span class="legend-indicator bg-info"></span>Downloaded
                                        </span> -->

                                    </div>
                                    <!-- End Card Body -->

                                    <!-- Card Footer -->
                                    <div class="card-footer pt-0" style="border-top: none;">
                                        <ul class="list-inline list-separator small text-body">
                                            <li class="list-inline-item">Is e-commerce?
                                                {{ $organization->is_ecommerce == 1 ? 'Yes' : 'No' }}</li>
                                            <li class="list-inline-item">Has ads?
                                                {{ $organization->is_sponsored == 1 ? 'Yes' : 'No' }}
                                            </li>
                                            <li class="list-inline-item">From {{ $organization->city }}, {{ $organization->country }}</li>
                                        </ul>
                                        <small>{{ $organization->keywords }}</small>
                                    </div>
                                    <!-- End Card Footer -->
                                </div>
                            </div>
                        @endforeach
                    </tab>

                    <tab name="{{ __('admin::app.organizations.reviews') }}" :selected="false">
                    </tab>

                    <tab name="{{ __('admin::app.organizations.technology') }}" :selected="false">
                    </tab>

                    <tab name="{{ __('admin::app.organizations.news') }}" :selected="false">
                    </tab>

                    <tab name="{{ __('admin::app.organizations.timeline') }}" :selected="false">
                        <div class="col">
                            <div class="card card-bordered h-100">
                                <div class="card-body">
                                    <ul class="list-comment">
                                        @if(isset($organization->archive))
                                            @foreach ($organization->archive as $item)
                                                <li class="list-comment-item">
                                                    <!-- Media -->
                                                    <div class="d-flex align-items-center mb-3">
                                                        <div class="flex-grow-1">
                                                            <div class="d-flex justify-content-between align-items-center">
                                                                <h6>
                                                                    <a href="{{ $item['url'] }}" target="_blank">{{ $item['url'] }}</a>
                                                                </h6>
                                                                <span class="d-block"><b>{{ date('d-m-Y', strtotime($item['time']['date'])) }}</b> - {{ $item['time']['timezone'] }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- End Media -->

                                                    <!-- <p>As a Special Education teacher this resonates so well with me. Fighting with gen
                                                        ed teachers to flatten for the students with learning disabilities. It also
                                                        confirms some things for me in my writing.</p> -->

                                                    <a class="link" href="{{ $item['url'] }}" target="_blank">Open <i class="bi-chevron-right small ms-1 small ms-1"></i></a>
                                                </li>
                                            @endforeach
                                        @else
                                            <li class="list-comment-item">
                                                <h5>We find no historical data</h5>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </tab>

                    <tab name="{{ __('admin::app.organizations.services') }}" :selected="false">
                    </tab>

                    <tab name="{{ __('admin::app.organizations.clients') }}" :selected="false">
                    </tab>

                </tabs>
            </div>
        </div>

        <div class="organization-content-right">

        </div>

    </div>


    {!! view_render_event('organizations.view.informations.after', ['organization' => $organization]) !!}

</div>
@stop
