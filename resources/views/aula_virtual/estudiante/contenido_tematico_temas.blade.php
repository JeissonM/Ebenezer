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
     <li><a href="{{route('contenidotematico.estudiante',$gmd->id)}}"><i class="fa fa-book"></i> Contenido Temático</a></li>
     <li class="active"><a> Temas</a></li>
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
             <div class="table-responsive">
                 <table class="table table-bordered table-striped table-hover">
                     <tbody>
                         <tr class="danger">
                             <th colspan="2">UNIDAD</th>
                             <th>AUTOR</th>
                         </tr>
                         <tr>
                             <td colspan="2">{{$unidad->nombre}}</td>
                             <td>{{$unidad->user->nombres." ".$unidad->user->apellidos}}</td>
                         </tr>
                         <tr class="danger">
                             <th>COMO SE DESARROLLARÁ</th>
                             <th>CUANDO SE DESARROLLARÁ</th>
                             <th>DÓNDE SE DESARROLLARÁ</th>
                         </tr>
                         <tr>
                             <td>{{$unidad->como_desarrollar}}</td>
                             <td>{{$unidad->cuando_desarrollar}}</td>
                             <td>{{$unidad->donde_desarrollar}}</td>
                         </tr>
                     </tbody>
                 </table>
             </div>
         </div>
         <div class="col-md-12">
             <h3 style="border-left: 10px solid; border-color: #f44336; background-color: #f7968f; padding: 5px;">Temas en la Unidad (Clic en el botón VER + para ver el contenido del tema u ocultarlo)</h3>
             <div class="table-responsive">
                 <table class="table table-bordered table-striped table-hover">
                     <thead>
                         <tr class="bg-danger">
                             <th>TEMA</th>
                             <th>INTRODUCCIÓN</th>
                             <th>DURACIÓN</th>
                             <th>AUTOR</th>
                         </tr>
                     </thead>
                     <tbody>
                         @if($temas!=null)
                         @foreach($temas as $key=>$value)
                         <tr style="cursor: pointer;" class="panela">
                             <td>{{$value['tema']->titulo}}</td>
                             <td>
                                 {{$value['tema']->introduccion}}
                                 <a class="btn btn-raised btn-primary btn-xs" title="Clic para ver el contenido del tema" id="{{$value['tema']->id}}" onclick="ver(this.id)">VER <i class="fa fa-plus"></i></a>
                                 <div class="list-group" id="TEMA_{{$value['tema']->id}}" style="margin-bottom:0px; display: none;">
                                     <h4><b>Listado de Subtemas</b></h4>
                                     @if($value['datos']!=null)
                                     @foreach($value['datos'] as $st)
                                     <a id="{{$st}}" onclick="verSubtema(this.id)" data-toggle="modal" data-target="#modal2" style="padding: 10px 16px;" class="list-group-item list-group-item-action">{{$st->titulo}}</a>
                                     @endforeach
                                     @else
                                     <a style="color: red; padding: 10px 16px;" class="list-group-item list-group-item-action list-group-item-danger"><i class="fa fa-warning"></i> No hay contenido</a>
                                     @endif
                                 </div>

                             </td>
                             <td>{{$value['tema']->duracion}}</td>
                             <td>{{$value['tema']->user->nombres." ".$value['tema']->user->apellidos}}</td>
                         </tr>
                         @endforeach
                         @else
                         <tr><td colspan="4" style="color: red; padding: 10px 16px;"><i class="fa fa-warning"></i> No hay temas en la unidad</td></tr>
                         @endif
                     </tbody>
                 </table>
             </div>
         </div>
         <div class="col-md-12">
             <h3 style="border-left: 10px solid; border-color: #f44336; background-color: #f7968f; padding: 5px;">Estándares en la Unidad (Logros Para el Boletín)</h3>
             <div class="table-responsive">
                 <table class="table table-bordered table-striped table-hover" style="font-size: 12px;">
                     <tbody>
                         @if($aprendizajes!=null)
                         @foreach($aprendizajes as $eu)
                         <tr class="bg-blue">
                             <th colspan="2"><label class="bg-orange">EST-{{$eu['estandar_id']}}</label> {{$eu['estandar']}}</th>
                         </tr>
                         @if($eu['componentes']!=null)
                         @foreach($eu['componentes'] as $compo)
                         <tr class="bg-light-blue">
                             <td style="padding: 1px;" colspan="2">COMPONENTE: {{$compo['componente']}}</td>
                         </tr>
                         @if($compo['competencias']!=null)
                         <tr>
                             <th style="padding: 1px;">COMPETENCIAS</th>
                             <th style="padding: 1px;">APRENDIZAJES</th>
                         </tr>
                         @foreach($compo['competencias'] as $compe)
                         <tr>
                             <td style="padding: 1px;">{{$compe['competencia']}}</td>
                             <td style="padding: 1px;">
                                 @if($compe['aprendizajes']!=null)
                                 <ul>
                                     @foreach($compe['aprendizajes'] as $a)
                                     <li>{!!$a!!}</li>
                                     @endforeach
                                 </ul>
                                 @else
                                 ---
                                 @endif
                             </td>
                         </tr>
                         @endforeach
                         @else
                         <tr>
                             <td colspan="2" style="color: red; padding: 10px 16px;"><i class="fa fa-warning"></i> No hay competencias en el componente</td>
                         </tr>
                         @endif
                         @endforeach
                         @else
                         <tr>
                             <td colspan="2" style="color: red; padding: 10px 16px;"><i class="fa fa-warning"></i> No hay componentes en el estándar</td>
                         </tr>
                         @endif
                         @endforeach
                         @else
                         <tr>
                             <td colspan="2" style="color: red; padding: 10px 16px;"><i class="fa fa-warning"></i> No hay estándares configurados en la unidad</td>
                         </tr>
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
                 <h4 class="modal-title">Contenido del Tema</h4>
             </div>
             <div class="modal-body">
                 <div class="row">
                     <div class="col-md-12" style="margin: 2.5%; width: 95%; padding: 50px;
		-webkit-box-shadow: 0px 0px 20px -3px rgba(0, 0, 0, 0.9);
		-moz-box-shadow: 0px 0px 20px -3px rgba(0, 0, 0, 0.9);
		box-shadow: 0px 0px 20px -3px rgba(0, 0, 0, 0.9);
		font-size: 12px;">
                         <h3><b id="sbtmTitulo">Titulo</b></h3>
                         <div id="sbtmDesarrollo">Desarrollo</div>
                         <h4><b id="sbtmAutor">Autor</b></h4>
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
         background-color: #f2dede !important;
         color: #000000 !important;
         cursor: pointer !important;
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

     var estadoVisor = [];

     function verSubtema(u) {
         var sbtm = JSON.parse(u);
         $("#sbtmTitulo").html(sbtm.titulo);
         $("#sbtmDesarrollo").html(sbtm.desarrollo);
         $("#sbtmAutor").html("AUTOR: " + sbtm.user.nombres + " " + sbtm.user.apellidos);
     }

     function ver(id) {
         //true es visible, false es oculto
         if (estadoVisor[id] == undefined) {
             estadoVisor[id] = true;
             $("#TEMA_" + id).show();
             $("#" + id).html("VER <i class='fa fa-minus'></i>");
         } else {
             if (estadoVisor[id]) {
                 estadoVisor[id] = false;
                 $("#TEMA_" + id).hide();
                 $("#" + id).html("VER <i class='fa fa-plus'></i>");
             } else {
                 estadoVisor[id] = true;
                 $("#TEMA_" + id).show();
                 $("#" + id).html("VER <i class='fa fa-minus'></i>");
             }
         }
     }
 </script>
 @endsection