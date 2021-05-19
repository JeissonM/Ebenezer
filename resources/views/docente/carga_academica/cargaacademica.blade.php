@extends('layouts.admin')
@section('breadcrumb')
    <h1>
        Bienvenido
        <small>Sr(a). {{Auth::user()->nombres}}</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{route('home')}}"><i class="fa fa-home"></i> Inicio</a></li>
        <li><a href="{{route('menu.academicodocente')}}"><i class="fa fa-vimeo"></i> Académico</a></li>
        <li class="active"><a>Carga académica</a></li>
    </ol>
@endsection
@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">ACADÉMICO</h3>
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
                <h4>Materias del Docente</h4>
                <div class="table-responsive" id="materias">

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
                    notify('Atención', 'El docente no tiene carga académica para los parámetros indicados', 'warning');
                }
            });
        }

        function getCarga() {
            $.ajax({
                type: 'GET',
                url: url + "docente/cargaacademica/getcarga/" + $("#unidad").val() + "/" + $("#periodo").val() + "/" + $("#jornada").val() + "/materias",
                data: {},
            }).done(function (msg) {
                $("#materias").html("");
                if (msg !== "null") {
                    var m = JSON.parse(msg);
                    var html = "<table id='tbmatriculados' class='table table-bordered table-striped table-hover'>" +
                        "<thead><tr class='bg-purple'><th>GRADO</th><th>CÓDIGO</th><th>MATERIA</th><th>GRUPO</th></tr></thead><tbody>";
                    $.each(m, function (index, item) {
                        html = html + "<tr><td>" + item.grado + "</td><td>" + item.codigo + "</td><td>" + item.materia + "</td><td>" + item.grupo + "</td></tr>";
                    });
                    html = html + "</tbody></table>";
                    $("#materias").html(html);
                } else {
                    notify('Atención', 'El docente no tiene carga académica para los parámetros indicados', 'warning');
                }
            });
        }
    </script>
@endsection
