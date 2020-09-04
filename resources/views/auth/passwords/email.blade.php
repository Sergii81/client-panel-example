@extends('layouts.login')

@section('title',  config('payment_system.app.name') .' :: '.__('password_request.title'))

@section('content')

    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <form class="login-form" action="{{ route('password.email') }}" method="post">
        @csrf
        <h3>@lang('password_request.forget_password')</h3>
        <p>@lang('password_request.enter_email')</p>
        <div class="form-group">
            <input class="form-control placeholder-no-fix @error('email') is-invalid @enderror"
                   name="email" value="{{ old('email') }}" required autocomplete="email" autofocus type="text"  placeholder="@lang('password_request.placeholder_email')">
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-actions">
            @if(url()->previous() != route('password.confirm'))
                <a href="{{route('login')}}" type="button" id="register-back-btn" class="btn btn-default">@lang('password_request.button_back')</a>
            @else
                <a href="{{route('password.confirm')}}" type="button" id="register-back-btn" class="btn btn-default">@lang('password_request.button_back')</a>
            @endif
            <button type="submit" class="btn btn-success uppercase pull-right">@lang('password_request.button_send')</button>
        </div>
    </form>

@endsection
