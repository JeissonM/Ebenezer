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
     <li class="active"><a> Continuar</a></li>
 </ol>
 @endsection
 @section('content')
 <div class="box">
     <div class="box-header with-border">
         <h3 class="box-title">BANCO DE PREGUNTAS - RESPUESTAS DE LA PREGUNTA</h3>
         <div class="box-tools pull-right">
             <button type="button" class="btn btn-box-tool" data-toggle="modal" data-target="#modal" title="Ayuda">
                 <i class="fa fa-question"></i></button>
             <button onclick="editor()" type="button" class="btn btn-box-tool" data-toggle="modal" data-target="#modalcrear" title="Agregar Respuesta">
                 <i class="fa fa-plus"></i></button>
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
                             <th>PREGUNTA</th>
                             <th>PUNTOS</th>
                             <th>AUTOR</th>
                             <th>RESPUESTA CRTA.</th>
                         </tr>
                     </thead>
                     <tbody>
                         <tr>
                             <td>{!! str_limit($a->pregunta, $limit = 100, $end = '...') !!}</td>
                             <td>{{$a->puntos}}</td>
                             <td>{{$a->user->nombres." ".$a->user->apellidos}}</td>
                             <td>{{$a->resp}}</td>
                         </tr>
                     </tbody>
                 </table>
             </div>
         </div>
         <div class="col-md-12">
             <h3>Listado de Respuestas en la Pregunta Seleccionada</h3>
             <div class="table-responsive">
                 <table id="tb" class="table table-bordered table-striped table-hover">
                     <thead>
                         <tr class="danger">
                             <th>LETRA</th>
                             <th>RESPUESTA</th>
                             <th>ACCIONES</th>
                         </tr>
                     </thead>
                     <tbody>
                         @if(count($a->respuestas)>0)
                         @foreach($a->respuestas as $r)
                         <tr>
                             <td>{{$r->letra}}</td>
                             <td>{!! str_limit($r->respuesta, $limit = 100, $end = '...') !!}</td>
                             <td>
                                 <a onclick="ponerDatos(this.id)" id="{{$r}}" type="button" class="btn btn-box-tool" data-toggle="modal" data-target="#modaleditar" style='margin-left: 10px; cursor: pointer;' data-toggle='tooltip' title='Editar'><i class='fa fa-edit'></i></a>
                                 <a href="{{route('preguntas.deleterespuesta',[$gmd->id,$r->id])}}" style='margin-left: 10px; cursor: pointer; color:red;' data-toggle='tooltip' title='Eliminar'><i class='fa fa-trash-o'></i></a>
                                 <a href="{{route('preguntas.correctarespuesta',[$gmd->id,$r->id])}}" style='margin-left: 10px; cursor: pointer; color:green;' data-toggle='tooltip' title='Marcar Como Respuesta Correcta'><i class='fa fa-check'></i></a>
                             </td>
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


 <div class="modal fade" id="modalcrear">
     <div class="modal-dialog modal-lg">
         <div class="modal-content">
             <div class="modal-header">
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span></button>
                 <h4 class="modal-title">Crear Nueva Respuesta</h4>
             </div>
             <div class="modal-body">
                 <div class="row">
                     <div class="col-md-12">
                         <form class="form" role='form' enctype="multipart/form-data" method="POST" action="{{route('preguntas.storerespuesta')}}">
                             @csrf
                             <input type="hidden" name="gmd_id" value="{{$gmd->id}}" />
                             <input type="hidden" name="pregunta_id" value="{{$a->id}}" />
                             <div class="col-md-12">
                                 <div class="form-group">
                                     <label>Letra</label>
                                     <input class="form-control" type="text" required="required" name="letra">
                                 </div>
                             </div>
                             <div class="col-md-12">
                                 <div class='form-group'>
                                     <label>Redacte la Respuesta Aquí...</label>
                                     <textarea id='respuesta' name='respuesta' rows='10' required></textarea>
                                 </div>
                             </div>
                             <div class="col-md-12" style="margin-top: 20px !important">
                                 <div class="form-group">
                                     <button class="btn btn-success icon-btn pull-left" type="submit"><i class="fa fa-fw fa-lg fa-save"></i>Guardar</button>
                                     <button class="btn btn-info icon-btn pull-left" type="reset"><i class="fa fa-fw fa-lg fa-trash-o"></i>Limpiar</button>
                                     <button type="button" class="btn btn-danger btn-flat pull-left" data-dismiss="modal"> <i class="fa fa-reply"></i> Regresar</button>
                                 </div>
                             </div>
                         </form>
                     </div>
                 </div>
             </div>
         </div>
         <!-- /.modal-content -->
     </div>
     <!-- /.modal-dialog -->
 </div>
 <!-- /.modal -->

 <div class="modal fade" id="modaleditar">
     <div class="modal-dialog modal-lg">
         <div class="modal-content">
             <div class="modal-header">
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span></button>
                 <h4 class="modal-title">Editar Respuesta</h4>
             </div>
             <div class="modal-body">
                 <div class="row">
                     <div class="col-md-12">
                         <form class="form" role='form' enctype="multipart/form-data" method="POST" action="{{route('preguntas.editrespuesta')}}">
                             @csrf
                             <input type="hidden" name="gmd_id" value="{{$gmd->id}}" />
                             <input type="hidden" name="respuesta_id" id="rta_id" />
                             <div class="col-md-12">
                                 <div class="form-group">
                                     <label>Letra</label>
                                     <input class="form-control" type="text" required="required" id="letrae" name="letra">
                                 </div>
                             </div>
                             <div class="col-md-12">
                                 <div class='form-group'>
                                     <label>Redacte la Respuesta Aquí...</label>
                                     <textarea name='respuesta' rows='10' id="respuestae" required></textarea>
                                 </div>
                             </div>
                             <div class="col-md-12" style="margin-top: 20px !important">
                                 <div class="form-group">
                                     <button class="btn btn-success icon-btn pull-left" type="submit"><i class="fa fa-fw fa-lg fa-save"></i>Guardar</button>
                                     <button class="btn btn-info icon-btn pull-left" type="reset"><i class="fa fa-fw fa-lg fa-trash-o"></i>Limpiar</button>
                                     <button type="button" class="btn btn-danger btn-flat pull-left" data-dismiss="modal"> <i class="fa fa-reply"></i> Regresar</button>
                                 </div>
                             </div>
                         </form>
                     </div>
                 </div>
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

     function editor() {
         CKEDITOR.replace('respuesta');
     }

     function ponerDatos(r) {
         var r=JSON.parse(r);
         $("#rta_id").val(r.id);
         $("#letrae").val(r.letra);
         $("#respuestae").val(r.respuesta);
         CKEDITOR.replace('respuestae');
     }
 </script>
 @endsection