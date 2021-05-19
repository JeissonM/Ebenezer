@extends('layouts.admin')
@section('breadcrumb')
<h1>
    Bienvenido
    <small>Sr(a). {{Auth::user()->nombres}}</small>
</h1>
<ol class="breadcrumb">
    <li><a href="{{route('home')}}"><i class="fa fa-home"></i> Inicio</a></li>
    <li><a href="{{route('menu.usuarios')}}"><i class="fa fa-users"></i> Usuarios</a></li>
    <li class="active"><a>Crear Usuario Manual</a></li>
</ol>
@endsection
@section('content')
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">CREAR NUEVO USUARIO</h3>
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
            @component('layouts.errors')
            @endcomponent
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <div class="col-md-4">
                    <input class="form-control" type="text" placeholder="Escriba la identificación a consultar" name="id" id="id">
                </div>
                <div class="col-md-4">
                    <button type="button" class="btn btn-primary btn-sm btn-block" onclick="getEstudiante()">Traer Estudiante</button>
                </div>
                <div class="col-md-4">
                    <button type="button" class="btn btn-primary btn-sm btn-block" onclick="getPersona()">Traer Persona</button>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-12">
                    <label class="control-label">Seleccione Persona Natural/Estudiante</label>
                    <select id='personanatural_id' class='form-control' onchange="mostrar()" required='required' name='personanatural_id'></select>
                </div>
            </div>
            <div class="col-md-12">
                <form class="form" role="form" method="POST" action="{{route('usuario.store')}}">
                    @csrf
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Identificacion del Usuario</label>
                            <input class="form-control" type="text" name="identificacion" required="required" id="identificacion">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Nombres del Usuario</label>
                            <input class="form-control" type="text" name="nombres" required="required" id="txt_nombres">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Apellidos del Usuario</label>
                            <input class="form-control" type="text" name="apellidos" required="required" id="txt_apellidos">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>E-mail del Usuario</label>
                            <input class="form-control" type="email" name="email" required="required" id="txt_email">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Seleccione el Estado del Usuario</label>
                            <select class="form-control" required="required"name="estado">
                                <option value="0">-- Seleccione una opción --</option>
                                <option value="ACTIVO">ACTIVO</option>
                                <option value="INACTIVO">INACTIVO</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Contraseña del Usuario</label>
                            <input class="form-control" type="password" name="password" required="required">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Seleccione los Grupos o Roles</label>
                            <select class="form-control select2" multiple="multiple"  style="width: 100%;" required="required" name="grupos[]">
                                <option value="0">-- Seleccione una opción --</option>
                                @foreach($grupos as $key=>$value)
                                <option value="{{$key}}">{{$value}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12" style="margin-top: 20px !important">
                        <div class="form-group">
                            <button class="btn btn-success icon-btn pull-left" type="submit"><i class="fa fa-fw fa-lg fa-save"></i>Guardar</button>
                            <button class="btn btn-info icon-btn pull-left" type="reset"><i class="fa fa-fw fa-lg fa-trash-o"></i>Limpiar</button>
                            <a class="btn btn-danger icon-btn pull-left" href="{{route('menu.usuarios')}}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancelar</a>
                        </div>
                    </div>
                </form>
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
                <p>Agregue un usuario al sistema y registre su/sus roles de acceso. Puede crear un usuario llenando todos los campos, a partir de las personas generales ó partiendo de un estudiante.</p>
            </div>
            <div class="modal-footer" style="background-color: #d2d6de !important; opacity: .65;">
                <button type="button"  class="btn btn-block btn-danger btn-flat pull-right" data-dismiss="modal"> <i class="fa fa-reply"></i> Regresar</button>
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
    $(document).ready(function () {
        $('#example1').DataTable();
        $('.select2').select2();
    });
   var vect = null;
   var vecte = null;
   var origen = false;

   function getPersona() {
       var id = $("#id").val();
       if (id.length === 0) {
           notify('Alerta', 'Debe ingresar identificación para continuar...', 'warning');
       } else {
           $.ajax({
               type: 'GET',
               url: url + "academico/personanatural/" + id + "/personaNaturals",
               data: {},
           }).done(function (msg) {
               var m = JSON.parse(msg);
               if (m.error === "NO") {
                   $('#personanatural_id option').each(function () {
                       $(this).remove();
                   });
                   vect = m.data1;
                   origen = true;
                   $("#personanatural_id").append("<option value='0'>-- Seleccione una opción --</option>");
                   $.each(m.data2, function (index, item) {
                       $("#personanatural_id").append("<option value='" + index + "'>" + item + "</option>");
                   });
               } else {
                   notify('Atención', m.msg, 'error');
                   $("#identificacion").val("");
                   $("#txt_nombres").val("");
                   $("#txt_apellidos").val("");
                   $("#txt_email").val("");
               }
           });
       }
   }

   function getEstudiante() {
       var id = $("#id").val();
       if (id.length === 0) {
           notify('Alerta', 'Debe ingresar identificación para continuar...', 'warning');
       } else {
           $.ajax({
               type: 'GET',
               url: url + "academico/estudiante/" + id + "/getestudiante",
               data: {},
           }).done(function (msg) {
               var m = JSON.parse(msg);
               if (m.error === "NO") {
                   $('#personanatural_id option').each(function () {
                       $(this).remove();
                   });
                   vecte = m.data1;
                   origen = false;
                   $("#personanatural_id").append("<option value='0'>-- Seleccione una opción --</option>");
                   $.each(m.data2, function (index, item) {
                       $("#personanatural_id").append("<option value='" + index + "'>" + item + "</option>");
                   });
               } else {
                   notify('Atención', m.msg, 'error');
                   $("#identificacion").val("");
                   $("#txt_nombres").val("");
                   $("#txt_apellidos").val("");
                   $("#txt_email").val("");
               }
           });
       }
   }

   function mostrar() {
       $("#identificacion").val("");
       $("#txt_nombres").val("");
       $("#txt_apellidos").val("");
       $("#txt_email").val("");
       var id = $("#personanatural_id").val();
       if (origen) {
           //pn
           $.each(vect, function (index, item) {
               if (item.id == id) {
                   $("#identificacion").val(item.identificacion);
                   $("#txt_nombres").val(item.nombres);
                   $("#txt_apellidos").val(item.apellidos);
                   $("#txt_email").val(item.mail);
               }
           });
       } else {
           //est
           $.each(vecte, function (index, item) {
                   $("#identificacion").val(item.identificacion);
                   $("#txt_nombres").val(item.nombres);
                   $("#txt_apellidos").val(item.apellidos);
                   $("#txt_email").val(item.mail);
           });
       }
   }
</script>
@endsection
