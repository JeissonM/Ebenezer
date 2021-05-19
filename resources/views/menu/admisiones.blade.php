@extends('layouts.admin')
@section('breadcrumb')
<h1>
    Bienvenido
    <small>Sr(a). {{Auth::user()->nombres}}</small>
</h1>
<ol class="breadcrumb">
    <li class="active"><a href="{{route('home')}}"><i class="fa fa-home"></i> Inicio</a></li>
    <li><a>Admisiones</a></li>
</ol>
@endsection
@section('content')
<div class="alert alert-success alert-dismissible" style="opacity: .65; font-size: 16px; color: #FFFFFF;">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h4><i class="icon fa fa-info"></i> Detalles!</h4>
    Configure todo lo necesario para que el proceso de admisión se lleve a cabo de manera práctica y correcta, gestione la información de los inscritos, realice las entrevistas de admisión, entre otras tareas.
</div>
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">MENÚ MÓDULO ADMISIONES</h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Minimizar">
                <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Cerrar">
                <i class="fa fa-times"></i></button>
        </div>
    </div>
    <div class="box-body">
        <div class="col-md-12">
            <!-- Custom Tabs -->
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab_1" data-toggle="tab"><i class="fa fa-cogs"></i> DATOS BÁSICOS</a></li>
                    <li><a href="#tab_2" data-toggle="tab"><i class="fa fa-list-ul"></i> DATOS DE ADMISIÓN Y MATRÍCULA</a></li>
                    <li><a href="#tab_3" data-toggle="tab"><i class="fa fa-calendar"></i> CALENDARIO, PROCESOS Y CONVOCATORIA</a></li>
                    <li><a href="#tab_4" data-toggle="tab"><i class="fa fa-calendar-plus-o"></i> AGENDA & ENTREVISTA</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_1">
                        <div class="row">
                            @if(session()->exists('PAG_ADMISIONES-PAISES'))
                            <div class="col-md-3">
                                <a href="{{route('pais.index')}}" class="btn btn-success btn-raised btn-block btn-flat"> PAÍSES</a>
                            </div>
                            @endif
                            @if(session()->exists('PAG_ADMISIONES-ESTADOS'))
                            <div class="col-md-5">
                                <a href="{{route('estado.index')}}" class="btn btn-success btn-raised btn-block btn-flat"> DEPARTAMENTOS, ESTADOS Ó PROVINCIAS</a>
                            </div>
                            @endif
                            @if(session()->exists('PAG_ADMISIONES-CIUDADES'))
                            <div class="col-md-4">
                                <a href="{{route('ciudad.index')}}" class="btn btn-success btn-raised btn-block btn-flat"> CIUDADES</a>
                            </div>
                            @endif
                            @if(session()->exists('PAG_ADMISIONES-TIPODOC'))
                            <div class="col-md-4">
                                <a href="{{route('tipodoc.index')}}" class="btn btn-success btn-raised btn-block btn-flat"> TIPOS DE DOCUMENTOS</a>
                            </div>
                            @endif
                            @if(session()->exists('PAG_ADMISIONES-SEXO'))
                            <div class="col-md-4">
                                <a href="{{route('sexo.index')}}" class="btn btn-success btn-raised btn-block btn-flat"> SEXO</a>
                            </div>
                            @endif
                            @if(session()->exists('PAG_ADMISIONES-ENTIDAD-SALUD'))
                            <div class="col-md-4">
                                <a href="{{route('entidadsalud.index')}}" class="btn btn-success btn-raised btn-block btn-flat"> ENTIDADES DE SALUD</a>
                            </div>
                            @endif
                            @if(session()->exists('PAG_ADMISIONES-ETNIAS'))
                            <div class="col-md-4">
                                <a href="{{route('etnia.index')}}" class="btn btn-success btn-raised btn-block btn-flat"> ETNIAS</a>
                            </div>
                            @endif
                            @if(session()->exists('PAG_ADMISIONES-ESTRATOS'))
                            <div class="col-md-4">
                                <a href="{{route('estrato.index')}}" class="btn btn-success btn-raised btn-block btn-flat"> NIVEL SOCIOECONOMICO</a>
                            </div>
                            @endif
                        </div>
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="tab_2">
                        <div class="row">
                            @if(session()->exists('PAG_ADMISIONES-OCUPACIONES'))
                            <div class="col-md-4">
                                <a href="{{route('ocupacion.index')}}" class="btn btn-success btn-raised btn-block btn-flat"> OCUPACIONES LABORALES</a>
                            </div>
                            @endif
                            @if(session()->exists('PAG_ADMISIONES-GRADOS-ACADEMICOS'))
                            <div class="col-md-5">
                                <a href="{{route('gradoacademico.index')}}" class="btn btn-success btn-raised btn-block btn-flat"> GRADOS ACADÉMICOS (AÑOS ESCOLARES)</a>
                            </div>
                            @endif
                            @if(session()->exists('PAG_ADMISIONES-CON-QUIEN-VIVE'))
                            <div class="col-md-3">
                                <a href="{{route('conquienvive.index')}}" class="btn btn-success btn-raised btn-block btn-flat"> ¿CON QUIÉN VIVE?</a>
                            </div>
                            @endif
                            @if(session()->exists('PAG_ADMISIONES-RANGO-SISBEN'))
                            <div class="col-md-4">
                                <a  href="{{route('rangosisben.index')}}" class="btn btn-success btn-raised btn-block btn-flat"> Rango Sisben</a>
                            </div>
                            @endif
                            @if(session()->exists('PAG_ADMISIONES-SITUACION-ANIO-ANTERIOR'))
                            <div class="col-md-4">
                                <a href="{{route('situacionanterior.index')}}" class="btn btn-success btn-raised btn-block btn-flat"> Situación Año Anterior</a>
                            </div>
                            @endif
                            @if(session()->exists('PAG_ADMISIONES-DOCUMENTOS-ANEXOS'))
                            <div class="col-md-4">
                                <a href="{{route('documentosanexos.index')}}" class="btn btn-success btn-raised btn-block btn-flat"> Documentos Anexos</a>
                            </div>
                            @endif
                            @if(session()->exists('PAG_ADMISIONES-PARAMETRIZAR-DOCUMENTOS-ANEXOS'))
                            <div class="col-md-4">
                                <a href="{{route('parametrizardocumentosanexos.index')}}" class="btn btn-success btn-raised btn-block btn-flat"> Parametrizar Documentos Anexos</a>
                            </div>
                            @endif
                        </div>
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="tab_3">
                        <div class="row">
                            @if(session()->exists('PAG_ADMISIONES-PERIODOS-ACADEMICOS'))
                            <div class="col-md-4">
                                <a href="{{route('periodoacademico.index')}}" class="btn btn-success btn-raised btn-block btn-flat"> PERÍODOS ACADÉMICOS</a>
                            </div>
                            @endif
                            @if(session()->exists('PAG_ADMISIONES-UNIDAD'))
                            <div class="col-md-4">
                                <a  href="{{route('unidad.index')}}" class="btn btn-success btn-raised btn-block btn-flat"> Unidades</a>
                            </div>
                            @endif
                            @if(session()->exists('PAG_ADMISIONES-JORNADA'))
                            <div class="col-md-4">
                                <a href="{{route('jornada.index')}}" class="btn btn-success btn-raised btn-block btn-flat"> Jornadas</a>
                            </div>
                            @endif
                            @if(session()->exists('PAG_ADMISIONES-PROGRAMAR-PERIODO'))
                            <div class="col-md-4">
                                <a  href="{{route('periodounidad.index')}}" class="btn btn-success btn-raised btn-block btn-flat"> Programar Período Académico</a>
                            </div>
                            @endif
                            @if(session()->exists('PAG_ADMISIONES-CONVOCATORIA'))
                            <div class="col-md-4">
                                <a href="{{route('convocatoria.index')}}" class="btn btn-success btn-raised btn-block btn-flat"> Convocatoria</a>
                            </div>
                            @endif
                            @if(session()->exists('PAG_ADMISIONES-CIRCUNSCRIPCION'))
                            <div class="col-md-4">
                                <a href="{{route('circunscripcion.index')}}" class="btn btn-success btn-raised btn-block btn-flat"> Circunscripción</a>
                            </div>
                            @endif
                        </div>
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="tab_4">
                        <div class="row">
                            @if(session()->exists('PAG_ADMISIONES-AGENDA-CITAS'))
                            <div class="col-md-4">
                                <a href="{{route('agendacita.index')}}" class="btn btn-success btn-raised btn-block btn-flat"> PROGRAMAR AGENDA</a>
                            </div>
                            @endif
                            @if(session()->exists('PAG_ADMISIONES-CONTRATO-INSCRIPCION'))
                            <div class="col-md-4">
                                <a href="{{route('contratoinscripcion.index')}}" class="btn btn-success btn-raised btn-block btn-flat"> CONTRATO DE INSCRIPCIÓN</a>
                            </div>
                            @endif
                            @if(session()->exists('PAG_ADMISIONES-AGENDAR-ENTREVISTA'))
                            <div class="col-md-4">
                                <a href="{{route('entrevista.create')}}" class="btn btn-success btn-raised btn-block btn-flat"> AGENDAR ENTREVISTA</a>
                            </div>
                            @endif
                            @if(session()->exists('PAG_ADMISIONES-AREAS-EXAMEN-ADMISION'))
                            <div class="col-md-4">
                                <a href="{{route('areaexamenadmision.index')}}" class="btn btn-success btn-raised btn-block btn-flat"> ÁREAS EXÁMEN ADMISIÓN</a>
                            </div>
                            @endif
                            @if(session()->exists('PAG_ADMISIONES-PARAMETRIZAR-AREAS'))
                            <div class="col-md-4">
                                <a href="{{route('areaexamenadmisiongrado.index')}}" class="btn btn-success btn-raised btn-block btn-flat"> PARAMETRIZAR ÁREAS EXÁMEN ADMISIÓN</a>
                            </div>
                            @endif
                            @if(session()->exists('PAG_ADMISIONES-HACER-ENTREVISTA'))
                            <div class="col-md-4">
                                <a href="{{route('realizarentrevista.index')}}" class="btn btn-success btn-raised btn-block btn-flat"> REALIZAR ENTREVISTA</a>
                            </div>
                            @endif
                            @if(session()->exists('PAG_ADMISIONES-HACER-EXAMEN'))
                            <div class="col-md-4">
                                <a href="{{route('examenadmision.index')}}" class="btn btn-success btn-raised btn-block btn-flat"> REALIZAR EXÁMEN DE ADMISIÓN</a>
                            </div>
                            @endif
                            @if(session()->exists('PAG_ADMISIONES-CREAR-ENTREVISTAS'))
                            <div class="col-md-4">
                                <a href="{{route('cuestionarioentrevista.index')}}" class="btn btn-success btn-raised btn-block btn-flat"> CREAR Y CONFIGURAR ENTREVISTAS</a>
                            </div>
                            @endif
                            @if(session()->exists('PAG_ADMISIONES-ADMITIR-ASPIRANTES'))
                            <div class="col-md-4">
                                <a href="{{route('admitiraspirantes.index')}}" class="btn btn-success btn-raised btn-block btn-flat"> ADMITIR ASPIRANTES</a>
                            </div>
                            @endif
                            @if(session()->exists('PAG_ADMISIONES-VERIFICAR-REQUISITOS-ADMISION'))
                            <div class="col-md-6">
                                <a href="{{route('verificarrequisitos.index')}}" class="btn btn-success btn-raised btn-block btn-flat"> VERIFICAR REQUISITOS DE INSCRIPCIÓN (DOCUMENTOS ANEXOS)</a>
                            </div>
                            @endif
                        </div>
                    </div>
                    <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
            </div>
            <!-- nav-tabs-custom -->
        </div>
    </div>
</div>
@endsection
