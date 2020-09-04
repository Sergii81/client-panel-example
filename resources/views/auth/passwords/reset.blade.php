@extends('layouts.login')

@section('title',  config('payment_system.app.name') .' :: '.__('password_reset.title'))

@section('content')

    <form class="login-form" action="{{ route('password.update') }}" method="post">
        @csrf

        <input type="hidden" name="token" value="{{ $token }}">

        <h3>@lang('password_reset.reset_password')</h3>

        <div class="form-group">
            <input class="form-control placeholder-no-fix @error('email') is-invalid @enderror"
                   name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus type="text" placeholder="@lang('password_reset.placeholder_email')">
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group">
            <input class="form-control placeholder-no-fix @error('password') is-invalid @enderror"
                   name="password" required autocomplete="new-password" type="password" placeholder="@lang('password_reset.placeholder_password')">
            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group">
            <input class="form-control placeholder-no-fix"
                   name="password_confirmation" required autocomplete="new-password" type="password" placeholder="@lang('password_reset.placeholder_re_password')" >
        </div>
        <div class="form-actions">
            <button type="submit" id="back-btn" class="btn btn-default">@lang('password_reset.button_reset')</button>

        </div>
    </form>


@endsection
