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
        <li><a href="{{route('hojadevida.index')}}"><i class="fa fa-edit"></i> Hoja de Vida Estudiante</a></li>
        <li class="active"><a> Menú</a></li>
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
            <h3 class="box-title">MENÚ HOJA DE VIDA ESTUDIANTE</h3>
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
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                        <tr class="info">
                            <th>IDENTIFICACIÓN</th>
                            <th>ESTUDIANTE</th>
                            <th>PERÍODO</th>
                            <th>JORNADA</th>
                            <th>UNIDAD</th>
                            <th>GRADO</th>
                            <th>ESTADO</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>{{$pn->persona->tipodoc->abreviatura." - ".$pn->persona->numero_documento}}</td>
                            <td>{{$pn->primer_nombre." ".$pn->segundo_nombre." ".$pn->primer_apellido." ".$pn->segundo_apellido}}</td>
                            <td>{{$estudiante->periodoacademico->etiqueta." - ".$estudiante->periodoacademico->anio}}</td>
                            <td>{{$estudiante->jornada->descripcion." - ".$estudiante->jornada->jornadasnies}}</td>
                            <td>{{$estudiante->unidad->nombre}}</td>
                            <td>{{$estudiante->grado->etiqueta}}</td>
                            <td>{{$estudiante->estado}}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-4">
                <a href="{{route('hojadevida.datosbasicos',$estudiante->id)}}"
                   class="btn btn-danger btn-raised btn-block btn-flat"> DATOS BASICOS</a>
            </div>
            <div class="col-md-4">
                <a href="{{route('hojadevida.complementarios',$estudiante->id)}}"
                   class="btn btn-danger btn-raised btn-block btn-flat"> DATOS COMPLEMENTARIOS</a>
            </div>
            <div class="col-md-4">
                <a href="{{route('padresestudiante.inicio',$estudiante->id)}}"
                   class="btn btn-danger btn-raised btn-block btn-flat"> PADRES</a>
            </div>
            <div class="col-md-4">
                <a href="{{route('acudientes.inicio',$estudiante->id)}}" class="btn btn-danger btn-raised btn-block btn-flat"> ACUDIENTES</a>
            </div>
            <div class="col-md-4">
                <a href="{{route('responsablefestudiante.inicio',$estudiante->id)}}"
                   class="btn btn-danger btn-raised btn-block btn-flat"> RESPONSABLES FINANCIEROS</a>
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
