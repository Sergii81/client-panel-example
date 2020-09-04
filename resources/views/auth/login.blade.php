@extends('layouts.login')

@section('title',  config('payment_system.app.name') .' :: '.__('login.title'))

@section('content')


    <form class="login-form" action="{{ route('login') }}" method="post">
        @csrf
        <h3 class="form-title">@lang('login.sign_in')</h3>
        <div class="alert alert-danger display-hide">
            <button class="close" data-close="alert"></button>
            <span>@lang('login.alert')</span>
        </div>
        <div class="form-group">
            <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
            <label class="control-label visible-ie8 visible-ie9">@lang('login.label_username')</label>
            <input id="email" class="form-control form-control-solid placeholder-no-fix @error('email') is-invalid @enderror" type="email"
                   placeholder="@lang('login.placeholder_username')" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">@lang('login.label_password')</label>
            <input ip="password" class="form-control form-control-solid placeholder-no-fix @error('password') is-invalid @enderror" type="password"
                   placeholder="@lang('login.placeholder_password')" name="password" required autocomplete="current-password">
            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-success uppercase">@lang('login.button_login')</button>
            <label class="rememberme check">
                <input type="checkbox" name="remember" value="1" name="remember" {{ old('remember') ? 'checked' : '' }}>@lang('login.checkbox_remember') </label>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" id="forget-password" class="forget-password">@lang('login.forgot_password')</a>
            @endif

        </div>
{{--        <div class="login-options">--}}
{{--            <h4>Or login with</h4>--}}
{{--            <ul class="social-icons">--}}
{{--                <li>--}}
{{--                    <a class="social-icon-color facebook" data-original-title="facebook" href="javascript:;"></a>--}}
{{--                </li>--}}
{{--                <li>--}}
{{--                    <a class="social-icon-color twitter" data-original-title="Twitter" href="javascript:;"></a>--}}
{{--                </li>--}}
{{--                <li>--}}
{{--                    <a class="social-icon-color googleplus" data-original-title="Goole Plus" href="javascript:;"></a>--}}
{{--                </li>--}}
{{--                <li>--}}
{{--                    <a class="social-icon-color linkedin" data-original-title="Linkedin" href="javascript:;"></a>--}}
{{--                </li>--}}
{{--            </ul>--}}
{{--        </div>--}}
        <div class="create-account">
            <p>
                <a href={{ route('register') }} id="register-btn" class="uppercase">@lang('login.register')</a>
            </p>
        </div>
    </form>

@endsection
