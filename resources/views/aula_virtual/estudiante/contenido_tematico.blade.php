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
     <li class="active"><a> Contenido Temático</a></li>
 </ol>
 @endsection
 @section('content')
 <div class="box">
     <div class="box-header with-border">
         <h3 class="box-title">CONTENIDO TEMÁTICO</h3>
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
             <h3 style="text-align: center; padding: 20px;"><b>UNIDADES SEGÚN EVALUACIONES ACADÉMICAS (PERÍODOS)</b></h3>
             <div class="box-group" id="accordion">
                 <!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
                 @if(count($evaluaciones)>0)
                 @foreach($evaluaciones as $e)
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
                                 @if($e->unidades!=null)
                                 @foreach($e->unidades as $u)
                                 <div class="col-lg-4 col-xs-6">
                                     <!-- small box -->
                                     <div class="small-box {{$u->color}}">
                                         <div class="inner">
                                             <h3>Unidad</h3>
                                             <p>{{str_limit($u->nombre,36,'...')}}</p>
                                             <p>AUTOR: {{$u->user->nombres." ".$u->user->apellidos}}</p>
                                         </div>
                                         <div class="icon">
                                             <i class="fa fa-book"></i>
                                         </div>
                                         <a style="cursor: pointer;" data-toggle="modal" data-target="#modal2" id="{{$u}}" onclick="verUnidad(this.id)" class="small-box-footer">Ver Datos de Unidad <i class="fa fa-eye"></i></a>
                                         <a href="{{route('contenidotematico.estudiante_temas',[$gmd->id,$u->id])}}" class="small-box-footer">Ver Contenido de Unidad (Temas y Subtemas) <i class="fa fa-arrow-circle-right"></i></a>
                                     </div>
                                 </div>
                                 @endforeach
                                 @else
                                 <h4 style="color: red;"><i class="fa fa-warning"></i> No hay unidades en esta evaluación(período).</h4>
                                 @endif
                             </div>
                         </div>
                     </div>
                 </div>
                 @endforeach
                 @else
                 <h4><b><i class="fa fa-warning"></i> No hay evaluaciones académicas(períodos) relacionadas</b></h4>
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
                 <p>Esta funcionalidad permite la visualización del contenido temático de la asignatura.</p>
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
     <div class="modal-dialog modal-lg" style="width: 80% !important;">
         <div class="modal-content">
             <div class="modal-header">
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span></button>
                 <h4 class="modal-title">Datos de Unidad</h4>
             </div>
             <div class="modal-body">
                 <div class="row">
                     <div class="col-md-12" style="margin: 2.5%; width: 95%; padding: 50px;
		-webkit-box-shadow: 0px 0px 20px -3px rgba(0, 0, 0, 0.9);
		-moz-box-shadow: 0px 0px 20px -3px rgba(0, 0, 0, 0.9);
		box-shadow: 0px 0px 20px -3px rgba(0, 0, 0, 0.9);
		font-size: 12px;">
                         <h3><b id="undNombre">Titulo</b></h3>
                         <div id="undContenido">Resumen</div>
                     </div>
                 </div>
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

     function verUnidad(u) {
         var und = JSON.parse(u);
         $("#undNombre").html(und.nombre);
         var html = "<h4><b>RESUMEN UNIDAD:</b> </h4>" + und.resumen + "<h4><b>COMO DESARROLLAR:</b> " + und.como_desarrollar + "</h4><h4><b>CUANDO DESARROLLAR:</b> " + und.cuando_desarrollar + "</h4><h4><b>DÓNDE DESARROLLAR:</b> " + und.donde_desarrollar + "</h4>";
         $("#undContenido").html(html);
     }
 </script>
 @endsection