@extends('layouts.admin')
@section('breadcrumb')
    <h1>
        Bienvenido
        <small>Sr(a). {{Auth::user()->nombres}}</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{route('inicio')}}"><i class="fa fa-home"></i> Inicio</a></li>
        <li><a href="{{route('menu.reportes')}}"><i class="fa fa-book"></i> Reportes</a></li>
        <li class="active"><a>Listado General de Estudiantes</a></li>
    </ol>
@endsection
@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">LISTADO GENERAL DE ESTUADIANTES </h3>
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
                        <select class="form-control" id="periodoacademico_id" onchange="getDocentes()">
                            @foreach($periodos as $key=>$value)
                                <option value="{{$key}}">{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Situación</label>
                        <select class="form-control" id="situacionestudiante_id">
                            <option value="0">TODO</option>
                            @foreach($situaciones as $key=>$value)
                                <option value="{{$key}}">{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Categoría</label>
                        <select class="form-control" id="categoria_id">
                            <option value="0">TODO</option>
                            @foreach($categorias as $key=>$value)
                                <option value="{{$key}}">{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-check form-check-inline" style="display: inline-block; margin: 1rem">
                    <input type="radio" class="form-check-input" name="exportar" id="pdf" value="pdf" checked>
                    <label class="form-check-label" for="pdf">Exportar en PDF</label>
                </div>
                <div class="form-check form-check-inline" style="display: inline-block; margin: 1rem">
                    <input type="radio" class="form-check-input" name="exportar" id="excel" value="excel">
                    <label class="form-check-label" for="excel">Exportar en Excel</label>
                </div>
            </div>
            <div class="col-md-12" style="margin-top: 20px !important">
                <div class="form-group">
                    <button class="btn btn-danger icon-btn pull-left" onclick="ir()"><i
                            class="fa fa-fw fa-lg fa-print"></i>Generar Reporte
                    </button>
                    <a class="btn btn-primary icon-btn pull-left" href="{{route('menu.reportes')}}"><i
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
                    <p>Esta funcionalidad permite al usuario consultar el listado general de los estudiantes por una
                        unidad, período, situación y categoría seleccionada.</p>
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
            // $('#example1').DataTable();
        });

        function ir() {
            var exportar = $('input:radio[name=exportar]:checked').val();
            var unidad = $("#unidad_id").val();
            var periodo = $("#periodoacademico_id").val();
            var situacion = $("#situacionestudiante_id").val();
            var categoria = $("#categoria_id").val();
            var a = document.createElement("a");
            a.target = "_blank";
            a.href = '{{url("reportes/listadogeneralestudiantes/")}}/' + unidad + "/" + periodo + "/" + situacion + "/" + categoria + "/" + exportar + "/imprimir";
            a.click();
            // location.href = url + "academico/cargagrados/" + $("#unidad_id").val() + "/" + $("#periodoacademico_id").val() + "/" + $("#jornada_id").val() + "/" + $("#grado_id").val() + "/continuar";
        }
    </script>
@endsection
