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
     <li><a href="{{route('ebeduc.index',$gmd->id)}}"><i class="fa fa-list-ol"></i> Banco Ebeduc</a></li>
     <li class="active"><a> Continuar</a></li>
 </ol>
 @endsection
 @section('content')
 <div class="box">
     <div class="box-header with-border">
         <h3 class="box-title">BANCO EBEDUC</h3>
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
                             <th>PRUEBA EBEDUC</th>
                             <th>DESCRIPCIÓN</th>
                             <th>TIPO</th>
                             <th>EVALUACIÓN ACADÉMICA</th>
                             <th>AUTOR</th>
                         </tr>
                     </thead>
                     <tbody>
                         <tr>
                             <td>{{$a->nombre}}</td>
                             <td>{{$a->descripcion}}</td>
                             <td>{{$a->tipo}}</td>
                             <td>{{$a->evaluacionacademica->nombre." (".$a->evaluacionacademica->peso."%)"}}</td>
                             <td>{{$a->user->nombres." ".$a->user->apellidos}}</td>
                         </tr>
                     </tbody>
                 </table>
             </div>
         </div>
         <div class="col-md-12">
             <div class="col-md-6">
                 <div class="callout callout-danger" style="padding: 5px; padding-left: 20px; text-align: center;">
                     <h2>Todas las Preguntas de la Materia</h2>
                 </div>
                 <div class="table-responsive">
                     <table id="tb" class="table table-bordered table-striped table-hover">
                         <thead>
                             <tr class="danger">
                                 <th>PREGUNTA</th>
                                 <th>PUNTOS</th>
                                 <th>AGREGAR</th>
                             </tr>
                         </thead>
                         <tbody>
                             @foreach($preguntas as $p)
                             <tr>
                                 <td>{!! str_limit($p->pregunta, $limit = 50, $end = '...') !!}</td>
                                 <td>{{$p->puntos}}</td>
                                 <td>
                                     <a href="{{route('ebeduc.addpregunta',[$gmd->id,$a->id,$p->id])}}" style="margin-left: 10px;" data-toggle="tooltip" title="Agregar Pregunta" style="margin-left: 10px;"><i class="fa fa-check"></i></a>
                                 </td>
                             </tr>
                             @endforeach
                         </tbody>
                     </table>
                 </div>
             </div>
             <div class="col-md-6">
                 <div class="callout callout-danger" style="padding: 5px; padding-left: 20px; text-align: center;">
                     <h2>Preguntas Cargadas en la Prueba Ebeduc</h2>
                 </div>
                 <div class="table-responsive">
                     <table class="table table-bordered table-striped table-hover">
                         <thead>
                             <tr class="danger">
                                 <th>PREGUNTA</th>
                                 <th>PUNTOS</th>
                                 <th>RETIRAR</th>
                             </tr>
                         </thead>
                         <tbody>
                             @if(count($preguntasya)>0)
                             @foreach($preguntasya as $py)
                             <tr>
                                 <td>{!! str_limit($py->pregunta->pregunta, $limit = 50, $end = '...') !!}</td>
                                 <td>{{$py->pregunta->puntos}}</td>
                                 <td>
                                     <a href="{{route('ebeduc.deletepregunta',[$gmd->id,$py->id])}}" style="margin-left: 10px; color:red;" data-toggle="tooltip" title="Retirar Pregunta"><i class="fa fa-times"></i></a>
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