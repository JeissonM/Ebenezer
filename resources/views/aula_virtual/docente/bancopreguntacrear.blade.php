@extends('layouts.admin')
@section('breadcrumb')
    <h1>
        Bienvenido
        <small>Sr(a). {{Auth::user()->nombres}}</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{route('home')}}"><i class="fa fa-home"></i> Inicio</a></li>
        <li><a href="{{route('menu.aulavirtual')}}"><i class="fa fa-vimeo"></i> Aula Virtual</a></li>
        <li><a href="{{route('aulavirtual.docenteinicio')}}"><i class="fa fa-home"></i> Inicio Docente</a></li>
        <li><a href="{{route('aulavirtual.menuauladocente',$gmd->id)}}"><i class="fa fa-list"></i> Panel Aula
                Virtual</a></li>
        <li><a href="{{route('preguntas.index',$gmd->id)}}"><i class="fa fa-question"></i> Banco de Preguntas</a></li>
        <li class="active"><a> Crear</a></li>
    </ol>
@endsection
@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">BANCO DE PREGUNTAS</h3>
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
                            <th>JORNADA</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>{{$gmd->gradomateria->unidad->nombre." - ".$gmd->gradomateria->unidad->ciudad->nombre}}</td>
                            <td>{{$gmd->gradomateria->periodoacademico->etiqueta." - ".$gmd->gradomateria->periodoacademico->anio}}</td>
                            <td>{{$gmd->gradomateria->jornada->descripcion." - ".$gmd->gradomateria->jornada->jornadasnies}}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                        <tr class="danger">
                            <th>GRADO</th>
                            <th>GRUPO</th>
                            <th>MATERIA</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>{{$gmd->gradomateria->grado->etiqueta}}</td>
                            <td>{{$gmd->grupo->nombre}}</td>
                            <td>{{$gmd->gradomateria->materia->codigomateria." - ".$gmd->gradomateria->materia->nombre}}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-12">
                <div class="col-md-12">
                    @component('layouts.errors')
                    @endcomponent
                </div>
                <h4>Datos de la Pregunta</h4>
                <form class="form" role='form' enctype="multipart/form-data" method="POST"
                      action="{{route('preguntas.store')}}">
                    @csrf
                    <input type="hidden" name="gmd_id" value="{{$gmd->id}}"/>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Puntos de la Preguntas</label>
                            <input class="form-control" type="number" required="required" name="puntos">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Tipo de Pregunta</label>
                            <select class="form-control" required="required" name="tipo">
                                <option value="RESPONDA">RESPONDA</option>
                                <option value="SELECCION MULTIPLE">SELECCION MULTIPLE</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Unidad</label>
                            <select class="form-control" name="ctunidad_id" id="ctunidad_id" onchange="getTemas()"
                                    required>
                                <option value="">--Seleccione una opción--</option>
                                @foreach($unidades as $key=>$value)
                                    <option value="{{$key}}">{{$value}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Temas</label>
                            <select class="form-control" name="ctunidadtema_id" id="ctunidadtema_id"
                                    required="required">

                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class='form-group'>
                            <label>Redacte la Pregunta Aquí...</label>
                            <textarea id='pregunta' name='pregunta' rows='10' cols='80' required></textarea>
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
                            <a class="btn btn-danger icon-btn pull-left" href="{{route('preguntas.index',$gmd->id)}}"><i
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
                    <p>Esta funcionalidad permite gestionar un completo banco de preguntas para las actividades de una
                        materia y grado en particular.</p>
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
            CKEDITOR.replace('pregunta');
        });

        function getTemas() {
            $.ajax({
                type: 'GET',
                url: url + "aulavirtual/actividad/" + $("#ctunidad_id").val() + "/gettemas",
                data: {},
            }).done(function (msg) {
                $('#ctunidadtema_id option').each(function () {
                    $(this).remove();
                });
                if (msg !== "null") {
                    var m = JSON.parse(msg);
                    $.each(m, function (index, item) {
                        $("#ctunidadtema_id").append("<option value='" + index + "'>" + item + "</option>");
                    });
                } else {
                    notify('Atención', 'La unidad seleccionada no tiene temas asociados.', 'warning');
                }
            });
        }
    </script>
@endsection
