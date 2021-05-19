 @extends('layouts.admin')
 @section('breadcrumb')
 <h1>
     Bienvenido
     <small>Sr(a). {{Auth::user()->nombres}}</small>
 </h1>
 <ol class="breadcrumb">
     <li><a href="{{route('home')}}"><i class="fa fa-home"></i> Inicio</a></li>
     <li><a href="{{route('menu.academicoestudiante')}}"><i class="fa fa-book"></i> Académico</a></li>
     <li class="active"><a> Calificaciones</a></li>
 </ol>
 @endsection
 @section('content')
 <div class="box">
     <div class="box-header with-border">
         <h3 class="box-title">CALIFICACIONES</h3>
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
                             <th>IDENTIFICACIÓN</th>
                             <th>ESTUDIANTE</th>
                             <th>UNIDAD</th>
                             <th>PERÍODO ACADÉMICO</th>
                             <th>JORNADA</th>
                             <th>GRADO</th>
                         </tr>
                     </thead>
                     <tbody>
                         <tr>
                             <td>{{$est->personanatural->persona->numero_documento}}</td>
                             <td>{{$est->personanatural->primer_nombre." ".$est->personanatural->segundo_nombre." ".$est->personanatural->primer_apellido." ".$est->personanatural->segundo_apellido}}</td>
                             <td>{{$est->unidad->nombre." - ".$est->unidad->ciudad->nombre}}</td>
                             <td>{{$est->periodoacademico->etiqueta." - ".$est->periodoacademico->anio}}</td>
                             <td>{{$est->jornada->descripcion." - ".$est->jornada->jornadasnies}}</td>
                             <td>{{$est->grado->etiqueta." - ".$est->grado->descripcion}}</td>
                         </tr>
                     </tbody>
                 </table>
             </div>
         </div>
         <div class="col-md-12">
             <h3 style="text-align: center; padding: 20px;"><b>MATERIAS MATRICULADAS</b></h3>
             @if($data!=null)
             @foreach($data as $key=>$value)
             <div class="col-md-6">
                 <div class="table-responsive">
                     <table class="table table-bordered table-striped table-hover">
                         <thead>
                             <tr class="danger">
                                 <th>{{$key}}</th>
                             </tr>
                         </thead>
                     </table>
                 </div>
                 <div class="table-responsive">
                     <table class="table table-bordered table-striped table-hover">
                         <thead>
                             <tr class="success">
                                 <th>MATERIA</th>
                                 <th>CALIFICACIÓN</th>
                             </tr>
                         </thead>
                         <tbody>
                             @foreach($value as $materia)
                             @foreach($materia as $i=>$v)
                             <tr>
                                 <td>{{$i}}</td>
                                 <td>{{number_format($v,2)}}</td>
                             </tr>
                             @endforeach
                             @endforeach
                         </tbody>
                     </table>
                 </div>
             </div>
             @endforeach
             @else
             <h4><b><i class="fa fa-warning"></i> El estudiante no tiene materias matriculadas</b></h4>
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
                 <p>Esta funcionalidad permite la visualización de las calificaciones del estudiante</p>
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
         //$('#tb').DataTable();
         //$(document.body).attr('class', 'skin-blue sidebar-mini sidebar-collapse');
     });
 </script>
 @endsection