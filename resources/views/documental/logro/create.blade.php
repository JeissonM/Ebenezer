@extends('layouts.admin')
@section('breadcrumb')
    <h1>
        Bienvenido
        <small>Sr(a). {{Auth::user()->nombres}}</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{route('home')}}"><i class="fa fa-home"></i> Inicio</a></li>
        <li><a href="{{route('menu.documental')}}"><i class="fa fa-book"></i> Documental</a></li>
        <li><a href="{{route('logro.index')}}"><i class="fa fa-edit"></i> Logros</a></li>
        <li><a href="{{route('logro.listar',$gmd)}}"><i class="fa fa-edit"></i> Listar Logros</a></li>
        <li class="active"><a> Crear</a></li>
    </ol>
@endsection
@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">CREAR NUEVO LOGRO</h3>
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
                        <tr class="bg-purple">
                            <th>UNIDAD</th>
                            <th>PERÍODO</th>
                            <th>JORNADA</th>
                            <th>GRADO</th>
                            <th>MATERIA</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>{{$gm->unidad->nombre}}</td>
                            <td>{{$gm->periodoacademico->etiqueta."-".$gm->periodoacademico->anio}}</td>
                            <td>{{$gm->jornada->descripcion." - ".$gm->jornada->jornadasnies}}</td>
                            <td>{{$gm->grado->etiqueta}}</td>
                            <td>{{$gm->materia->codigomateria."-".$gm->materia->nombre}}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-12">
                <form class="form" role='form' method="POST" action="{{route('logro.store')}}">
                    @csrf
                    <input type="hidden" name="unidad_id" value="{{$gm->unidad_id}}">
                    <input type="hidden" name="jornada_id" value="{{$gm->jornada_id}}">
                    <input type="hidden" name="grado_id" value="{{$gm->grado_id}}">
                    <input type="hidden" name="materia_id" value="{{$gm->materia_id}}">
                    <input type="hidden" name="gmd" value="{{$gmd}}">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Descripción</label>
                            <textarea class="form-control " name="descripcion" rows="5"></textarea>
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
                            <a class="btn btn-danger icon-btn pull-left" href="{{route('logro.index')}}"><i
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
                    <p>Esta funcionalidad permite gestionar los logros de una materia. Agragar nuevo logro.</p>
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

        });
    </script>
@endsection
