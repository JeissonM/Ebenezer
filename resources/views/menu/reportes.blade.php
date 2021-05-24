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
                                        <a target="_blank" href="{{route('reportes.listadogeneraldocentes')}}"
                                           class="btn btn-danger btn-raised btn-block btn-flat"> LISTADO GENERAL DE DOCENTES</a>
                                    </div>
                                @endif
                                @if(session()->exists('PAG_REPORTES-CARGA-ACADEMICA-DOCENTE'))
                                    <div class="col-md-4">
                                        <a href="{{route('reportes.cargadocente')}}"
                                           class="btn btn-danger btn-raised btn-block btn-flat"> CARGA ACADÉMICA DE UN DOCENTE</a>
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
@endsection
@section('script')
    <script type="text/javascript">
        $(document).ready(function () {
            //$('#example1').DataTable();
        });

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
