@extends('layouts.main')

@section('title',  config('payment_system.app.name') .' :: '.__('outlets.add.title'))

@section('content')

    <h3 class="page-title">@lang('outlets.add.page_title')</h3>

    @include('layouts.partial.page_breadcrumb_add_edit',  [
        'route'                     => route('payment_system:outlets.index'),
        'breadcrumb_text'           => __('breadcrumbs.outlets'),
        'breadcrumb_text_add_edit'  => __('breadcrumbs.add.outlets'),
    ])

    <div class="row">
        <div class="col-md-6 ">
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
                <form class="form-horizontal" role="form" method="post" action="{{route('payment_system:outlets.add')}}">
                    @csrf
                    <input type="hidden" name="client_id" value="{{auth()->user()->id}}">
                    <div class="form-body">
                        <div class="form-group">
                            <label class="col-md-3 control-label" for="name">@lang('outlets.add_edit.label_name')</label>
                            <div class="col-md-9">
                                <input type="text" id="name" class="form-control @error('name') is-invalid @enderror" name="name"
                                       placeholder="@lang('outlets.add_edit.placeholder_name')" required value="{{old('name')}}">
                                {{--                                <span class="help-block">--}}
                                {{--											A block of help text. </span>--}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label" for="outlet_url">@lang('outlets.add_edit.label_outlet_url')</label>
                            <div class="col-md-9">
                                <input type="text" id="outlet_url" name="outlet_url" class="form-control @error('outlet_url') is-invalid @enderror"
                                       placeholder="@lang('outlets.add_edit.placeholder_outlet_url')" required value="{{old('outlet_url')}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label" for="email">@lang('outlets.add_edit.label_payment_gateways')</label>
                            <div class="col-md-9 payment_gateways">
                                @foreach($data['gateways'] as $gateway)
                                    <div class="checkbox-list">
                                        <label>
                                            <div class="checker">
                                                <span class="">
                                                    <input type="checkbox" name="gateway_{{$gateway->id}}" id="gateway_{{$gateway->id}}" onchange="fun_check()">
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
                                                    <th>@lang('outlets.add_edit.settings')</th>
                                                    <th>@lang('outlets.add_edit.values')</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td>@lang('outlets.add_edit.currency')</td>
                                                    <td>{{$gateway->currency}}</td>
                                                </tr>
                                                <tr>
                                                    <td>@lang('outlets.add_edit.rolling')</td>
                                                    <td>{{$gateway->rolling}}</td>
                                                </tr>
                                                <tr>
                                                    <td>@lang('outlets.add_edit.transaction_percent')</td>
                                                    <td>{{$gateway->transaction_percent}}</td>
                                                </tr>
                                                <tr>
                                                    <td>@lang('outlets.add_edit.transaction_cost')</td>
                                                    <td>{{$gateway->transaction_cost}}</td>
                                                </tr>
                                                <tr>
                                                    <td>@lang('outlets.add_edit.refund')</td>
                                                    <td>{{$gateway->refund}}</td>
                                                </tr>
                                                <tr>
                                                    <td>@lang('outlets.add_edit.chargeback')</td>
                                                    <td>{{$gateway->chargeback}}</td>
                                                </tr>
                                                <tr>
                                                    <td>@lang('outlets.add_edit.hold')</td>
                                                    <td>{{$gateway->hold}}</td>
                                                </tr>
                                                <tr>
                                                    <td>@lang('outlets.add_edit.min_payout')</td>
                                                    <td>{{$gateway->min_payout}}</td>
                                                </tr>
                                                <tr>
                                                    <td>@lang('outlets.add_edit.payment_methods')</td>
                                                    <td>{{$gateway->payment_methods}}</td>
                                                </tr>
                                                <tr>
                                                    <td>@lang('outlets.add_edit.payout_cost')</td>
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
                            <label class="col-md-3 control-label">@lang('outlets.add_edit.label_outlet_status')</label>
                            <div class="col-md-9">
                                <div class="radio-list">
                                    <label class="radio-inline">
                                        <div class="radio">
                                            <span class="">
                                                <input type="radio" name="outlet_status" value="test" checked>
                                            </span>
                                        </div>
                                        @lang('outlets.add_edit.label_radio_test')
                                    </label>
                                    <label class="radio-inline ">
                                        <div class="radio">
                                            <span class="">
                                                <input type="radio" name="outlet_status" value="active" >
                                            </span>
                                        </div>
                                        @lang('outlets.add_edit.label_radio_active')
                                    </label>

                                </div>
                            </div>

                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label" for="success_url">@lang('outlets.add_edit.label_success_url')</label>
                            <div class="col-md-9">
                                <input type="text" id="success_url" class="form-control @error('success_url') is-invalid @enderror" name="success_url"
                                       placeholder="@lang('outlets.add_edit.placeholder_success_url')" required value="{{ old('success_url') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label" for="failed_url">@lang('outlets.add_edit.label_failed_url')</label>
                            <div class="col-md-9">
                                <input type="text" id="failed_url" class="form-control @error('failed_url') is-invalid @enderror" name="failed_url"
                                       placeholder="@lang('outlets.add_edit.placeholder_failed_url')" required value="{{ old('failed_url') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label" for="callback_url">@lang('outlets.add_edit.label_callback_url')</label>
                            <div class="col-md-9">
                                <input type="text" id="callback_url" class="form-control @error('callback_url') is-invalid @enderror" name="callback_url"
                                       placeholder="@lang('outlets.add_edit.placeholder_callback_url')" required value="{{ old('callback_url') }}">
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-3 col-md-9">
                                <a href="{{route('payment_system:outlets.index')}}" type="button" class="btn default">@lang('outlets.add_edit.button_back')</a>
                                <button type="submit" class="btn green">@lang('outlets.add.button_save')</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
