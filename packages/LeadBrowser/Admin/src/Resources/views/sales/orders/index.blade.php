@extends('admin::layouts.master')

@section('page_title')
    {{ __('admin::app.sales.orders.title') }}
@stop

@section('content-wrapper')
    <div class="content full-page">
        <table-component data-src="{{ route('sales.orders.index') }}">
            <template v-slot:table-header>
                <h1>
                    {!! view_render_event('orders.index.header.before') !!}

                    {{ __('admin::app.sales.orders.title') }}

                    {!! view_render_event('orders.index.header.after') !!}
                </h1>
            </template>
        </table-component>
    </div>
@stop