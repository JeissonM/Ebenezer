@extends('layouts.admin')
@section('breadcrumb')
<h1>
    Bienvenido
    <small>Sr(a). {{Auth::user()->nombres}}</small>
</h1>
<ol class="breadcrumb">
    <li class="active"><a href="{{route('home')}}"><i class="fa fa-home"></i> Inicio</a></li>
    <li><a>Inscripción</a></li>
</ol>
@endsection
@section('content')
<div class="alert alert-success alert-dismissible" style="font-size: 16px; color: #FFFFFF;">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h4><i class="icon fa fa-info"></i> Detalles!</h4>
    Realice el proceso de inscripción para su/sus hijo(s), gestione la información básica del acudiente, agende la entrevista para cada aspirante, configure el responsable financiero del estudiante, entre otras funciones.
</div>
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">MENÚ INSCRIPCIÓN</h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Minimizar">
                <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Cerrar">
                <i class="fa fa-times"></i></button>
        </div>
    </div>
    <div class="box-body">
        @if(session()->exists('PAG_PANELACUDIENTE-INSCRIPCION-INFORMACIONACUDIENTE'))
        <div class="col-md-4">
            <a href="{{route('inscripcion.index')}}" class="btn btn-success btn-raised btn-block btn-flat"> DATOS DEL ACUDIENTE</a>
        </div>
        @endif
        @if(session()->exists('PAG_PANELACUDIENTE-INSCRIPCION-INSCRIBIRASPIRANTE'))
        <div class="col-md-4">
            <a href="{{route('inscripcion.aspirante')}}" class="btn btn-success btn-raised btn-block btn-flat"> INSCRIBIR ASPIRANTE</a>
        </div>
        @endif
        @if(session()->exists('PAG_PANELACUDIENTE-INSCRIPCION-PADRESASPIRANTES'))
        <div class="col-md-4">
            <a href="{{route('padresaspirantes.index')}}" class="btn btn-success btn-raised btn-block btn-flat"> PADRES ASPIRANTE</a>
        </div>
        @endif
        @if(session()->exists('PAG_PANELACUDIENTE-INSCRIPCION-RESPONSABLEFINANCIERO'))
        <div class="col-md-4">
            <a href="{{route('responsablefaspirante.index')}}" class="btn btn-success btn-raised btn-block btn-flat"> RESPONSABLE FINANCIERO ASPIRANTE</a>
        </div>
        @endif
        @if(session()->exists('PAG_PANELACUDIENTE-INSCRIPCION-AGENDARCITA'))
        <div class="col-md-4">
            <a href="{{route('entrevistaa.index')}}" class="btn btn-success btn-raised btn-block btn-flat"> PROGRAMAR ENTREVISTA</a>
        </div>
        @endif
        @if(session()->exists('PAG_PANELACUDIENTE-INSCRIPCION-MODIFICARASPIRANTE'))
        <div class="col-md-4">
            <a href="{{route('aspirante.lista')}}" class="btn btn-success btn-raised btn-block btn-flat"> MODIFICAR DATOS DE LOS ASPIRANTES</a>
        </div>
        @endif
        @if(session()->exists('PAG_PANELACUDIENTE-INSCRIPCION-DOCUMENTOSANEXOS'))
        <div class="col-md-6">
            <a href="{{route('inscripcion.documentosanexos')}}" class="btn btn-success btn-raised btn-block btn-flat"> VER DOCUMENTOS ANEXOS AL PROCESO DE INSCRIPCIÓN</a>
        </div>
        @endif
        @if(session()->exists('PAG_PANELACUDIENTE-INSCRIPCION-IMPRIMIRFORMULARIO'))
        <div class="col-md-6">
            <a href="{{route('inscripcion.formimprimir')}}" class="btn btn-success btn-raised btn-block btn-flat"> IMPRIMIR FORMULARIO DE INSCRIPCIÓN</a>
        </div>
        @endif
    </div>
</div>
@endsection