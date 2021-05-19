@extends('layouts.admin')
@section('breadcrumb')
<h1>
    Bienvenido
    <small>Sr(a). {{Auth::user()->nombres}}</small>
</h1>
<ol class="breadcrumb">
    <li><a href="{{route('menu.matricula')}}"><i class="fa fa-users"></i> Admisiones</a></li>
    <li><a href="{{route('menu.matricula')}}"><i class="fa fa-cogs"></i> Datos Básicos</a></li>
    <li><a href="{{route('materia.index')}}"><i class="fa fa-book"></i> Materias</a></li>
    <li class="active"><a>Ver</a></li>
</ol>
@endsection
@section('content')
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">VER MATERIA</h3>
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
                        <td class="contact"><b>Id de la Materia</b></td>
                        <td class="subject">{{$materia->id}}</td>
                    </tr>
                    <tr class="read">
                        <td class="contact"><b>Código Materia</b></td>
                        <td class="subject">{{$materia->codigomateria}}</td>
                    </tr>
                    <tr class="read">
                        <td class="contact"><b>Nombre Materia</b></td>
                        <td class="subject">{{$materia->nombre}}</td>
                    </tr>
                    <tr class="read">
                        <td class="contact"><b>Descripción</b></td>
                        <td class="subject">{{$materia->descripcion}}</td>
                    </tr>
                    <tr class="read">
                        <td class="contact"><b>Intensidad Horaria</b></td>
                        <td class="subject">{{$materia->ih}}</td>
                    </tr>
                    <tr class="read">
                        <td class="contact"><b>Recuperable</b></td>
                        <td class="subject">{{$materia->recuperable}}</td>
                       
                    </tr>
                    <tr class="read">
                        <td class="contact"><b>Nivelable</b></td>
                        <td class="subject">{{$materia->nivelable}}</td>
                    </tr>
                    <tr class="read">
                        <td class="contact"><b>Area</b></td>
                        <td class="subject">{{$materia->area->nombre}}</td>
                    </tr>
                    <tr class="read">
                        <td class="contact"><b>Naturaleza</b></td>
                        <td class="subject">@if($materia->naturaleza_id!=null){{$materia->naturaleza->nombre}}@endif</td>
                    </tr>
                    <tr class="read">
                        <td class="contact"><b>Creado</b></td>
                        <td class="subject">{{$materia->created_at}}</td>
                    </tr>
                    <tr class="read">
                        <td class="contact"><b>Modificado</b></td>
                        <td class="subject">{{$materia->updated_at}}</td>
                    </tr>
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