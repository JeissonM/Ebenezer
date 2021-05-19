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
        <li><a href="{{route('responsablefestudiante.inicio',$a->id)}}"><i class="fa fa-users"></i> Responsable
                Financiero</a></li>
        <li class="active"><a>Crear</a></li>
    </ol>
@endsection
@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">INGRESAR LOS DATOS DEL RESPONSABLE FINANCIERO</h3>
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

            <div class="col-md-12">
                <h3>Listado de Personas naturales</h3>
                <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-striped table-hover">
                        <thead>
                        <tr class="danger">
                            <th>DOCUMENTO</th>
                            <th>NOMBRE</th>
                            <th>ACCIONES</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($personas as $p)
                            <tr>
                                <td>{{$p->persona->numero_documento}}</td>
                                <td>{{$p->primer_nombre." ".$p->segundo_nombre." ".$p->primer_apellido." ".$p->segundo_apellido}}</td>

                                <td>
                                    <a style="color:green;" data-toggle="tooltip" id="{{$p->id}}"
                                       onclick="mostrar(this.id)" title="Continuar"><i class="fa fa-check"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-12" id="formulario" style="display: none">
                <form class="form" role='form' method="POST" action="{{route('responsablefestudiante.store')}}">
                    @csrf
                    <input type="hidden" value="{{$a->id}}" name="estudiante_id"/>
                    <input type="hidden" name="personanatural_id" id="personanatural_id">
                    <h5 class="text-danger">Los campos con asterísco(*) son obligatorios</h5>
                    <div class="col-md-12">
                        <h3>Información Financiera</h3>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Dirección Laboral*</label>
                                <input type="text" class="form-control" name="direccion_trabajo" required/>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Teléfono Laboral*</label>
                                <input type="text" class="form-control" name="telefono_trabajo" required/>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Puesto de Trabajo</label>
                                <input type="text" class="form-control" name="puesto_trabajo"/>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Empresa Donde Labora</label>
                                <input type="text" class="form-control" name="empresa_labora"/>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Jefe Inmediato</label>
                                <input type="text" class="form-control" name="jefe_inmediato"/>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Teléfono del Jefe Inmediato</label>
                                <input type="text" class="form-control" name="telefono_jefe"/>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Si es Independiente, Describa Qué Hace</label>
                                <textarea class="form-control" rows="1" name="descripcion_trabajador_independiente"></textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Profesión</label>
                                <select class="form-control select2" name="ocupacion_id">
                                    @foreach($profesions as $key=>$value)
                                        <option value="{{$key}}">{{$value}}</option>
                                    @endforeach
                                </select>
                            </div>
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
                               href="{{route('responsablefestudiante.inicio',$a->id)}}"><i
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
                    <p>Esta funcionalidad permitirá al usuario gestionar la información del responsable financiero deL
                        estudiante seleccionado.</p>
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
            $('#example1').DataTable();
            $('.select2').select2();
        });

        function mostrar(pn) {
            $("#limpiar").click();
            $("#formulario").removeAttr('style');
            $("#personanatural_id").attr('value', pn);
        }

        function getEstados(pais, dpto, ciudad) {
            var id = $("#" + pais).val();
            $.ajax({
                type: 'GET',
                url: url + "admisiones/pais/" + id + "/estados",
                data: {},
            }).done(function (msg) {
                $('#' + dpto + ' option').each(function () {
                    $(this).remove();
                });
                $('#' + ciudad + ' option').each(function () {
                    $(this).remove();
                });
                if (msg !== "null") {
                    var m = JSON.parse(msg);
                    $.each(m, function (index, item) {
                        $("#" + dpto).append("<option value='" + item.id + "'>" + item.value + "</option>");
                    });
                } else {
                    notify('Atención', 'El País seleccionado no posee información de estados.', 'error');
                }
            });
        }

        function getCiudades(name, ciudad) {
            var id = $("#" + name).val();
            $.ajax({
                type: 'GET',
                url: url + "admisiones/estado/" + id + "/ciudades",
                data: {},
            }).done(function (msg) {
                $('#' + ciudad + ' option').each(function () {
                    $(this).remove();
                });
                if (msg !== "null") {
                    var m = JSON.parse(msg);
                    $.each(m, function (index, item) {
                        $("#" + ciudad).append("<option value='" + item.id + "'>" + item.value + "</option>");
                    });
                } else {
                    notify('Atención', 'El Estado seleccionado no posee información de ciudades.', 'error');
                }
            });
        }
    </script>
@endsection
