@extends('layouts.main')

@section('title',  config('payment_system.app.name') .' :: '.__('payouts_create.title'))

@section('content')

    <h3 class="page-title">@lang('payouts_create.page_title')</h3>

    @include('layouts.partial.page_breadcrumb_add_edit',  [
        'route'                     => route('payment_system:finance.payouts_create_form'),
        'breadcrumb_text'           => __('breadcrumbs.payouts_create'),
        'breadcrumb_text_add_edit'  => __('breadcrumbs.payouts_create_platio'),
    ])

    @php $gateway = $data['gateway'] @endphp
    <div class="row">
        <div class="col-md-6">
            <div class="portlet box blue">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-wallet"></i>{{$gateway->name}}
                        <span>@lang('payouts_create.placeholder_amount_1', ['amount' => $data['amount']->amount]) {{$data['amount']->currency}}</span>
                    </div>
                </div>
                <div class="portlet-body form">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form class="form-horizontal" role="form" method="post" action="{{route('payment_system:finance.payouts_create')}}">
                        @csrf
                        <input type="hidden" name="client_id" value="{{auth()->user()->id}}">
                        <input type="hidden" name="gateway_id" value="{{$gateway->id}}">
                        <input type="hidden" name="gateway_payment_method" value="{{$gateway->payment_methods}}">
                        <input type="hidden" name="gateway_currency" value="{{$data['amount']->currency}}">
                        <div class="form-body">
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="amount">@lang('payouts_create.label_amount')</label>
                                <div class="col-md-9">
                                    <input type="number" id="amount" min="{{$gateway->min_payout}}" max="{{$data['amount']->amount}}" class="form-control @error('amount') is-invalid @enderror" name="amount"
                                           placeholder="@lang('payouts_create.placeholder_amount_1', ['amount' => $data['amount']->amount]) {{$data['amount']->currency}}" value="{{ old('amount') }}" onchange="min_max_interval(this);">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="card_no">@lang('payouts_create.label_card_no')</label>
                                <div class="col-md-9">
                                    <input type="text" id="card_no" class="form-control @error('card_no') is-invalid @enderror" name="card_no"
                                           placeholder="@lang('payouts_create.placeholder_card_no')"  value="{{ old('card_no') }}">
                                </div>
                            </div>
                            <div class="form-actions">
                                <div class="row">
                                    <div class="col-md-offset-3 col-md-9">
                                        <button type="submit" class="btn blue" >@lang('payouts_create.button_create')</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
