@extends('layouts.admin')
@section('breadcrumb')
<h1>
    Bienvenido
    <small>Sr(a). {{Auth::user()->nombres}}</small>
</h1>
<ol class="breadcrumb">
    <li><a href="{{route('home')}}"><i class="fa fa-home"></i> Inicio</a></li>
    <li><a href="{{route('menu.admisiones')}}"><i class="fa fa-users"></i> Admisiones</a></li>
    <li><a href="{{route('menu.admisiones')}}"><i class="fa fa-list-ul"></i> Datos de Admisión y Matrícula</a></li>
    <li class="active"><a>Parametrizar Documentos anexos</a></li>
</ol>
@endsection
@section('content')
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">PARAMETRIZACIÓN DE DOCUMENTOS ANEXOS</h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-toggle="modal" data-target="#modal" title="Ayuda">
                <i class="fa fa-question"></i></button>
            <a class="btn btn-box-tool" data-toggle="modal" data-target="#modalAgregar" title="Agregar Parametrización">
                <i class="fa fa-plus-circle"></i></a>
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Minimizar">
                <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Cerrar">
                <i class="fa fa-times"></i></button>
        </div>
    </div>
    <div class="box-body">
        <div class="col-md-12">
            <div class="col-md-3">
                <div class="form-group">
                    <label>Seleccione Unidad</label>
                    <select class="form-control" required="required" id="unidad_id">
                        @foreach($unidades as $key=>$value)
                        <option value="{{$key}}">{{$value}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Seleccione Jornada</label>
                    <select class="form-control" required="required" id="jornada_id">
                        @foreach($jornadas as $key=>$value)
                        <option value="{{$key}}">{{$value}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Seleccione Grado</label>
                    <select class="form-control" required="required" id="grado_id">
                        @foreach($grados as $key=>$value)
                        <option value="{{$key}}">{{$value}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label>Seleccione Proceso</label>
                    <select class="form-control" required="required" id="proceso_id">
                        @foreach($procesos as $key=>$value)
                        <option value="{{$key}}">{{$value}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <button class="btn btn-primary icon-btn pull-left" type="button" style="margin-top: 20px" onclick="cargarDatos()"><i class="fa fa-fw fa-lg fa-save"></i>Cargar Datos</button>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="table-responsive" style="margin-top: 20px;">
                <table id='example1' class='table table-bordered table-striped table-hover'>
                    <thead>
                        <tr class='info'>
                            <th>ID</th>
                            <th>NOMBRE</th>
                            <th>ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody id="tb">

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
                <p>Esta funcionalidad le permite al usuario indicar los documentos o requisitos que son requeridos para los procesos académicos teniendo en cuenta el grado, la unidad, el proceso y la jornada. Seleccione los parámetros necesarios para visualizar los documentos agregados, eliminarlos o agregar nuevos documentos a la parametrización.</p>
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
<div class="modal fade" id="modalAgregar">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Agregar Nuevo Documento a la Configuración Seleccionada</h4>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr class="info">
                                <th>ID</th>
                                <th>NOMBRE</th>
                                <th>AGREGAR</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($docs as $key=>$value)
                            <tr>
                                <td>{{$key}}</td>
                                <td>{{$value}}</td>
                                <td>
                                    <a onclick="enviar(this.id)" id="{{$key}}" style="color: blue; margin-left: 10px;" data-toggle="tooltip" title="Agregar Documento Anexo" style="margin-left: 10px;"><i class="fa fa-arrow-right"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
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
@endsection
@section('script')
<script type="text/javascript">
    $(document).ready(function() {
        //$('#example1').DataTable();
    });

    function cargarDatos() {
        var unidad = $("#unidad_id").val();
        var jornada = $("#jornada_id").val();
        var grado = $("#grado_id").val();
        var proceso = $("#proceso_id").val();
        $.ajax({
            type: 'GET',
            url: url + "admisiones/parametrizardocumentosanexos/" + unidad + "/" + jornada + "/" + grado + "/" + proceso + "/getdocparametrizados",
            data: {},
        }).done(function(msg) {
            $("#tb").html("");
            var m = JSON.parse(msg);
            if (m.error == "NO") {
                var html = "";
                $.each(m.data, function(index, item) {
                    html = html + "<tr><td>" + item.id + "</td><td>" + item.nombre + "</td>" +
                        "<td><a href='" + url + "admisiones/parametrizardocumentosanexos/" + item.id + "/delete' style='color: red; margin-left: 10px;' data-toggle='tooltip' title='Eliminar Documento Anexo'><i class='fa fa-trash-o'></i></a></td></tr>";
                });
                html = html + "";
                $("#tb").html(html);
            } else {
                notify('Atención', m.mensaje, 'error');
            }
        });
    }

    function enviar(id) {
        var unidad = $("#unidad_id").val();
        var jornada = $("#jornada_id").val();
        var grado = $("#grado_id").val();
        var proceso = $("#proceso_id").val();
        $.ajax({
            type: 'GET',
            url: url + "admisiones/parametrizardocumentosanexos/" + unidad + "/" + jornada + "/" + grado + "/" + proceso + "/" + id + "/guardarparametrizados",
            data: {},
        }).done(function(msg) {
            var m = JSON.parse(msg);
            if (m.error == "NO") {
                notify('Atención', m.mensaje, 'success');
                cargarDatos();
            } else {
                notify('Atención', m.mensaje, 'error');
            }
        });
    }
</script>
@endsection