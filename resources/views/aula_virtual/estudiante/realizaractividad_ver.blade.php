@extends('layouts.admin')
@section('breadcrumb')
    <h1>
        Bienvenido
        <small>Sr(a). {{Auth::user()->nombres}}</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{route('home')}}"><i class="fa fa-home"></i> Inicio</a></li>
        <li><a href="{{route('menu.aulavirtual')}}"><i class="fa fa-vimeo"></i> Aula Virtual</a></li>
        <li><a href="{{route('aulavirtual.estudianteinicio')}}"><i class="fa fa-home"></i> Inicio Estudiante</a></li>
        <li><a href="{{route('aulavirtual.menuaulaestudiante',$gmd->id)}}"><i class="fa fa-list"></i> Panel Aula Virtual</a>
        </li>
        <li><a href="{{route('realizaractividad.index',$gmd->id)}}"><i class="fa fa-check"></i> Realizar Actividades,
                Exámenes & Ebeduc</a></li>
        <li class="active"><a> Visualizar</a></li>
    </ol>
@endsection
@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">REALIZAR ACTIVIDADES, EXAMENES & EBEDUC</h3>
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
                            <td>{{$se->nombre}}</td>
                            <td>{{number_format($se->nota_inicial,2,'.',',')." - ".number_format($se->nota_final,2,'.',',')}}</td>
                            <td>{{number_format($se->nota_aprobatoria,2,'.',',')}}</td>
                            <td>{{$eval->nombre." (".$eval->peso."%)"}}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-12">
                <h3 style="text-align: center; padding: 20px;"><b>@if($aa->ebeduc=='SI') PRUEBA EBEDUC @else
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
                            <td>{{$aa->actividad->nombre}}</td>
                            <td>{{$aa->actividad->descripcion}}</td>
                            <td>{{$aa->peso." % DE LA EVALUACIÓN"}}</td>
                            <td>{{"Entre ".$aa->fecha_inicio." & ".$aa->fecha_final}}</td>
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
                                        <li><b>Estandar:</b> {{$item->aprendizaje->estandarcomponente->estandar->titulo}}</li>
                                        <li>
                                            <b>Componente:</b> {{$item->aprendizaje->componentecompetencia->componente->componente}}
                                        </li>
                                        <li>
                                            <b>Competencia:</b> {{$item->aprendizaje->componentecompetencia->competencia->competencia}}
                                        </li>
                                        <li>
                                            <b>Aprendizaje:</b> {{$item->aprendizaje->logro}}
                                        </li>
                                    </ul>
                                @endforeach
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <h3 style="text-align: center; padding: 20px;"><b>CONTENIDO</b></h3>
                @if($aa->actividad->tipo=='ACTIVIDAD-VACIA')
                    <h4 class="text-center text-danger">Esta actividad es solo un espacio para que el docente aplique
                        una calificación de una actividad realizada en clase fuera del entorno virtual</h4>
                @endif
                @if($aa->actividad->tipo=='EXAMEN')
                    <h4>Cuestionario</h4>
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                <tr class="danger">
                                    <th>PREGUNTA</th>
                                    <th>PUNTOS</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(count($aa->actividad->actividadpreguntas)>0)
                                    @foreach($aa->actividad->actividadpreguntas as $py)
                                        <tr>
                                            <td>{!! str_limit($py->pregunta->pregunta, $limit = 100, $end = '...') !!}</td>
                                            <td>{{$py->pregunta->puntos}}</td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
                @if($aa->actividad->tipo=='ACTIVIDAD-RECURSO')
                    <h4>Recurso Descargable</h4>
                    <h4 class="text-center text-danger">Solo se visualizan documentos PDF, si el documento de la
                        actividad no se visualiza correctamente puede descargarlo desde <a
                            href="{{asset('documentos/aulavirtual/'.$aa->actividad->recurso)}}"
                            download="{{$aa->actividad->recurso}}">aquí.</a></h4>
                    <iframe src="{{asset('documentos/aulavirtual/'.$aa->actividad->recurso)}}" width="100%"
                            height="800px"></iframe>
                @endif
                @if($aa->actividad->tipo=='ACTIVIDAD-ESCRITA')
                    <div class="col-md-12">
                        <div class="col-md-12"
                             style="border: 1px solid; border-color: #eee; padding: 50px;-webkit-box-shadow: 0px 0px 20px -4px rgba(0,0,0,0.75);-moz-box-shadow: 0px 0px 20px -4px rgba(0,0,0,0.75);box-shadow: 0px 0px 20px -4px rgba(0,0,0,0.75);">
                            <h3>{{$aa->actividad->nombre}}</h3><br/>
                            <h4>{{$aa->actividad->descripcion}}</h4><br/>
                            {!!$aa->actividad->recurso!!}
                        </div>
                    </div>
                @endif
                <div class="col-md-12">
                    <h3 style="text-align: center; padding: 20px; margin-top: 20px;"><b>RESULTADO</b></h3>
                    @if(count($aa->resultadoactividads)>0)
                        @if($aa->actividad->tipo=='ACTIVIDAD-VACIA' || $aa->actividad->tipo=='EXAMEN')
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover">
                                    <thead>
                                    <tr class="danger">
                                        <th>CAL.</th>
                                        <th>ANOTACIONES GENERALES</th>
                                        <th>ANOTACIONES DOCENTE</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>{{number_format($aa->resultadoactividads[0]->calificacion,2)}}</td>
                                        <td>{{$aa->resultadoactividads[0]->anotaciones_sistema}}</td>
                                        <td>{{$aa->resultadoactividads[0]->anotaciones_docente}}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        @endif
                        @if($aa->actividad->tipo=='ACTIVIDAD-RECURSO' or $aa->actividad->tipo=='ACTIVIDAD-ESCRITA')
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover">
                                    <thead>
                                    <tr class="danger">
                                        <th>CAL.</th>
                                        <th>ANOTACIONES GENERALES</th>
                                        <th>ANOTACIONES DOCENTE</th>
                                        <th>EVIDENCIA</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>{{number_format($aa->resultadoactividads[0]->calificacion,2)}}</td>
                                        <td>{{$aa->resultadoactividads[0]->anotaciones_sistema}}</td>
                                        <td>{{$aa->resultadoactividads[0]->anotaciones_docente}}</td>
                                        <td><a target="_blank"
                                               href="{{asset('documentos/aulavirtual/'.$aa->resultadoactividads[0]->recurso)}}">{{$aa->resultadoactividads[0]->recurso}}</a>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    @else
                        <h4 class="text-center text-danger">No hay calificación todavía.</h4>
                    @endif
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
                    <p>Esta funcionalidad permite la visualización de actividades y simulacros EBEDUC para una materia,
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
            // $(document.body).attr('class', 'skin-blue sidebar-mini sidebar-collapse');
        });
    </script>
@endsection
