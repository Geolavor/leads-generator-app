@extends('admin::layouts.dashboard')

@section('page_title')
    {{ __('admin::app.sales.transactions.title') }}
@stop

@section('content-wrapper')
    <div class="content full-page">
        <table-component data-src="{{ route('sales.transactions.index') }}">
            <template v-slot:table-header>
                <h1>
                    {!! view_render_event('transactions.index.header.before') !!}

                    {{ __('admin::app.sales.transactions.title') }}

                    {!! view_render_event('transactions.index.header.after') !!}
                </h1>
            </template>
        </table-component>
    </div>
@stop
