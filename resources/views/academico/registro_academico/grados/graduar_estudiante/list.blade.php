@extends('layouts.admin')
@section('breadcrumb')
    <h1>
        Bienvenido
        <small>Sr(a). {{Auth::user()->nombres}}</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{route('home')}}"><i class="fa fa-home"></i> Inicio</a></li>
        <li><a href="{{route('menu.academico')}}"><i class="fa fa-book"></i> Académico</a></li>
        <li><a href="{{route('menu.academico')}}"><i class="fa fa-edit"></i> Registro Académico</a></li>
        <li><a href="{{route('menu.grados')}}"><i class="fa fa-graduation-cap"></i> Grados</a></li>
        <li class="active"><a>Graduar Estudiante</a></li>
    </ol>
@endsection
@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">GRADUAR ESTUDIANTES</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-toggle="modal" data-target="#modal" title="Ayuda">
                    <i class="fa fa-question"></i></button>
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
                        <select class="form-control" id="grado_id" onchange="getCeremonia()">
                            <option value="">--Seleccione una opción--</option>
                            @foreach($grados as $key=>$value)
                                <option value="{{$key}}">{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Ceremonia</label>
                        <select class="form-control" id="ceremonia_id">
                            <option value="">--Seleccione una opción--</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-12" style="margin-top: 20px !important">
                <div class="form-group">
                    <button class="btn btn-success icon-btn pull-left" onclick="ir()"><i
                            class="fa fa-fw fa-lg fa-save"></i>Listar Estudiantes
                    </button>
                    <a class="btn btn-danger icon-btn pull-left" href="{{route('menu.grados')}}"><i
                            class="fa fa-fw fa-lg fa-times-circle"></i>Cancelar</a>
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
                    <p>Esta funcionalidad permite al usuario graduar a los estudiantes que estan asigandos a una ceremonia.</p>
                </div>
                <div class="modal-footer" style="background-color: #d2d6de !important; opacity: .65;">
                    <button type="button" class="btn btn-block btn-danger btn-flat pull-right" data-dismiss="modal"><i
                            class="fa fa-reply"></i> Regresar
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
        $(document).ready(function () {
            $('#example1').DataTable();
        });

        function getCeremonia() {
            var und = $("#unidad_id").val();
            var per = $("#periodoacademico_id").val();
            var jor = $("#jornada_id").val();
            var gra = $("#grado_id").val();
            if (und == null || jor == null || gra.length <= 0 || per == null) {
                notify('Alerta', 'Debe indicar todos los parámetros para continuar', 'warning');
            }
            $.ajax({
                type: 'GET',
                url: url + "academico/ceremoniaestudiante/" + und + "/" + per + "/" + jor + "/" + gra + "/getCeremonia",
                data: {},
            }).done(function (msg) {
                $("#ceremonia_id option").each(function () {
                    $(this).remove();
                });
                if (msg != "null") {
                    var m = JSON.parse(msg);
                    $.each(m, function (index, item) {
                        $("#ceremonia_id").append("<option value='" + item.id + "'>" + item.value + "</option>");
                    });
                } else {
                    notify('Atención', 'No hay ceremonias para los parametros seleccionados.', 'error');
                }
            });
        }

        function ir() {
            var cer = $("#ceremonia_id").val();
            if (cer.length <= 0) {
                notify('Atención', 'Debe indicar todos los parámetros para continuar.', 'error');
            } else {
                location.href = url + "academico/graduarestudiante/" + $("#ceremonia_id").val() + "/listar";
            }
        }
    </script>
@endsection
