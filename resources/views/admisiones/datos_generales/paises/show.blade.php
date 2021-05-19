@extends('layouts.admin')
@section('breadcrumb')
<h1>
    Bienvenido
    <small>Sr(a). {{Auth::user()->nombres}}</small>
</h1>
<ol class="breadcrumb">
    <li><a href="{{route('menu.admisiones')}}"><i class="fa fa-users"></i> Admisiones</a></li>
    <li><a href="{{route('menu.admisiones')}}"><i class="fa fa-cogs"></i> Datos Básicos</a></li>
    <li><a href="{{route('pais.index')}}"><i class="fa fa-globe"></i> Paises</a></li>
    <li class="active"><a>Ver</a></li>
</ol>
@endsection
@section('content')
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">VER PAIS</h3>
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
                        <td class="contact"><b>Id del Pais</b></td>
                        <td class="subject">{{$pais->id}}</td>
                    </tr>
                    <tr class="read">
                        <td class="contact"><b>Código</b></td>
                        <td class="subject">{{$pais->codigo}}</td>
                    </tr>
                    <tr class="read">
                        <td class="contact"><b>Código Abreviado</b></td>
                        <td class="subject">{{$pais->codigo_dos}}</td>
                    </tr>
                    <tr class="read">
                        <td class="contact"><b>Nombre</b></td>
                        <td class="subject">{{$pais->nombre}}</td>
                    </tr>
                    <tr class="read">
                        <td class="contact"><b>Continente</b></td>
                        <td class="subject">{{$pais->continente}}</td>
                    </tr>
                    <tr class="read">
                        <td class="contact"><b>Región</b></td>
                        <td class="subject">{{$pais->region}}</td>
                    </tr>
                    <tr class="read">
                        <td class="contact"><b>Área</b></td>
                        <td class="subject">{{$pais->area}} Km2</td>
                    </tr>
                    <tr class="read">
                        <td class="contact"><b>Año de Independencia</b></td>
                        <td class="subject">{{$pais->independencia}}</td>
                    </tr>
                    <tr class="read">
                        <td class="contact"><b>Población</b></td>
                        <td class="subject">{{$pais->poblacion}} Habitantes</td>
                    </tr>
                    <tr class="read">
                        <td class="contact"><b>Expectativa de Vida</b></td>
                        <td class="subject">{{$pais->expectativa_vida}} %</td>
                    </tr>
                    <tr class="read">
                        <td class="contact"><b>Producto Interno Bruto de la Nación</b></td>
                        <td class="subject">{{$pais->producto_interno_bruto}}</td>
                    </tr>
                    <tr class="read">
                        <td class="contact"><b>Producto Interno Bruto Antiguo de la Nación</b></td>
                        <td class="subject">{{$pais->producto_interno_bruto_antiguo}}</td>
                    </tr>
                    <tr class="read">
                        <td class="contact"><b>Nombre Local</b></td>
                        <td class="subject">{{$pais->nombre_local}}</td>
                    </tr>
                    <tr class="read">
                        <td class="contact"><b>Tipo de Gobierno</b></td>
                        <td class="subject">{{$pais->gobierno}}</td>
                    </tr>
                    <tr class="read">
                        <td class="contact"><b>Jefe de Estado</b></td>
                        <td class="subject">{{$pais->jefe_estado}}</td>
                    </tr>
                    <tr class="read">
                        <td class="contact"><b>Creado</b></td>
                        <td class="subject">{{$pais->created_at}}</td>
                    </tr>
                    <tr class="read">
                        <td class="contact"><b>Modificado</b></td>
                        <td class="subject">{{$pais->updated_at}}</td>
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