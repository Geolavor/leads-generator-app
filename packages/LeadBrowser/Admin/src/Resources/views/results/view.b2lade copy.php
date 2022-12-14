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

    {!! view_render_event('results.view.header.before', ['result' => $result]) !!}

    <div class="page-header">
        {{ Breadcrumbs::render('results.view', $result) }}
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
                data-toggle="tooltip" data-placement="top" title="Top profile"> -->

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
                                <a href="#">{{ $result->stage_id == 1 ? 'Downloaded' : 'Finished' }}</a>
                            </div>
                            <!-- End Col -->

                            <div class="col-auto">
                            </div>
                            <!-- End Col -->
                        </div>
                        <!-- End Row -->
                    </div>
                    <!-- End Col -->

                    <div class="col-lg-auto">
                        <div class="d-flex">
                            <form action="{{ route('results.transfer', ['result_id' => $result->id]) }}" method="post"
                                @submit.prevent="onSubmit" enctype="multipart/form-data">
                                @csrf()
                                <button class="btn btn-success btn-md">Add to prospects</button>
                            </form>
                            <button class="btn btn-warning btn-md mx-2">Remove</button>
                        </div>
                    </div>
                    <!-- End Col -->
                </div>
                <!-- End Row -->
            </div>
        </div>
        <!-- End Media -->
    </div>


    {!! view_render_event('results.view.header.after', ['result' => $result]) !!}


    {!! view_render_event('results.view.informations.before', ['result' => $result]) !!}

    <div class="row">
        <div class="col-sm-6 col-lg-3 mb-3 mb-lg-5">
            <!-- Card -->
            <div class="card h-100">
                <div class="card-body">
                    <h6 class="card-subtitle mb-2">Company size</h6>

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

                    @if ($result->risk_value)
                    <?php
                        if ($result->risk_value > 8) {
                            $badge = 'warning';
                            $text = 'High';
                        } else if ($result->risk_value > 5) {
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

    <div class="page-content result-view">

        <div class="result-content-left">
            {!! view_render_event('results.view.informations.details.before', ['result' => $result]) !!}

            <div class="panel">
                <div class="panel-header" style="padding-top: 0">
                    {{ __('admin::app.results.details') }}
                </div>

                <div class="panel-body">

                    <div class="custom-attribute-view">

                        <div class="btn-group btn-group-segment mb-4" role="group" aria-label="Work status radio button group">
                            <input type="radio" class="btn-check" name="applyForJobWorkStatusBtnRadio"
                                id="applyForJobWorkStatusYesBtnRadio" autocomplete="off">
                            <label class="btn btn-sm" for="applyForJobWorkStatusYesBtnRadio"><i
                                    class="bi-hand-thumbs-up me-1"></i> I like this</label>

                            <input type="radio" class="btn-check" name="applyForJobWorkStatusBtnRadio"
                                id="applyForJobWorkStatusNoBtnRadio" autocomplete="off">
                            <label class="btn btn-sm" for="applyForJobWorkStatusNoBtnRadio"><i
                                    class="bi-hand-thumbs-down me-1"></i> I don't like it</label>
                        </div>

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
                                <!-- <a>Hide generic emails</a>
                                        <br> -->
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
                                                    {{ $item['possible_email_correction'] == 1 ? 'Yes' : 'No' }} </li>
                                                <li>{{ __('admin::app.analyze.emails.free_email_provider') }}?
                                                    {{ $item['free_email_provider'] == 1 ? 'Yes' : 'No' }}</li>
                                                <li>{{ __('admin::app.analyze.emails.disposable_email_provider') }}?
                                                    {{ $item['disposable_email_provider'] == 1 ? 'Yes' : 'No' }}</li>
                                                <li>{{ __('admin::app.analyze.emails.role_or_business_email') }}?
                                                    {{ $item['role_or_business_email'] == 1 ? 'Yes' : 'No' }}</li>
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
                                <span class="multi-value bg-white border-0">
                                    <img class="avatar avatar-xss ms-1"
                                        src="{{ asset('vendor/leadBrowser/admin/assets/images/gtm.svg') }}"
                                        alt="Top rating" data-toggle="tooltip" data-placement="top" title="Top profile">
                                    GTM
                                </span>
                                <span class="multi-value bg-white border-0">
                                    <img class="avatar avatar-xss ms-1"
                                        src="{{ asset('vendor/leadBrowser/admin/assets/images/hotjar.svg') }}"
                                        alt="Top rating" data-toggle="tooltip" data-placement="top" title="Top profile">
                                    Hotjar
                                </span>
                                <span class="multi-value bg-white border-0">
                                    <img class="avatar avatar-xss ms-1"
                                        src="{{ asset('vendor/leadBrowser/admin/assets/images/sentry.svg') }}"
                                        alt="Top rating" data-toggle="tooltip" data-placement="top" title="Top profile">
                                    Sentry
                                </span>
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

                        @include('admin::common.custom-attributes.view', [
                        'customAttributes' => app('LeadBrowser\Attribute\Repositories\AttributeRepository')->findWhere([
                        'entity_type' => 'results',
                        ]),
                        'entity' => $result,
                        ])
                    </div>

                </div>
            </div>
        </div>

        <div class="result-content-right">

        </div>

    </div>


    <div class="panel mt-5">
        <div class="panel-header">
            {{ __('admin::app.results.workers') }}
        </div>
    </div>
    <div class="row row-cols-1 row-cols-md-3 g-4">
        @foreach ($workers as $item)
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

                    <span class="card-subtitle">{{ $item['role'] }}</span>
                    <h4 class="card-title">{{ $item['name'] }}</h4>
                    <p class="card-text">{{ $item['description'] }}</p>
                </div>

                <div class="card-footer pt-0" style="border-top:none">
                    <v-menu>
                        <span class="email-status email-status-sm email-status-primary"
                            style="width: 10px;height: 10px;background: #00cd00;display: inline-block;border-radius:60%"></span>

                        <span style="cursor:pointer">{{ $item['email'] }}</span>
                        <span>{{ ' (' . $item['type'] . ')'}}</span>

                        <template #popper>
                            <ul class="list-unstyled list-py-1 mb-0 p-2">
                                <li>{{ __('admin::app.analyze.emails.valid_format') }}?
                                    {{ $item['valid_format'] == 1 ? 'Yes' : 'No' }} </li>
                                <li>{{ __('admin::app.analyze.emails.valid_mx_records') }}?
                                    {{ $item['valid_mx_records'] == 1 ? 'Yes' : 'No' }}</li>
                                <li>{{ __('admin::app.analyze.emails.possible_email_correction') }}?
                                    {{ $item['possible_email_correction'] == 1 ? 'Yes' : 'No' }} </li>
                                <li>{{ __('admin::app.analyze.emails.free_email_provider') }}?
                                    {{ $item['free_email_provider'] == 1 ? 'Yes' : 'No' }}</li>
                                <li>{{ __('admin::app.analyze.emails.disposable_email_provider') }}?
                                    {{ $item['disposable_email_provider'] == 1 ? 'Yes' : 'No' }}</li>
                                <li>{{ __('admin::app.analyze.emails.role_or_business_email') }}?
                                    {{ $item['role_or_business_email'] == 1 ? 'Yes' : 'No' }}</li>
                                <li>{{ __('admin::app.analyze.emails.valid_host') }}?
                                    <b>{{ $item['valid_host'] == 1 ? 'Yes' : 'No' }}</b></li>
                            </ul>
                        </template>
                    </v-menu>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    @if (false)
        <div class="page-content result-view">
            <div class="panel">
                <div class="panel-header">
                    {{ __('admin::app.results.reviews') }}
                </div>
            </div>

            @foreach ($result->organization->reviews as $review)
            <div class="panel" style="margin-bottom:10px">
                <div class="panel-body">
                    <div class="mb-3"><img class="profile-pic" style="max-width:80px"
                            src="{{ $review['profile_photo_url'] }}"> </div>
                    <div style="display: inline-flex;">
                        <h3 style="margin:0px">{{ $review['author_name'] }}</h3>
                        <span v-if="false" class="badge badge-primary"
                            style="margin-left:5px">{{ $review['rating'] }}</span>
                    </div>
                    <p class="review">{{ $review['text'] }}</p>
                    <small>{{ core()->formatDate($review['time'], 'd M Y'); }}</small>
                </div>
            </div>
            @endforeach
        </div>
    @endif

    @if (count($similars) > 0)
    <div class="mt-5 page-content result-view">
        <div class="panel">
            <div class="panel-header">
                {{ __('admin::app.results.similar') }}
            </div>
        </div>

        <div class="panel" style="margin-bottom:10px;">
            <div class="panel-body" style="display:flex;">
                <div class="row row-cols-1 row-cols-sm-2">
                    @foreach ($similars as $organization)
                    <div class="col mb-5">
                        <div class="card card-bordered h-100">
                            <!-- Card Body -->
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col">
                                        <!-- Media -->
                                        <div class="d-flex align-items-center">
                                            @if ($organization['icon'])
                                            <div class="flex-shrink-0">
                                                <img class="avatar avatar-sm avatar-4x3" src="{{ $organization['icon'] }}"
                                                    alt="Image Description">
                                            </div>
                                            @endif

                                            <div class="flex-grow-1 <?php echo $organization['icon'] ? 'ms-3' : '' ?>">
                                                <h6 class="card-title">
                                                    <a class="text-dark"
                                                        href="../demo-jobs/employer.html">{{ $organization['title'] }}</a>
                                                    <img class="avatar avatar-xss ms-1"
                                                        src="{{ asset('vendor/leadBrowser/admin/assets/images/top-vendor.svg') }}"
                                                        alt="Top rating" data-toggle="tooltip" data-placement="top"
                                                        title="Top profile">
                                                </h6>
                                            </div>
                                        </div>
                                        <!-- End Media -->
                                    </div>
                                    <!-- End Col -->

                                    <div class="col-auto">
                                        <form action="{{ route('organizations.buy', ['organization_id' => $organization['id']]) }}" method="post"
                                            @submit.prevent="onSubmit" enctype="multipart/form-data">
                                            @csrf()
                                            <button class="btn btn-success btn-md">Buy</button>
                                        </form>
                                    </div>
                                    <!-- End Col -->
                                </div>
                                <!-- End Row -->

                                <h3 class="card-title">
                                    <a class="text-dark" href="../demo-jobs/employer.html">{{ $organization['title'] }}</a>
                                </h3>

                                <span class="d-block small text-body mb-1">
                                    {{ $organization['description'] }}
                                </span>

                                <span class="badge bg-soft-info text-info me-2">
                                    <span class="legend-indicator bg-info"></span>Downloaded
                                </span>
                                <span class="badge bg-soft-info text-info me-2">
                                    <span>{{ $organization['count_emails'] }}</span> emails
                                </span>
                                <span class="badge bg-soft-info text-info me-2">
                                    <span>{{ $organization['count_taxs'] }}</span> tax nr's
                                </span>
                                <span class="badge bg-soft-info text-info me-2">
                                    <span>{{ $organization['count_socials'] }}</span> socials
                                </span>
                            </div>
                            <!-- End Card Body -->

                            <!-- Card Footer -->
                            <div class="card-footer pt-0" style="border-top: none;">
                                <ul class="list-inline list-separator small text-body">
                                    <li class="list-inline-item">Is e-commerce?
                                        {{ $organization['is_ecommerce'] == 1 ? 'Yes' : 'No' }}</li>
                                    <li class="list-inline-item">Has ads?
                                        {{ $organization['is_sponsored'] == 1 ? 'Yes' : 'No' }}</li>
                                    <li class="list-inline-item">From {{ $organization['city'] }}, {{ $organization['country'] }}</li>
                                </ul>
                                <small>{{ $organization['keywords'] }}</small>
                            </div>
                            <!-- End Card Footer -->
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

    </div>
    @endif

    {!! view_render_event('results.view.informations.after', ['result' => $result]) !!}

</div>
@stop