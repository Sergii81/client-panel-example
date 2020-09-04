@extends('layouts.login')

@section('title',  config('payment_system.app.name') .' :: '.__('verify_email.title'))

@section('content')

            @if (session('resent'))
                <div class="alert alert-success" role="alert">
                    @lang('verify_email.alert_message')
                </div>
            @endif
            <div class=" verify_email_form">
                <form class="login-form" method="POST" action="{{ route('verification.resend') }}">
                    <h3 class="form-title">@lang('verify_email.page_title')</h3>
                    <span>@lang('verify_email.info_1')</span>
                    <span>@lang('verify_email.info_2')</span>
                    @csrf
                    <button type="submit" class="btn btn-link">@lang('verify_email.button')</button>
                </form>
            </div>

@endsection
