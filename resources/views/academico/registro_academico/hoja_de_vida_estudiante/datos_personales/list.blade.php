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
        <li class="active"><a>Datos Personales</a></li>
    </ol>
@endsection
@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">DATOS PERSONALES</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-toggle="modal" data-target="#modal" title="Ayuda">
                    <i class="fa fa-question"></i></button>
                <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Minimizar">
                    <i class="fa fa-minus"></i></button>
                <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Cerrar">
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
                <form class="form" role='form' enctype="multipart/form-data" method="POST" action="{{route('hojadevida.moddatosbasicos')}}">
                    @csrf
                    <input type="hidden" name="estudiante_id" value="{{$a->id}}" />
                    <h5 class="text-danger">Los campos con asterísco(*) son obligatorios</h5>
                    <div class="col-md-12">
                        <h3>Información Personal</h3>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Tipo Documento de Identidad</label>
                                <select class="form-control" id="tipodoc_id" name="tipodoc_id" required>
                                    @foreach($tipodoc as $key=>$value)
                                        @if($key==$pn->persona->tipodoc_id)
                                            <option selected value="{{$key}}">{{$value}}</option>
                                        @else
                                            <option value="{{$key}}">{{$value}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Número de Identidad*</label>
                                <input type="text" class="form-control" value="{{$pn->persona->numero_documento}}" name="numero_documento" required />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Lugar de Expedición</label>
                                <input class="form-control" type="text" value="{{$pn->persona->lugar_expedicion}}" name="lugar_expedicion">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Fecha de Expedición</label>
                                <input class="form-control" type="date" value="{{$pn->persona->fecha_expedicion}}" name="fecha_expedicion">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Primer Nombre*</label>
                                <input class="form-control" type="text" value="{{$pn->primer_nombre}}" required="required" name="primer_nombre">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Segundo Nombre</label>
                                <input class="form-control" type="text" value="{{$pn->segundo_nombre}}" name="segundo_nombre">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Primer Apellido*</label>
                                <input class="form-control" type="text" value="{{$pn->primer_apellido}}" required="required" name="primer_apellido">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Segundo Apellido</label>
                                <input class="form-control" type="text" value="{{$pn->segundo_apellido}}" name="segundo_apellido">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Sexo</label>
                                <select class="form-control" name="sexo_id">
                                    @foreach($sexos as $key=>$value)
                                        @if($pn->sexo_id==$key)
                                            <option selected value="{{$key}}">{{$value}}</option>
                                        @else
                                            <option value="{{$key}}">{{$value}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            @if($a->foto!='NO')(<a target="_blank" href="{{asset('images/fotos/'.$a->foto)}}"> Ver Fotografía Actual</a>)@endif
                            <div class="form-group">
                                <label>Fotografía (Formatos JPG, PNG)</label>
                                <input type="file" name="foto" accept=".pdf,.jpg,.png" class="form-control" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Fecha de Nacimiento</label>
                                <input class="form-control" type="date" value="{{$pn->fecha_nacimiento}}" name="fecha_nacimiento">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Grupo Sanguíneo/RH</label>
                                <select class="form-control" name="rh">
                                    @foreach($rh as $key=>$value)
                                        @if($pn->rh==$key)
                                            <option selected value="{{$key}}">{{$value}}</option>
                                        @else
                                            <option value="{{$key}}">{{$value}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <h3>Información de Ubicación</h3>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>País</label>
                                <select class="form-control" id="pais_id" name="pais_id" onchange="getEstados('pais_id', 'estado_id', 'ciudad_id')">
                                    @foreach($paises as $key=>$value)
                                        @if($pn->ciudad->estado->pais_id==$key)
                                            <option selected value="{{$key}}">{{$value}}</option>
                                        @else
                                            <option value="{{$key}}">{{$value}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Estado/Departamento</label>
                                <select class="form-control" id="estado_id" name="estado_id" onchange="getCiudades('estado_id', 'ciudad_id')">
                                    @foreach($estados as $key=>$value)
                                        @if($pn->ciudad->estado_id==$key)
                                            <option selected value="{{$key}}">{{$value}}</option>
                                        @else
                                            <option value="{{$key}}">{{$value}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Ciudad</label>
                                <select class="form-control" id="ciudad_id" name="ciudad_id">
                                    @foreach($ciudades as $key=>$value)
                                        @if($pn->ciudad_id==$key)
                                            <option selected value="{{$key}}">{{$value}}</option>
                                        @else
                                            <option value="{{$key}}">{{$value}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Barrio de Residencia</label>
                                <input class="form-control" type="text" value="{{$a->barrio_residencia}}" name="barrio_residencia">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Dirección de Residencia</label>
                                <input class="form-control" type="text" value="{{$pn->persona->direccion}}" name="direccion_residencia">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Correo Electrónico*</label>
                                <input class="form-control" type="email" value="{{$pn->persona->mail}}" name="mail" required="">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Teléfono</label>
                                <input class="form-control" type="tel" value="{{$pn->persona->telefono}}" name="telefono">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Celular</label>
                                <input class="form-control" type="number" value="{{$pn->persona->celular}}" name="celular">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <h3>Información Socioeconómica</h3>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Estrato*</label>
                                <select class="form-control" name="estrato_id" required>
                                    @foreach($estratos as $key=>$value)
                                        @if($a->estrato_id==$key)
                                            <option selected value="{{$key}}">{{$value}}</option>
                                        @else
                                            <option value="{{$key}}">{{$value}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12" style="margin-top: 20px !important">
                        <div class="form-group">
                            <button class="btn btn-success icon-btn pull-left" type="submit"><i class="fa fa-fw fa-lg fa-save"></i>Guardar</button>
                            <button class="btn btn-info icon-btn pull-left" type="reset"><i class="fa fa-fw fa-lg fa-trash-o"></i>Limpiar</button>
                            <a class="btn btn-danger icon-btn pull-left" href="{{route('menu.hojadevidaestudiante',$a->id)}}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancelar</a>
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
                    <p>Esta funcionalidad permitirá al usuario modificar los datos del estudiante.</p>
                </div>
                <div class="modal-footer" style="background-color: #d2d6de !important; opacity: .65;">
                    <button type="button" class="btn btn-block btn-danger btn-flat pull-right" data-dismiss="modal"> <i class="fa fa-reply"></i> Regresar</button>
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
        $(document).ready(function() {
            $('#example1').DataTable();
            $('.select2').select2();
        });

        function getEstados(pais, dpto, ciudad) {
            var id = $("#" + pais).val();
            $.ajax({
                type: 'GET',
                url: url + "admisiones/pais/" + id + "/estados",
                data: {},
            }).done(function(msg) {
                $('#' + dpto + ' option').each(function() {
                    $(this).remove();
                });
                $('#' + ciudad + ' option').each(function() {
                    $(this).remove();
                });
                if (msg !== "null") {
                    var m = JSON.parse(msg);
                    $.each(m, function(index, item) {
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
            }).done(function(msg) {
                $('#' + ciudad + ' option').each(function() {
                    $(this).remove();
                });
                if (msg !== "null") {
                    var m = JSON.parse(msg);
                    $.each(m, function(index, item) {
                        $("#" + ciudad).append("<option value='" + item.id + "'>" + item.value + "</option>");
                    });
                } else {
                    notify('Atención', 'El Estado seleccionado no posee información de ciudades.', 'error');
                }
            });
        }
    </script>
@endsection
