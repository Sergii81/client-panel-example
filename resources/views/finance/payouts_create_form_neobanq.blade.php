@extends('layouts.main')

@section('title',  config('payment_system.app.name') .' :: '.__('payouts_create.title'))

@section('content')

    <h3 class="page-title">@lang('payouts_create.page_title')</h3>

    @include('layouts.partial.page_breadcrumb_add_edit',  [
        'route'                     => route('payment_system:finance.payouts_create_form'),
        'breadcrumb_text'           => __('breadcrumbs.payouts_create'),
        'breadcrumb_text_add_edit'  => __('breadcrumbs.payouts_create_neobanq'),
    ])


    @php $gateway = $data['gateway'] @endphp
    <div class="row">
        <div class="col-md-6">
            <div class="portlet box blue-madison">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-wallet"></i>{{$gateway->name}}
                        <span>
                            @if($gateway->min_payout < $data['amount']->amount)  @lang('payouts_create.placeholder_amount_2', ['min' => $gateway->min_payout, 'max' => $data['amount']->amount])
                            @else @lang('payouts_create.placeholder_amount_3', ['min' => $gateway->min_payout])
                            @endif
                            {{$data['amount']->currency}}

                        </span>
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
                                <label class="col-md-3 control-label" for="amount_2">@lang('payouts_create.label_amount')</label>
                                <div class="col-md-9">
                                    <input type="number" id="amount" min="{{$gateway->min_payout}}" max="{{$data['amount']->amount}}" class="form-control @error('amount_2') is-invalid @enderror" name="amount"
                                           @if($gateway->min_payout < $data['amount']->amount)  placeholder="@lang('payouts_create.placeholder_amount_2', ['min' => $gateway->min_payout, 'max' => $data['amount']->amount]) {{$data['amount']->currency}}"
                                           @else placeholder="@lang('payouts_create.placeholder_amount_3', ['min' => $gateway->min_payout]) {{$data['amount']->currency}}" disabled
                                           @endif
                                           value="{{ old('amount_2') }}" onchange="min_max_interval(this);" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="iban">@lang('payouts_create.label_iban')</label>
                                <div class="col-md-9">
                                    <input type="text" id="iban" class="form-control @error('iban') is-invalid @enderror" name="iban"
                                           placeholder="@lang('payouts_create.placeholder_iban')"  value="{{ old('iban') }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="beneficiary">@lang('payouts_create.label_beneficiary')</label>
                                <div class="col-md-9">
                                    <input type="text" id="beneficiary" class="form-control @error('beneficiary') is-invalid @enderror" name="beneficiary"
                                           placeholder="@lang('payouts_create.placeholder_beneficiary')"  value="{{ old('beneficiary') }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="country">@lang('payouts_create.label_country')</label>
                                <div class="col-md-9">
                                    <select class="form-control" id="country" name="country" autofocus>
                                        <option selected disabled> @lang('payouts_create.option_country') </option>
                                        @foreach($data['locations'] as $location)
                                            <option value="{{ $location['iso_3166_1_alpha2'] }}"
                                                @if ($location['iso_3166_1_alpha2'] == auth()->user()->country) selected="selected" @endif>
                                                {{ $location['name'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="city">@lang('payouts_create.label_city')</label>
                                <div class="col-md-9">
                                    <input type="text" id="city" class="form-control @error('city') is-invalid @enderror" name="city"
                                           placeholder="@lang('payouts_create.placeholder_city')"  value="{{ auth()->user()->city ?? '' }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="address">@lang('payouts_create.label_address')</label>
                                <div class="col-md-9">
                                    <input type="text" id="address" class="form-control @error('address') is-invalid @enderror" name="address"
                                           placeholder="@lang('payouts_create.placeholder_address')"  value="{{ auth()->user()->address ?? '' }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="bank_name">@lang('payouts_create.label_bank_name')</label>
                                <div class="col-md-9">
                                    <input type="text" id="bank_name" class="form-control @error('bank_name') is-invalid @enderror" name="bank_name"
                                           placeholder="@lang('payouts_create.placeholder_bank_name')"  value="{{ old('bank_name') }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="swift">@lang('payouts_create.label_swift')</label>
                                <div class="col-md-9">
                                    <input type="text" id="swift" class="form-control @error('swift') is-invalid @enderror" name="swift"
                                           placeholder="@lang('payouts_create.placeholder_swift')"  value="{{ old('swift') }}">
                                </div>
                            </div>
                            <div class="form-actions">
                                <div class="row">
                                    <div class="col-md-offset-3 col-md-9">
                                        <button type="submit" class="btn blue-madison @if($gateway->min_payout > $data['amount']->amount) disabled @endif">@lang('payouts_create.button_create')</button>
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
