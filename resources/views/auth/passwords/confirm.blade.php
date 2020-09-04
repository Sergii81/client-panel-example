@extends('layouts.login')

@section('title',  config('payment_system.app.name') .' :: '.__('password_confirm.title'))

@section('content')


    <form class="login-form" action="{{ route('password.confirm') }}" method="post">
        @csrf

        <h3>@lang('password_confirm.confirm_password')</h3>
        <p>@lang('password_confirm.please_confirm')</p>

        <div class="form-group">
            <input class="form-control placeholder-no-fix @error('password') is-invalid @enderror"
                   name="password" required autocomplete="ncurrent-password" type="password" placeholder="@lang('password_confirm.placeholder_password')">
            @error('password')
            <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-actions">
            <button type="submit" id="back-btn" class="btn btn-primary">@lang('password_confirm.button_confirm')</button>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" id="forget-password" class="forget-password">@lang('password_confirm.forgot_password')</a>
            @endif
        </div>
    </form>
@endsection
