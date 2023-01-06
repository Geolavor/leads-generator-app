@extends('admin::layouts.master')

@section('page_title')
{{ __('admin::app.user.account.my_account') }}
@stop

@section('css')
<style>
    .panel-header,
    .panel-body {
        margin: 0 auto;
        max-width: 800px;
    }

</style>
@stop

@section('content-wrapper')
<div class="content full-page adjacent-center">
    <div class="row">
        <div class="col-3">
            <x-core.account.sidebar />
        </div>
        <div class="col-9">
            <div class="d-grid gap-3 gap-lg-5">
                <!-- Card -->
                <div class="card">
                    <div class="card-header border-bottom">
                        <h5 class="card-header-title">Payment method</h5>
                    </div>

                    <!-- Body -->
                    <div class="card-body">
                        <div class="mb-4">
                            <p>Cards will be charged either at the end of the month or whenever your balance exceeds the
                                usage threshold. All major credit / debit cards accepted.</p>
                        </div>

                        <!-- List Group -->
                        <ul class="list-group mb-5">

                            <!-- Item -->
                            <li class="list-group-item">
                                <div class="mb-2">
                                    <h5>{{ auth()->guard('user')->user()->name }} <span class="text-danger small ms-1" v-if="false">Expired</span></h5>
                                </div>

                                <!-- Media -->
                                @if(auth()->guard('user')->user()->pm_type)
                                <div class="d-flex">
                                    <div class="flex-shrink-0">
                                        <img class="avatar avatar-sm" src="{{ asset('vendor/leadBrowser/admin/assets/images/visa.svg') }}"
                                            alt="Image Description">
                                    </div>

                                    <div class="flex-grow-1 ms-3">
                                        <div class="row">
                                            <div class="col-sm mb-3 mb-sm-0">
                                                <span class="d-block text-dark">{{ auth()->guard('user')->user()->pm_type }} •••• {{ auth()->guard('user')->user()->pm_last_four }}</span>
                                                <small class="d-block text-muted" v-if="false">Debit - Expires 04/20</small>
                                            </div>
                                            <!-- End Col -->

                                            <div class="col-sm-auto">
                                                <div class="d-flex gap-3">
                                                    @if(false)
                                                    <a class="btn btn-white btn-xs" href="javascript:;"
                                                        data-bs-toggle="modal" data-bs-target="#accountEditCardModal">
                                                        <i class="bi-pencil-fill me-1"></i> Edit
                                                    </a>
                                                    @endif
                                                    <form method="POST" action="{{ route('user.account.delete-card') }}">
                                                        @csrf()
                                                        <button type="button" class="btn btn-white btn-xs">
                                                            <i class="bi-trash me-1"></i> Delete
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                            <!-- End Col -->
                                        </div>
                                        <!-- End Row -->
                                    </div>
                                </div>
                                @endif
                                <!-- End Media -->
                            </li>
                            <!-- End Item -->
                        </ul>
                        <!-- End List Group -->
                    </div>
                    <!-- End Body -->
                </div>
                <!-- End Card -->

                <!-- Card -->
                <div class="card">
                    <!-- Header -->
                    <div class="card-header">
                        <h5 class="card-header-title">Order history</h5>
                    </div>
                    <!-- End Header -->

                    <!-- Table -->
                    <div class="table-responsive">
                        <table class="table table-borderless table-thead-bordered table-nowrap table-align-middle">
                            <thead class="thead-light">
                                <tr>
                                    <th>Reference</th>
                                    <th>Status</th>
                                    <th>Amount</th>
                                    <th>Updated</th>
                                    <th>Invoice</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($invoices as $invoice)
                                    <tr class="p-2">
                                        <td><a href="#">#3682303</a></td>
                                        <td><span class="badge bg-soft-warning text-warning">Pending</span></td>
                                        <td>{{ $invoice->total() }}</td>
                                        <td>{{ $invoice->date()->toFormattedDateString()  }}</td>
                                        <td>
                                            <a class="btn btn-white btn-xs" href="{{ route('user.account.billing.download', $invoice->id) }}">
                                                <i class="bi-file-earmark-arrow-down-fill me-1"></i> PDF
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            @if(false)
                            <tbody>
                                @foreach($transactions as $transaction)
                                    <tr>
                                        <td>{{ $transaction->amount() }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            @endif
                        </table>
                    </div>
                    <!-- End Table -->
                </div>
                <!-- End Card -->
            </div>
        </div>
    </div>
</div>
@stop
