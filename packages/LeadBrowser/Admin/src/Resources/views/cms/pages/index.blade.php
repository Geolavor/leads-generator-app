@extends('admin::layouts.dashboard')

@section('page_title')
    {{ __('admin::app.cms.pages.title') }}
@stop

@section('content-wrapper')
    <div class="content full-page">
        <table-component data-src="{{ route('cms.pages.index') }}">
            <template v-slot:table-header>
                <h1>
                    {!! view_render_event('cms.pages.pages.before') !!}

                    {{ __('admin::app.cms.pages.title') }}

                    {!! view_render_event('cms.pages.pages.after') !!}
                </h1>
            </template>

            @if (bouncer()->hasPermission('cms.create'))
                <template v-slot:table-action>
                    <a href="{{ route('cms.pages.create') }}" class="btn btn-primary">{{ __('admin::app.cms.pages.create-title') }}</a>
                </template>
            @endif
        </table-component>
    </div>
@stop
