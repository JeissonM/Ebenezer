@extends('layouts.admin')
@section('breadcrumb')
<h1>
    Bienvenido
    <small>Sr(a). {{Auth::user()->nombres}}</small>
</h1>
<ol class="breadcrumb">
    <li><a href="{{route('home')}}"><i class="fa fa-home"></i> Inicio</a></li>
    <li><a href="{{route('menu.usuarios')}}"><i class="fa fa-users"></i> Usuarios</a></li>
    <li><a href="{{route('grupousuario.index')}}"><i class="fa fa-street-view"></i> Grupo de Usuarios</a></li>
    <li class="active"><a>Ver</a></li>
</ol>
@endsection
@section('content')
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">VER GRUPO DE USUARIO</h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Minimizar">
                <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Cerrar">
                <i class="fa fa-times"></i></button>
        </div>
    </div>
    <div class="box-body">
        <div class="col-md-12">
            @component('layouts.errors')
            @endcomponent
        </div>
        <div class="col-md-12">
            <table class="table table-hover">
                <tbody>
                    <tr class="read">
                        <td class="contact"><b>Id del Grupo</b></td>
                        <td class="subject">{{$grupo->id}}</td>
                    </tr>
                    <tr class="read">
                        <td class="contact"><b>Nombre</b></td>
                        <td class="subject">{{$grupo->nombre}}</td>
                    </tr>
                    <tr class="read">
                        <td class="contact"><b>Descripción</b></td>
                        <td class="subject">{{$grupo->descripcion}}</td>
                    </tr>
                    <tr class="read">
                        <td class="contact"><b>Cantidad de Usuarios en el Grupo</b></td>
                        <td class="subject">{{$total}}</td>
                    </tr>
                    <tr class="read">
                        <td class="contact"><b>Creado</b></td>
                        <td class="subject">{{$grupo->created_at}}</td>
                    </tr>
                    <tr class="read">
                        <td class="contact"><b>Modificado</b></td>
                        <td class="subject">{{$grupo->updated_at}}</td>
                    </tr>
                </tbody>
            </table>
            <div class="col-md-12">
                <div class="callout callout-success" style="padding: 5px; background-color: #3c8dbc !important; padding-left: 10px; text-align: center;">
                    <h5>MÓDULOS A LOS QUE TIENE ACCESO EL GRUPO DE USUARIOS </h5>
                </div>
                <ul class="timeline timeline-inverse">
                    @foreach($grupo->modulos as $modulo)
                    <li>
                        <div class="timeline-item"><h3 class="timeline-header no-border">{{$modulo->nombre}} ==> {{$modulo->descripcion}}</h3></div>
                    </li>
                    @endforeach
                </ul>
            </div>
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