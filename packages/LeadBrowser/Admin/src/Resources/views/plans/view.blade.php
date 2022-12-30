@extends('admin::layouts.master')

@section('page_title')
{{ __('admin::app.settings.sources.title') }}
@stop

@section('content-wrapper')
<div class="container content-space-t-2 content-space-t-lg-2 content-space-b-2">

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="">
                <p>You will be charged ${{ number_format($plan->price, 2) }} for {{ $plan->name }} Plan</p>
            </div>
            <div class="card">
                <form>
                    <div class="page-content">
                        <div class="form-container">

                            <div class="panel">
                                <div class="panel-body">

                                    <card-payment
                                        :plan_id="'{{ $plan->id }}'"
                                        :stripe_key="'{{ env('STRIPE_KEY') }}'"
                                    ></card-payment>

                                </div>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
@stop
