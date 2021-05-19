@extends('layouts.admin')
@section('breadcrumb')
    <h1>
        Bienvenido
        <small>Sr(a). {{Auth::user()->nombres}}</small>
    </h1>
    <ol class="breadcrumb">
        <li class="active"><a href="{{route('home')}}"><i class="fa fa-home"></i> Inicio</a></li>
        <li><a>Académico</a></li>
    </ol>
@endsection
@section('content')
    <div class="alert alert-primary alert-dismissible" style="opacity: .65; font-size: 16px; color: #FFFFFF;">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-info"></i> Detalles!</h4>
        Módulo académico, permite visualizar la carga académica del estudiante para cada período académico y grado,
        permite visualizar las calificaciones y horario de clases de los estudiantes.
    </div>
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">MENÚ MÓDULO ACADÉMICO</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                        title="Minimizar">
                    <i class="fa fa-minus"></i></button>
                <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip"
                        title="Cerrar">
                    <i class="fa fa-times"></i></button>
            </div>
        </div>
        <div class="box-body">
            <div class="col-md-12">
                @if(session()->exists('PAG_ACADEMICO-ESTUDIANTE-VER-CARGA'))
                    <div class="col-md-3">
                        <a href="{{route('cargaacademica.estudiante')}}"
                           class="btn btn-primary btn-raised btn-block btn-flat"> CARGA ACADÉMICA</a>
                    </div>
                @endif
                @if(session()->exists('PAG_ACADEMICO-ESTUDIANTE-VER-CALIFICACIONES'))
                    <div class="col-md-3">
                        <a href="{{route('calificaciones.todasestudiante')}}"
                           class="btn btn-primary btn-raised btn-block btn-flat"> CALIFICACIONES</a>
                    </div>
                @endif
                @if(session()->exists('PAG_ACADEMICO-ESTUDIANTE-HORARIOS'))
                    <div class="col-md-3">
                        <a href="{{route('horario.horarioestudiante')}}"
                           class="btn btn-primary btn-raised btn-block btn-flat"> HORARIO DE CLASES</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script type="text/javascript">
        $(document).ready(function () {
            //$('#example1').DataTable();
        });
    </script>
@endsection
