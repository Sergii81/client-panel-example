@extends('layouts.main')

@section('title',  config('payment_system.app.name') .' :: '.__('balance.title'))

@section('content')

    <h3 class="page-title">@lang('balance.page_title')</h3>

    @include('layouts.partial.page_breadcrumb',  [
        'breadcrumb_text'  => __('breadcrumbs.balance'),
    ])


    <div class="row">
        @foreach($data['balances_gateway_sum'] as $balances_gateway_sum)
            <div class="col-lg-6">
                <div class="portlet box @if($balances_gateway_sum->gateway_id == 1) blue @else blue-madison @endif">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-wallet"></i>@lang('balance.table.gateway'){{$balances_gateway_sum->gateway->name}}
                            @lang('balance.table.balance'){{$balances_gateway_sum->gateway_sum}} {{$balances_gateway_sum->currency}}
                        </div>
                        <div class="tools">
                            @lang('balance.table.rolling_reserve'){{$balances_gateway_sum->gateway_rolling_reserve}} {{$balances_gateway_sum->currency}}
                        </div>
                    </div>
                    <div class="portlet box">
                        <div class="portlet-body flip-scroll">
                            <table id="table_balance_{{$balances_gateway_sum->gateway_id}}" class="table table-bordered table-striped table-condensed flip-content table-hover">
                                <thead class="flip-content">
                                <tr>
                                    <th>@lang('balance.table.table_header.th_1')</th>
                                    <th>@lang('balance.table.table_header.th_2')</th>
                                    <th>@lang('balance.table.table_header.th_3')</th>
                                    <th>@lang('balance.table.table_header.th_4')</th>
                                    <th>@lang('balance.table.table_header.th_5')</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($data["balances_gateway_$balances_gateway_sum->gateway_id"] as $k => $balance)
                                    <tr>
                                        <td>{{++$k}}</td>
                                        <td>{{$balance->sum}}</td>
                                        <td>{{$balance->available_for_payout - $balance->payout_amount}}</td>
                                        <td>{{$balance->currency}}</td>
                                        <td>{{$balance->rolling_reserve}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
                @if($data["holds_gateway_$balances_gateway_sum->gateway_id"]->isNotEmpty() && $balances_gateway_sum->rolling_reserve != 0)
                <div class="portlet box @if($balances_gateway_sum->gateway_id == 1) blue @else blue-madison @endif">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-wallet"></i>Hold шлюза {{$balances_gateway_sum->gateway->name}}
                        </div>
                    </div>
                    <div class="portlet box">
                        <div class="portlet-body flip-scroll">
                            <table id="table_hold_{{$balances_gateway_sum->gateway_id}}" class="table table-bordered table-striped table-condensed flip-content table-hover">
                                <thead class="flip-content">
                                <tr>
                                    <th>@lang('holds.table.table_header.th_1')</th>
                                    <th>@lang('holds.table.table_header.th_2')</th>
                                    <th>@lang('holds.table.table_header.th_3')</th>
                                    <th>@lang('holds.table.table_header.th_4')</th>
                                    <th>@lang('holds.table.table_header.th_5')</th>
                                    <th>@lang('holds.table.table_header.th_6')</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($data["holds_gateway_$balances_gateway_sum->gateway_id"] as $k => $hold)
                                    <tr>
                                        <td>{{++$k}}</td>
                                        <td>{{$hold->transaction_id}}</td>
                                        <td>{{$hold->transaction_amount}}</td>
                                        <td>{{$hold->outlet->name}}</td>
                                        <td>{{$hold->hold_count}}</td>
                                        <td>{{$hold->rolling_reserve}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        @endforeach
    </div>


@endsection
