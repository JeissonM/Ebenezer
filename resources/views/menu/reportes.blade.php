@extends('layouts.admin')
@section('breadcrumb')
    <h1>
        Bienvenido
        <small>Sr(a). {{Auth::user()->nombres}}</small>
    </h1>
    <ol class="breadcrumb">
        <li class="active"><a href="{{route('home')}}"><i class="fa fa-home"></i> Inicio</a></li>
        <li><a>Reportes</a></li>
    </ol>
@endsection
@section('content')
    <div class="alert alert-danger alert-dismissible" style="opacity: .65; font-size: 16px; color: #FFFFFF;">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-info"></i> Detalles!</h4>
        Módulo de reportes, getione los diferentes reportes del sistema.
    </div>
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">MENÚ MÓDULO REPORTES</h3>
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
                <!-- Custom Tabs -->
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab_1" data-toggle="tab"><i class="fa fa-book"></i> ACADÉMICO</a>
                        </li>
                        <li><a href="#tab_2" data-toggle="tab"><i class="fa fa-edit"></i> REGISTRO ACADÉMICO</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_1">
                            <div class="row">
                                @if(session()->exists('PAG_REPORTES-LISTADO-GENERAL-DOCENTE'))
                                    <div class="col-md-4">
                                        <button type="button" class="btn btn-danger btn-raised btn-block btn-flat"
                                                data-toggle="modal" data-target="#modal"> LISTADO GENERAL DE
                                            DOCENTES
                                        </button>
                                    </div>
                                @endif
                                @if(session()->exists('PAG_REPORTES-CARGA-ACADEMICA-DOCENTE'))
                                    <div class="col-md-4">
                                        <a href="{{route('reportes.cargadocente')}}"
                                           class="btn btn-danger btn-raised btn-block btn-flat"> CARGA ACADÉMICA DE UN
                                            DOCENTE</a>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="tab-pane" id="tab_2">
                            <div class="row">
                            </div>
                        </div>
                    </div>
                    <!-- /.tab-content -->
                </div>
                <!-- nav-tabs-custom -->
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Generar reporte</h4>
                </div>
                <div class="modal-body">
                    <p>Seleccione el formato para el reporte.</p>
                    <div class="form-check form-check-inline" style="display: inline-block; margin: 1rem">
                        <input type="radio" class="form-check-input" name="exportar" id="pdf" value="pdf" checked>
                        <label class="form-check-label" for="pdf">Exportar en PDF</label>
                    </div>
                    <div class="form-check form-check-inline" style="display: inline-block; margin: 1rem">
                        <input type="radio" class="form-check-input" name="exportar" id="excel" value="excel">
                        <label class="form-check-label" for="excel">Exportar en Excel</label>
                    </div>
                </div>
                <div class="modal-footer" style="background-color: #d2d6de !important; opacity: .65;">
                    <button type="button" class="btn btn-block btn-danger btn-flat pull-right" data-dismiss="modal"><i
                            class="fa fa-reply"></i> Cancelar
                    </button>
                    <button class="btn btn-block btn-primary btn-flat pull-right" onclick="ir()">
                        LISTADO GENERAL DE DOCENTES
                    </button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

@endsection
@section('script')
    <script type="text/javascript">
        $(document).ready(function () {
            //$('#example1').DataTable();
        });

        function ir() {
            var exportar = $('input:radio[name=exportar]:checked').val();
            var imprimir = true;
            var a = document.createElement("a");
            a.target = "_blank";
            a.href = '{{url("reportes/listadogeneraldocentes/imprimir/")}}/' +  imprimir + "/"+ exportar;
            a.click();
            // location.href = url + "academico/cargagrados/" + $("#unidad_id").val() + "/" + $("#periodoacademico_id").val() + "/" + $("#jornada_id").val() + "/" + $("#grado_id").val() + "/continuar";
        }

        function unidad() {
            if (confirm('Será redirigido al módulo ADMISIONES en su funcionalidad UNIDADES')) {
                location.href = url + "admisiones/unidad";
            }
        }

        function periodo() {
            if (confirm('Será redirigido al módulo ADMISIONES en su funcionalidad PERÍODO ACADÉMICO')) {
                location.href = url + "admisiones/periodoacademico";
            }
        }

        function programar() {
            if (confirm('Será redirigido al módulo ADMISIONES en su funcionalidad PROGRAMAR PERÍODO')) {
                location.href = url + "admisiones/periodounidad";
            }
        }
    </script>
@endsection
