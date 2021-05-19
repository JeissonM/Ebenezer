@extends('layouts.admin')
@section('breadcrumb')
<h1>
    Bienvenido
    <small>Sr(a). {{Auth::user()->nombres}}</small>
</h1>
<ol class="breadcrumb">
    <li><a href="{{route('menu.admisiones')}}"><i class="fa fa-users"></i> Admisiones</a></li>
    <li><a href="{{route('menu.admisiones')}}"><i class="fa fa-cogs"></i> Datos Básicos</a></li>
    <li><a href="{{route('ciudad.index')}}"><i class="fa fa-globe"></i> Ciudades</a></li>
    <li class="active"><a>Ver</a></li>
</ol>
@endsection
@section('content')
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">VER CIUDAD</h3>
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
                        <td class="contact"><b>Id de la Ciudad</b></td>
                        <td class="subject">{{$ciudad->id}}</td>
                    </tr>
                    <tr class="read">
                        <td class="contact"><b>Código</b></td>
                        <td class="subject">{{$ciudad->codigo_dane}}</td>
                    </tr>
                    <tr class="read">
                        <td class="contact"><b>Nombre</b></td>
                        <td class="subject">{{$ciudad->nombre}}</td>
                    </tr>
                    <tr class="read">
                        <td class="contact"><b>Estado</b></td>
                        <td class="subject">@if($ciudad->estado_dpto==1)<span class="label label-success">ACTIVO</span>@else<span class="label label-danger">INACTIVO</span>@endif</td>
                    </tr>
                    <tr class="read">
                        <td class="contact"><b>Código País</b></td>
                        <td class="subject">{{$ciudad->codigo_pais}}</td>
                    </tr>
                    <tr class="read">
                        <td class="contact"><b>Distrito</b></td>
                        <td class="subject">{{$ciudad->distrito}}</td>
                    </tr>
                    <tr class="read">
                        <td class="contact"><b>Población</b></td>
                        <td class="subject">{{$ciudad->poblacion}} HABITANTES</td>
                    </tr>
                    <tr class="read">
                        <td class="contact"><b>Departamento/Estado</b></td>
                        <td class="subject">@if($ciudad->estado!==null){{$ciudad->estado->nombre}}@endif</td>
                    </tr>
                    <tr class="read">
                        <td class="contact"><b>País</b></td>
                        <td class="subject">@if($ciudad->estado->pais!==null){{$ciudad->estado->pais->nombre}}@endif</td>
                    </tr>
                    <tr class="read">
                        <td class="contact"><b>Creado</b></td>
                        <td class="subject">{{$ciudad->created_at}}</td>
                    </tr>
                    <tr class="read">
                        <td class="contact"><b>Modificado</b></td>
                        <td class="subject">{{$ciudad->updated_at}}</td>
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