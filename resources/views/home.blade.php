@extends('layouts.admin')
@section('breadcrumb')
<h1>
    Bienvenido
    <small>Sr(a). {{Auth::user()->nombres}}</small>
</h1>
<ol class="breadcrumb">
    <li class="active"><a href="{{route('home')}}"><i class="fa fa-home"></i> Inicio</a></li>
</ol>
@endsection
@section('content')
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Inicio</h3>

        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Minimizar">
                <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Cerrar">
                <i class="fa fa-times"></i> </button>
        </div>
    </div>
    <div class="box-body">
        @if(session()->exists('MOD_INICIO'))
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-aqua-gradient"><i class="fa fa-home"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Inicio</span>
                    <a href="{{route('inicio')}}" class="info-box-number">INICIO</a>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        @endif
        @if(session()->exists('MOD_USUARIOS'))
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-blue-gradient"><i class="fa fa-users"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Seguridad</span>
                    <a href="{{route('menu.usuarios')}}" class="info-box-number">& USUARIOS</a>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        @endif
        @if(session()->exists('MOD_ADMISIONES'))
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-green-gradient"><i class="fa fa-check-circle-o"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Admisiones</span>
                    <a href="{{route('menu.admisiones')}}" class="info-box-number">& SELECCIÓN</a>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        @endif
        @if(session()->exists('MOD_MATRICULA'))
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-aqua-gradient"><i class="fa fa-tasks"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Proceso de</span>
                    <a href="{{route('menu.matricula')}}" class="info-box-number">MATRÍCULA</a>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        @endif
        @if(session()->exists('MOD_PANEL-ACUDIENTE'))
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-green-gradient"><i class="fa fa-edit"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Proceso de</span>
                    <a href="{{route('menu.inscripcion')}}" class="info-box-number">INSCRIPCIÓN</a>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        @endif
        @if(session()->exists('MOD_ACADEMICO'))
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-red-gradient"><i class="fa fa-book"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Módulo</span>
                    <a href="{{route('menu.academico')}}" class="info-box-number">ACADÉMICO</a>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        @endif
            @if(session()->exists('MOD_ACADEMICO-DOCENTE'))
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-red-gradient"><i class="fa fa-folder"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Módulo</span>
                            <a href="{{route('menu.academicodocente')}}" class="info-box-number">ACADÉMICO</a>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
            @endif
            @if(session()->exists('MOD_DOCUMENTAL'))
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-purple-gradient"><i class="fa fa-folder"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Módulo</span>
                            <a href="{{route('menu.documental')}}" class="info-box-number">DOCUMENTAL</a>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
            @endif
        @if(session()->exists('MOD_PANEL-DOCENTE'))
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-red-gradient"><i class="fa fa-vimeo"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">AULA</span>
                    <a href="{{route('menu.aulavirtual')}}" class="info-box-number">VIRTUAL</a>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        @endif
        @if(session()->exists('MOD_PANEL-ESTUDIANTE'))
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-red-gradient"><i class="fa fa-vimeo"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">AULA</span>
                    <a href="{{route('menu.aulavirtual')}}" class="info-box-number">VIRTUAL</a>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        @endif
        @if(session()->exists('MOD_ACADEMICO-ESTUDIANTE'))
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-teal-active"><i class="fa fa-book"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Módulo</span>
                    <a href="{{route('menu.academicoestudiante')}}" class="info-box-number">ACADÉMICO</a>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        @endif
        @if(session()->exists('MOD_ACADEMICO-ACUDIENTE'))
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-teal-active"><i class="fa fa-book"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Módulo</span>
                    <a href="{{route('menu.academicoacudiente')}}" class="info-box-number">ACADÉMICO</a>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        @endif
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-red-gradient"><i class="fa fa-sign-out"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Adiós</span>
                    <a href="{{ route('logout') }}" onclick="event.preventDefault();
                            document.getElementById('logout-form3').submit();" class="info-box-number">
                        SALIR</a>
                    <form id="logout-form3" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
    </div>
</div>
@endsection
