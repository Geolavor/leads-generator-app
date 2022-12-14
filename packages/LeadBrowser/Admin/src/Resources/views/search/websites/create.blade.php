@extends('admin::layouts.master')

@section('page_title')
    {{ __('admin::app.search.create-title') }}
@stop

@section('content-wrapper')
    <div class="content full-page adjacent-center">
        {!! view_render_event('search.websites.create.header.before') !!}

        <div class="page-header">

            <div class="page-title">
                <h1>{{ __('admin::app.search.create-title') }}</h1>
            </div>
        </div>

        {!! view_render_event('search.websites.create.header.after') !!}

        <div class="card" style="background: azure;">
            <div class="card-body">
                <div class="row col-md-divider align-items-md-center">
                    <div class="col-md-9">
                        <h3>Bonus for you</h3>
                        <p>With each search, you will also get it completely free of charge if the data is available online.</p>

                        <div class="row">
                            <div class="col-sm-6">
                                <!-- List Checked -->
                                <ul class="list-checked list-checked-bg-success list-checked-sm mb-0">
                                    <li class="list-checked-item">E-mails verification</li>
                                    <li class="list-checked-item">Company rating</li>
                                </ul>
                                <!-- End List Checked -->
                            </div>
                            <!-- End Col -->

                            <div class="col-sm-6">
                                <!-- List Checked -->
                                <ul class="list-checked list-checked-bg-success list-checked-sm mb-0">
                                    <li class="list-checked-item">Employes data <span
                                            class="badge bg-soft-secondary text-dark rounded-pill ms-1">Beta</span></li>
                                    <li class="list-checked-item">Risk value</li>
                                </ul>
                                <!-- End List Checked -->
                            </div>
                            <!-- End Col -->
                        </div>
                        <!-- End Row -->
                    </div>
                    <!-- End Col -->

                    <div class="col-md-3">
                        <div class="ps-md-2">
                            <h4>API</h4>
                            <p>You can use this functionality through our API.</p>
                            <a class="link" href="https://mariuszmalek.notion.site/API-v1-5a61fbeb57f54b72adc81b4f9af62acd" target="_blank">Get Started <i class="bi-chevron-right small ms-1"></i></a>
                        </div>
                    </div>
                    <!-- End Col -->
                </div>
                <!-- End Row -->
            </div>
        </div>

        <form
            method="POST"
            action="{{ !isset($csv_data) ? route('search.websites.store') : route('search.websites.save') }}"
            @submit.prevent="onSubmit"
            enctype="multipart/form-data"
        >

            <div class="page-content">
                <div class="form-container">

                    @csrf()

                    @if (!isset($csv_data))
                        <div class="panel">
                            
            
                            <div class="panel-body">

                                {!! view_render_event('search.websites.create.form_controls.before') !!}

                                @include('admin::common.custom-attributes.edit', [
                                    'customAttributes' => app('LeadBrowser\Attribute\Repositories\AttributeRepository')->findWhere([
                                        'entity_type' => 'search_websites',
                                    ]),
                                ])

                                <span>or</span>

                                <div class="form-group">
                                    <attachment-wrapper></attachment-wrapper>
                                </div>

                                <button type="submit" class="btn btn-primary">
                                    {{ __('admin::app.search.save-btn-title') }}
                                </button>

                                {!! view_render_event('search.websites.create.form_controls.after') !!}

                            </div>
                        </div>
                    @endif

                    @if (isset($csv_data) && $csv_data_file)

                    <input type="hidden" name="csv_data_file_id" value="{{ $csv_data_file->id }}"/>

                    <div class="panel">

                        <div class="panel-header">
                            {!! view_render_event('search.websites.create.form_buttons.before') !!}

                            <button type="submit" class="btn btn-primary">
                                {{ __('admin::app.search.save-btn-title') }}
                            </button>

                            <a href="{{ route('search.websites.index') }}">{{ __('admin::app.search.back') }}</a>

                            {!! view_render_event('search.websites.create.form_buttons.after') !!}
                        </div>
                        
                        <div class="panel-body table-responsive">
                            <table class="min-w-full divide-y divide-gray-200 border">
                                @if (isset($headings))
                                    <thead>
                                    <tr>
                                        @foreach ($headings[0][0] as $csv_header_field)
                                            {{--                                            @dd($headings)--}}
                                            <th class="px-6 py-3 bg-gray-50">
                                                <span class="text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">{{ $csv_header_field }}</span>
                                            </th>
                                        @endforeach
                                    </tr>
                                    </thead>
                                @endif

                                <tbody class="bg-white divide-y divide-gray-200 divide-solid">
                                @foreach($csv_data as $row)
                                    <tr class="bg-white">
                                        @foreach ($row as $key => $value)
                                            <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                                                {{ $value }}
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach

                                <tr>
                                    @foreach ($csv_data[0] as $key => $value)
                                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                                            <select name="fields[{{ $key }}]">
                                                @foreach (config('extractor.websites.db_fields') as $db_field)
                                                    <option value="{{ (\Request::has('header')) ? $db_field : $loop->index }}" @if ($key === $db_field) selected @endif>{{ $db_field }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    @endforeach
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endif

                </div>

            </div>

        </form>

    </div>
@stop