@extends('layouts.admin')
@section('breadcrumb')
<h1>
    Bienvenido
    <small>Sr(a). {{Auth::user()->nombres}}</small>
</h1>
<ol class="breadcrumb">
    <li><a href="{{route('home')}}"><i class="fa fa-home"></i> Inicio</a></li>
    <li><a href="{{route('menu.inscripcion')}}"><i class="fa fa-edit"></i> Inscripción</a></li>
    <li><a href="{{route('inscripcion.aspirante')}}"><i class="fa fa-edit"></i> Inscribir Aspirante</a></li>
    <li class="active"><a>Inscribir</a></li>
</ol>
@endsection
@section('content')
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">INSCRIBIR ASPIRANTE</h3>
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
            <div class="responsive-table">
                <table class="table table-hover table-responsive table-bordered table-condensed" width="100%" cellspacing="0">
                    <thead>
                        <tr class="info">
                            <th>Unidad</th>
                            <th>Jornada</th>
                            <th>Período</th>
                            <th>Grado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{$unidad->nombre}}</td>
                            <td>{{$jornada->descripcion." - ".$jornada->jornadasnies}}</td>
                            <td>{{$periodo->etiqueta." - ".$periodo->anio}}</td>
                            <td>{{$grado->etiqueta}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <form class="form" enctype="multipart/form-data" role='form' method="POST" action="{{route('inscripcion.aspirantestore')}}">
                @csrf
                <input type="hidden" name="tipodoc_id" value="{{$tipodoc->id}}" />
                <input type="hidden" name="numero_documento" value="{{$num}}" />
                <input type="hidden" name="periodoacademico_id" value="{{$periodo->id}}" />
                <input type="hidden" name="grado_id" value="{{$grado->id}}" />
                <input type="hidden" name="unidad_id" value="{{$unidad->id}}" />
                <input type="hidden" name="jornada_id" value="{{$jornada->id}}" />
                <input type="hidden" name="convocatoria_id" value="{{$conv->id}}" />
                <h5 class="text-danger">Los campos con asterísco(*) son obligatorios</h5>
                <div class="col-md-12">
                    <h3>Información Personal</h3>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Tipo Documento*</label>
                            <input type="text" class="form-control" value="{{$tipodoc->descripcion}}" readonly />
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Número de Identidad*</label>
                            <input type="text" class="form-control" value="{{$num}}" readonly />
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Lugar de Expedición</label>
                            <input class="form-control" type="text" name="lugar_expedicion">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Fecha de Expedición</label>
                            <input class="form-control" type="date" name="fecha_expedicion">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Primer Nombre*</label>
                            <input class="form-control" type="text" required="required" name="primer_nombre">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Segundo Nombre</label>
                            <input class="form-control" type="text" name="segundo_nombre">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Primer Apellido*</label>
                            <input class="form-control" type="text" required="required" name="primer_apellido">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Segundo Apellido</label>
                            <input class="form-control" type="text" name="segundo_apellido">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Sexo</label>
                            <select class="form-control" name="sexo_id">
                                @foreach($sexos as $key=>$value)
                                <option value="{{$key}}">{{$value}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Fotografía (Formatos JPG, PNG)</label>
                            <input type="file" name="foto" accept=".pdf,.jpg,.png" class="form-control" />
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Fecha de Nacimiento</label>
                            <input class="form-control" type="date" name="fecha_nacimiento">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Grupo Sanguíneo/RH</label>
                            <select class="form-control" name="rh">
                                <option value="A+">A+</option>
                                <option value="A-">A-</option>
                                <option value="B+">B+</option>
                                <option value="B-">B-</option>
                                <option value="AB+">AB+</option>
                                <option value="AB-">AB-</option>
                                <option value="O+">O+</option>
                                <option value="O-">O-</option>
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
                                <option value="{{$key}}">{{$value}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Estado/Departamento</label>
                            <select class="form-control" id="estado_id" name="estado_id" onchange="getCiudades('estado_id', 'ciudad_id')">
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Ciudad</label>
                            <select class="form-control" id="ciudad_id" name="ciudad_id">
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Barrio de Residencia</label>
                            <input class="form-control" type="text" name="barrio_residencia">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Dirección de Residencia</label>
                            <input class="form-control" type="text" name="direccion_residencia">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Correo Electrónico*</label>
                            <input class="form-control" type="email" name="correo" required="">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Teléfono</label>
                            <input class="form-control" type="tel" name="telefono">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Celular</label>
                            <input class="form-control" type="number" name="celular">
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <h3>Información Complementaria</h3>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Estrato*</label>
                            <select class="form-control" name="estrato_id" required>
                                @foreach($estratos as $key=>$value)
                                <option value="{{$key}}">{{$value}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Circunscripción*</label>
                            <select class="form-control select2" name="circunscripcion_id" required>
                                @foreach($circunscripciones as $key=>$value)
                                <option value="{{$key}}">{{$value}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>¿Padres Separados?</label>
                            <select class="form-control" name="padres_separados">
                                <option value="SI">SI</option>
                                <option value="NO">NO</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Iglesia a la que Asistes</label>
                            <input type="text" class="form-control" name="iglesia_asiste" />
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Pastor</label>
                            <input type="text" class="form-control" name="pastor" />
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>¿Tiene Alguna Discapacidad?</label>
                            <select class="form-control" name="discapacidad">
                                <option value="SI">SI</option>
                                <option value="NO">NO</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>¿Familias en Acción?</label>
                            <select class="form-control" name="familias_en_accion">
                                <option value="SI">SI</option>
                                <option value="NO">NO</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>¿Población Víctima del Conflicto?</label>
                            <select class="form-control" name="poblacion_victima_conflicto">
                                <option value="SI">SI</option>
                                <option value="NO">NO</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>¿Eres Desplazado?</label>
                            <select class="form-control" name="desplazado">
                                <option value="SI">SI</option>
                                <option value="NO">NO</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Colegio de Procedencia</label>
                            <input type="text" class="form-control" name="colegio_procedencia" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>¿Compromiso Adquirido?</label>
                            <select class="form-control" name="compromiso_adquirido">
                                <option value="SI">SI</option>
                                <option value="NO">NO</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Étnia</label>
                            <select class="form-control" name="etnia_id">
                                @foreach($etnias as $key=>$value)
                                <option value="{{$key}}">{{$value}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>¿Con Quién Vives?</label>
                            <select class="form-control" name="conquienvive_id">
                                @foreach($conquienvives as $key=>$value)
                                <option value="{{$key}}">{{$value}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Rango SISBEN</label>
                            <select class="form-control select2" name="rangosisben_id">
                                @foreach($sisben as $key=>$value)
                                <option value="{{$key}}">{{$value}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Entidad Salud</label>
                            <select class="form-control select2" name="entidadsalud_id">
                                @foreach($entidades as $key=>$value)
                                <option value="{{$key}}">{{$value}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Situación Año Anterior</label>
                            <select class="form-control select2" name="situacionanioanterior_id">
                                @foreach($situaciones as $key=>$value)
                                <option value="{{$key}}">{{$value}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-12" style="margin-top: 20px !important">
                    <div class="form-group">
                        <button class="btn btn-success icon-btn pull-left" type="submit"><i class="fa fa-fw fa-lg fa-save"></i>Guardar</button>
                        <button class="btn btn-info icon-btn pull-left" type="reset"><i class="fa fa-fw fa-lg fa-trash-o"></i>Limpiar</button>
                        <a class="btn btn-danger icon-btn pull-left" href="{{route('inscripcion.aspirante')}}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancelar</a>
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
                <p>Esta funcionalidad permitirá al usuario inscribir un aspirante en el sistema.</p>
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