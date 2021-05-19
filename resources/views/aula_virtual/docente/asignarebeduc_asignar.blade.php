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
     <li><a href="{{route('asignaractividad.index',$gmd->id)}}"><i class="fa fa-check"></i> Asignar Actividades</a></li>
     <li class="active"><a> Asignar Ebeduc</a></li>
 </ol>
 @endsection
 @section('content')
 <div class="box">
     <div class="box-header with-border">
         <h3 class="box-title">ASIGNAR EBEDUC</h3>
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
                             <th>EVALUACIÓN</th>
                         </tr>
                     </thead>
                     <tbody>
                         <tr>
                             <td>{{$se->nombre}}</td>
                             <td>{{number_format($se->nota_inicial,2,'.',',')." - ".number_format($se->nota_final,2,'.',',')}}</td>
                             <td>{{number_format($se->nota_aprobatoria,2,'.',',')}}</td>
                             <td>{{$ev->nombre." (".$ev->peso."%)"}}</td>
                         </tr>
                     </tbody>
                 </table>
             </div>
         </div>
         <div class="col-md-12">
             <h4>Datos de la Prueba Ebeduc (Llene los datos solicitados, seleccione la prueba y presione ASIGNAR)</h4>
             <form id="asignar-form" method="POST" action="{{route('asignarebeduc.asignarstore')}}">
                 @csrf
                 <input type="hidden" name="gmd_id" value="{{$gmd->id}}" />
                 <input type="hidden" name="e" value="{{$ev->id}}" />
                 <input type="hidden" name="actividad_id" id="actividad_id" />
                 <div class="col-md-6">
                     <div class="form-group">
                         <label>Fecha Inicio</label>
                         <input class="form-control" type="datetime-local" required="required" name="fecha_inicio">
                     </div>
                 </div>
                 <div class="col-md-6">
                     <div class="form-group">
                         <label>Fecha Vencimiento</label>
                         <input class="form-control" type="datetime-local" required="required" name="fecha_final">
                     </div>
                 </div>
                 <div class="col-md-12">
                     <div class="form-group">
                         <label>Peso %(Porcentaje (de 0 a 100) dentro del {{$ev->peso}}% de la evaluación {{$ev->nombre}})</label>
                         <input class="form-control" type="text" required="required" name="peso">
                     </div>
                 </div>
                 <div class="col-md-12">
                     <label>Listado de Pruebas en la Materia</label>
                     <div class="table-responsive">
                         <table id="tb" class="table table-bordered table-striped table-hover">
                             <thead>
                                 <tr class="danger">
                                     <th>TÍTULO</th>
                                     <th>TIPO</th>
                                     <th>EVALUACIÓN ACADÉMICA</th>
                                     <th>AUTOR</th>
                                     <th>ACCIONES</th>
                                 </tr>
                             </thead>
                             <tbody>
                                 @foreach($acts as $a)
                                 @if($a->ebeduc=='SI')
                                 <tr>
                                     <td>{{$a->nombre}}</td>
                                     <td>{{$a->tipo}}</td>
                                     <td>{{$a->evaluacionacademica->nombre." (".$a->evaluacionacademica->peso."%)"}}</td>
                                     <td>{{$a->user->nombres." ".$a->user->apellidos}}</td>
                                     <td>
                                         <a target="_blank" href="{{route('ebeduc.show',[$gmd->id,$a->id])}}" style='margin-left: 10px; cursor: pointer; color:green;' data-toggle='tooltip' title='Ver'><i class='fa fa-eye'></i></a>
                                         <a id="{{$a->id}}" onclick="asignar(this.id)" style='margin-left: 10px; cursor: pointer; color:orangered;' data-toggle='tooltip' title='ASIGNAR'><i class='fa fa-arrow-right'></i> ASIGNAR</a>
                                     </td>
                                 </tr>
                                 @endif
                                 @endforeach
                             </tbody>
                         </table>
                     </div>
                 </div>
             </form>
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
                 <p>Esta funcionalidad permite la asignación de pruebas ebeduc para una materia, grado y evaluación académica en particular.</p>
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
     });

     function asignar(id) {
         $("#actividad_id").val(id);
         if ($("#asignar-form")[0].checkValidity()) {
             $("#asignar-form").submit();
         } else {
             notify('Atención', 'Faltan campos por llenar', 'error');
         }
     }
 </script>
 @endsection