@extends('admin::layouts.master')

@section('page_title')
    {{ __('admin::app.sales.invoices.add-title') }}
@stop

@section('content-wrapper')
    <div class="content full-page">
        <form method="POST" action="{{ route('sales.invoices.store', $order->id) }}" @submit.prevent="onSubmit">
            @csrf()

            <div class="page-header">
                <div class="page-title">
                    <h1>
                        <i class="icon angle-left-icon back-link" onclick="window.location = '{{ route('sales.invoices.index') }}'"></i>

                        {{ __('admin::app.sales.invoices.add-title') }}
                    </h1>
                </div>

                <div class="page-action">
                    <button type="submit" class="btn btn-lg btn-primary">
                        {{ __('admin::app.sales.invoices.save-btn-title') }}
                    </button>
                </div>
            </div>

            <div class="page-content">
                <div class="sale-container">

                    <accordian title="{{ __('admin::app.sales.orders.order-and-account') }}" :active="true">
                        <div slot="body">

                            <div class="sale">
                                <div class="sale-section">
                                    <div class="secton-title">
                                        <span>{{ __('admin::app.sales.orders.order-info') }}</span>
                                    </div>

                                    <div class="section-content">
                                        <div class="row">
                                            <span class="title">
                                                {{ __('admin::app.sales.invoices.order-id') }}
                                            </span>

                                            <span class="value">
                                                <a href="{{ route('sales.orders.view', $order->id) }}">#{{ $order->increment_id }}</a>
                                            </span>
                                        </div>

                                        <div class="row">
                                            <span class="title">
                                                {{ __('admin::app.sales.orders.order-date') }}
                                            </span>

                                            <span class="value">
                                                {{ $order->created_at }}
                                            </span>
                                        </div>

                                        <div class="row">
                                            <span class="title">
                                                {{ __('admin::app.sales.orders.order-status') }}
                                            </span>

                                            <span class="value">
                                                {{ $order->status_label }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="sale-section">
                                    <div class="secton-title">
                                        <span>{{ __('admin::app.sales.orders.account-info') }}</span>
                                    </div>

                                    <div class="section-content">
                                        <div class="row">
                                            <span class="title">
                                                {{ __('admin::app.sales.orders.customer-name') }}
                                            </span>

                                            <span class="value">
                                                {{ $order->customer_full_name }}
                                            </span>
                                        </div>

                                        <div class="row">
                                            <span class="title">
                                                {{ __('admin::app.sales.orders.email') }}
                                            </span>

                                            <span class="value">
                                                {{ $order->customer_email }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </accordian>

                    <accordian title="{{ __('admin::app.sales.orders.products-ordered') }}" :active="true">
                        <div slot="body">

                            <div class="table">
                                <div class="table-responsive">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>{{ __('admin::app.sales.orders.SKU') }}</th>
                                                <th>{{ __('admin::app.sales.orders.product-name') }}</th>
                                                <th>{{ __('admin::app.sales.invoices.qty-ordered') }}</th>
                                                <th>{{ __('admin::app.sales.invoices.qty-to-invoice') }}</th>
                                            </tr>
                                        </thead>

                                        <tbody>

                                            @foreach ($order->items as $item)
                                                @if ($item->qty_to_invoice > 0)
                                                    <tr>
                                                        <td>{{ $item->getTypeInstance()->getOrderedItem($item)->sku }}</td>
                                                        <td>
                                                            {{ $item->name }}

                                                            @if (isset($item->additional['attributes']))
                                                                <div class="item-options">

                                                                    @foreach ($item->additional['attributes'] as $attribute)
                                                                        <b>{{ $attribute['attribute_name'] }} : </b>{{ $attribute['option_label'] }}</br>
                                                                    @endforeach

                                                                </div>
                                                            @endif
                                                        </td>
                                                        <td>{{ $item->qty_ordered }}</td>
                                                        <td>
                                                            <div class="control-group" :class="[errors.has('invoice[items][{{ $item->id }}]') ? 'has-error' : '']">
                                                                <input type="text" v-validate="'required|numeric|min:0'" class="control" id="invoice[items][{{ $item->id }}]" name="invoice[items][{{ $item->id }}]" value="{{ $item->qty_to_invoice }}" data-vv-as="&quot;{{ __('admin::app.sales.invoices.qty-to-invoice') }}&quot;"/>

                                                                <span class="control-error" v-if="errors.has('invoice[items][{{ $item->id }}]')">
                                                                    @verbatim
                                                                        {{ errors.first('invoice[items][<?php echo $item->id ?>]') }}
                                                                    @endverbatim
                                                                </span>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </accordian>

                </div>
            </div>
        </form>
    </div>
@stop