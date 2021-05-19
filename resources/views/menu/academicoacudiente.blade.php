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
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                        <tr class="info">
                            <th>IDENTIFICACIÓN</th>
                            <th>ESTUDIANTE</th>
                            <th>PERÍODO</th>
                            <th>JORNADA</th>
                            <th>UNIDAD</th>
                            <th>GRADO</th>
                            <th>ESTADO</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>{{$pn->persona->tipodoc->abreviatura." - ".$pn->persona->numero_documento}}</td>
                            <td>{{$pn->primer_nombre." ".$pn->segundo_nombre." ".$pn->primer_apellido." ".$pn->segundo_apellido}}</td>
                            <td>{{$a->periodoacademico->etiqueta." - ".$a->periodoacademico->anio}}</td>
                            <td>{{$a->jornada->descripcion." - ".$a->jornada->jornadasnies}}</td>
                            <td>{{$a->unidad->nombre}}</td>
                            <td>{{$a->grado->etiqueta}}</td>
                            <td>{{$a->estado}}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-12">
                @if(session()->exists('PAG_ACADEMICO-ACUDIENTE-VER-CARGA'))
                    <div class="col-md-3">
                        <a href="{{route('cargaacademica.acudiente',$a->id)}}"
                           class="btn btn-primary btn-raised btn-block btn-flat"> CARGA ACADÉMICA</a>
                    </div>
                @endif
                @if(session()->exists('PAG_ACADEMICO-ACUDIENTE-VER-CALIFICACIONES'))
                    <div class="col-md-3">
                        <a href="{{route('calificaciones.todasacudiente',$a->id)}}"
                           class="btn btn-primary btn-raised btn-block btn-flat"> CALIFICACIONES</a>
                    </div>
                @endif
                @if(session()->exists('PAG_ACADEMICO-ACUDIENTE-HORARIOS'))
                    <div class="col-md-3">
                        <a href="{{route('horario.horarioacudiente',$a->id)}}"
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
