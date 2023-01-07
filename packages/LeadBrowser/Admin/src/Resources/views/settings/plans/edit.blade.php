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
    </div>
</div>
@stop
