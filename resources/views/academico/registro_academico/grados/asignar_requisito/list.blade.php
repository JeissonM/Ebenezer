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
        <li class="active"><a> Asignar Requisitos</a></li>
    </ol>
@endsection
@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">ASIGNAR REQUISITOS A GRADO</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-toggle="modal" data-target="#modal" title="Ayuda">
                    <i class="fa fa-question"></i></button>
                <button type="button" class="btn btn-box-tool" data-toggle="modal" data-target="#agregar"
                        title="Agregar Requisitos">
                    <i class="fa fa-plus"></i></button>
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
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Jornada</label>
                        <select class="form-control" id="jornada_id">
                            @foreach($jornadas as $key=>$value)
                                <option value="{{$key}}">{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Grado</label>
                        <select class="form-control" id="grado_id" onchange="getRequisitos()">
                            @foreach($grados as $key=>$value)
                                <option value="{{$key}}">{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="table-responsive">
                    <table id="tb" class="table table-bordered table-striped table-hover">
                        <thead>
                        <tr class="danger">
                            <th>GRADO</th>
                            <th>REQUISITO</th>
                            <th>JORNADA</th>
                            <th>UNIDAD</th>
                            <th>ACCIONES</th>
                        </tr>
                        </thead>
                        <tbody id="tb2">
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
                    <p>Esta funcionalidad permite asignar y eliminar requisitos a un grado seleccionado.</p>
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

    <div class="modal fade" id="agregar">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Agregar Requisitos</h4>
                </div>
                <div class="modal-body">
                    <div class="col md 12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover">
                                <tbody>
                                @foreach($requisitos as $r)
                                    <tr class="danger">
                                        <td class="contact">{{$r->descripcion}}</td>
                                        <td class="subject"><a style="margin-left: 10px; color: green;"
                                                               data-toggle="tooltip" title="Agregar Requisito"
                                                               id="{{$r->id}}" onclick="guardar(this.id)"><i
                                                    class="fa fa-check"></i></a></td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="background-color: #d2d6de !important; opacity: .65;">
                    <button type="button" class="btn btn-block btn-danger btn-flat pull-right" data-dismiss="modal"><i
                            class="fa fa-reply"></i> Cancelar
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
            $('#tb').DataTable();
        });

        function guardar(id) {
            var und = $("#unidad_id").val();
            var jor = $("#jornada_id").val();
            var gra = $("#grado_id").val();
            if (und == null || jor == null || gra == null) {
                notify('Alerta', 'Debe indicar todos los parámetros para continuar', 'warning');
            } else {
                $.ajax({
                    type: 'GET',
                    url: url + "academico/asignarrequisitogrado/" + und + "/" + jor + "/" + gra + "/" + id + "/agregarrequisito"
                }).done(function (msg) {
                    if (msg == "SI") {
                        notify('Atención', 'Requisito agregado correctamente', 'success');
                    }
                    if (msg == "NO") {
                        notify('Atención', 'No se pudo agregar el requisito seleccionado', 'error');
                    }
                    if (msg == "EXISTE") {
                        notify('Atención', 'El requisito seleccionado ya fue agregado anteriormente.', 'warning');
                    }
                    getRequisitos();
                });
            }
        }

        function eliminar(id) {
            $.ajax({
                type: 'GET',
                url: url + "academico/asignarrequisitogrado/" + id + "/eliminar"
            }).done(function (msg) {
                if (msg == "SI") {
                    notify('Atención', 'Requisito eliminado correctamente', 'success');
                } else {
                    notify('Atención', 'No se pudo eliminar el requisito seleccionado', 'error');
                }
            });
            getRequisitos();
        }

        function getRequisitos() {
            $("#tb2").html("");
            var und = $("#unidad_id").val();
            var jor = $("#jornada_id").val();
            var gra = $("#grado_id").val();
            if (und == null || jor == null || gra == null) {
                notify('Alerta', 'Debe indicar todos los parámetros para continuar', 'warning');
            }
            $.ajax({
                type: 'GET',
                url: url + "academico/asignarrequisitogrado/" + und + "/" + jor + "/" + gra + "/getrequisitos",
                data: {},
            }).done(function (msg) {
                if (msg !== "null") {
                    var m = JSON.parse(msg);
                    var html = "";
                    $.each(m, function (index, item) {
                        html = html + "<tr><td>" + item.grado + "</td>";
                        html = html + "<td>" + item.requisito + "</td>";
                        html = html + "<td>" + item.jornada + "</td>";
                        html = html + "<td>" + item.unidad + "</td>";
                        html = html + "<td><a style='margin-left: 10px;color: red;' data-toggle='tooltip' title='Eliminar Requisito' id='" + item.id + "' onclick='eliminar(this.id)' <i class='fa fa-trash'></i></a></td>";
                        +"</tr>";
                    });
                    $("#tb2").html(html);
                } else {
                    notify('Atención', 'No hay requisitos asignado para los parametros seleccionados', 'error');
                }
            });
        }
    </script>
@endsection
