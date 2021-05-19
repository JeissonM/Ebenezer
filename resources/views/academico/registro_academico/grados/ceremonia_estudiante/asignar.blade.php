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
        <li><a href="{{route('ceremoniaestudiante.index')}}"><i class="fa fa-edit"></i> Asignar Estudiantes a Ceremonia</a></li>
        <li class="active"><a>Agregar Estudiantes</a></li>
    </ol>
@endsection
@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">AGREGAR ESTUDIANTES A CEREMONIA</h3>
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
                            <th>TITULO</th>
                            <th>LUGAR</th>
                            <th>FECHA INICIO</th>
                            <th>FECHA FIN</th>
                            <th>PERÍODO</th>
                            <th>JORNADA</th>
                            <th>UNIDAD</th>
                            <th>GRADO</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>{{$ceremonia->titulo}}</td>
                            <td>{{$ceremonia->lugar}}</td>
                            <td>{{$ceremonia->fechahorainicio}}</td>
                            <td>{{$ceremonia->fechahorafin}}</td>
                            <td>{{$ceremonia->periodoacademico->etiqueta." - ".$ceremonia->periodoacademico->anio}}</td>
                            <td>{{$ceremonia->jornada->descripcion." - ".$ceremonia->jornada->jornadasnies}}</td>
                            <td>{{$ceremonia->unidad->nombre}}</td>
                            <td>{{$ceremonia->grado->etiqueta}}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-6">
                <div class="callout callout-danger" style="padding: 5px; padding-left: 20px; text-align: center;">
                    <h2>Estudiantes</h2>
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
                        @foreach($estudiantes as $m)
                            <tr>
                                <td>{{$m->personanatural->persona->tipodoc->abreviatura."-".$m->personanatural->persona->numero_documento}}</td>
                                <td>{{$m->personanatural->primer_nombre." ".$m->personanatural->segundo_nombre." ".$m->personanatural->primer_apellido." ".$m->personanatural->segundo_apellido}}</td>
                                <td>
                                    @if($m->cumplio == "SI")
                                        <a href="{{route('ceremoniaestudiante.agregar',[$m->id,$ceremonia->id])}}"
                                           style="margin-left: 10px;" data-toggle="tooltip" title="Agregar Estudiante"
                                           style="margin-left: 10px;"><i class="fa fa-check"></i></a>
                                        @else
                                        REQUISITOS IMCOMPLETOS {{$m->cumplidos}}/{{$m->requisitos}}
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-6">
                <div class="callout callout-danger" style="padding: 5px; padding-left: 20px; text-align: center;">
                    <h2>Estudiantes en la Ceremonia</h2>
                </div>
                <div class="table-responsive">
                    <table id="tb2" class="table table-bordered table-striped table-hover">
                        <thead>
                        <tr class="danger">
                            <th>IDENTIFICACIÓN</th>
                            <th>NOMBRE</th>
                            <th>RETIRAR</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($asignados as $ms)
                            <tr>
                                <td>{{$ms->estudiante->personanatural->persona->tipodoc->abreviatura."-".$ms->estudiante->personanatural->persona->numero_documento}}</td>
                                <td>{{$ms->estudiante->personanatural->primer_nombre." ".$ms->estudiante->personanatural->segundo_nombre." ".$ms->estudiante->personanatural->primer_apellido." ".$ms->estudiante->personanatural->segundo_apellido}}</td>
                                <td>
                                    <a href="{{route('ceremoniaestudiante.retirar',$ms->id)}}"
                                       style="margin-left: 10px; color:red;" data-toggle="tooltip"
                                       title="Retirar Estudiante"><i class="fa fa-times"></i></a>
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
                    <p>Esta funcionalidad permitirá al usuario gestionar los estudiantes en la ceremonia seleccionada.</p>
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
            $('#tb2').DataTable();
            $('.select2').select2();
        });
    </script>
@endsection
