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
     <li class="active"><a>Panel Aula Virtual</a></li>
 </ol>
 @endsection
 @section('content')
 <div class="box">
     <div class="box-header with-border">
         <h3 class="box-title">AULA VIRTUAL</h3>
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
         </div>
         <div class="col-md-12" style="text-align: center;">
             <div class="col-md-4">
                 <a href="{{route('contenidotematico.estudiante',$gmd->id)}}" class="btn btn-raised btn-app btn-warning btn-block">
                     <i class="fa fa-book"></i> Contenido Temático
                     <div class="ripple-container"></div>
                 </a>
             </div>
             <div class="col-md-4">
                 <a class="btn btn-app btn-raised btn-block btn-info" data-toggle="modal" data-target="#modal2">
                     <i class="fa fa-users"></i> Estudiantes & Docente
                     <div class="ripple-container"></div>
                 </a>
             </div>
             <div class="col-md-4">
                 <a href="{{route('forodiscusion.estudianteinicio',$gmd->id)}}" class="btn btn-raised btn-app btn-danger btn-block">
                     <i class="fa fa-bullhorn"></i> Foros de Discusión
                     <div class="ripple-container"></div>
                 </a>
             </div>
             <div class="col-md-4">
                 <a href="{{route('realizaractividad.index',$gmd->id)}}" class="btn btn-app btn-raised btn-primary btn-block">
                     <i class="fa fa-edit"></i> Realizar Actividades, Exámenes & Ebeduc
                     <div class="ripple-container"></div>
                 </a>
             </div>
             <div class="col-md-4">
                 <a href="{{route('calificacionestudiante.index',$gmd->id)}}" class="btn btn-raised btn-app btn-success btn-block">
                     <i class="fa fa-list-ol"></i> Calificaciones
                     <div class="ripple-container"></div>
                 </a>
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
                 <p>Esta funcionalidad le permite gestionar el <b>Aula Virtual</b>, realizar actividades, evaluaciones, ver calificaciones y participar en los foros de inquietudes sobre las temáticas de la cátedra.</p>
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
 <div class="modal fade" id="modal2">
     <div class="modal-dialog">
         <div class="modal-content">
             <div class="modal-header">
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span></button>
                 <h4 class="modal-title">Docente & Estudiantes del Curso</h4>
             </div>
             <div class="modal-body">

                 <!-- TO DO List -->
                 <div class="box box-primary">
                     <div class="box-body">
                         <!-- See dist/js/pages/dashboard.js to activate the todoList plugin -->
                         <ul class="todo-list">
                             <li>
                                 <span class="handle">
                                     <i class="fa fa-ellipsis-v"></i>
                                     <i class="fa fa-ellipsis-v"></i>
                                 </span>
                                 <input type="checkbox" value="">
                                 <small class="label label-success"><i class="fa fa-clock-o"></i> DOCENTE</small>
                                 <span class="text">{{$docente->personanatural->primer_nombre." ".$docente->personanatural->segundo_nombre." ".$docente->personanatural->primer_apellido." ".$docente->personanatural->segundo_apellido}}</span>
                             </li>
                             @if(count($contactos)>0)
                             @foreach($contactos as $c)
                             <li>
                                 <span class="handle">
                                     <i class="fa fa-ellipsis-v"></i>
                                     <i class="fa fa-ellipsis-v"></i>
                                 </span>
                                 <input type="checkbox" value="">
                                 <small class="label label-primary"><i class="fa fa-clock-o"></i> ESTUDIANTE</small>
                                 <span class="text">{{$c->estudiante->personanatural->primer_nombre." ".$c->estudiante->personanatural->segundo_nombre." ".$c->estudiante->personanatural->primer_apellido." ".$c->estudiante->personanatural->segundo_apellido}}</span>
                             </li>
                             @endforeach
                             @endif
                         </ul>
                     </div>
                 </div>
                 <!-- /.box -->
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
 @endsection
 @section('script')
 <script type="text/javascript">
     $(document).ready(function() {
         //$('#example1').DataTable();
         $(document.body).attr('class', 'skin-blue sidebar-mini sidebar-collapse');
     });
 </script>
 @endsection