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
     <li class="active"><a> Realizar Actividades, Exámenes & Ebeduc</a></li>
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
                         </tr>
                     </thead>
                     <tbody>
                         <tr>
                             <td>{{$se->nombre}}</td>
                             <td>{{number_format($se->nota_inicial,2,'.',',')." - ".number_format($se->nota_final,2,'.',',')}}</td>
                             <td>{{number_format($se->nota_aprobatoria,2,'.',',')}}</td>
                         </tr>
                     </tbody>
                 </table>
             </div>
         </div>
         <div class="col-md-12">
             <h3 style="text-align: center; padding: 20px;"><b>EVALUACIONES ACADÉMICAS</b></h3>
             <div class="box-group" id="accordion">
                 <!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
                 @if(count($evals)>0)
                 @foreach($evals as $e)
                 <div class="panel box box-success">
                     <div class="box-header with-border panela">
                         <h4 class="box-title">
                             <a data-toggle="collapse" data-parent="#accordion" href="#collapse{{$e->id}}">
                                 {{$e->nombre." (".$e->peso."%)"}}
                             </a>
                         </h4>
                     </div>
                     <div id="collapse{{$e->id}}" class="panel-collapse collapse">
                         <div class="box-body">
                             <!-- CONTENIDO PERIODO -->
                             <div class="col-md-12">
                                 <h4><b>ACTIVIDADES</b></h4>
                                 @if($e->actividades!=null)
                                 <div class="table-responsive">
                                     <table class="table table-bordered table-striped table-hover">
                                         <thead>
                                             <tr class="danger">
                                                 <th>ACTIVIDAD</th>
                                                 <th>TIPO-PESO</th>
                                                 <th>FECHA ENTREGA</th>
                                                 <th>ESTADO</th>
                                                 <th>ACCIONES</th>
                                             </tr>
                                         </thead>
                                         <tbody>
                                             @foreach($e->actividades as $a)
                                             @if($a->ebeduc=='NO')
                                             <tr>
                                                 <td>{{$a->actividad->nombre}}</td>
                                                 <td>{{$a->actividad->tipo." - ".$a->peso."%"}}</td>
                                                 <td>{{"Entre ".$a->fecha_inicio." y ".$a->fecha_final}}</td>
                                                 <td>
                                                     @if($a->vencida=='SI')
                                                     <label class="label label-danger">VENCIDA</label>
                                                     @else
                                                     <label class="label label-success">VIGENTE</label>
                                                     @endif
                                                 </td>
                                                 <td>
                                                     <a href="{{route('realizaractividad.ver',[$gmd->id,$a->id])}}" style='margin-left: 10px; cursor: pointer;' data-toggle='tooltip' title="Ver Actividad"><i class="fa fa-eye"></i></a>
                                                     @if($a->vencida=='NO')
                                                     <a href="{{route('realizaractividad.realizar',[$gmd->id,$a->id])}}" style='margin-left: 10px; cursor: pointer; color:#009688;' data-toggle='tooltip' title="Realizar Actividad"><i class="fa fa-check"></i></a>
                                                     @endif
                                                 </td>
                                             </tr>
                                             @endif
                                             @endforeach
                                         </tbody>
                                     </table>
                                 </div>
                                 @else
                                 <h4 style="color: red;"><i class="fa fa-warning"></i> No hay actividades en esta evaluación.</h4>
                                 @endif
                             </div>
                             <div class="col-md-12">
                                 <h4><b>PRUEBA EBEDUC</b></h4>
                                 @if($e->actividades!=null)
                                 <div class="table-responsive">
                                     <table class="table table-bordered table-striped table-hover">
                                         <thead>
                                             <tr class="danger">
                                                 <th>PRUEBA</th>
                                                 <th>TIPO</th>
                                                 <th>FECHA ENTREGA</th>
                                                 <th>ESTADO</th>
                                                 <th>ACCIONES</th>
                                             </tr>
                                         </thead>
                                         <tbody>
                                             @foreach($e->actividades as $a)
                                             @if($a->ebeduc=='SI')
                                             <tr>
                                                 <td>{{$a->actividad->nombre}}</td>
                                                 <td>{{$a->actividad->tipo." - ".$a->peso."%"}}</td>
                                                 <td>{{"Entre ".$a->fecha_inicio." y ".$a->fecha_final}}</td>
                                                 <td>
                                                     @if($a->vencida=='SI')
                                                     <label class="label label-danger">VENCIDA</label>
                                                     @else
                                                     <label class="label label-success">VIGENTE</label>
                                                     @endif
                                                 </td>
                                                 <td>
                                                     <a href="{{route('realizaractividad.ver',[$gmd->id,$a->id])}}" style='margin-left: 10px; cursor: pointer;' data-toggle='tooltip' title="Ver Prueba Ebeduc"><i class="fa fa-eye"></i></a>
                                                     @if($a->vencida=='NO')
                                                     <a href="{{route('realizaractividad.realizar',[$gmd->id,$a->id])}}" style='margin-left: 10px; cursor: pointer; color:#009688;' data-toggle='tooltip' title="Realizar Prueba Ebeduc"><i class="fa fa-check"></i></a>
                                                     @endif
                                                 </td>
                                             </tr>
                                             @endif
                                             @endforeach
                                         </tbody>
                                     </table>
                                 </div>
                                 @else
                                 <h4 style="color: red;"><i class="fa fa-warning"></i> No hay pruebas ebeduc en esta evaluación.</h4>
                                 @endif
                             </div>
                         </div>
                     </div>
                 </div>
                 @endforeach
                 @else
                 <h4><b><i class="fa fa-warning"></i> No hay evaluaciones académicas relacionadas</b></h4>
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
     });
 </script>
 @endsection