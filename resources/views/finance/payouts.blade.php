@extends('layouts.main')

@section('title',  config('payment_system.app.name') .' :: '.__('payouts.title'))

@section('content')

    <h3 class="page-title">@lang('payouts.page_title')</h3>

    @include('layouts.partial.page_breadcrumb',  [
        'breadcrumb_text'  => __('breadcrumbs.payouts'),
    ])


    <div class="portlet box">
        <div class="portlet-body flip-scroll">
            <table id="table_payouts" class="table table-bordered table-striped table-condensed flip-content table-hover">
                <thead class="flip-content">
                    <tr>
                        <th>@lang('payouts.table.table_header.th_1')</th>
                        <th>@lang('payouts.table.table_header.th_2')</th>
                        <th>@lang('payouts.table.table_header.th_3')</th>
                        <th>@lang('payouts.table.table_header.th_4')</th>
                        <th>@lang('payouts.table.table_header.th_5')</th>
                        <th>@lang('payouts.table.table_header.th_6')</th>
                        <th>@lang('payouts.table.table_header.th_7')</th>
                    </tr>
                </thead>
                <tbody>

                @foreach ($data['payouts'] as $k => $payout)
                    <tr>
                        <td>{{++$k}}</td>
                        <td>{{$payout->gateway->name}}</td>
                        <td>{{$payout->amount}}</td>
                        <td>{{$payout->currency}}</td>
                        <td>{{$payout->payout_method}}</td>
                        <td>
                            @if($payout->gateway->id == 1)
                                {{$payout->card_no}}
                            @else
                                {{$payout->iban}}
                                {{$payout->benificiar}}<br>
                                {{$payout->country}}<br>
                                {{$payout->city}}<br>
                                {{$payout->address}}<br>
                                {{$payout->bank_name}}<br>
                                {{$payout->swift}}
                            @endif
                        </td>
                        <td>
                            @if($payout->status == 'created') <span class="badge badge-info">{{$payout->status}}</span> @endif
                            @if($payout->status == 'completed') <span class="badge badge-success">{{$payout->status}}</span> @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection

