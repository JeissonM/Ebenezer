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
    <li class="active"><a>Cambio de Grupo Matriculado</a></li>
</ol>
@endsection
@section('content')
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">CAMBIAR GRUPO MATRICULADO</h3>
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
                    <select class="form-control" id="grado_id" onchange="getMatriculados()">
                        @foreach($grados as $key=>$value)
                        <option value="{{$key}}">{{$value}}</option>
                        @endforeach
                    </select>
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
                <p>Esta funcionalidad permite al usuario cambiar de un grupo a otro a un estudiante matriculado.</p>
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
    });


    function getMatriculados() {
        $("#matriculados").html("");
        var periodo = $('#periodoacademico_id').val();
        var grado = $('#grado_id').val();
        var unidad = $('#unidad_id').val();
        var jornada = $('#jornada_id').val();
        $.ajax({
            type: 'GET',
            url: url + "matricula/matricularantiguos/matricula/estudiantes/antiguos/" + unidad + "/" + periodo + "/" + jornada + "/" + grado + "/listar/matriculados",
            data: {},
        }).done(function(msg) {
            if (msg !== "null") {
                var m = JSON.parse(msg);
                var html = "<table id='tbmatriculados' class='table table-bordered table-striped table-hover'>" +
                    "<thead><tr class='danger'><th>IDENTIFICACIÓN</th><th>ESTUDIANTE</th><th>CONTINUAR</th></tr></thead><tbody>";
                $.each(m, function(index, item) {
                    html = html + "<tr><td>" + item.identificacion + "</td><td>" + item.estudiante + "</td>" +
                        "<td><a href='" + url + "matricula/matricularantiguos/" + item.id + "' style='margin-left: 10px; cursor: pointer;' data-toggle='tooltip' title='Continuar'><i class='fa fa-arrow-right'></i></a></td></tr>";
                });
                html = html + "</tbody></table>";
                $("#matriculados").html(html);
                $('#tbmatriculados').DataTable();
            } else {
                notify('Atención', 'El grado seleccionado no tiene estudiantes matriculados', 'warning');
            }
        });
    }
</script>
@endsection