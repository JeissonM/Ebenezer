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
     <li class="active"><a> Banco Ebeduc</a></li>
 </ol>
 @endsection
 @section('content')
 <div class="box">
     <div class="box-header with-border">
         <h3 class="box-title">BANCO EBEDUC</h3>
         <div class="box-tools pull-right">
             <button type="button" class="btn btn-box-tool" data-toggle="modal" data-target="#modal" title="Ayuda">
                 <i class="fa fa-question"></i></button>
             <a href="{{route('ebeduc.crear',$gmd->id)}}" class="btn btn-box-tool" data-toggle="tooltip" data-original-title="Agregar Prueba Ebeduc">
                 <i class="fa fa-plus-circle"></i></a>
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
             <h3>Listado de Pruebas(solo quién crea la prueba puede editarla o gestionarla)</h3>
             <div class="table-responsive">
                 <table id="tb" class="table table-bordered table-striped table-hover">
                     <thead>
                         <tr class="danger">
                             <th>TÍTULO</th>
                             <th>DESCRIPCIÓN</th>
                             <th>EVALUACIÓN ACADÉMICA</th>
                             <th>AUTOR</th>
                             <th>ACCIONES</th>
                         </tr>
                     </thead>
                     <tbody>
                         @foreach($actividades as $a)
                         @if($a->ebeduc=='SI')
                         <tr>
                             <td>{{$a->nombre}}</td>
                             <td>{{$a->descripcion}}</td>
                             <td>{{$a->evaluacionacademica->nombre." (".$a->evaluacionacademica->peso."%)"}}</td>
                             <td>{{$a->user->nombres." ".$a->user->apellidos}}</td>
                             <td>
                                 <a href="{{route('ebeduc.show',[$gmd->id,$a->id])}}" style='margin-left: 10px; cursor: pointer; color:green;' data-toggle='tooltip' title='Ver'><i class='fa fa-eye'></i></a>
                                 @if(Auth::user()->id==$a->user_id)
                                 <a href="{{route('ebeduc.edit',[$gmd->id,$a->id])}}" style='margin-left: 10px; cursor: pointer;' data-toggle='tooltip' title='Editar'><i class='fa fa-edit'></i></a>
                                 @if($a->tipo=='EXAMEN')
                                 <a href="{{route('ebeduc.continuar',[$gmd->id,$a->id])}}" style='margin-left: 10px; cursor: pointer; color:orangered;' data-toggle='tooltip' title='Continuar'><i class='fa fa-arrow-right'></i></a>
                                 @endif
                                 @endif
                             </td>
                         </tr>
                         @endif
                         @endforeach
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
                 <p>Esta funcionalidad permite gestionar un completo banco de pruebas ebeduc para una materia, grado y evaluación académica en particular.</p>
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