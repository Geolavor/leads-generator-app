@extends('admin::layouts.master')

@section('page_title')
{{ __('admin::app.analyze.create-website-title') }}
@stop

@section('content-wrapper')
<div class="content full-page adjacent-center">
    {!! view_render_event('search.location.create.header.before') !!}

    <div class="page-header">
        <div class="page-title">
            <h1>{{ __('admin::app.analyze.create-website-title') }}</h1>
        </div>
    </div>

    {!! view_render_event('search.location.create.header.after') !!}

    <div class="page-content">
        <div class="form-container">

            <div class="panel">
                <div class="panel-header">
                    {!! view_render_event('analyze.create.form_buttons.before') !!}

                    <a href="{{ route('search.location.index') }}">{{ __('admin::app.analyze.back') }}</a>

                    {!! view_render_event('analyze.create.form_buttons.after') !!}
                </div>

                <div class="panel-body">

                    @if ($data && isset($data))
                        <div class="custom-attribute-view">

                            @if ($data['logotype'])
                            <div class="attribute-value-row">
                                <img class="profile-pic" style="background: #EFF0F5;max-width:200px;margin-bottom:10px"
                                    src="{{ $data['logotype'] }}">
                            </div>
                            @endif

                            <div class="attribute-value-row">
                                <div class="label">Visitors</div>

                                <div class="value">
                                    + 1,000 / month
                                </div>
                            </div>

                            <div class="attribute-value-row">
                                <div class="label">Tax number</div>

                                <div class="value">
                                    @foreach ($data['taxs'] as $item)
                                    <span class="multi-value">
                                        {{ $item }}
                                    </span>
                                    @endforeach
                                </div>
                            </div>

                            @if($data && isset($data['emails']))
                            <div class="attribute-value-row">
                                <div class="label">Emails</div>

                                <div class="value">
                                    @foreach ($data['emails'] as $item)
                                        <span class="multi-value">
                                            <v-menu>
                                                <span class="email-status email-status-sm email-status-primary" style="width: 10px;height: 10px;background: #00cd00;display: inline-block;border-radius: 50%;"></span>
                                                
                                                <span style="cursor:pointer">{{ $item['value'] }}</span>
                                                <span>{{ ' (' . $item['type'] . ')'}}</span>
                                            </v-menu>
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                            @endif

                            <div class="attribute-value-row">
                                <div class="label">Social-media</div>

                                <div class="value">
                                    @foreach ($data['social'] as $item)
                                    <span class="multi-value">
                                        {{ $item }}
                                    </span>
                                    @endforeach
                                </div>
                            </div>

                        </div>
                    @endif

                </div>
                
            </div>
        </div>
    </div>
</div>
@stop
