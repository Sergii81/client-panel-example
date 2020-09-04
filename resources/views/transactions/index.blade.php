@extends('layouts.main')

@section('title',  config('payment_system.app.name') .' :: '.__('transactions.title'))

@section('content')

    <h3 class="page-title">@lang('transactions.page_title')</h3>

    @include('layouts.partial.page_breadcrumb',  [
        'breadcrumb_text'  => __('breadcrumbs.transactions'),
    ])

    <div class="row">
{{--        <div class="col-xs-3">--}}
{{--            <div class="form-group">--}}
{{--                <label for="select_client">@lang('transactions.table.select_client')</label>--}}
{{--                <select id="select_client" multiple="multiple" class="form-control select_client" name="select_client[]" style="width: 100%">--}}
{{--                </select>--}}
{{--            </div>--}}
{{--        </div>--}}
        <div class="col-lg-3">
            <div class="form-group">
                <label for="select_outlet">@lang('transactions.table.select_outlet')</label>
                <select id="select_outlet" multiple="multiple" class="form-control select_outlet" name="select_outlet[]" style="width: 100%">
                </select>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="form-group">
                <label for="select_gateway">@lang('transactions.table.select_gateway')</label>
                <select id="select_gateway" multiple="multiple" class="form-control select_gateway" name="select_gateway[]" style="width: 100%">
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <form action="{{route('payment_system:transactions.index')}}" id="transaction_range_form" method="get">
            <div class="col-lg-3">
                <div class="form-group">
                    <label>@lang('transactions.table.select_period')</label>
                    <div class="input-group input-large date-picker input-daterange" data-date="2020-01-31" data-date-format="yyyy-mm-dd">
                        <span class="input-group-addon"> @lang('transactions.table.from') </span>
                        <input type="text" class="form-control" name="transaction_from" value="{{ $data['date_from'] }}">
                        <span class="input-group-addon"> @lang('transactions.table.to') </span>
                        <input type="text" class="form-control" name="transaction_to" value="{{ $data['date_to'] }}">
                    </div>
                </div>

            </div>
            <div class="col-lg-3">
                <button class="btn btn-primary submit_transaction_period" type="submit">@lang('transactions.table.button_transaction_period')</button>
            </div>
        </form>

    </div>

    <div class="portlet box">
        <div class="portlet-body flip-scroll">
            <table id="table_transactions" class="table table-bordered table-striped table-condensed flip-content table-hover">
                <thead class="flip-content">
                <tr>
                    <th>@lang('transactions.table.table_header.th_1')</th>
                    <th>@lang('transactions.table.table_header.th_2')</th>
                    <th>@lang('transactions.table.table_header.th_3')</th>
                    <th>@lang('transactions.table.table_header.th_4')</th>
                    <th>@lang('transactions.table.table_header.th_5')</th>
                    <th>@lang('transactions.table.table_header.th_6')</th>
                    <th>@lang('transactions.table.table_header.th_7')</th>
                    <th>@lang('transactions.table.table_header.th_8')</th>
                    <th>@lang('transactions.table.table_header.th_9')</th>
                    <th>@lang('transactions.table.table_header.th_10')</th>
                    <th>@lang('transactions.table.table_header.th_11')</th>
                    <th>@lang('transactions.table.table_header.th_12')</th>
                </tr>
                </thead>
                <tbody>

                @foreach ($data['transactions'] as $k => $transaction)
                    <tr>
                        <td>{{$transaction->id}}</td>
                        <td>{{$transaction->outlet->name}}</td>
                        <td>{{$transaction->gateway->name}}</td>
                        <td>{{$transaction->amount}}</td>
                        <td>{{$transaction->currency}}</td>
                        <td>комиссия</td>
                        <td>{{$transaction->status}}</td>
                        <td>{{$transaction->user_first_name}} {{$transaction->user_last_name}}</td>
                        <td>{{$transaction->email}} </td>
                        <td>@if (!empty($transaction->card_no))   {{ substr_replace($transaction->card_no, '**** **** **** ', 0, 12) }} @endif</td>
                        <td>{{$transaction->created_at}}</td>

                        <td>
                            <a href="{{ route('payment_system:transactions.show_details', $transaction->id) }}" class="btn blue btn-xs client_edit">
                                @lang('transactions.table.button_more_details')
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
                {{--                <tfoot>--}}
                {{--                <tr>--}}
                {{--                    <th>@lang('transactions.table.table_footer.th_1')</th>--}}
                {{--                    <th>@lang('transactions.table.table_footer.th_2')</th>--}}
                {{--                    <th>@lang('transactions.table.table_footer.th_3')</th>--}}
                {{--                    <th>@lang('transactions.table.table_footer.th_4')</th>--}}
                {{--                    <th>@lang('transactions.table.table_footer.th_5')</th>--}}
                {{--                    <th>@lang('transactions.table.table_footer.th_6')</th>--}}
                {{--                    <th>@lang('transactions.table.table_footer.th_7')</th>--}}
                {{--                    <th>@lang('transactions.table.table_footer.th_8')</th>--}}
                {{--                    <th>@lang('transactions.table.table_footer.th_9')</th>--}}
                {{--                    <th>@lang('transactions.table.table_footer.th_10')</th>--}}
                {{--                    <th>@lang('transactions.table.table_footer.th_11')</th>--}}
                {{--                    <th>@lang('transactions.table.table_footer.th_12')</th>--}}
                {{--                </tr>--}}
                {{--                </tfoot>--}}
            </table>
        </div>
    </div>

@endsection
