@extends('layouts.main')

@section('title',  config('payment_system.app.name') .' :: '.__('payouts_create.title'))

@section('content')

    <h3 class="page-title">@lang('payouts_create.page_title')</h3>

    @include('layouts.partial.page_breadcrumb',  [
        'breadcrumb_text'  => __('breadcrumbs.payouts_create'),
    ])

    <div class="row">
        <div class="col-md-6 ">
            <div class="portlet-body form">

                <div class="form-group">
                    <label class="col-md-3 control-label" for="email">@lang('payouts_create.label_payment_gateways')</label>
                    <div class="col-md-9 payment_gateways">
                        <div class="radio-list">
                            @if(!empty($data['gateway_1']))
                                @php $gateway_1 = $data['gateway_1']; @endphp
                                <a href="{{route('payment_system:finance.payouts_create_form_gateway_name', $gateway_1->id)}}" class="btn blue">
                                    <i class="icon-wallet"></i>{{$gateway_1->name}}
                                </a>
                            @endif
                            @if(!empty($data['gateway_2']))
                                @php $gateway_2 = $data['gateway_2']; @endphp
                                <a href="{{route('payment_system:finance.payouts_create_form_gateway_name', $gateway_2->id)}}" class="btn blue-madison">
                                    <i class="icon-wallet"></i>{{$gateway_2->name}}
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
