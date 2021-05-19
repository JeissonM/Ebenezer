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
        <li><a href="{{route('menu.hojadevidaestudiante',$a->id)}}"><i class="fa fa-edit"></i> Menú</a></li>
        <li><a href="{{route('acudientes.inicio',$a->id)}}"><i class="fa fa-edit"></i> Acudientes</a></li>
        <li class="active"><a>Agregar Acudiente</a></li>
    </ol>
@endsection
@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">ACUDIENTES</h3>
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
                @component('layouts.errors')
                @endcomponent
            </div>
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                        <tr class="danger">
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
                            <td>{{$a->periodoacademico->etiqueta." - ".$a->periodoacademico->anio}}</td>
                            <td>{{$a->jornada->descripcion." - ".$a->jornada->jornadasnies}}</td>
                            <td>{{$a->unidad->nombre}}</td>
                            <td>{{$a->grado->etiqueta}}</td>
                            <td>{{$a->estado}}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-6">
                <div class="callout callout-danger" style="padding: 5px; padding-left: 20px; text-align: center;">
                    <h2>Personas Natural</h2>
                </div>
                <div class="table-responsive">
                    <table id="tb" class="table table-bordered table-striped table-hover">
                        <thead>
                        <tr class="danger">
                            <th>IDENTIFICACIÓN</th>
                            <th>NOMBRE</th>
                            <th>AGREGAR</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($personas as $m)
                            <tr>
                                <td>{{$m->persona->tipodoc->abreviatura."-".$m->persona->numero_documento}}</td>
                                <td>{{$m->primer_nombre." ".$m->segundo_nombre." ".$m->primer_apellido." ".$m->segundo_apellido}}</td>
                                <td>
                                    <a href="{{route('acudientes.agregar',[$m->id,$a->id])}}"
                                       style="margin-left: 10px;" data-toggle="tooltip" title="Agregar Acudiente"
                                       style="margin-left: 10px;"><i class="fa fa-check"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-6">
                <div class="callout callout-danger" style="padding: 5px; padding-left: 20px; text-align: center;">
                    <h2>Acudientes del Estudiante</h2>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                        <tr class="danger">
                            <th>IDENTIFICACIÓN</th>
                            <th>NOMBRE</th>
                            <th>RETIRAR</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($acudientes as $ms)
                            <tr>
                                <td>{{$ms->personanatural->persona->tipodoc->abreviatura."-".$ms->personanatural->persona->numero_documento}}</td>
                                <td>{{$ms->personanatural->primer_nombre." ".$ms->personanatural->segundo_nombre." ".$ms->personanatural->primer_apellido." ".$ms->personanatural->segundo_apellido}}</td>
                                <td>
                                    <a href="{{route('acudientes.delete',$ms->id)}}"
                                       style="margin-left: 10px; color:red;" data-toggle="tooltip"
                                       title="Retirar Acudiente"><i class="fa fa-times"></i></a>
                                </td>
                            </tr>
                        @endforeach
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
                    <p>Esta funcionalidad permitirá al usuario gestionar los acudientes del estudiante seleccionado.</p>
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
            $('#tb').DataTable();
            $('.select2').select2();
        });
    </script>
@endsection
