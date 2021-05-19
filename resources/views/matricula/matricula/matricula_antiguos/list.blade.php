@extends('layouts.admin')
@section('breadcrumb')
<h1>
    Bienvenido
    <small>Sr(a). {{Auth::user()->nombres}}</small>
</h1>
<ol class="breadcrumb">
    <li><a href="{{route('home')}}"><i class="fa fa-home"></i> Inicio</a></li>
    <li><a href="{{route('menu.matricula')}}"><i class="fa fa-check"></i> Matrícula</a></li>
    <li><a href="{{route('menu.matricula')}}"><i class="fa fa-check-circle-o"></i> Matrícula</a></li>
    <li class="active"><a>Matricular Estudiantes Antiguos</a></li>
</ol>
@endsection
@section('content')
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">MATRICULAR ESTUDIANTES ANTIGUOS</h3>
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
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-check"></i> Tenga en cuenta!</h4>
                Está a punto de realizar matrícula académica a los estudiantes antiguos del grado indicado. Es necesario primero crear grupos y asignar carga académica para el período.
                Para realizar la matrícula académica el estudiante debe:
                <ul>
                    <li>Haber aprobado todas y cada una de las asignaturas del grado académico</li>
                    <li>No tener pendiente períodos por recuperar en ninguna materia</li>
                    <li>No tener Validación pendiente</li>
                    <li>Haber pagado la matrícula financiera</li>
                </ul>
                <p>Los estudiantes repitentes serán matriculados en el grado que han reprobado</p>
                <b>El campo FILTRO DE ESTADO permite definir si la matrícula es para los estudiantes que aprobaron el grado o para los repitentes</b>
            </div>
        </div>
        <div class="col-md-6">
            <div class="callout callout-danger" style="padding: 5px; padding-left: 20px; text-align: center;">
                <h2>Parámetros Año Anterior (Estudiantes sin Matrícula)</h2>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Unidad Académica o Sede</label>
                    <select class="form-control" id="unidad_id">
                        @foreach($unidades as $key=>$value)
                        <option value="{{$key}}">{{$value}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Período Académico</label>
                    <select class="form-control" id="periodoacademico_id">
                        @foreach($periodos as $key=>$value)
                        <option value="{{$key}}">{{$value}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Jornada</label>
                    <select class="form-control" id="jornada_id">
                        @foreach($jornadas as $key=>$value)
                        <option value="{{$key}}">{{$value}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Grado</label>
                    <select class="form-control" id="grado_id">
                        @foreach($grados as $key=>$value)
                        <option value="{{$key}}">{{$value}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Situación Estudiante</label>
                    <select class="form-control" id="situacion_id">
                        @foreach($situaciones as $key=>$value)
                        <option value="{{$key}}">{{$value}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Filtro de Estado</label>
                    <select class="form-control" id="estado">
                        <option value="APROBADO">APROBADO</option>
                        <option value="REPROBADO">REPROBADO</option>
                    </select>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <button class="btn btn-success icon-btn btn-block" onclick="cargarSinMatricula()"><i class="fa fa-fw fa-lg fa-list"></i>Cargar Estudiantes Sin MAtricular</button>
                </div>
            </div>
            <div class="col-md-12">
                <div class="table-responsive" id="nomatriculados">

                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="callout callout-danger" style="padding: 5px; padding-left: 20px; text-align: center;">
                <h2>Parámetros Año a Matricular (Estudiantes Matriculados)</h2>
            </div>
            <div class="col-md-12">
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
            <div class="col-md-6">
                <div class="form-group">
                    <label>Jornada</label>
                    <select class="form-control" id="jornada">
                        @foreach($jornadas as $key=>$value)
                        <option value="{{$key}}">{{$value}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Grado</label>
                    <select class="form-control" id="grado" onchange="getGrupos()">
                        @foreach($grados as $key=>$value)
                        <option value="{{$key}}">{{$value}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-8">
                <div class="form-group">
                    <label>Grupo</label>
                    <select class="form-control" id="grupo">

                    </select>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <button class="btn btn-success icon-btn btn-block" onclick="cargarConMatricula()"><i class="fa fa-fw fa-lg fa-check"></i>Cargar Estudiantes Matriculados</button>
                </div>
            </div>
            <div class="col-md-12">
                <div class="table-responsive" id="matriculados">

                </div>
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
                <p>Esta funcionalidad permite al usuario realizar la matrícula académica a los estudiantes antiguos de la institución, éste proceso requiere que se gestione primero grupos para los grados y carga académica asignada a los grupos y docentes.</p>
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
        $('#example1').DataTable();
        $(document.body).attr('class', 'skin-blue sidebar-mini sidebar-collapse');
    });


    function getGrupos() {
        $.ajax({
            type: 'GET',
            url: url + "academico/cargagrupomatdoc/" + $("#unidad").val() + "/" + $("#periodo").val() + "/" + $("#jornada").val() + "/" + $("#grado").val() + "/grupos",
            data: {},
        }).done(function(msg) {
            $('#grupo option').each(function() {
                $(this).remove();
            });
            if (msg !== "null") {
                var m = JSON.parse(msg);
                $.each(m, function(index, item) {
                    $("#grupo").append("<option value='" + item.id + "'>" + item.value + "</option>");
                });
            } else {
                notify('Atención', 'El grado seleccionado no tiene grupos', 'warning');
            }
        });
    }

    function cargarConMatricula() {
        $("#matriculados").html("");
        var grupo = $('#grupo').val();
        if (grupo == null) {
            notify('Atención', 'Seleccione grupo para continuar', 'warning');
            return;
        }
        $.ajax({
            type: 'GET',
            url: url + "matricula/matricularantiguos/matriculados/" + grupo + "/listar",
            data: {},
        }).done(function(msg) {
            if (msg !== "null") {
                var m = JSON.parse(msg);
                var html = "<table id='tbmatriculados' class='table table-bordered table-striped table-hover'>" +
                    "<thead><tr class='danger'><th>ESTUDIANTE</th><th>RETIRAR</th></tr></thead><tbody>";
                $.each(m, function(index, item) {
                    html = html + "<tr><td>(" + item.identificacion + ") " + item.estudiante + "</td>" +
                        "<td><a onclick='retirar(this.id)' id='" + item.estudiantegrupo + "' style='margin-left: 10px; cursor: pointer; color:red;' data-toggle='tooltip' title='Retirar Estudiante'><i class='fa fa-times'></i> RETIRAR ESTUDIANTE</a></td></tr>";
                });
                html = html + "</tbody></table>";
                $("#matriculados").html(html);
                $('#tbmatriculados').DataTable();
            } else {
                notify('Atención', 'El grupo seleccionado no tiene estudiantes matriculados', 'warning');
            }
        });
    }

    function cargarSinMatricula() {
        $("#nomatriculados").html("");
        var estado = $('#estado').val();
        var periodo = $('#periodoacademico_id').val();
        var grado = $('#grado_id').val();
        var unidad = $('#unidad_id').val();
        var jornada = $('#jornada_id').val();
        var situacionestudiante = $('#situacion_id').val();
        $.ajax({
            type: 'GET',
            url: url + "matricula/matricularantiguos/nomatriculados/" + unidad + "/" + periodo + "/" + jornada + "/" + grado + "/" + situacionestudiante + "/" + estado + "/listar",
            data: {},
        }).done(function(msg) {
            if (msg !== "null") {
                var m = JSON.parse(msg);
                var html = "<table id='tbnomatriculados' class='table table-bordered table-striped table-hover'>" +
                    "<thead><tr class='danger'><th>ESTUDIANTE</th><th>MATRICULAR</th></tr></thead><tbody>";
                $.each(m, function(index, item) {
                    html = html + "<tr><td>(" + item.identificacion + ") " + item.estudiante + "</td>" +
                        "<td><a onclick='matricular(this.id)' id='" + item.id + "' style='margin-left: 10px; cursor: pointer;' data-toggle='tooltip' title='Matricular Estudiante'><i class='fa fa-check'></i> MATRICULAR ESTUDIANTE</a></td></tr>";
                });
                html = html + "</tbody></table>";
                $("#nomatriculados").html(html);
                $('#tbnomatriculados').DataTable();
            } else {
                notify('Atención', 'El grado seleccionado no tiene estudiantes para matricular con los parámetros indicados', 'warning');
            }
        });
    }

    function matricular(estudiante) {
        var grupo = $('#grupo').val();
        if (grupo == null) {
            notify('Atención', 'Seleccione grupo para continuar', 'warning');
            return;
        }
        $.ajax({
            type: 'GET',
            url: url + "matricula/matricularantiguos/matricula/estudiantes/antiguos/" + grupo + "/" + estudiante + "/matricular",
            data: {},
        }).done(function(msg) {
            var m = JSON.parse(msg);
            notify('Atención', m.mensaje, m.tipo);
            cargarConMatricula();
            cargarSinMatricula();
        });
    }

    function retirar(estudiantegrupo) {
        $.ajax({
            type: 'GET',
            url: url + "matricula/matricularantiguos/matricula/estudiantes/antiguos/" + estudiantegrupo + "/retirara",
            data: {},
        }).done(function(msg) {
            var m = JSON.parse(msg);
            notify('Atención', m.mensaje, m.tipo);
            cargarConMatricula();
            cargarSinMatricula();
        });
    }
</script>
@endsection