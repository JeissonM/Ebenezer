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
     <li><a href="{{route('aulavirtual.menuaulaestudiante',$gmd->id)}}"><i class="fa fa-list"></i> Panel Aula Virtual</a></li>
     <li><a href="{{route('realizaractividad.index',$gmd->id)}}"><i class="fa fa-check"></i> Realizar Actividades, Exámenes & Ebeduc</a></li>
     <li class="active"><a> Realizar</a></li>
 </ol>
 @endsection
 @section('content')
 <div class="box">
     <div class="box-header with-border">
         <h3 class="box-title">REALIZAR ACTIVIDADES, EXAMENES & EBEDUC</h3>
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
             <h3 style="text-align: center; padding: 20px;"><b>@if($aa->ebeduc=='SI') PRUEBA EBEDUC @else ACTIVIDAD/EXAMEN @endif</b></h3>
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
                                     </ul>
                                 @endforeach
                             </td>
                         </tr>
                     </tbody>
                 </table>
             </div>
             <h3 style="text-align: center; padding: 20px;"><b>EJECUTAR</b></h3>
             @if($aa->actividad->tipo=='ACTIVIDAD-VACIA')
             <h4 class="text-center text-danger">Esta actividad es solo un espacio para que el docente aplique una calificación de una actividad realizada en clase fuera del entorno virtual</h4>
             @if(count($aa->resultadoactividads)>0)
             <h3 style="text-align: center; padding: 20px; margin-top: 20px;"><b>EVIDENCIA DE LA ACTIVIDAD</b></h3>
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
                             <td>{{$aa->resultadoactividads[0]->calificacion}}</td>
                             <td>{{$aa->resultadoactividads[0]->anotaciones_sistema}}</td>
                             <td>{{$aa->resultadoactividads[0]->anotaciones_docente}}</td>
                         </tr>
                     </tbody>
                 </table>
             </div>
             @else
             <h3 style="text-align: center; padding: 20px; margin-top: 20px;"><b>SOLICITAR CALIFICACIÓN DE LA ACTIVIDAD (Si no realiza este paso, no tendrá calificación para la actividad)</b></h3>
             <form class="form" role='form' method="POST" action="{{route('realizaractividad.pedircalificacion')}}">
                 @csrf
                 <input type="hidden" name="gmd_id" value="{{$gmd->id}}" />
                 <input type="hidden" name="periodoacademico_id" value="{{$gmd->gradomateria->periodoacademico_id}}" />
                 <input type="hidden" name="asignaractividad_id" value="{{$aa->id}}" />
                 <input type="hidden" name="grupo_id" value="{{$gmd->grupo_id}}" />
                 <input type="hidden" name="evaluacionacademica_id" value="{{$eval->id}}" />
                 <input type="hidden" name="estudiante_id" value="{{$est->id}}" />
                 <input type="hidden" name="ebeduc" value="{{$aa->ebeduc}}" />
                 <input type="hidden" name="peso" value="{{$aa->peso}}" />
                 <input type="hidden" name="tipo" value="{{$aa->actividad->tipo}}" />
                 <div class="col-md-12" style="margin-top: 20px !important">
                     <div class="form-group">
                         <button class="btn btn-success icon-btn pull-left" type="submit"><i class="fa fa-fw fa-lg fa-save"></i>PEDIR CALIFICACIÓN</button>
                     </div>
                 </div>
             </form>
             @endif
             @endif
             @if($aa->actividad->tipo=='EXAMEN')
             @if(count($aa->resultadoactividads)>0)
             <h3 style="text-align: center; padding: 20px; margin-top: 20px;"><b>EVIDENCIA DE LA ACTIVIDAD</b></h3>
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
                             <td>{{$aa->resultadoactividads[0]->calificacion}}</td>
                             <td>{{$aa->resultadoactividads[0]->anotaciones_sistema}}</td>
                             <td>{{$aa->resultadoactividads[0]->anotaciones_docente}}</td>
                         </tr>
                     </tbody>
                 </table>
             </div>
             @else
             <form class="form" role='form' method="POST" action="{{route('realizaractividad.guardarexamen')}}">
                 @csrf
                 <input type="hidden" name="gmd_id" value="{{$gmd->id}}" />
                 <input type="hidden" name="periodoacademico_id" value="{{$gmd->gradomateria->periodoacademico_id}}" />
                 <input type="hidden" name="asignaractividad_id" value="{{$aa->id}}" />
                 <input type="hidden" name="grupo_id" value="{{$gmd->grupo_id}}" />
                 <input type="hidden" name="evaluacionacademica_id" value="{{$eval->id}}" />
                 <input type="hidden" name="estudiante_id" value="{{$est->id}}" />
                 <input type="hidden" name="ebeduc" value="{{$aa->ebeduc}}" />
                 <input type="hidden" name="peso" value="{{$aa->peso}}" />
                 <input type="hidden" name="tipoa" value="{{$aa->actividad->tipo}}" />
                 <div class="col-md-12">
                     @if(count($aa->actividad->actividadpreguntas)>0)
                     <ol>
                         @foreach($aa->actividad->actividadpreguntas as $py)
                         <li style="background-color: #eee; border: 1px solid; border-radius: 5px; padding: 10px; margin-top: 10px;">
                             <input type="hidden" name="pregunta_id[]" value="{{$py->pregunta_id}}" />
                             <input type="hidden" name="tipo[]" value="{{$py->pregunta->tipo}}" />
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
                             @else
                             <textarea id='respuesta_{{$py->pregunta_id}}' name='respuesta_{{$py->pregunta->id}}[]' rows='5' cols='80' required></textarea>
                             @endif
                         </li>
                         @endforeach
                     </ol>
                     @endif
                 </div>
                 <div class="col-md-12" style="margin-top: 20px !important">
                     <div class="form-group">
                         <button class="btn btn-success icon-btn pull-left" type="submit"><i class="fa fa-fw fa-lg fa-save"></i>Guardar Respuestas</button>
                     </div>
                 </div>
             </form>
             @endif
             @endif
             @if($aa->actividad->tipo=='ACTIVIDAD-RECURSO')
             <h4>Recurso Descargable</h4>
             <h4 class="text-center text-danger">Solo se visualizan documentos PDF, si el documento de la actividad no se visualiza correctamente puede descargarlo desde <a href="{{asset('documentos/aulavirtual/'.$aa->actividad->recurso)}}" download="{{$aa->actividad->recurso}}">aquí.</a></h4>
             <iframe src="{{asset('documentos/aulavirtual/'.$aa->actividad->recurso)}}" width="100%" height="800px"></iframe>
             @endif
             @if($aa->actividad->tipo=='ACTIVIDAD-ESCRITA')
             <div class="col-md-12">
                 <div class="col-md-12" style="border: 1px solid; border-color: #eee; padding: 50px;-webkit-box-shadow: 0px 0px 20px -4px rgba(0,0,0,0.75);-moz-box-shadow: 0px 0px 20px -4px rgba(0,0,0,0.75);box-shadow: 0px 0px 20px -4px rgba(0,0,0,0.75);">
                     <h3>{{$aa->actividad->nombre}}</h3><br />
                     <h4>{{$aa->actividad->descripcion}}</h4><br />
                     {!!$aa->actividad->recurso!!}
                 </div>
             </div>
             @endif
             @if($aa->actividad->tipo=='ACTIVIDAD-RECURSO' or $aa->actividad->tipo=='ACTIVIDAD-ESCRITA')
             <div class="col-md-12">
                 @if(count($aa->resultadoactividads)>0)
                 <h3 style="text-align: center; padding: 20px; margin-top: 20px;"><b>EVIDENCIA DE LA ACTIVIDAD CARGADA</b></h3>
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
                                 <td>{{$aa->resultadoactividads[0]->calificacion}}</td>
                                 <td>{{$aa->resultadoactividads[0]->anotaciones_sistema}}</td>
                                 <td>{{$aa->resultadoactividads[0]->anotaciones_docente}}</td>
                                 <td><a target="_blank" href="{{asset('documentos/aulavirtual/'.$aa->resultadoactividads[0]->recurso)}}">{{$aa->resultadoactividads[0]->recurso}}</a></td>
                             </tr>
                         </tbody>
                     </table>
                 </div>
                 @endif
                 <h3 style="text-align: center; padding: 20px; margin-top: 20px;"><b>CARGAR EVIDENCIA DE LA ACTIVIDAD</b></h3>
                 <h4>Mientras la actividad se encuentre habilitada usted puede corregir el documento y subirlo de nuevo cuantas veces quiera. Tenga en cuenta que si la evidencia que subió ya tiene calificación dicha nota será borrada cuando suba un nuevo documento.</h4>
                 <form class="form" enctype="multipart/form-data" role='form' method="POST" action="{{route('realizaractividad.subirresultado')}}">
                     @csrf
                     <input type="hidden" name="gmd_id" value="{{$gmd->id}}" />
                     <input type="hidden" name="periodoacademico_id" value="{{$gmd->gradomateria->periodoacademico_id}}" />
                     <input type="hidden" name="asignaractividad_id" value="{{$aa->id}}" />
                     <input type="hidden" name="grupo_id" value="{{$gmd->grupo_id}}" />
                     <input type="hidden" name="evaluacionacademica_id" value="{{$eval->id}}" />
                     <input type="hidden" name="estudiante_id" value="{{$est->id}}" />
                     <input type="hidden" name="ebeduc" value="{{$aa->ebeduc}}" />
                     <input type="hidden" name="peso" value="{{$aa->peso}}" />
                     <input type="hidden" name="tipo" value="{{$aa->actividad->tipo}}" />
                     <div class="col-md-12">
                         <div class="form-group">
                             <label>De clic aquí para seleccionar el documento evidencia de la solución de la actividad</label>
                             <input type="file" class="form-control" name="recurso" required="required">
                         </div>
                     </div>
                     <div class="col-md-12" style="margin-top: 20px !important">
                         <div class="form-group">
                             <button class="btn btn-success icon-btn pull-left" type="submit"><i class="fa fa-fw fa-lg fa-save"></i>Guardar</button>
                         </div>
                     </div>
                 </form>
             </div>
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
                 <p>Esta funcionalidad permite la realización de actividades y simulacros EBEDUC para una materia, grado y evaluación académica en particular.</p>
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
         $(document.body).attr('class', 'skin-blue sidebar-mini sidebar-collapse');
         var a = <?php echo json_encode($aa->actividad->actividadpreguntas) ?>;
         a.forEach(function(i) {
             if (i.pregunta.tipo == 'RESPONDA') {
                 CKEDITOR.replace('respuesta_' + i.pregunta_id);
             }
         });
     });
 </script>
 @endsection
