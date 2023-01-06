@extends('admin::layouts.dashboard')

@section('page_title')
    {{ __('admin::app.sales.invoices.title') }}
@stop

@section('content-wrapper')
    <div class="content full-page">
        <table-component data-src="{{ route('sales.invoices.index') }}">
            <template v-slot:table-header>
                <h1>
                    {!! view_render_event('invoices.index.header.before') !!}

                    {{ __('admin::app.sales.invoices.title') }}

                    {!! view_render_event('invoices.index.header.after') !!}
                </h1>
            </template>
        </table-component>
    </div>
@stop
