@extends('layouts.admin')
@section('breadcrumb')
<h1>
    Bienvenido
    <small>Sr(a). {{Auth::user()->nombres}}</small>
</h1>
<ol class="breadcrumb">
    <li><a href="{{route('home')}}"><i class="fa fa-home"></i> Inicio</a></li>
    <li><a href="{{route('menu.documental')}}"><i class="fa fa-book"></i> Documental</a></li>
    <li class="active"><a>Boletines por Grupo</a></li>
</ol>
@endsection
@section('content')
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">GENERAR BOLETINES POR GRUPO</h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Minimizar">
                <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Cerrar">
                <i class="fa fa-times"></i></button>
        </div>
    </div>
    <div class="box-body">
        <div class="col-md-12">
            <div class="callout bg-purple-gradient" style="padding: 5px; padding-left: 20px; text-align: center;">
                <h3>Genere boletines para todos los estudiantes del grupo indicado.</h3>
            </div>
            <div class="alert alert-warning" role="alert">
                <strong>Tenga en cuenta:</strong> Los estudiantes que para este momento tienen actividades, exámenes o pruebas pendientes por presentar, les serán calificadas en cero punto cero (0.0).
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Unidad Académica o Sede</label>
                    <select class="form-control" id="unidad">
                        @foreach($unidades as $key=>$value)
                        <option value="{{$key}}">{{$value}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-6">
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
                    <select class="form-control" id="jornada" onchange="getGrados()">
                        <option value="0">-- Seleccione Jornada --</option>
                        @foreach($jornadas as $key=>$value)
                        <option value="{{$key}}">{{$value}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Grado</label>
                    <select class="form-control" id="grado_id" onchange="getCarga()">

                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Grupo</label>
                    <select class="form-control" id="materia_id" onchange="getEstudiantes()">

                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Evaluación Académica</label>
                    <select class="form-control" id="evaluacion">
                        <option value="0">-- Seleccione Evaluación --</option>
                        @foreach($evals as $key=>$value)
                        <option value="{{$value->id}}">{{$value->nombre." (".$value->peso."%)"}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label> </label>
                    <button onclick="mostrar()" type="button" class="btn bg-purple margin btn-block"><i class="fa fa-file-pdf-o"></i> GENERAR BOLETINES</button>
                </div>
            </div>
        </div>
        <div class="col-md-12" style="display: none;" id="mostrar1">

        </div>
        <div class="col-md-12">
            <h3>Estudiantes del Grupo</h3>
            <div class="table-responsive" id="estudiantes">

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
            url: url + "aulavirtual/docente/inicio/" + $("#unidad").val() + "/" + $("#periodo").val() + "/" + $("#jornada").val() + "/" + $("#grado_id").val() + "/grupos/delgrado",
            data: {},
        }).done(function(msg) {
            if (msg !== "null") {
                var m = JSON.parse(msg);
                var html = "<option value='0'>-- Seleccione una opción --</option>";
                $.each(m, function(index, item) {
                    html = html + "<option value='" + item.id + "'>" + item.nombre + "</option>";
                });
                $("#materia_id").html(html);
            } else {
                notify('Atención', 'El grado no tiene grupos asignados', 'warning');
            }
        });
    }

    function getEstudiantes() {
        $.ajax({
            type: 'GET',
            url: url + "documental/logro/personalizar/inicio/" + $("#materia_id").val() + "/estudiantes/delgrupo",
            data: {},
        }).done(function(msg) {
            $("#estudiantes").html("");
            if (msg !== "null") {
                var m = JSON.parse(msg);
                var html = "<table id='tbmatriculados' class='table table-bordered table-striped table-hover'>" +
                    "<thead><tr class='bg-purple'><th>IDENTIFICACIÓN</th><th>ESTUDIANTE</th></tr></thead><tbody>";
                $.each(m, function(index, item) {
                    html = html + "<tr><td>" + item.identificacion + "</td><td>" + item.nombres + "</td></tr>";
                });
                html = html + "</tbody></table>";
                $("#estudiantes").html(html);
            } else {
                notify('Atención', 'El grupo no tiene estudiantes matriculados', 'warning');
            }
        });
    }

    function mostrar() {
        var p = $("#periodo").val();
        var g = $("#materia_id").val();
        var e = $("#evaluacion").val();
        if (g == null || g == '0') {
            notify('Atención', 'Debe indicar el grupo para continuar', 'error');
            return;
        }
        var html = "<div class='alert alert-warning' role='alert' id='mostrar2'><strong>Tenga en cuenta:</strong> Este proceso puede tomar varios minutos dependiendo " +
            "de su velocidad de conexión a internet y del servidor web donde la institución tenga alojada " +
            "la plataforma EBENEZER. Cuando el proceso finalice, le será entregada una pantalla de donde podrá descargar los boletines de los estudiantes.</div><a class='btn bg-purple margin' href='" + url + "documental/boletines/" + g + "/" + p + "/" + e + "/procesar'>PROCESAR GRUPO</a>";
        $("#mostrar1").html(html);
        $("#mostrar1").fadeIn();
    }
</script>
@endsection