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
        <li><a href="{{route('graduarestudiante.index')}}"><i class="fa fa-edit"></i> Graduar Estudiantes</a></li>
        <li class="active"><a>Graduar</a></li>
    </ol>
@endsection
@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">GRADUAR ESTUDIANTES</h3>
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
            <div class="col-md-12">
                <form class="form" role='form' method="POST" action="{{route('graduarestudiante.store')}}">
                @csrf
                    <input type="hidden" name="ceremonia_id" value="{{$ceremonia->id}}">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Situación</label>
                            <select class="form-control" id="situacionestudiante_id" name="situacionestudiante_id">
                                @foreach($situaciones as $key=>$value)
                                    <option value="{{$key}}">{{$value}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Categoría</label>
                            <select class="form-control" id="categoria_id" name="categoria_id">
                                @foreach($categorias as $key=>$value)
                                    <option value="{{$key}}">{{$value}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="callout callout-danger" style="padding: 5px; padding-left: 20px; text-align: center;">
                            <h2>Estudiantes</h2>
                        </div>
                        <div class="table-responsive">
                            <table id="tb" class="table table-bordered table-striped table-hover">
                                <thead>
                                <tr class="danger">
                                    <th>IDENTIFICACIÓN</th>
                                    <th>NOMBRE</th>
                                    <th>GRADUAR</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($estudiantes as $m)
                                    <tr>
                                        <td>{{$m->estudiante->personanatural->persona->tipodoc->abreviatura."-".$m->estudiante->personanatural->persona->numero_documento}}</td>
                                        <td>{{$m->estudiante->personanatural->primer_nombre." ".$m->estudiante->personanatural->segundo_nombre." ".$m->estudiante->personanatural->primer_apellido." ".$m->estudiante->personanatural->segundo_apellido}}</td>
                                        <td>
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="estudiantes[]" value="{{$m->estudiante_id}}"><span class="checkbox-material"></span>
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-12" style="margin-top: 20px !important">
                        <div class="form-group">
                            <button class="btn btn-success icon-btn pull-left" type="submit"><i
                                    class="fa fa-fw fa-lg fa-save"></i>Guardar
                            </button>
                            <button class="btn btn-info icon-btn pull-left" type="reset"><i
                                    class="fa fa-fw fa-lg fa-trash-o"></i>Limpiar
                            </button>
                            <a class="btn btn-danger icon-btn pull-left" href="{{route('graduarestudiante.index')}}"><i
                                    class="fa fa-fw fa-lg fa-times-circle"></i>Cancelar</a>
                        </div>
                    </div>
                </form>
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
                    <p>Esta funcionalidad permitirá al usuario gestionar los estudiantes que seran graduados.</p>
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
