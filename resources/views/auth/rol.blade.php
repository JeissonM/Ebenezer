@extends('layouts.app')

@section('content')
<div class="login-box">
    <div class="login-logo">
        <a href="{{url('/')}}">Ebenezer <b>Valledupar</b></a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg" style="font-size: 20px">Seleccione un rol para ingresar al sistema</p>
        <form class="form-horizontal" method="POST" action="{{ route('rol') }}">
            {{ csrf_field() }}
            <div class="form-group has-feedback">
                <div class="col-md-12">
                    <select class="form-control" required="required" name="grupo">
                        <option value="0">-- Seleccione una opción --</option>
                        @foreach($grupos as $key=>$value)
                        <option value="{{$key}}">{{$value}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group has-feedback">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-info btn-raised btn-block btn-flat">
                        <i class="fa fa-sign-in"></i> Iniciar Sesión
                    </button>
                </div>
            </div>
        </form>
    </div>
    <!-- /.login-box-body -->
</div>
<!-- /.login-box -->  
@endsection
