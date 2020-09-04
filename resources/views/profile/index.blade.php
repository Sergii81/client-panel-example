@extends('layouts.main')

@section('title',  config('payment_system.app.name') .' :: '.__('profile.title'))

@section('content')

    <h3 class="page-title">@lang('profile.page_title')</h3>

    @include('layouts.partial.page_breadcrumb',  [
        'breadcrumb_text'  => __('breadcrumbs.profile'),
    ])

    <div class="row">
        <div class="col-md-6 ">
            <div class="portlet-body form">
                <form class="form-horizontal" role="form" method="post" action="{{route('payment_system:profile.edit')}}">
                    @csrf
                    <input type="hidden" name="user_id" value="{{$data['user']->id}}">
                    <div class="form-body">
                        <div class="form-group">
                            <label class="col-md-3 control-label" for="name">@lang('profile.edit.label_name')</label>
                            <div class="col-md-9">
                                <input type="text" id="name" class="form-control" name="name"
                                       placeholder="@lang('profile.edit.placeholder_name')" value="{{ $data['user']->name }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label" for="email">@lang('profile.edit.label_login')</label>
                            <div class="col-md-9">
                                <input type="email" id="email"
                                       name="email" class="form-control" placeholder="@lang('profile.edit.placeholder_login')" required value="{{ $data['user']->email }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label" for="password">@lang('profile.edit.label_password')</label>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <input id="password" class="form-control" type="text"
                                           name="password" placeholder="@lang('profile.edit.placeholder_password')">
                                    <span class="input-group-btn">
                                        <button id="genpassword" class="btn btn-success" type="button"
                                                onclick="$('#password').val(str_rand());return false;">
                                            <i class="fa fa-arrow-left fa-fw"></i> @lang('profile.edit.generate')
                                        </button>
                                    </span>
                                </div>
                                <span class="help-block help-block_password">
                                    @lang('clients.edit.dont_want_to_change_password')
                                </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label" for="email">@lang('profile.edit.label_payment_gateways')</label>
                            <div class="col-md-9 payment_gateways">
                                @php @endphp
                                @foreach($data['gateways'] as $gateway)
                                    <div class="checkbox-list">
                                        <label>
                                            <div class="checker">
                                                <span class="">
                                                    <input type="checkbox" name="gateway_{{$gateway->id}}" id="gateway_{{$gateway->id}}" onchange="fun_check()"
                                                           @if($data['user']->gateway_1 == $gateway->id || $data['user']->gateway_2 == $gateway->id) checked="checked" @endif>
                                                    <input type="hidden" name="gateway_id_{{$gateway->id}}" value="{{$gateway->id}}">
                                                </span>
                                            </div>
                                            {{$gateway->name}}
                                        </label>
                                    </div>

                                    <div class="portlet-body box yellow gateway_table_{{$gateway->id}}" style="display: none">
                                        <div class="table-scrollable">
                                            <table class="table table-bordered table-hover">
                                                <thead>
                                                <tr>
                                                    <th>@lang('profile.edit.settings')</th>
                                                    <th>@lang('profile.edit.values')</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td>@lang('profile.edit.currency')</td>
                                                    <td>{{$gateway->currency}}</td>
                                                </tr>
                                                <tr>
                                                    <td>@lang('profile.edit.rolling')</td>
                                                    <td>{{$gateway->rolling}}</td>
                                                </tr>
                                                <tr>
                                                    <td>@lang('profile.edit.transaction_percent')</td>
                                                    <td>{{$gateway->transaction_percent}}</td>
                                                </tr>
                                                <tr>
                                                    <td>@lang('profile.edit.transaction_cost')</td>
                                                    <td>{{$gateway->transaction_cost}}</td>
                                                </tr>
                                                <tr>
                                                    <td>@lang('profile.edit.refund')</td>
                                                    <td>{{$gateway->refund}}</td>
                                                </tr>
                                                <tr>
                                                    <td>@lang('profile.edit.chargeback')</td>
                                                    <td>{{$gateway->chargeback}}</td>
                                                </tr>
                                                <tr>
                                                    <td>@lang('profile.edit.hold')</td>
                                                    <td>{{$gateway->hold}}</td>
                                                </tr>
                                                <tr>
                                                    <td>@lang('profile.edit.min_payout')</td>
                                                    <td>{{$gateway->min_payout}}</td>
                                                </tr>
                                                <tr>
                                                    <td>@lang('profile.edit.payment_methods')</td>
                                                    <td>{{$gateway->payment_methods}}</td>
                                                </tr>
                                                <tr>
                                                    <td>@lang('profile.edit.payout_cost')</td>
                                                    <td>{{$gateway->payout_cost}}</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label" for="country">@lang('profile.edit.label_country')</label>
                            <div class="col-md-9">
                                <select class="form-control" id="country" name="country" autofocus>
                                    <option selected disabled> @lang('profile.edit.option_country') </option>
                                    @foreach($data['locations'] as $location)
                                        <option value="{{ $location['iso_3166_1_alpha2'] }}"
                                            @if ($data['user']->country != null && $location['iso_3166_1_alpha2'] == $data['user']->country) selected="selected" @endif>
                                            {{ $location['name'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label" for="state">@lang('profile.edit.label_state')</label>
                            <div class="col-md-9">
                                <input type="text" id="state" class="form-control" name="state"
                                       placeholder="@lang('profile.edit.placeholder_state')" value="{{ $data['user']->state ?? '' }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label" for="city">@lang('profile.edit.label_city')</label>
                            <div class="col-md-9">
                                <input type="text" id="city" class="form-control" name="city"
                                       placeholder="@lang('profile.edit.placeholder_city')" value="{{ $data['user']->city ?? '' }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label" for="zip">@lang('profile.edit.label_zip')</label>
                            <div class="col-md-9">
                                <input type="text" id="zip" class="form-control" name="zip"
                                       placeholder="@lang('profile.edit.placeholder_zip')" value="{{ $data['user']->zip ?? '' }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label" for="address">@lang('profile.edit.label_address')</label>
                            <div class="col-md-9">
                                <input type="text" id="address" class="form-control" name="address"
                                       placeholder="@lang('profile.edit.placeholder_address')" value="{{ $data['user']->address ?? '' }}">
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-3 col-md-9">
                                <button type="submit" class="btn green">@lang('profile.edit.button_edit')</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
