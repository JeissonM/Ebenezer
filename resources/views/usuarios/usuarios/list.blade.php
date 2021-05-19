@extends('layouts.admin')
@section('breadcrumb')
<h1>
    Bienvenido
    <small>Sr(a). {{Auth::user()->nombres}}</small>
</h1>
<ol class="breadcrumb">
    <li><a href="{{route('home')}}"><i class="fa fa-home"></i> Inicio</a></li>
    <li><a href="{{route('menu.usuarios')}}"><i class="fa fa-users"></i> Usuarios</a></li>
    <li class="active"><a> Listado de Usuarios</a></li>
</ol>
@endsection
@section('content')
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">LISTADO DE USUARIOS</h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Minimizar">
                <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Cerrar">
                <i class="fa fa-times"></i></button>
        </div>
    </div>
    <div class="box-body">
        <div class="table-responsive">
            <table id="example1" class="table table-bordered table-striped table-hover">
                <thead>
                    <tr class="info">
                        <th>IDENTIFICACIÓN</th>
                        <th>USUARIO</th>
                        <th>CORREO</th>
                        <th>ESTADO</th>
                        <th>ROLES</th>
                        <th>CREADO</th>
                        <th>MODIFICADO</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($usuarios as $usuario)
                    <tr>
                        <td>{{$usuario->identificacion}}</td>
                        <td>{{$usuario->nombres}} {{$usuario->apellidos}}</td>
                        <td>{{$usuario->email}}</td>
                        <td>@if($usuario->estado=='ACTIVO')<label class="label label-success">ACTIVO</label>@else<label class="label label-danger">INACTIVO</label>@endif</td>
                        <td>
                            @foreach($usuario->grupousuarios as $grupo)
                            {{$grupo->nombre}} - 
                            @endforeach
                        </td>
                        <td>{{$usuario->created_at}}</td>
                        <td>{{$usuario->updated_at}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
@section('script')
<script type="text/javascript">
    $(document).ready(function () {
        $('#example1').DataTable();
    });
</script>
@endsection
