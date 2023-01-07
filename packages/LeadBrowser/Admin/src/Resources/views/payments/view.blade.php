@extends('admin::layouts.dashboard')

@section('page_title')
{{ __('admin::app.settings.sources.title') }}
@stop

@section('content-wrapper')
<div class="container content-space-t-2 content-space-t-lg-2 content-space-b-2">
    <div class="row mb-3">

    
        <div class="col-12">
            <div class="card" style="width:24rem;margin:auto;">
                <div class="card-body">
                    <form action="{{route('settings.plan.store')}}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="plan name">Plan Name:</label>
                            <input type="text" class="form-control" name="name" placeholder="Enter Plan Name">
                        </div>
                        <div class="form-group">
                            <label for="price">Price:</label>
                            <input type="text" class="form-control" name="price" placeholder="Enter Price">
                        </div>
                        <div class="form-group">
                            <label for="description">Plan Description:</label>
                            <input type="text" class="form-control" name="description" placeholder="Enter Description">
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-12 mb-3">
            <form method="POST" action="{{ route('payments.store', ['plan_id' => 1]) }}" @submit.prevent="onSubmit" enctype="multipart/form-data">
                @csrf()
                <div class="page-action" style="display: inline-flex;">
                    <button class="btn btn-primary btn-md">{{ 'Plan' }}</button>
                </div>
            </form>
        </div>
        
        <div class="col-md mb-3">
        
            <!-- Card -->
            <div class="card card-lg form-check form-check-select-stretched h-100 zi-1">
                <div class="card-header text-center">
                    <!-- Form Check -->
                    <input type="radio" class="form-check-input" name="billingPricingRadio" id="billingPricingRadio1"
                        value="basic">
                    <label class="form-check-label" for="billingPricingRadio1"></label>
                    <!-- End Form Check -->

                    <span class="card-subtitle">Basic</span>
                    <h2 class="card-title display-3 text-dark">Free</h2>
                    <p class="card-text">Forever free</p>
                </div>

                <div class="card-body d-flex justify-content-center">
                    <!-- List Checked -->
                    <ul class="list-checked list-checked-primary mb-0">
                        <li class="list-checked-item">Unlimited users</li>
                        <li class="list-checked-item">Plan features</li>
                        <li class="list-checked-item">1 app</li>
                    </ul>
                    <!-- End List Checked -->
                </div>

                <div class="card-footer border-0 text-center">
                    <div class="d-grid mb-2">
                        <button type="button" class="form-check-select-stretched-btn btn btn-white">Select plan</button>
                    </div>
                    <p class="card-text small">
                        <i class="bi-question-circle me-1"></i> Terms &amp; conditions apply
                    </p>
                </div>
            </div>
            <!-- End Card -->
        </div>
        <!-- End Col -->

        <div class="col-md mb-3">
            <!-- Card -->
            <div class="card card-lg form-check form-check-select-stretched h-100 zi-1 checked">
                <div class="card-header text-center">
                    <!-- Form Check -->
                    <input type="radio" class="form-check-input" name="billingPricingRadio" id="billingPricingRadio2"
                        checked="" value="starter">
                    <label class="form-check-label" for="billingPricingRadio2"></label>
                    <!-- End Form Check -->

                    <span class="card-subtitle">Starter</span>
                    <h2 class="card-title display-3 text-dark">
                        $<span id="pricingCount1" data-hs-toggle-switch-item-options="{
                             &quot;min&quot;: 22,
                             &quot;max&quot;: 32
                           }">32</span>
                        <span class="fs-6 text-muted">/ mon</span>
                    </h2>
                    <p class="card-text">Or prepay monthly</p>
                </div>

                <div class="card-body d-flex justify-content-center">
                    <!-- List Checked -->
                    <ul class="list-checked list-checked-primary mb-0">
                        <li class="list-checked-item">3 users</li>
                        <li class="list-checked-item">Plan features</li>
                        <li class="list-checked-item">3 apps</li>
                        <li class="list-checked-item">Product support</li>
                    </ul>
                    <!-- End List Checked -->
                </div>

                <div class="card-footer border-0 text-center">
                    <div class="d-grid mb-2">
                        <button type="button" class="form-check-select-stretched-btn btn btn-white">Select plan</button>
                    </div>
                    <p class="card-text small">
                        <i class="bi-question-circle me-1"></i> Terms &amp; conditions apply
                    </p>
                </div>
            </div>
            <!-- End Card -->
        </div>
        <!-- End Col -->

        <div class="col-md mb-3">
            <!-- Card -->
            <div class="card card-lg form-check form-check-select-stretched h-100 zi-1">
                <div class="card-header text-center">
                    <!-- Form Check -->
                    <input type="radio" class="form-check-input" name="billingPricingRadio" id="billingPricingRadio3"
                        value="enterprise">
                    <label class="form-check-label" for="billingPricingRadio3"></label>
                    <!-- End Form Check -->

                    <span class="card-subtitle">Enterprise</span>
                    <h2 class="card-title display-3 text-dark">
                        $<span id="pricingCount2" data-hs-toggle-switch-item-options="{
                             &quot;min&quot;: 42,
                             &quot;max&quot;: 54
                           }">54</span>
                        <span class="fs-6 text-muted">/ mon</span>
                    </h2>
                    <p class="card-text">Or prepay annually</p>
                </div>

                <div class="card-body d-flex justify-content-center">
                    <!-- List Checked -->
                    <ul class="list-checked list-checked-primary mb-0">
                        <li class="list-checked-item">Unlimited users</li>
                        <li class="list-checked-item">Plan features</li>
                        <li class="list-checked-item">Unlimited apps</li>
                        <li class="list-checked-item">Product support</li>
                    </ul>
                    <!-- End List Checked -->
                </div>

                <div class="card-footer border-0 text-center">
                    <div class="d-grid mb-2">
                        <button type="button" class="form-check-select-stretched-btn btn btn-white">Select plan</button>
                    </div>
                    <p class="card-text small">
                        <i class="bi-question-circle me-1"></i> Terms &amp; conditions apply
                    </p>
                </div>
            </div>
            <!-- End Card -->
        </div>
        <!-- End Col -->
    </div>
</div>
@stop
