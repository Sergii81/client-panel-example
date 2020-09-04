@extends('layouts.main')

@section('title',  config('payment_system.app.name') .' :: '.__('transactions.title'))

@section('content')

    <h3 class="page-title">@lang('transactions.page_title')</h3>

    @include('layouts.partial.page_breadcrumb_add_edit',  [
        'route'                     => route('payment_system:transactions.index'),
        'breadcrumb_text'           => __('breadcrumbs.transactions'),
        'breadcrumb_text_add_edit'  => __('breadcrumbs.transaction_details'),
    ])

    <div class="row">
        <div class="col-lg-4">
            <div class="portlet box blue" >
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-basket"></i>@lang('transactions.details.title')
                    </div>
                </div>
                <div class="table-scrollable">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>@lang('transactions.details.setting')</th>
                                <th>@lang('transactions.details.value')</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>@lang('transactions.details.id')</td>
                                <td>{{ $data['transaction']->id }}</td>
                            </tr>
                            <tr>
                                <td>@lang('transactions.details.status')</td>
                                <td>{{ $data['transaction']->status }}</td>
                            </tr>

                            <tr>
                                <td>@lang('transactions.details.outlet')</td>
                                <td>{{ $data['transaction']->outlet->name }}</td>
                            </tr>
                            <tr>
                                <td>@lang('transactions.details.bayer')</td>
                                <td>{{ $data['transaction']->user_first_name }} {{ $data['transaction']->user_last_name }}</td>
                            </tr>
                            <tr>
                                <td>@lang('transactions.details.email')</td>
                                <td>{{ $data['transaction']->email }}</td>
                            </tr>
                            <tr>
                                <td>@lang('transactions.details.payment_id')</td>
                                <td>{{ $data['transaction']->ext_payment_id }}</td>
                            </tr>
                            <tr>
                                <td>@lang('transactions.details.description')</td>
                                <td>{{ $data['transaction']->ext_description }}</td>
                            </tr>
                            <tr>
                                <td>@lang('transactions.details.amount')</td>
                                <td>{{ $data['transaction']->amount }}</td>
                            </tr>
                            <tr>
                                <td>@lang('transactions.details.currency')</td>
                                <td>{{ $data['transaction']->currency }}</td>
                            </tr>
                            <tr>
                                <td>@lang('transactions.details.gateway')</td>
                                <td>{{ $data['transaction']->gateway->name }}</td>
                            </tr>
                            <tr>
                                <td>@lang('transactions.details.gateway_order_id')</td>
                                <td>{{ $data['transaction']->gateway_order_id }}</td>
                            </tr>
                            <tr>
                                <td>@lang('transactions.details.gateway_message')</td>
                                <td>{{ $data['transaction']->gateway_message }}</td>
                            </tr>
                            <tr>
                                <td>@lang('transactions.details.gateway_status')</td>
                                <td>{{ $data['transaction']->gateway_status }}</td>
                            </tr>
                            <tr>
                                <td>@lang('transactions.details.ip')</td>
                                <td>{{ $data['transaction']->ip }}</td>
                            </tr>
                            <tr>
                                <td>@lang('transactions.details.address')</td>
                                <td>{{ $data['transaction']->zip }} {{ $data['transaction']->city }} {{ $data['transaction']->state }} {{ $data['transaction']->country }}</td>
                            </tr>
                            <tr>
                                <td>@lang('transactions.details.card')</td>
                                <td>@php echo substr_replace($data['transaction']->card_no, '**** **** **** ', 0, 12) @endphp</td>
                            </tr>
                            <tr>
                                <td>@lang('transactions.details.card_date')</td>
                                <td>{{ $data['transaction']->card_month }}/{{ $data['transaction']->card_year }}</td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>


@endsection
