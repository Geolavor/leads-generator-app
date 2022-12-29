@extends('admin::layouts.master')

@section('page_title')
{{ $result->organization->title }}
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

    {!! view_render_event('organizations.view.header.before', ['organization' => $result->organization]) !!}

    <div class="page-header">
        {{ Breadcrumbs::render('organizations.view', $result->organization) }}
    </div>

    <div class="page-header">
        <div class="d-flex">
            @if ($result->organization->icon)
            <!-- Avatar -->
            <div class="flex-shrink-0">
                <div class="avatar avatar-lg avatar-4x3">
                    <img class="avatar-img" src="{{ $result->organization->icon }}" alt="Image Description">
                </div>
            </div>
            <!-- End Avatar -->
            @endif
            <div class="flex-grow-1 ms-4">
                <div class="row">
                    <div class="col-lg mb-3 mb-lg-0">
                        <h1 class="page-header-title">{{ $result->organization->title }}</h1>

                        <!-- <img class="avatar avatar-xss ms-1"
                src="{{ asset('vendor/leadBrowser/admin/assets/images/top-vendor.svg') }}" alt="Top rating"
                data-toggle="tooltip" data-organizationment="top" title="Top profile"> -->

                        <div class="row align-items-center">

                            @if ($result->organization->website)
                            <div class="col-auto">
                                <span>Website:</span>
                                <a href="{{ $result->organization->website }}"
                                    target="_blank">{{ $result->organization->website }}</a>
                            </div>
                            <!-- End Col -->
                            @endif

                            <div class="col-auto">
                                <span>Category:</span>
                                <a href="#">{{ $result->organization->types }}</a>
                            </div>
                            <!-- End Col -->

                            <div class="col-auto">
                                <span>Stage:</span>
                                <a href="#">{{ $result->organization->stage_id == 1 ? 'Downloaded' : 'Finished' }}</a>
                            </div>
                            <!-- End Col -->

                            <div class="col-auto">

                            </div>
                            <!-- End Col -->
                        </div>
                        <!-- End Row -->
                    </div>
                    <!-- End Col -->
                </div>
                <!-- End Row -->
            </div>
        </div>
        <!-- End Media -->
    </div>


    {!! view_render_event('organizations.view.header.after', ['organization' => $result->organization]) !!}


    {!! view_render_event('organizations.view.informations.before', ['organization' => $result->organization]) !!}

    <div class="row">
        <div class="col-sm-6 col-lg-3 mb-3 mb-lg-5">
            <!-- Card -->
            <div class="card h-100">
                <div class="card-body">
                    <h6 class="card-subtitle mb-2">Total workers</h6>

                    <div class="row align-items-center gx-2">
                        <div class="col">
                            <span class="js-counter display-4 text-dark"
                                data-value="24">{{ $result->organization->count_workers }}</span>
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
                                data-value="12">{{ $result->organization->count_emails }}</span>
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
                            <span class="js-counter display-4 text-dark"
                                data-value="56">{{ $result->organization->count_taxs }}</span>
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

                    @if ($result->organization->risk_value)
                    <?php
                        if ($result->organization->risk_value > 8) {
                            $badge = 'warning';
                            $text = 'High';
                        } else if ($result->organization->risk_value > 5) {
                            $badge = 'primary';
                            $text = 'Medium';
                        } else {
                            $badge = 'success';
                            $text = 'Low';
                        }
                    ?>

                    <div class="row align-items-center gx-2">
                        <div class="col">
                            <span class="js-counter display-4 text-dark" data-value="28">28</span>
                            <span class="display-4 text-dark">%</span>
                            <span class="text-body fs-5 ms-1">matching</span>
                        </div>

                        <div class="col-auto">
                            <span class="badge badge-{{$badge}} p-1">{{ $text }}</span>
                        </div>
                    </div>
                    @endif
                    <!-- End Row -->
                </div>
            </div>
            <!-- End Card -->
        </div>

    </div>

    <div class="page-content organization-view">

        <div class="organization-content-left">
            {!! view_render_event('organizations.view.informations.details.before', ['organization' =>
            $result->organization]) !!}

            <div class="panel">
                <tabs>

                    <tab name="{{ __('admin::app.leads.details') }}" :selected="true">
                        <div>
                            <div class="custom-attribute-view">

                                @if($result->organization->description)
                                <div class="attribute-value-row">
                                    <div class="label">Description</div>

                                    <div class="value">
                                        {{ $result->organization->description }}
                                    </div>
                                </div>
                                @endif

                                <div class="attribute-value-row">
                                    <div class="label">Ads</div>

                                    <div class="value">
                                        {{ $result->organization->is_sponsored ? 'Yes' : 'No' }}
                                    </div>
                                </div>

                                @if ($result->organization->price)
                                <div class="attribute-value-row">
                                    <div class="label">Price</div>

                                    <div class="value">
                                        {{ $result->organization->price }}
                                    </div>
                                </div>
                                @endif

                                @if ($result->organization->formatted_address)
                                <div class="attribute-value-row">
                                    <div class="label">Address</div>

                                    <div class="value">
                                        {{ $result->organization->formatted_address }}
                                    </div>
                                </div>
                                @endif

                                @if ($result->organization->international_phone_number)
                                <div class="attribute-value-row">
                                    <div class="label">Phone number</div>

                                    <div class="value">
                                        {{ $result->organization->international_phone_number }}
                                    </div>
                                </div>
                                @endif

                                @if ($result->organization->count_taxs > 0)
                                <div class="attribute-value-row">
                                    <div class="label">Tax numbers</div>

                                    <div class="value">
                                        @include ('admin::common.custom-attributes.view.taxs', ['value' =>
                                        $result->organization->taxs])
                                    </div>
                                </div>
                                @endif

                                @if ($result->organization->year_founded)
                                <div class="attribute-value-row">
                                    <div class="label">Year founded</div>

                                    <div class="value">
                                        {{ $result->organization->year_founded }}
                                    </div>
                                </div>
                                @endif

                                <div class="attribute-value-row">
                                    <div class="label">{{ __('admin::app.datagrid.ecommerce') }}?</div>

                                    <div class="value">
                                        {{ $result->organization->is_ecommerce == 1 ? 'Yes' : 'No' }}
                                    </div>
                                </div>

                                @if ($result->organization->count_emails)
                                <div class="attribute-value-row">
                                    <div class="label">Emails</div>

                                    <div class="value">
                                        @foreach ($emails as $item)
                                        <span class="multi-value">
                                            <v-menu>
                                                <span class="email-status email-status-sm email-status-primary"
                                                    style="width: 10px;height: 10px;background: #00cd00;display: inline-block;border-radius: 50%;"></span>

                                                <span style="cursor:pointer">{{ $item['email'] }}</span>
                                                <span>{{ ' (' . $item['type'] . ')'}}</span>

                                                <template #popper>
                                                    <ul class="list-unstyled list-py-1 mb-0 p-2">
                                                        <li>{{ __('admin::app.analyze.emails.valid_format') }}?
                                                            {{ $item['valid_format'] == 1 ? 'Yes' : 'No' }} </li>
                                                        <li>{{ __('admin::app.analyze.emails.valid_mx_records') }}?
                                                            {{ $item['valid_mx_records'] == 1 ? 'Yes' : 'No' }}</li>
                                                        <li>{{ __('admin::app.analyze.emails.possible_email_correction') }}?
                                                            {{ $item['possible_email_correction'] == 1 ? 'Yes' : 'No' }}
                                                        </li>
                                                        <li>{{ __('admin::app.analyze.emails.free_email_provider') }}?
                                                            {{ $item['free_email_provider'] == 1 ? 'Yes' : 'No' }}</li>
                                                        <li>{{ __('admin::app.analyze.emails.disposable_email_provider') }}?
                                                            {{ $item['disposable_email_provider'] == 1 ? 'Yes' : 'No' }}
                                                        </li>
                                                        <li>{{ __('admin::app.analyze.emails.role_or_business_email') }}?
                                                            {{ $item['role_or_business_email'] == 1 ? 'Yes' : 'No' }}
                                                        </li>
                                                        <li>{{ __('admin::app.analyze.emails.valid_host') }}?
                                                            <b>{{ $item['valid_host'] == 1 ? 'Yes' : 'No' }}</b></li>
                                                    </ul>
                                                </template>
                                            </v-menu>
                                        </span>
                                        @endforeach
                                    </div>
                                </div>
                                @endif

                                @if(!empty($result->organization->categories))
                                <div class="attribute-value-row">
                                    <div class="label">Categories</div>

                                    <div class="value">
                                        @include ('admin::common.custom-attributes.view.types', ['value' =>
                                        $result->organization->categories])
                                    </div>
                                </div>
                                @endif

                                @if(count($result->organization->socials) > 0)
                                <div class="attribute-value-row">
                                    <div class="label">Social-media</div>

                                    <div class="value">
                                        @include ('admin::common.custom-attributes.view.socials', ['value' =>
                                        $result->organization->socials])
                                    </div>
                                </div>
                                @endif

                                <div class="attribute-value-row">
                                    <div class="label">Technology</div>

                                    <div class="value">
                                        @foreach ($result->organization->technologies as $technology)
                                        <span class="multi-value">
                                            <img class="avatar avatar-xss ms-1"
                                                src="{{ asset('vendor/leadBrowser/admin/assets/images/' . $technology->type . '.svg') }}"
                                                alt="Top rating" data-toggle="tooltip" data-organizationment="top"
                                                title="Top profile">
                                            <span style="cursor:pointer">{{ $technology->type }}</span>
                                        </span>
                                        @endforeach
                                    </div>
                                </div>

                                @if($result->organization->keywords)
                                <div class="attribute-value-row">
                                    <div class="label">Keywords</div>

                                    <div class="value">
                                        {{ $result->organization->keywords }}
                                    </div>
                                </div>
                                @endif

                                <div class="attribute-value-row">
                                    <div class="label">{{ __('admin::app.datagrid.domain_created') }}</div>

                                    <div class="value">
                                        {{ date('d-m-Y', strtotime($result->organization->domain_created)) }}
                                    </div>
                                </div>

                                <div class="attribute-value-row">
                                    <div class="label">{{ __('admin::app.datagrid.domain_expires') }}</div>

                                    <div class="value">
                                        {{ date('d-m-Y', strtotime($result->organization->domain_expires)) }}
                                    </div>
                                </div>

                                <div class="attribute-value-row">
                                    <div class="label">{{ __('admin::app.datagrid.domain_owner') }}</div>

                                    <div class="value">
                                        {{ $result->organization->domain_owner }}
                                    </div>
                                </div>

                                @include('admin::common.custom-attributes.view', [
                                'customAttributes' =>
                                app('LeadBrowser\Attribute\Repositories\AttributeRepository')->findWhere([
                                'entity_type' => 'organizations',
                                ]),
                                'entity' => $result->organization,
                                ])
                            </div>
                        </div>
                    </tab>

                    <tab name="{{ __('admin::app.organizations.workers') }}" :selected="false">
                        <div class="row row-cols-1 row-cols-md-2 g-4">
                            @foreach ($result->organization->persons as $person)
                            <div class="col">
                                <div class="card card-transition h-100">
                                    <div class="card-body">
                                        <div class="d-flex">
                                            <div class="flex-shrink-0">
                                                <div class="avatar avatar-lg avatar-circle mb-4">
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

                                        <span class="card-subtitle">{{ $person->role }}</span>
                                        <h4 class="card-title">{{ $person->name }}</h4>
                                        <p class="card-text">{{ $person->description ?? '' }}</p>
                                    </div>

                                    <div class="card-footer pt-0" style="border-top:none">
                                        @foreach ($person->emails as $email)
                                        <div>
                                            <v-menu>
                                                <span class="email-status email-status-sm email-status-primary"
                                                    style="width: 10px;height: 10px;background: #00cd00;display: inline-block;border-radius:60%"></span>

                                                <span style="cursor:pointer">{{ $email['value'] }}</span>
                                                <span>({{ $email['label'] }})</span>

                                                <template #popper>
                                                    <ul class="list-unstyled list-py-1 mb-0 p-2">
                                                        <li>{{ __('admin::app.analyze.emails.valid_format') }}? Yes</li>
                                                        <li>{{ __('admin::app.analyze.emails.valid_mx_records') }}? Yes
                                                        </li>
                                                        <li>{{ __('admin::app.analyze.emails.possible_email_correction') }}?
                                                            Yes</li>
                                                        <li>{{ __('admin::app.analyze.emails.free_email_provider') }}?
                                                            Yes</li>
                                                        <li>{{ __('admin::app.analyze.emails.disposable_email_provider') }}?
                                                            Yes</li>
                                                        <li>{{ __('admin::app.analyze.emails.role_or_business_email') }}?
                                                            Yes</li>
                                                        <li>{{ __('admin::app.analyze.emails.valid_host') }}? Yes</li>
                                                    </ul>
                                                </template>
                                            </v-menu>
                                        </div>
                                        @endforeach

                                        @foreach ($person->social_media as $social)
                                        <div>
                                            <span>
                                                <a href="{{ $social['value'] }}" target="_blank">
                                                    <img class="avatar avatar-xss ms-1"
                                                        src="{{ asset('vendor/leadBrowser/admin/assets/images/' . $social['type'] . '.svg') }}"
                                                        alt="Linkedin profile" data-toggle="tooltip"
                                                        data-placement="top" title="Linkedin profile">
                                                </a>
                                            </span>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </tab>

                    <tab name="{{ __('admin::app.organizations.similar') }}" :selected="false">
                        @foreach ($similars as $result->organization)
                        <div class="col mb-5">
                            <div class="card card-bordered h-100">
                                <!-- Card Body -->
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="col">
                                            <!-- Media -->
                                            <div class="d-flex align-items-center">
                                                @if ($result->organization->icon && isset($result->organization->icon))
                                                <div class="flex-shrink-0">
                                                    <img class="avatar avatar-sm avatar-4x3"
                                                        src="{{ $result->organization->icon }}"
                                                        alt="{{ $result->organization->title }}">
                                                </div>
                                                @endif

                                                <div
                                                    class="flex-grow-1 <?php echo $result->organization->icon ? 'ms-3' : '' ?>">
                                                    <h6 class="card-title">
                                                        <a class="text-dark"
                                                            href="/organizations/view/{{ $result->organization->id }}">{{ $result->organization->title }}</a>
                                                        <img class="avatar avatar-xss ms-1"
                                                            src="{{ asset('vendor/leadBrowser/admin/assets/images/top-vendor.svg') }}"
                                                            alt="Top rating" data-toggle="tooltip"
                                                            data-organizationment="top" title="Top profile">
                                                    </h6>
                                                </div>
                                            </div>
                                            <!-- End Media -->
                                        </div>
                                        <!-- End Col -->

                                        <div class="col-auto">
                                            <form
                                                action="{{ route('organizations.buy', ['organization_id' => $result->organization->id]) }}"
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
                                            href="/organizations/view/{{ $result->organization->id }}">{{ $result->organization->title }}</a>
                                    </h3>

                                    <span class="d-block small text-body mb-1">
                                        {{ $result->organization->description }}
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
                                            {{ $result->organization->is_ecommerce == 1 ? 'Yes' : 'No' }}</li>
                                        <li class="list-inline-item">Has ads?
                                            {{ $result->organization->is_sponsored == 1 ? 'Yes' : 'No' }}
                                        </li>
                                        <li class="list-inline-item">From {{ $result->organization->city }},
                                            {{ $result->organization->country }}</li>
                                    </ul>
                                    <small>{{ $result->organization->keywords }}</small>
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
                        <div>
                            <ul class="list-comment">
                                @if(count($result->archive) > 0)
                                    @foreach ($result->archive as $item)
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
                                    <li>
                                        <h2>We find no historical data</h2>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </tab>

                </tabs>
            </div>
        </div>

        <div class="organization-content-right">

        </div>

    </div>


    {!! view_render_event('organizations.view.informations.after', ['organization' => $result->organization]) !!}

</div>
@stop
