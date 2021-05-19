@extends('layouts.admin')
@section('breadcrumb')
    <h1>
        Bienvenido
        <small>Sr(a). {{Auth::user()->nombres}}</small>
    </h1>
    <ol class="breadcrumb">
        <li class="active"><a href="{{route('home')}}"><i class="fa fa-home"></i> Inicio</a></li>
        <li><a>Académicos</a></li>
    </ol>
@endsection
@section('content')
    <div class="alert alert-danger alert-dismissible" style="opacity: .65; font-size: 16px; color: #FFFFFF;">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-info"></i> Detalles!</h4>
        Módulo académico, lleve a cabo todas las tareas relacionadas a la carga académica para docentes y grupos,
        calificaciones, disciplina, actividades, y todos los procesos académicos de la institución..
    </div>
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">MENÚ MÓDULO ACADÉMICO</h3>
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
                        <li class="active"><a href="#tab_1" data-toggle="tab"><i class="fa fa-book"></i> CARGA ACADÉMICA</a>
                        </li>
                        <li><a href="#tab_2" data-toggle="tab"><i class="fa fa-bookmark"></i> CARGA ADMINISTRATIVA</a>
                        </li>
                        <li><a href="#tab_3" data-toggle="tab"><i class="fa fa-calendar-o"></i> CALENDARIO ACADÉMICO</a>
                        </li>
                        <li><a href="#tab_4" data-toggle="tab"><i class="fa fa-edit"></i> REGISTRO ACADÉMICO</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_1">
                            <div class="row">
                                @if(session()->exists('PAG_ACADEMICO-CARGA-ACADEMICA-GRADOS'))
                                    <div class="col-md-4">
                                        <a href="{{route('cargagrados.index')}}"
                                           class="btn btn-danger btn-raised btn-block btn-flat"> CARGA ACADÉMICA A
                                            GRADOS</a>
                                    </div>
                                @endif
                                @if(session()->exists('PAG_ACADEMICO-CARGA-ACADEMICA-DOCENTES'))
                                    <div class="col-md-4">
                                        <a href="{{route('cargagrupomatdoc.index')}}"
                                           class="btn btn-danger btn-raised btn-block btn-flat"> CARGA ACADÉMICA A
                                            DOCENTES</a>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="tab-pane" id="tab_2">
                            <div class="row">
                                @if(session()->exists('PAG_ACADEMICO-PERSONAS-NATURALES'))
                                    <div class="col-md-3">
                                        <a href="{{route('personanatural.index')}}"
                                           class="btn btn-danger btn-raised btn-block btn-flat"> PERSONAS NATURALES</a>
                                    </div>
                                @endif
                                @if(session()->exists('PAG_ADMISIONES-UNIDAD'))
                                    <div class="col-md-3">
                                        <a onclick="unidad()" class="btn btn-danger btn-raised btn-block btn-flat">
                                            UNIDADES</a>
                                    </div>
                                @endif
                                @if(session()->exists('PAG_ACADEMICO-SITUACION-ADMINISTRATIVA'))
                                    <div class="col-md-3">
                                        <a href="{{route('situacionadministrativa.index')}}"
                                           class="btn btn-danger btn-raised btn-block btn-flat"> SITUACIÓN
                                            ADMINISTRATIVA</a>
                                    </div>
                                @endif
                                @if(session()->exists('PAG_ACADEMICO-DOCENTES'))
                                    <div class="col-md-3">
                                        <a href="{{route('docente.index')}}"
                                           class="btn btn-danger btn-raised btn-block btn-flat"> DOCENTES</a>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="tab-pane" id="tab_3">
                            <div class="row">
                                @if(session()->exists('PAG_ADMISIONES-PERIODOS-ACADEMICOS'))
                                    <div class="col-md-3">
                                        <a onclick="periodo()" class="btn btn-danger btn-raised btn-block btn-flat">
                                            PERÍODO ACADÉMICO</a>
                                    </div>
                                @endif
                                @if(session()->exists('PAG_ADMISIONES-PROGRAMAR-PERIODO'))
                                    <div class="col-md-3">
                                        <a onclick="programar()" class="btn btn-danger btn-raised btn-block btn-flat">
                                            PROGRAMAR PERÍODO</a>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="tab-pane" id="tab_4">
                            <div class="row">
                                @if(session()->exists('PAG_ACADEMICO-HOJA-DE-VIDA'))
                                    <div class="col-md-3">
                                        <a href="{{route('hojadevida.index')}}"
                                           class="btn btn-danger btn-raised btn-block btn-flat"> HOJA DE VIDA
                                            ESTUDIANTE</a>
                                    </div>
                                @endif
                                @if(session()->exists('PAG_ACADEMICO-MATRICULA-FINANCIERA'))
                                    <div class="col-md-3">
                                        <a href="{{route('matriculafinanciera.index')}}"
                                           class="btn btn-danger btn-raised btn-block btn-flat"> MATRÍCULA
                                            FINANCIERA</a>
                                    </div>
                                @endif
                                @if(session()->exists('PAG_ACADEMICO-HORARIOS'))
                                    <div class="col-md-3">
                                        <a href="{{route('horario.index')}}"
                                           class="btn btn-danger btn-raised btn-block btn-flat"> HORARIOS</a>
                                    </div>
                                @endif
                                <div class="col-md-3">
                                    <a disabled="disabled" class="btn btn-danger btn-raised btn-block btn-flat">
                                        CALIFICACIONES</a>
                                </div>
                                @if(session()->exists('PAG_ACADEMICO-SANCIONES'))
                                    <div class="col-md-3">
                                        <a href="{{route('sancion.index')}}"
                                           class="btn btn-danger btn-raised btn-block btn-flat"> SANCIONES &
                                            DISCIPLINA</a>
                                    </div>
                                @endif
                                @if(session()->exists('PAG_ACADEMICO-SISTEMA-EVALUACION'))
                                    <div class="col-md-3">
                                        <a href="{{route('sistemaevaluacion.index')}}"
                                           class="btn btn-danger btn-raised btn-block btn-flat"> SISTEMA DE
                                            EVALUACIÓN</a>
                                    </div>
                                @endif
                                @if(session()->exists('PAG_ACADEMICO-EVALUACION-ACADEMICA'))
                                    <div class="col-md-3">
                                        <a href="{{route('evaluacionacademica.index')}}"
                                           class="btn btn-danger btn-raised btn-block btn-flat"> EVALUACIÓN
                                            ACADÉMICA</a>
                                    </div>
                                @endif
                                @if(session()->exists('PAG_ACADEMICO-GRADOS'))
                                    <div class="col-md-3">
                                        <a href="{{route('menu.grados')}}"
                                           class="btn btn-danger btn-raised btn-block btn-flat"> GRADOS</a>
                                    </div>
                                @endif
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
