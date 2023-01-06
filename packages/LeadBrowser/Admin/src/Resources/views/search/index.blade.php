@extends('admin::layouts.dashboard')

@section('page_title')
    {{ __('admin::app.search.title') }}
@stop

@section('content-wrapper')
    <div class="content full-page">

        <div class="page-header">
            
            {{ Breadcrumbs::render('search') }}

            <div class="page-title">
                <h1>
                    {{ __('admin::app.search.title') }}
                </h1>
            </div>
        </div>

        <div class="page-content settings-container">
            @php($menu = Menu::prepare())

            @foreach ($menu->items['search']['children'] as $setting)
                <div class="panel">
                    <div class="panel-header">
                        <h3>{{ $setting['name'] }}

                        @if(!empty($setting['tooltip']))
                            <a v-tooltip="'{{ $setting['tooltip'] }}'">
                                <i class="bi bi-info-circle"></i>
                            </a>
                        @endif

                        </h3>

                        <p>{{ __($setting['info']) }}</p>
                    </div>
                    
                    <div class="panel-body">
                        <div class="setting-link-container">

                            @foreach ($setting['children'] as $subSetting)

                                <div class="setting-link-item {{ $subSetting['class'] ?? '' }}">
                                    <a href="{{ $subSetting['url'] }}">
                                        <div class="icon-container">
                                            <i class="icon bi {{ $subSetting['icon-class'] ?? '' }}"></i>
                                        </div>
                                        
                                        <div class="setting-info">
                                            <label>{{ $subSetting['name'] }}</label>

                                            @if($subSetting['free'] ?? false)
                                                <span class="badge badge-sm badge-success">Free</span>
                                            @endif
                                            
                                            <p>{{ __($subSetting['info'] ?? '') }}</p>
                                        </div>
                                    </a>
                                </div>

                            @endforeach

                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@stop
