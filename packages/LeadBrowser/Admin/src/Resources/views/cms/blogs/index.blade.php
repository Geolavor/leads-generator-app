@extends('admin::layouts.master')

@section('page_title')
    {{ __('admin::app.cms.blogs.title') }}
@stop

@section('content-wrapper')
    <div class="content full-page">
        <table-component data-src="{{ route('cms.blogs.index') }}">
            <template v-slot:table-header>
                <h1>
                    {!! view_render_event('cms.blogs.blogs.before') !!}

                    {{ __('admin::app.cms.blogs.title') }}

                    {!! view_render_event('cms.blogs.blogs.after') !!}
                </h1>
            </template>

            @if (bouncer()->hasPermission('cms.create'))
                <template v-slot:table-action>
                    <a href="{{ route('cms.blogs.create') }}" class="btn btn-primary">{{ __('admin::app.cms.blogs.create-title') }}</a>
                </template>
            @endif
        </table-component>
    </div>
@stop
