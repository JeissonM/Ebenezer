@extends('layouts.admin')
@section('breadcrumb')
<h1>
    Bienvenido
    <small>Sr(a). {{Auth::user()->nombres}}</small>
</h1>
<ol class="breadcrumb">
    <li><a href="{{route('home')}}"><i class="fa fa-home"></i> Inicio</a></li>
    <li class="active"><a> Documental</a></li>
</ol>
@endsection
@section('content')
<div class="alert bg-purple-gradient alert-dismissible" style="opacity: .65; font-size: 16px; color: #FFFFFF;">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h4><i class="icon fa fa-info"></i> Detalles!</h4>
    Esta funcionalidad permitirá según el rol del usuario autenticado gestionar los logros académicos, estándares, competencias, componentes, indicadores de logros, personalizar los logros alcanzados por cada estudiante en las evaluaciones académicas y por último, gestionar los boletines.
</div>
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">MENÚ MODULO DOCUMENTAL</h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Minimizar">
                <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Cerrar">
                <i class="fa fa-times"></i></button>
        </div>
    </div>
    <div class="box-body">
        @if(session()->exists('PAG_DOCUMENTAL-COMPONENTES'))
        <div class="col-md-4">
            <a href="{{route('componente.index')}}" class="btn bg-purple btn-raised btn-block btn-flat"> COMPONENTES</a>
        </div>
        @endif
        @if(session()->exists('PAG_DOCUMENTAL-COMPETENCIAS'))
        <div class="col-md-4">
            <a href="{{route('competencia.index')}}" class="btn bg-purple btn-raised btn-block btn-flat"> COMPETENCIAS</a>
        </div>
        @endif
        @if(session()->exists('PAG_DOCUMENTAL-COMPETENCIAS-A-COMPONENTES'))
        <div class="col-md-4">
            <a href="{{route('componente.competencias')}}" class="btn bg-purple btn-raised btn-block btn-flat"> COMPETENCIAS A COMPONENTES</a>
        </div>
        @endif
        @if(session()->exists('PAG_DOCUMENTAL-ESTANDAR'))
        <div class="col-md-4">
            <a href="{{route('estandar.index')}}" class="btn bg-purple btn-raised btn-block btn-flat"> ESTÁNDAR</a>
        </div>
        @endif
        @if(session()->exists('PAG_DOCUMENTAL-LOGROS'))
        <!--<div class="col-md-4">
            <a href="{{route('logro.index')}}" class="btn bg-purple btn-raised btn-block btn-flat"> LOGROS</a>
        </div>-->
        @endif
        @if(session()->exists('PAG_DOCUMENTAL-LOGROS-PERSONALIZAR'))
        <!--<div class="col-md-6">
            <a href="{{route('logro.personalizar_inicio')}}" class="btn bg-purple btn-raised btn-block btn-flat"> LOGROS PERSONALIZADOS PARA EL ESTUDIANTE</a>
        </div>-->
        @endif
        @if(session()->exists('PAG_DOCUMENTAL-BOLETINES'))
        <div class="col-md-4">
            <a href="{{route('boletines.index')}}" class="btn bg-purple btn-raised btn-block btn-flat"> GENERAR BOLETINES POR GRUPO</a>
        </div>
        @endif
    </div>
</div>
@endsection
@section('script')
<script type="text/javascript">
    $(document).ready(function() {
        //$('#example1').DataTable();
    });
</script>
@endsection