@extends('layouts.admin')
@section('breadcrumb')
    <h1>
        Bienvenido
        <small>Sr(a). {{Auth::user()->nombres}}</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{route('inicio')}}"><i class="fa fa-home"></i> Inicio</a></li>
        <li><a href="{{route('menu.reportes')}}"><i class="fa fa-book"></i> Reportes</a></li>
        <li class="active"><a>Horario por Grupo</a></li>
    </ol>
@endsection
@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">HORARIO POR GRUPO</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                        title="Minimizar">
                    <i class="fa fa-minus"></i></button>
                <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip"
                        title="Cerrar">
                    <i class="fa fa-times"></i></button>
            </div>
        </div>
        <div class="box-body">
            <div class="col-md-12">
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
                        <select class="form-control" id="materia_id" onchange="Horario()">

                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-12" style="margin-top: 50px">
                <h3>Horario</h3>
                <div class="table-responsive" id="horario">

                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script type="text/javascript">
        $(document).ready(function () {
            //$('#example1').DataTable();
        });

        function getGrados() {
            $.ajax({
                type: 'GET',
                url: url + "aulavirtual/docente/inicio/" + $("#unidad").val() + "/" + $("#periodo").val() + "/" + $("#jornada").val() + "/grados",
                data: {},
            }).done(function (msg) {
                $('#grado_id option').each(function () {
                    $(this).remove();
                });
                if (msg !== "null") {
                    var m = JSON.parse(msg);
                    $("#grado_id").append("<option value='0'>-- Seleccione un Grado --</option>");
                    $.each(m, function (index, item) {
                        $("#grado_id").append("<option value='" + index + "'>" + item + "</option>");
                    });
                } else {
                    notify('Atención', 'No hay carga académica para los parámetros indicados', 'warning');
                }
            });
        }

        function getCarga() {
            $.ajax({
                type: 'GET',
                url: url + "aulavirtual/docente/inicio/" + $("#unidad").val() + "/" + $("#periodo").val() + "/" + $("#jornada").val() + "/" + $("#grado_id").val() + "/grupos/delgrado",
                data: {},
            }).done(function (msg) {
                if (msg !== "null") {
                    var m = JSON.parse(msg);
                    var html = "<option value='0'>-- Seleccione una opción --</option>";
                    $.each(m, function (index, item) {
                        html = html + "<option value='" + item.id + "'>" + item.nombre + "</option>";
                    });
                    $("#materia_id").html(html);
                } else {
                    notify('Atención', 'El grado no tiene grupos asignados', 'warning');
                }
            });
        }

        function Horario(){
            var p = $("#periodo").val();
            var g = $("#grado_id").val();
            var grupo = $("#materia_id").val();
            var j = $("#jornada").val();
            var u = $("#unidad").val();
            if (grupo.length <= 0) {
                notify('Atención', 'Debe sellecionar todos los parametros.', 'warning');
            }
            $.ajax({
                type: 'GET',
                url: '{{url("reportes/horariogrupo/")}}/' + u + "/" + p + "/" + g + "/" + grupo + "/consultar",
                data: {},
            }).done(function (msg) {
                $("#horario").html("");
                if (msg !== "null") {
                    var m = JSON.parse(msg);
                    var html = "<table id='tbmatriculados' class='table table-bordered table-striped table-hover'>" +
                        "<thead><tr class='bg-purple'><th>GRUPO</th><th>HORARIO</th></tr></thead><tbody>";
                    html = html + m.html;
                    html = html + "</tbody></table>";
                    $("#horario").html(html);
                } else {
                    notify('Atención', 'El grupo no tiene horario.', 'warning');
                }
            });
        }
    </script>
@endsection
