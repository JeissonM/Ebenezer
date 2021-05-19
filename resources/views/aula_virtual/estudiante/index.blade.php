 @extends('layouts.admin')
 @section('breadcrumb')
 <h1>
     Bienvenido
     <small>Sr(a). {{Auth::user()->nombres}}</small>
 </h1>
 <ol class="breadcrumb">
     <li><a href="{{route('home')}}"><i class="fa fa-home"></i> Inicio</a></li>
     <li><a href="{{route('menu.aulavirtual')}}"><i class="fa fa-vimeo"></i> Aula Virtual</a></li>
     <li class="active"><a>Inicio Estudiante</a></li>
 </ol>
 @endsection
 @section('content')
 <div class="box">
     <div class="box-header with-border">
         <h3 class="box-title">AULA VIRTUAL</h3>
         <div class="box-tools pull-right">
             <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Minimizar">
                 <i class="fa fa-minus"></i></button>
             <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Cerrar">
                 <i class="fa fa-times"></i></button>
         </div>
     </div>
     <div class="box-body">
         <div class="col-md-12">
             <div class="col-md-6">
                 <div class="form-group">
                     <label>Unidad Académica o Sede</label>
                     <select class="form-control" id="unidad">
                         <option value="{{$estudiante->unidad_id}}">{{$estudiante->unidad->nombre." - ".$estudiante->unidad->ciudad->nombre}}</option>
                     </select>
                 </div>
             </div>
             <div class="col-md-6">
                 <div class="form-group">
                     <label>Período Académico</label>
                     <select class="form-control" id="periodo">
                         <option value="{{$estudiante->periodoacademico_id}}">{{$estudiante->periodoacademico->etiqueta." - ".$estudiante->periodoacademico->anio}}</option>
                     </select>
                 </div>
             </div>
             <div class="col-md-6">
                 <div class="form-group">
                     <label>Jornada</label>
                     <select class="form-control" id="jornada">
                         <option value="{{$estudiante->jornada_id}}">{{$estudiante->jornada->descripcion." - ".$estudiante->jornada->jornadasnies}}</option>
                     </select>
                 </div>
             </div>
             <div class="col-md-6">
                 <div class="form-group">
                     <label>Grado</label>
                     <select class="form-control" id="grado_id" onchange="getCarga()">
                         <option value="0">-- Seleccione una opción --</option>
                         <option value="{{$estudiante->grado_id}}">{{$estudiante->grado->etiqueta." - ".$estudiante->grado->descripcion}}</option>
                     </select>
                 </div>
             </div>
         </div>
         <div class="col-md-12">
             <h4>Materias del Estudiante</h4>
             <div class="table-responsive" id="materias">

             </div>
         </div>
     </div>
 </div>
 @endsection
 @section('script')
 <script type="text/javascript">
     $(document).ready(function() {
         //$('#example1').DataTable();
     });

     function getCarga() {
         $.ajax({
             type: 'GET',
             url: url + "aulavirtual/estudiante/inicio/" + $("#unidad").val() + "/" + $("#periodo").val() + "/" + $("#jornada").val() + "/" + $("#grado_id").val() + "/materias/estudiante",
             data: {},
         }).done(function(msg) {
             $("#materias").html("");
             if (msg !== "null") {
                 var m = JSON.parse(msg);
                 var html = "<table id='tbmatriculados' class='table table-bordered table-striped table-hover'>" +
                     "<thead><tr class='danger'><th>CÓDIGO</th><th>MATERIA</th><th>GRUPO</th><th>CONTINUAR</th></tr></thead><tbody>";
                 $.each(m, function(index, item) {
                     html = html + "<tr><td>" + item.codigo + "</td><td>" + item.materia + "</td><td>" + item.grupo + "</td>" +
                         "<td><a href='" + url + "aulavirtual/estudiante/inicio/" + item.gmd_id + "/menu/aula/estudiante' style='margin-left: 10px; cursor: pointer;' data-toggle='tooltip' title='Continuar al Aula'><i class='fa fa-arrow-right'></i> CONTINUAR AL AULA</a></td></tr>";
                 });
                 html = html + "</tbody></table>";
                 $("#materias").html(html);
             } else {
                 notify('Atención', 'El estudiante no tiene carga académica para los parámetros indicados', 'warning');
             }
         });
     }
 </script>
 @endsection