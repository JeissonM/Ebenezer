@extends('layouts.app')

@section('content')
<div class="login-box" style="width: 60% !important;">
    <div class="login-logo">
        <a href="{{url('/')}}">Ebenezer <b>Valledupar</b> - Registro de Acudiente</a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <img class="login-box-msg" style="width: 100%;" src="{{asset('images/logo.png')}}" alt="Logo" >
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="col-md-6">
                <div class="form-group has-feedback">
                    <input type="number" class="form-control{{ $errors->has('identificacion') ? ' is-invalid' : '' }}" placeholder="Identificación" id="identificacion" name="identificacion" value="{{ old('identificacion') }}" required autofocus>
                    <span class="fa fa-credit-card form-control-feedback"></span>
                    @if ($errors->has('identificacion'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('identificacion') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group has-feedback">
                    <input type="text" class="form-control{{ $errors->has('apellidos') ? ' is-invalid' : '' }}" placeholder="Apellidos" id="apellidos" name="apellidos" value="{{ old('apellidos') }}" required autofocus>
                    <span class="fa fa-user form-control-feedback"></span>
                    @if ($errors->has('apellidos'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('apellidos') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group has-feedback">
                    <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required placeholder="Contraseña">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    @if ($errors->has('password'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group has-feedback">
                    <input type="text" class="form-control{{ $errors->has('nombres') ? ' is-invalid' : '' }}" placeholder="Nombres" id="nombres" name="nombres" value="{{ old('nombres') }}" required autofocus>
                    <span class="fa fa-user form-control-feedback"></span>
                    @if ($errors->has('nombres'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('nombres') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group has-feedback">
                    <input type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="Correo Electrónico" id="email" name="email" value="{{ old('email') }}" required autofocus>
                    <span class="fa fa-mail-reply form-control-feedback"></span>
                    @if ($errors->has('email'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group has-feedback">
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required placeholder="Confirmar Contraseña">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-info btn-raised btn-block btn-flat"> Registrar</button>
                </div>
                <!-- /.col -->
            </div>
        </form>
    </div>
    <!-- /.login-box-body -->
</div>
<!-- /.login-box -->  
@endsection