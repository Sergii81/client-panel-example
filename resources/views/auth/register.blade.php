@extends('layouts.login')

@section('title',  config('payment_system.app.name') .' :: '.__('register.title'))

@section('content')

    <!-- BEGIN REGISTRATION FORM -->
    <form class="login-form" action="{{ route('register') }}" method="post">
        @csrf
        <h3 class="form-title">@lang('register.registration')</h3>
        <p class="hint">
            @lang('register.enter_details')
        </p>
        <div class="form-group">
            <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
            <label class="control-label visible-ie8 visible-ie9">@lang('register.label_name')</label>
            <input class="form-control placeholder-no-fix @error('name') is-invalid @enderror"
                   name="name" value="{{ old('name') }}" required autocomplete="name" autofocus type="text" placeholder="@lang('register.placeholder_name')">
            @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">@lang('register.label_email')</label>
            <input class="form-control placeholder-no-fix @error('email') is-invalid @enderror"
                   name="email" value="{{ old('email') }}" required autocomplete="email" type="text" placeholder="@lang('register.placeholder_email')" >
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">@lang('register.label_password')</label>
            <input class="form-control placeholder-no-fix @error('password') is-invalid @enderror"
                   name="password" required autocomplete="new-password" type="password" id="register_password" placeholder="@lang('register.placeholder_password')" >
            @error('password')
            <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">@lang('register.label_re_password')</label>
            <input class="form-control placeholder-no-fix" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="@lang('register.placeholder_re_password')">
        </div>
{{--        <div class="form-group margin-top-20 margin-bottom-20">--}}
{{--            <label class="check">--}}
{{--                <input type="checkbox" name="tnc"/> I agree to the <a href="javascript:;">--}}
{{--                    Terms of Service </a>--}}
{{--                & <a href="javascript:;">--}}
{{--                    Privacy Policy </a>--}}
{{--            </label>--}}
{{--            <div id="register_tnc_error">--}}
{{--            </div>--}}
{{--        </div>--}}
        <div class="form-actions">
            <a href="{{route('login')}}" type="button" id="register-back-btn" class="btn btn-default">@lang('register.button_back')</a>
            <button type="submit" id="register-submit-btn" class="btn btn-success uppercase pull-right">@lang('register.button_send')</button>
        </div>
    </form>
    <!-- END REGISTRATION FORM -->

{{--<div class="container">--}}
{{--    <div class="row justify-content-center">--}}
{{--        <div class="col-md-8">--}}
{{--            <div class="card">--}}
{{--                <div class="card-header">{{ __('Register') }}</div>--}}

{{--                <div class="card-body">--}}
{{--                    <form method="POST" action="{{ route('register') }}">--}}
{{--                        @csrf--}}

{{--                        <div class="form-group row">--}}
{{--                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>--}}

{{--                            <div class="col-md-6">--}}
{{--                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>--}}

{{--                                @error('name')--}}
{{--                                    <span class="invalid-feedback" role="alert">--}}
{{--                                        <strong>{{ $message }}</strong>--}}
{{--                                    </span>--}}
{{--                                @enderror--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                        <div class="form-group row">--}}
{{--                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>--}}

{{--                            <div class="col-md-6">--}}
{{--                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">--}}

{{--                                @error('email')--}}
{{--                                    <span class="invalid-feedback" role="alert">--}}
{{--                                        <strong>{{ $message }}</strong>--}}
{{--                                    </span>--}}
{{--                                @enderror--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                        <div class="form-group row">--}}
{{--                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>--}}

{{--                            <div class="col-md-6">--}}
{{--                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">--}}

{{--                                @error('password')--}}
{{--                                    <span class="invalid-feedback" role="alert">--}}
{{--                                        <strong>{{ $message }}</strong>--}}
{{--                                    </span>--}}
{{--                                @enderror--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                        <div class="form-group row">--}}
{{--                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>--}}

{{--                            <div class="col-md-6">--}}
{{--                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                        <div class="form-group row mb-0">--}}
{{--                            <div class="col-md-6 offset-md-4">--}}
{{--                                <button type="submit" class="btn btn-primary">--}}
{{--                                    {{ __('Register') }}--}}
{{--                                </button>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </form>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}
@endsection
