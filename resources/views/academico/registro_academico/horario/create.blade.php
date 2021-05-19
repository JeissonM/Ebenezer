@extends('layouts.admin')
@section('breadcrumb')
    <h1>
        Bienvenido
        <small>Sr(a). {{Auth::user()->nombres}}</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{route('home')}}"><i class="fa fa-home"></i> Inicio</a></li>
        <li><a href="{{route('menu.academico')}}"><i class="fa fa-book"></i> Académico</a></li>
        <li><a href="{{route('menu.academico')}}"><i class="fa fa-bookmark"></i> Registro Académico</a></li>
        <li><a href="{{route('horario.index')}}"><i class="fa fa-bookmark"></i> Horario</a></li>
        <li class="active"><a>Gestionar Horario</a></li>
    </ol>
@endsection
@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">GESTIONAR HORARIO</h3>
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
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                        <tr class="danger">
                            <th>UNIDAD</th>
                            <th>PERÍODO ACADÉMICO</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>{{$grupo->unidad->nombre." - ".$grupo->unidad->ciudad->nombre}}</td>
                            <td>{{$grupo->periodoacademico->etiqueta." - ".$grupo->periodoacademico->anio}}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                        <tr class="danger">
                            <th>JORNADA</th>
                            <th>GRADO</th>
                            <th>GRUPO</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>{{$grupo->jornada->descripcion." - ".$grupo->jornada->jornadasnies}}</td>
                            <td>{{$grupo->grado->etiqueta}}</td>
                            <td>{{$grupo->nombre}}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <h4>Horario del Grupo</h4>
                @if($horario != null)
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                            <tr class="danger">
                                <th>ID</th>
                                <th>HORARIO</th>
                                <th>ACCIONES</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>{{$horario->id}}</td>
                                <td><a target="_blank" href="{{asset('horarios/'.$horario->horario)}}">{{$horario->horario}}</a></td>
                                <td><a href="{{route('horario.delete',$horario->id)}}"
                                       style="margin-left: 10px; color:red;" data-toggle="tooltip"
                                       title="Eliminar Horario"><i class="fa fa-trash-o"></i></a></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                @else
                    <form class="form" role='form' method="POST" action="{{route('horario.store')}}"
                          enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="grupo_id" value="{{$grupo->id}}">
                        <div class="col md 12">
                            <div class="form-group">
                                <label>Horario (Adjuntar archivo .pdf)</label>
                                <input type="file" class="form-control" name="horario" required="required">
                            </div>
                        </div>
                        <div class="col-md-12" style="margin-top: 20px !important">
                            <div class="form-group">
                                <button class="btn btn-success icon-btn pull-left" type="submit"><i
                                        class="fa fa-fw fa-lg fa-save"></i>Guardar
                                </button>
                                <button class="btn btn-info icon-btn pull-left" id="limpiar" type="reset"><i
                                        class="fa fa-fw fa-lg fa-trash-o"></i>Limpiar
                                </button>
                                <a class="btn btn-danger icon-btn pull-left"
                                   href="{{route('horario.index')}}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancelar</a>
                            </div>
                        </div>
                    </form>
                @endif
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
                    <p>Esta funcionalidad permite al usuario gestionar el horario para el grupo seleccionado.</p>
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
        });
    </script>
@endsection
