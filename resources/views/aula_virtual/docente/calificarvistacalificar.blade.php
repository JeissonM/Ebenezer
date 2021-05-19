 <?php

    use App\Http\Controllers\CalificaciondocenteController;
    use App\Respuesta;

    ?>
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
     <li><a href="{{route('aulavirtual.menuauladocente',$gmd->id)}}"><i class="fa fa-list"></i> Panel Aula Virtual</a></li>
     <li><a href="{{route('calificaciondocente.index',$gmd->id)}}"><i class="fa fa-check"></i> Calificar Actividades, Exámenes & Ebeduc</a></li>
     <li><a href="{{route('calificaciondocente.listarestudiantes',[$gmd->id,$a->id])}}"><i class="fa fa-list"></i> Listar Estudiantes</a></li>
     <li class="active"><a> Calificar Actividad</a></li>
 </ol>
 @endsection
 @section('content')
 <div class="box">
     <div class="box-header with-border">
         <h3 class="box-title">CALIFICAR ACTIVIDADES, EXAMENES & EBEDUC</h3>
         <div class="box-tools pull-right">
             <button type="button" class="btn btn-box-tool" data-toggle="modal" data-target="#modal" title="Ayuda">
                 <i class="fa fa-question"></i></button>
             <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Minimizar">
                 <i class="fa fa-minus"></i></button>
             <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Cerrar">
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
             <div class="table-responsive">
                 <table class="table table-bordered table-striped table-hover">
                     <thead>
                         <tr class="danger">
                             <th>ACTIVIDAD</th>
                             <th>DESCRIPCIÓN</th>
                             <th>PESO</th>
                             <th>FECHA ENTREGA</th>
                             <th>TIPO</th>
                         </tr>
                     </thead>
                     <tbody>
                         <tr>
                             <td>{{$a->actividad->nombre}}</td>
                             <td>{{$a->actividad->descripcion}}</td>
                             <td>{{$a->peso." % DE LA EVALUACIÓN ACADÉMICA"}}</td>
                             <td>{{"Entre ".$a->fecha_inicio." & ".$a->fecha_final}}</td>
                             <td>{{$a->actividad->tipo}}</td>
                         </tr>
                     </tbody>
                 </table>
             </div>
             <div class="table-responsive">
                 <table class="table table-bordered table-striped table-hover">
                     <thead>
                         <tr class="danger">
                             <th>IDENTIFICACIÓN</th>
                             <th>ESTUDIANTE</th>
                             <th>CATEGORÍA</th>
                             <th>SITUACIÓN</th>
                         </tr>
                     </thead>
                     <tbody>
                         <tr>
                             <td>{{$est->personanatural->persona->numero_documento}}</td>
                             <td>{{$est->personanatural->primer_nombre." ".$est->personanatural->segundo_nombre." ".$est->personanatural->primer_apellido." ".$est->personanatural->segundo_apellido}}</td>
                             <td>{{$est->categoria->nombre}}</td>
                             <td>{{$est->situacionestudiante->nombre}}</td>
                         </tr>
                     </tbody>
                 </table>
             </div>
         </div>
         <div class="col-md-12">
             <h3 style="text-align: center; padding: 20px;"><b>CALIFICAR ACTIVIDAD</b></h3>
             @if($cal!=null)
             <h4 class="text-center text-danger">El estudiante presentó la actividad y posee calificación parcial o completa, puede terminar de calificar la actividad o modificar la calificación que ya tiene.</h4>
             @if($a->actividad->tipo=='ACTIVIDAD-RECURSO' or $a->actividad->tipo=='ACTIVIDAD-ESCRITA')
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
                             <td>{{number_format($cal->calificacion,2)}}</td>
                             <td>{{$cal->anotaciones_sistema}}</td>
                             <td>{{$cal->anotaciones_docente}}</td>
                             <td><a target="_blank" href="{{asset('documentos/aulavirtual/'.$cal->recurso)}}">{{$cal->recurso}}</a></td>
                         </tr>
                     </tbody>
                 </table>
             </div>
             @endif
             @if($a->actividad->tipo=='ACTIVIDAD-VACIA' || $a->actividad->tipo=='EXAMEN')
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
                             <td>{{number_format($cal->calificacion,2)}}</td>
                             <td>{{$cal->anotaciones_sistema}}</td>
                             <td>{{$cal->anotaciones_docente}}</td>
                         </tr>
                     </tbody>
                 </table>
             </div>
             @endif
             <!-- EDITAR -->
             @if($a->actividad->tipo=='ACTIVIDAD-RECURSO' || $a->actividad->tipo=='ACTIVIDAD-VACIA' || $a->actividad->tipo=='ACTIVIDAD-ESCRITA')
             <!-- OTRAS ACTIVIDADES -->
             <form class="form" role='form' method="POST" action="{{route('calificaciondocente.calificaractividad')}}">
                 @csrf
                 <input type="hidden" name="gmd_id" value="{{$gmd->id}}" />
                 <input type="hidden" name="periodoacademico_id" value="{{$gmd->gradomateria->periodoacademico_id}}" />
                 <input type="hidden" name="asignaractividad_id" value="{{$a->id}}" />
                 <input type="hidden" name="grupo_id" value="{{$gmd->grupo_id}}" />
                 <input type="hidden" name="evaluacionacademica_id" value="{{$a->evaluacionacademica_id}}" />
                 <input type="hidden" name="estudiante_id" value="{{$est->id}}" />
                 <input type="hidden" name="ebeduc" value="{{$a->ebeduc}}" />
                 <input type="hidden" name="peso" value="{{$a->peso}}" />
                 <input type="hidden" name="tipo" value="{{$a->actividad->tipo}}" />
                 <input type="hidden" name="r_id" value="{{$cal->id}}" />
                 <div class="col-md-6">
                     <div class="form-group">
                         <label>Anotaciones/Observaciones</label>
                         <input class="form-control" type="text" required="required" value="{{$cal->anotaciones_docente}}" name="anotaciones_docente">
                     </div>
                 </div>
                 <div class="col-md-6">
                     <div class="form-group">
                         <label>Calificación</label>
                         <input class="form-control" type="text" required="required" value="{{$cal->calificacion}}" name="calificacion">
                     </div>
                 </div>
                 <div class="col-md-12" style="margin-top: 20px !important">
                     <div class="form-group">
                         <button class="btn btn-success icon-btn pull-left" type="submit"><i class="fa fa-fw fa-lg fa-save"></i>Guardar</button>
                     </div>
                 </div>
             </form>
             @else
             <!-- EXAMEN O EBEDUC -->
             @if(count($cal->resactividadresps)>0)
             <!-- HAY EXAMEN REALIZADO, PUEDE CALIFICAR POR SISTEMA -->
             <form class="form" role='form' method="POST" action="{{route('calificaciondocente.observaciones')}}">
                 @csrf
                 <input type="hidden" name="gmd_id" value="{{$gmd->id}}" />
                 <input type="hidden" name="periodoacademico_id" value="{{$gmd->gradomateria->periodoacademico_id}}" />
                 <input type="hidden" name="asignaractividad_id" value="{{$a->id}}" />
                 <input type="hidden" name="grupo_id" value="{{$gmd->grupo_id}}" />
                 <input type="hidden" name="evaluacionacademica_id" value="{{$a->evaluacionacademica_id}}" />
                 <input type="hidden" name="estudiante_id" value="{{$est->id}}" />
                 <input type="hidden" name="ebeduc" value="{{$a->ebeduc}}" />
                 <input type="hidden" name="peso" value="{{$a->peso}}" />
                 <input type="hidden" name="tipo" value="{{$a->actividad->tipo}}" />
                 <input type="hidden" name="r_id" value="{{$cal->id}}" />
                 <div class="col-md-12">
                     <div class="form-group">
                         <label>Agregar Anotaciones u Observaciones a la Calificación</label>
                         <input class="form-control" type="text" required="required" value="{{$cal->anotaciones_docente}}" name="anotaciones_docente">
                     </div>
                 </div>
                 <div class="col-md-12" style="margin-top: 20px !important">
                     <div class="form-group">
                         <button class="btn btn-success icon-btn pull-left" type="submit"><i class="fa fa-fw fa-lg fa-save"></i>Guardar</button>
                     </div>
                 </div>
             </form>
             <div class="col-md-12">
                 <h3 style="text-align: center; padding: 20px;"><b>CUESTIONARIO</b></h3>
                 @if(count($a->actividad->actividadpreguntas)>0)
                 <ol>
                     @foreach($a->actividad->actividadpreguntas as $py)
                     <li style="background-color: #eee; border: 1px solid; border-radius: 5px; padding: 10px; margin-top: 10px;">
                         {!! $py->pregunta->pregunta !!}
                         @if($py->pregunta->tipo=='SELECCION MULTIPLE')
                         <div class="form-group">
                             @foreach($py->pregunta->respuestas as $r)
                             <div>
                                 <div class="radio">
                                     <label style="color: #000;">
                                         <input type="radio" name="respuesta_{{$py->pregunta->id}}[]" value="{{$r->id}}"><span class="circle"></span><span class="check"></span>
                                         {{$r->letra.") "}} {!! $r->respuesta !!}
                                     </label>
                                 </div>
                             </div>
                             @endforeach
                         </div>
                         <p><?php
                            $resp = CalificaciondocenteController::respuesta_correcta($cal->id, $py->pregunta_id);
                            if ($resp != null) {
                                if ($resp->respuesta_id != null) {
                                    $rr = Respuesta::find($resp->respuesta_id);
                                    echo "<b style='color: red;'>RESPUESTA: " . $rr->letra . ") " . $rr->respuesta . "</b>";
                                } else {
                                    echo "<b style='color: red;'>EL ESTUDIANTE NO RESPONDIÓ</b>";
                                }
                                echo "</br><b style='color: red;'>PUNOS PREGUNTA: " . $py->pregunta->puntos . "</b></br><b style='color: red;'>PUNTOS OBTENIDOS: " . $resp->puntos_obtenidos . "</b>";
                            }
                            ?>
                         </p>
                         @else
                         <p>
                             <?php
                                $resp = CalificaciondocenteController::respuesta_correcta($cal->id, $py->pregunta_id);
                                if ($resp != null) {
                                    if ($resp->respuesta != null) {
                                        echo "<b style='color: red;'>RESPUESTA: " . $resp->respuesta . "</b>";
                                    } else {
                                        echo "<b style='color: red;'>EL ESTUDIANTE NO RESPONDIÓ</b>";
                                    }
                                    echo "</br><b style='color: red;'>PUNOS PREGUNTA: " . $py->pregunta->puntos . "</b></br><b style='color: red;'>PUNTOS OBTENIDOS: " . $resp->puntos_obtenidos . "</b>";
                                }
                                ?>
                         </p>
                         <form class="form" role='form' method="POST" action="{{route('calificaciondocente.solocalificacion')}}">
                             @csrf
                             <input type="hidden" name="gmd_id" value="{{$gmd->id}}" />
                             <input type="hidden" name="asignaractividad_id" value="{{$a->id}}" />
                             <input type="hidden" name="estudiante_id" value="{{$est->id}}" />
                             <input type="hidden" name="resactividadresp_id" value="{{$resp->id}}" />
                             <div class="form-group">
                                 <label style="color: #000;">Calificación entre 0 y {{$py->pregunta->puntos}} (Puntos que usted cree que merece la respuesta del estudiante)</label>
                                 <input class="form-control" type="text" required="required" value="{{$resp->puntos_obtenidos}}" name="puntos_obtenidos">
                                 <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> GUARDAR CALIFICACIÓN</button>
                             </div>
                         </form>
                         @endif
                     </li>
                     @endforeach
                 </ol>
                 @endif
             </div>
             @else
             <!-- NO HAY EXAMEN REALIZADO, PUEDE EDITAR LA CALIFICACION -->
             <form class="form" role='form' method="POST" action="{{route('calificaciondocente.calificaractividad')}}">
                 @csrf
                 <input type="hidden" name="gmd_id" value="{{$gmd->id}}" />
                 <input type="hidden" name="periodoacademico_id" value="{{$gmd->gradomateria->periodoacademico_id}}" />
                 <input type="hidden" name="asignaractividad_id" value="{{$a->id}}" />
                 <input type="hidden" name="grupo_id" value="{{$gmd->grupo_id}}" />
                 <input type="hidden" name="evaluacionacademica_id" value="{{$a->evaluacionacademica_id}}" />
                 <input type="hidden" name="estudiante_id" value="{{$est->id}}" />
                 <input type="hidden" name="ebeduc" value="{{$a->ebeduc}}" />
                 <input type="hidden" name="peso" value="{{$a->peso}}" />
                 <input type="hidden" name="tipo" value="{{$a->actividad->tipo}}" />
                 <input type="hidden" name="r_id" value="{{$cal->id}}" />
                 <div class="col-md-6">
                     <div class="form-group">
                         <label>Anotaciones/Observaciones</label>
                         <input class="form-control" type="text" required="required" value="{{$cal->anotaciones_docente}}" name="anotaciones_docente">
                     </div>
                 </div>
                 <div class="col-md-6">
                     <div class="form-group">
                         <label>Calificación</label>
                         <input class="form-control" type="text" required="required" value="{{$cal->calificacion}}" name="calificacion">
                     </div>
                 </div>
                 <div class="col-md-12" style="margin-top: 20px !important">
                     <div class="form-group">
                         <button class="btn btn-success icon-btn pull-left" type="submit"><i class="fa fa-fw fa-lg fa-save"></i>Guardar</button>
                     </div>
                 </div>
             </form>
             @endif
             @endif
             @else
             <!-- CREAR NUEVA -->
             <h4 class="text-center text-danger">El estudiante no presentó la actividad, puede asignar una calificación usted mismo, sino lo hace, el sistema calificará en 0 la actividad.</h4>
             <form class="form" role='form' method="POST" action="{{route('calificaciondocente.calificarcero')}}">
                 @csrf
                 <input type="hidden" name="gmd_id" value="{{$gmd->id}}" />
                 <input type="hidden" name="periodoacademico_id" value="{{$gmd->gradomateria->periodoacademico_id}}" />
                 <input type="hidden" name="asignaractividad_id" value="{{$a->id}}" />
                 <input type="hidden" name="grupo_id" value="{{$gmd->grupo_id}}" />
                 <input type="hidden" name="evaluacionacademica_id" value="{{$a->evaluacionacademica_id}}" />
                 <input type="hidden" name="estudiante_id" value="{{$est->id}}" />
                 <input type="hidden" name="ebeduc" value="{{$a->ebeduc}}" />
                 <input type="hidden" name="peso" value="{{$a->peso}}" />
                 <input type="hidden" name="tipo" value="{{$a->actividad->tipo}}" />
                 <div class="col-md-6">
                     <div class="form-group">
                         <label>Anotaciones/Observaciones</label>
                         <input class="form-control" type="text" required="required" name="anotaciones_docente">
                     </div>
                 </div>
                 <div class="col-md-6">
                     <div class="form-group">
                         <label>Calificación</label>
                         <input class="form-control" type="text" required="required" name="calificacion">
                     </div>
                 </div>
                 <div class="col-md-12" style="margin-top: 20px !important">
                     <div class="form-group">
                         <button class="btn btn-success icon-btn pull-left" type="submit"><i class="fa fa-fw fa-lg fa-save"></i>Guardar</button>
                     </div>
                 </div>
             </form>
             @endif
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
                 <p>Esta funcionalidad permite la calificación de actividades y simulacros EBEDUC para una materia, grado y evaluación académica en particular.</p>
             </div>
             <div class="modal-footer" style="background-color: #d2d6de !important; opacity: .65;">
                 <button type="button" class="btn btn-block btn-danger btn-flat pull-right" data-dismiss="modal"> <i class="fa fa-reply"></i> Regresar</button>
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

     .panela:hover>h4>a {
         color: #FFF !important;
     }
 </style>
 @endsection
 @section('script')
 <script type="text/javascript">
     $(document).ready(function() {
         $('#tb').DataTable();
         //$(document.body).attr('class', 'skin-blue sidebar-mini sidebar-collapse');
     });
 </script>
 @endsection