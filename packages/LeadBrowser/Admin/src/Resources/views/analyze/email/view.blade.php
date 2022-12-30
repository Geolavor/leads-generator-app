@extends('admin::layouts.master')

@section('page_title')
{{ __('admin::app.analyze.create-email-title') }}
@stop

@section('content-wrapper')
<div class="content full-page adjacent-center">
    {!! view_render_event('search.location.create.header.before') !!}

    <div class="page-header">
        <div class="page-title">
            <h1>{{ __('admin::app.analyze.create-email-title') }}</h1>
        </div>
    </div>

    {!! view_render_event('search.location.create.header.after') !!}

    <form action="{{ route('results.transfer', ['email' => $email]) }}" method="post" @submit.prevent="onSubmit" enctype="multipart/form-data">

        <div class="page-content">
            <div class="form-container">

                <div class="panel">
                    <div class="panel-header">
                        {!! view_render_event('analyze.create.form_buttons.before') !!}
                        
                        <a href="{{ route('search.location.index') }}">{{ __('admin::app.analyze.back') }}</a>

                        {!! view_render_event('analyze.create.form_buttons.after') !!}
                    </div>

                    <div class="panel-body">

                        <div class="custom-attribute-view">

                            <div class="attribute-value-row">
                                <div class="value">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <i class="bi bi-shield-check analyze-icon"></i>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h5 class="text-inherit mb-0">Invalid</h5>
                                            <p>This email address isn't used to receive emails.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="attribute-value-row">
                                <div class="label">E-mail</div>

                                <div class="value">
                                    <span class='badge badge-round badge-{$status}'></span>{{ $email }}
                                </div>
                            </div>

                            @if($data)
                                @foreach($data as $key => $item)
                                <div class="attribute-value-row">
                                    <div class="label">{{ __('admin::app.analyze.emails.' . $key) }}</div>

                                    <div class="value">
                                        {{ $item == 1 ? 'Yes' : 'No' }}
                                    </div>
                                </div>
                                @endforeach
                            @endif

                        </div>

                    </div>

                </div>
            </div>
        </div>

    </form>
</div>
@stop
