@extends('layouts.admin')
@section('breadcrumb')
<h1>
    Bienvenido
    <small>Sr(a). {{Auth::user()->nombres}}</small>
</h1>
<ol class="breadcrumb">
    <li><a href="{{route('home')}}"><i class="fa fa-home"></i> Inicio</a></li>
    <li><a href="{{route('menu.documental')}}"><i class="fa fa-book"></i> Documental</a></li>
    <li class="active"><a> Estándar</a></li>
</ol>
@endsection
@section('content')
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">GESTIÓN DE ESTÁNDAR</h3>
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
            <div class="alert alert-warning alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <strong>Alerta<i class="fa fa-exclamation"></i></strong>
                <p>Esta función le permite actuar sobre el banco de estándares creados en la institución que pertenecen a las áreas asociadas en su carga académica cada año.</p>
                <b>Nota: </b>El período académico solamente tiene como función desplegar la carga académica del docente, no interfiere en el banco de estándares.
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Unidad Académica o Sede</label>
                    <select class="form-control" id="unidad">
                        @foreach($unidades as $key=>$value)
                        <option value="{{$key}}">{{$value}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Período Académico</label>
                    <select class="form-control" id="periodo">
                        @foreach($periodos as $key=>$value)
                        <option value="{{$key}}">{{$value}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Jornada</label>
                    <select class="form-control" id="jornada" onchange="getCarga()">
                        <option value="0">-- Seleccione Jornada --</option>
                        @foreach($jornadas as $key=>$value)
                        <option value="{{$key}}">{{$value}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <h3>Materias del Docente</h3>
            <div class="col-md-12" id="materias">

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
                <p>Esta funcionalidad permite gestionar los estándares de manera general, por área; configurar sus componentes y definir competencias dentro de ellos.</p>
            </div>
            <div class="modal-footer" style="background-color: #d2d6de !important; opacity: .65;">
                <button type="button" class="btn btn-block btn-danger btn-flat pull-right" data-dismiss="modal"><i class="fa fa-reply"></i> Regresar
                </button>
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
        $('#example1').DataTable();
        //$('#tb2').DataTable();
        //$(document.body).attr('class', 'skin-blue sidebar-mini sidebar-collapse');
    });

    function getGrados() {
        $.ajax({
            type: 'GET',
            url: url + "aulavirtual/docente/inicio/" + $("#unidad").val() + "/" + $("#periodo").val() + "/" + $("#jornada").val() + "/grados",
            data: {},
        }).done(function(msg) {
            $('#grado_id option').each(function() {
                $(this).remove();
            });
            if (msg !== "null") {
                var m = JSON.parse(msg);
                $("#grado_id").append("<option value='0'>-- Seleccione un Grado --</option>");
                $.each(m, function(index, item) {
                    $("#grado_id").append("<option value='" + index + "'>" + item + "</option>");
                });
            } else {
                notify('Atención', 'El docente no tiene carga académica para los parámetros indicados', 'warning');
            }
        });
    }

    function getCarga() {
        $.ajax({
            type: 'GET',
            url: url + "docente/cargaacademica/getcarga/" + $("#unidad").val() + "/" + $("#periodo").val() + "/" + $("#jornada").val() + "/materias",
            data: {},
        }).done(function(msg) {
            $("#materias").html("");
            if (msg !== "null") {
                var m = JSON.parse(msg);
                var html = "";
                $.each(m, function(index, item) {
                    html = html + "<div class='col-md-4'><div class='box box-widget widget-user-2'>" +
                        "<div class='widget-user-header " + item.color + "'>" +
                        "<h3 class='widget-user-username' style='margin-left: 0px !important;'>";
                    if (item.ciclos != null) {
                        $.each(item.ciclos, function(index2, item2) {
                            html = html + item2.ciclo + " - ";
                        });
                    } else {
                        html = html + "---";
                    }
                    html = html + "</h3>" +
                        "<h5 class='widget-user-desc' style='margin-left: 0px !important;'>ÁREA: " + item.area + "<br>MATERIA: " + item.materia + "<br>GRUPO: " + item.grupo + "<br>GRADO: " + item.grado + "</h5></div>" +
                        "<div class='box-footer no-padding'>" +
                        "<ul class='nav nav-stacked'>" +
                        "<li><a href='" + url + "documental/estandar/" + item.area_id + "/" + item.grupo_id + "/listar'><b>CREAR Y CONFIGURAR ESTÁNDAR</b> <span class='pull-right badge bg-blue'><i class='fa fa-arrow-right'></i></span></a></li>" +
                        "</ul></div></div></div>";
                });
                $("#materias").html(html);
            } else {
                notify('Atención', 'El docente no tiene carga académica para los parámetros indicados', 'warning');
            }
        });
    }
</script>
@endsection