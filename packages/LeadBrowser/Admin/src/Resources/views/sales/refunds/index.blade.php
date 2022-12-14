@extends('admin::layouts.master')

@section('page_title')
    {{ __('admin::app.sales.refunds.title') }}
@stop

@section('content-wrapper')
    <div class="content full-page">
        <table-component data-src="{{ route('sales.refunds.index') }}">
            <template v-slot:table-header>
                <h1>
                    {!! view_render_event('refunds.index.header.before') !!}

                    {{ __('admin::app.sales.refunds.title') }}

                    {!! view_render_event('refunds.index.header.after') !!}
                </h1>
            </template>
        </table-component>
    </div>
@stop