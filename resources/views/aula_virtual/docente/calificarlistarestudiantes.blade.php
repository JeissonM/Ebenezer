@extends('layouts.admin')
@section('breadcrumb')
    <h1>
        Bienvenido
        <small>Sr(a). {{Auth::user()->nombres}}</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{route('home')}}"><i class="fa fa-home"></i> Inicio</a></li>
        <li><a href="{{route('menu.aulavirtual')}}"><i class="fa fa-vimeo"></i> Aula Virtual</a></li>
        <li><a href="{{route('aulavirtual.docenteinicio')}}"><i class="fa fa-home"></i> Inicio Docente</a></li>
        <li><a href="{{route('aulavirtual.menuauladocente',$gmd->id)}}"><i class="fa fa-list"></i> Panel Aula
                Virtual</a></li>
        <li><a href="{{route('calificaciondocente.index',$gmd->id)}}"><i class="fa fa-check"></i> Calificar Actividades,
                Exámenes & Ebeduc</a></li>
        <li class="active"><a> Listar Estudiantes</a></li>
    </ol>
@endsection
@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">CALIFICAR ACTIVIDADES, EXAMENES & EBEDUC</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-toggle="modal" data-target="#modal" title="Ayuda">
                    <i class="fa fa-question"></i></button>
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
                        <tr class="danger">
                            <th>UNIDAD</th>
                            <th>PERÍODO ACADÉMICO</th>
                            <th>JORNADA</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>{{$gmd->gradomateria->unidad->nombre." - ".$gmd->gradomateria->unidad->ciudad->nombre}}</td>
                            <td>{{$gmd->gradomateria->periodoacademico->etiqueta." - ".$gmd->gradomateria->periodoacademico->anio}}</td>
                            <td>{{$gmd->gradomateria->jornada->descripcion." - ".$gmd->gradomateria->jornada->jornadasnies}}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                        <tr class="danger">
                            <th>GRADO</th>
                            <th>GRUPO</th>
                            <th>MATERIA</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>{{$gmd->gradomateria->grado->etiqueta}}</td>
                            <td>{{$gmd->grupo->nombre}}</td>
                            <td>{{$gmd->gradomateria->materia->codigomateria." - ".$gmd->gradomateria->materia->nombre}}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                        <tr class="danger">
                            <th>SISTEMA DE EVALUACIÓN</th>
                            <th>RANGO DE NOTA</th>
                            <th>NOTA APROBATORIA</th>
                            <th>EVALUACIÓN ACADÉMICA</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>{{$a->evaluacionacademica->sistemaevaluacion->nombre}}</td>
                            <td>{{number_format($a->evaluacionacademica->sistemaevaluacion->nota_inicial,2,'.',',')." - ".number_format($a->evaluacionacademica->sistemaevaluacion->nota_final,2,'.',',')}}</td>
                            <td>{{number_format($a->evaluacionacademica->sistemaevaluacion->nota_aprobatoria,2,'.',',')}}</td>
                            <td>{{$a->evaluacionacademica->nombre." (".$a->evaluacionacademica->peso."%)"}}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <h3 style="text-align: center; padding: 20px;"><b>@if($a->ebeduc=='SI') PRUEBA EBEDUC @else
                            ACTIVIDAD/EXAMEN @endif</b></h3>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                        <tr class="danger">
                            <th>ACTIVIDAD</th>
                            <th>DESCRIPCIÓN</th>
                            <th>PESO</th>
                            <th>FECHA ENTREGA</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>{{$a->actividad->nombre}}</td>
                            <td>{{$a->actividad->descripcion}}</td>
                            <td>{{$a->peso." % DE LA EVALUACIÓN"}}</td>
                            <td>{{"Entre ".$a->fecha_inicio." & ".$a->fecha_final}}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                        <tr class="danger">
                            <th>UNIDAD</th>
                            <th>TEMA</th>
                            <th>LOGROS</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>{{$actividad->ctunidadtema->ctunidad->nombre}}</td>
                            <td>{{$actividad->ctunidadtema->titulo}}</td>
                            <td>
                                @foreach($actividad->ctunidadestandaraprendizajes as $item)
                                    <ul>
                                        <li>
                                            <b>Estandar:</b> {{$item->aprendizaje->estandarcomponente->estandar->titulo}}
                                        </li>
                                        <li>
                                            <b>Componente:</b> {{$item->aprendizaje->componentecompetencia->componente->componente}}
                                        </li>
                                        <li>
                                            <b>Competencia:</b> {{$item->aprendizaje->componentecompetencia->competencia->competencia}}
                                        </li>
                                    </ul>
                                @endforeach
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-12">
                <h3 style="text-align: center; padding: 20px;"><b>LISTADO DE ESTUDIANTES EN EL GRUPO</b></h3>
                <div class="table-responsive">
                    <table id="tb" class="table table-bordered table-striped table-hover">
                        <thead>
                        <tr class="danger">
                            <th>ESTUDIANTE</th>
                            <th>ESTADO</th>
                            <th>CALIFICAR/EDITAR</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($contactos)>0)
                            @foreach($contactos as $c)
                                <tr>
                                    <td>{{$c->estudiante->personanatural->primer_nombre." ".$c->estudiante->personanatural->segundo_nombre." ".$c->estudiante->personanatural->primer_apellido." ".$c->estudiante->personanatural->segundo_apellido}}</td>
                                    <td>{{$c->realizo}}</td>
                                    <td>
                                        <a href="{{route('calificaciondocente.vistacalificar',[$gmd->id,$a->id,$c->estudiante_id])}}"
                                           style='margin-left: 10px; cursor: pointer;' data-toggle='tooltip'
                                           title="Calificar"><i class="fa fa-check"></i></a></td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Información de Ayuda</h4>
                </div>
                <div class="modal-body">
                    <p>Esta funcionalidad permite la calificación de actividades y simulacros EBEDUC para una materia,
                        grado y evaluación académica en particular.</p>
                </div>
                <div class="modal-footer" style="background-color: #d2d6de !important; opacity: .65;">
                    <button type="button" class="btn btn-block btn-danger btn-flat pull-right" data-dismiss="modal"><i
                            class="fa fa-reply"></i> Regresar
                    </button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
    <style type="text/css">
        .panela:hover {
            background-color: #009688;
            color: #FFF !important;
            cursor: pointer;
        }

        .panela:hover > h4 > a {
            color: #FFF !important;
        }
    </style>
@endsection
@section('script')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#tb').DataTable();
            //$(document.body).attr('class', 'skin-blue sidebar-mini sidebar-collapse');
        });
    </script>
@endsection
