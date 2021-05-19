@extends('layouts.admin')
@section('breadcrumb')
<h1>
    Bienvenido
    <small>Sr(a). {{Auth::user()->nombres}}</small>
</h1>
<ol class="breadcrumb">
    <li><a href="{{route('home')}}"><i class="fa fa-home"></i> Inicio</a></li>
    <li><a href="{{route('menu.academico')}}"><i class="fa fa-book"></i> Académico</a></li>
    <li><a href="{{route('menu.academico')}}"><i class="fa fa-bookmark"></i> Carga Académica</a></li>
    <li class="active"><a>Carga Académica de los Docentes</a></li>
</ol>
@endsection
@section('content')
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">GESTIÓN DE CARGA ACADÉMICA PARA LOS DOCENTES</h3>
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
            <div class="col-md-4">
                <div class="form-group">
                    <label>Jornada</label>
                    <select class="form-control" id="jornada_id">
                        @foreach($jornadas as $key=>$value)
                        <option value="{{$key}}">{{$value}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Grado</label>
                    <select class="form-control" id="grado_id" onchange="getGrupos()">
                        @foreach($grados as $key=>$value)
                        <option value="{{$key}}">{{$value}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Grupo</label>
                    <select class="form-control" id="grupo_id">

                    </select>
                </div>
            </div>
        </div>
        <div class="col-md-12" style="margin-top: 20px !important">
            <div class="form-group">
                <button class="btn btn-success icon-btn pull-left" onclick="ir()"><i class="fa fa-fw fa-lg fa-save"></i>Gestionar Carga</button>
                <a class="btn btn-danger icon-btn pull-left" href="{{route('menu.academico')}}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancelar</a>
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
                <p>Esta funcionalidad permite al usuario gestionar la carga académica para cada uno de los docentes, este proceso es necesario para realizar la matrícula académica. <b>Antes de realizar éste proceso, debe diligenciar la carga académica para los grados</b></p>
                <p>Esta funcionalidad permite cargarle materias a los grupos y definir el docente que impartirá cada cátedra.</p>
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

    function ir() {
        location.href = url + "academico/cargagrupomatdoc/" + $("#unidad_id").val() + "/" + $("#periodoacademico_id").val() + "/" + $("#jornada_id").val() + "/" + $("#grado_id").val() + "/" + $("#grupo_id").val() + "/continuar";
    }

    function getGrupos() {
        $.ajax({
            type: 'GET',
            url: url + "academico/cargagrupomatdoc/" + $("#unidad_id").val() + "/" + $("#periodoacademico_id").val() + "/" + $("#jornada_id").val() + "/" + $("#grado_id").val() + "/grupos",
            data: {},
        }).done(function(msg) {
            $('#grupo_id option').each(function() {
                $(this).remove();
            });
            if (msg !== "null") {
                var m = JSON.parse(msg);
                $.each(m, function(index, item) {
                    $("#grupo_id").append("<option value='" + item.id + "'>" + item.value + "</option>");
                });
            } else {
                notify('Atención', 'El grado seleccionado no tiene grupos', 'error');
            }
        });
    }
</script>
@endsection