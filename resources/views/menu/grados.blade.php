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
        <li class="active"><a> Menú Grados</a></li>
    </ol>
@endsection
@section('content')
    <div class="alert alert-danger alert-dismissible" style="opacity: .65; font-size: 16px; color: #FFFFFF;">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-info"></i> Detalles!</h4>
        El aplicativo busca mantener una política de datos digitalizada el cual mantendrá almacenada la información del
        estudiante y de esta manera saber los procesos de desarrollo del alumno. Las funcionalidades implementadas
        permiten a los usuarios una eficiente interacción con el aplicativo y facilitan el desarrollo adecuado de los
        procesos. Esta funcionalidad permite gestionar la hoja de vida del estudiante.
    </div>
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">MENÚ GRADOS</h3>
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
            <div class="col-md-4">
                <a href="{{route('requisitogrado.index')}}"
                   class="btn btn-danger btn-raised btn-block btn-flat"> REQUISITOS DE GRADO</a>
            </div>
            <div class="col-md-4">
                <a href="{{route('asignarrequisitogrado.index')}}"
                   class="btn btn-danger btn-raised btn-block btn-flat">ASIGNAR REQUISITOS A GRADO</a>
            </div>
            <div class="col-md-4">
                <a href="{{route('verificarrequisitogrado.index')}}"
                   class="btn btn-danger btn-raised btn-block btn-flat">VERIFICAR REQUISITOS DE GRADO</a>
            </div>
            <div class="col-md-4">
                <a href="{{route('ceremonia.index')}}"
                   class="btn btn-danger btn-raised btn-block btn-flat"> CEREMONIAS</a>
            </div>
            <div class="col-md-4">
                <a href="{{route('ceremoniaestudiante.index')}}"
                   class="btn btn-danger btn-raised btn-block btn-flat"> ASIGNAR ESTUDIANTES A CEREMONIA</a>
            </div>
            <div class="col-md-4">
                <a href="#"
                   class="btn btn-danger btn-raised btn-block btn-flat"> ACTA GENERAL DE LA CEREMONIA</a>
            </div>
            <div class="col-md-4">
                <a href="{{route('graduarestudiante.index')}}" class="btn btn-danger btn-raised btn-block btn-flat"> GRADUAR ESTUDIANTES</a>
            </div>
            <div class="col-md-4">
                <a href="#"
                   class="btn btn-danger btn-raised btn-block btn-flat"> GENERAR ACTA DE GRADO ESTUDIANTE</a>
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
