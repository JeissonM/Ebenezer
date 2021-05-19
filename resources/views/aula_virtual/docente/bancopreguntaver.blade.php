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
     <li><a href="{{route('preguntas.index',$gmd->id)}}"><i class="fa fa-question"></i> Banco de Preguntas</a></li>
     <li class="active"><a> Ver</a></li>
 </ol>
 @endsection
 @section('content')
 <div class="box">
     <div class="box-header with-border">
         <h3 class="box-title">BANCO DE PREGUNTAS</h3>
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
         <div class="col-md-12">
             <h4>Datos de la Pregunta</h4>
             <table class="table table-hover">
                 <tbody>
                     <tr class="read">
                         <td class="contact"><b>Id</b></td>
                         <td class="subject">{{$a->id}}</td>
                     </tr>
                     <tr class="read">
                         <td class="contact"><b>Puntos</b></td>
                         <td class="subject">{{$a->puntos}}</td>
                     </tr>
                     <tr class="read">
                         <td class="contact"><b>Respuesta Correcta</b></td>
                         <td class="subject">{{$a->resp}}</td>
                     </tr>
                     <tr class="read">
                         <td class="contact"><b>Autor</b></td>
                         <td class="subject">{{$a->user->nombres." ".$a->user->apellidos}}</td>
                     </tr>
                     <tr class="read">
                         <td class="contact"><b>Creado</b></td>
                         <td class="subject">{{$a->created_at}}</td>
                     </tr>
                     <tr class="read">
                         <td class="contact"><b>Modificado</b></td>
                         <td class="subject">{{$a->updated_at}}</td>
                     </tr>
                     <tr class="read">
                         <td class="contact"><b>Pregunta</b></td>
                         <td class="subject">{!!$a->pregunta!!}</td>
                     </tr>
                     <tr class="read">
                         <td class="contact"><b>Todas las Respuestas</b></td>
                         <td class="subject">
                             <ul>
                                 @if(count($a->respuestas)>0)
                                 @foreach($a->respuestas as $r)
                                 <li>{{$r->letra." - "}} {!!$r->respuesta!!}</li>
                                 @endforeach
                                 @else
                                 ---
                                 @endif
                             </ul>
                         </td>
                     </tr>
                 </tbody>
             </table>
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
                 <p>Esta funcionalidad permite gestionar un completo banco de preguntas para las actividades de una materia y grado en particular.</p>
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
         $('#tb').DataTable();
     });
 </script>
 @endsection