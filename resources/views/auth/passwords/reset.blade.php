@extends('layouts.app')

@section('content')
<div class="login-box">
    <div class="login-logo">
        <a href="{{url('/')}}">Ebenezer <b>Valledupar</b></a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg" style="font-size: 20px">Cambiar Contraseña</p>
        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <div class="form-group row">
                <label for="email" class="col-md-12">{{ __('E-Mail Address') }}</label>
                <div class="col-md-12">
                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $email ?? old('email') }}" required autofocus>
                    @if ($errors->has('email'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
            <div class="form-group row">
                <label for="password" class="col-md-12">{{ __('Password') }}</label>
                <div class="col-md-12">
                    <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
                    @if ($errors->has('password'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
            <div class="form-group row">
                <label for="password-confirm" class="col-md-12">{{ __('Confirm Password') }}</label>
                <div class="col-md-12">
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                </div>
            </div>
            <div class="form-group row mb-0">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-info btn-raised btn-block btn-flat">
                        {{ __('Reset Password') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
    <!-- /.login-box-body -->
</div>
<!-- /.login-box -->  
@endsection
