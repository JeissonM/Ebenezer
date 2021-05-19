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
     <li><a href="{{route('actividad.index',$gmd->id)}}"><i class="fa fa-list-ol"></i> Banco de Actividades</a></li>
     <li class="active"><a> Editar</a></li>
 </ol>
 @endsection
 @section('content')
 <div class="box">
     <div class="box-header with-border">
         <h3 class="box-title">BANCO DE ACTIVIDADES</h3>
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
         <div class="col-md-12" style="display: flex; justify-content: center;">
             <div class="col-md-5" style="border: 1px solid; margin: 10px;">
                 <h4>Datos de la Actividad Editables</h4>
                 <form class="form" role='form' method="POST" action="{{route('actividad.update')}}">
                     @csrf
                     <input type="hidden" name="data" value="BASICO" />
                     <input type="hidden" name="gmd_id" value="{{$gmd->id}}" />
                     <input type="hidden" name="a_id" value="{{$a->id}}" />
                     <div class="col-md-12">
                         <div class="form-group">
                             <label>Nombre de la Actividad</label>
                             <input class="form-control" type="text" value="{{$a->nombre}}" required="required" name="nombre">
                         </div>
                     </div>
                     <div class="col-md-12">
                         <div class="form-group">
                             <label>Descripción (Opcional)</label>
                             <input class="form-control" type="text" value="{{$a->descripcion}}" name="descripcion">
                         </div>
                     </div>
                     <div class="col-md-12">
                         <div class="form-group">
                             <label>Evaluación Académica</label>
                             <select class="form-control" name="evaluacionacademica_id" required>
                                 @foreach($evaluaciones as $key=>$value)
                                 @if($a->evaluacionacademica_id==$key)
                                 <option selected value="{{$key}}">{{$value}}</option>
                                 @else
                                 <option value="{{$key}}">{{$value}}</option>
                                 @endif
                                 @endforeach
                             </select>
                         </div>
                     </div>
                     <div class="col-md-12">
                         <div class="form-group">
                             <button class="btn btn-success icon-btn btn-block" type="submit"><i class="fa fa-fw fa-lg fa-save"></i>Guardar</button>
                         </div>
                     </div>
                 </form>
             </div>
             @if($a->tipo=='ACTIVIDAD-RECURSO')
             <div class="col-md-5" style="border: 1px solid; margin: 10px;">
                 <h4>Cambiar el Documento</h4>
                 <a href="{{asset('documentos/aulavirtual/'.$a->recurso)}}" target="_blank">Ver el Documento Actual</a>
                 <form class="form" role='form' enctype="multipart/form-data" method="POST" action="{{route('actividad.update')}}">
                     @csrf
                     <input type="hidden" name="data" value="DOCUMENTO" />
                     <input type="hidden" name="gmd_id" value="{{$gmd->id}}" />
                     <input type="hidden" name="a_id" value="{{$a->id}}" />
                     <div class="col-md-12">
                         <div class='form-group'>
                             <label>Suba el Documento con la Descripción de la Actividad (PDF)</label>
                             <input type='file' required name='recurso' accept='.pdf' class='form-control' />
                         </div>
                     </div>
                     <div class="col-md-12">
                         <div class="form-group">
                             <button class="btn btn-success icon-btn btn-block" type="submit"><i class="fa fa-fw fa-lg fa-save"></i>Guardar</button>
                         </div>
                     </div>
                 </form>
             </div>
             @endif
             @if($a->tipo=='ACTIVIDAD-ESCRITA')
             <div class="col-md-5" style="border: 1px solid; margin: 10px;">
                 <h4>Cambiar el Contenido</h4>
                 <form class="form" role='form' enctype="multipart/form-data" method="POST" action="{{route('actividad.update')}}">
                     @csrf
                     <input type="hidden" name="data" value="ESCRITO" />
                     <input type="hidden" name="gmd_id" value="{{$gmd->id}}" />
                     <input type="hidden" name="a_id" value="{{$a->id}}" />
                     <div class="col-md-12">
                         <div class='form-group'>
                             <label>Redacte la Actividad Aquí...</label>
                             <textarea id='recurso' name='recurso' rows='10' cols='80' required>{{$a->recurso}}</textarea>
                         </div>
                     </div>
                     <div class="col-md-12">
                         <div class="form-group">
                             <button class="btn btn-success icon-btn btn-block" type="submit"><i class="fa fa-fw fa-lg fa-save"></i>Guardar</button>
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
                 <p>Esta funcionalidad permite gestionar un completo banco de actividades para una materia, grado y evaluación académica en particular.</p>
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
         CKEDITOR.replace('recurso');
     });
 </script>
 @endsection