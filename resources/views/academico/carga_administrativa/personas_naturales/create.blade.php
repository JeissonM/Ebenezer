@extends('layouts.admin')
@section('breadcrumb')
<h1>
    Bienvenido
    <small>Sr(a). {{Auth::user()->nombres}}</small>
</h1>
<ol class="breadcrumb">
    <li><a href="{{route('home')}}"><i class="fa fa-home"></i> Inicio</a></li>
    <li><a href="{{route('menu.academico')}}"><i class="fa fa-book"></i> Académico</a></li>
    <li><a href="{{route('menu.academico')}}"><i class="fa fa-briefcase"></i> Carga Administrativa</a></li>
    <li><a href="{{route('personanatural.index')}}"><i class="fa fa-user"></i> Personas Naturales</a></li>
    <li class="active"><a> Crear Persona</a></li>
</ol>
@endsection
@section('content')
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">CREAR NUEVA PERSONA</h3>
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
            <form class="form" role='form' method="POST" action="{{route('personanatural.store')}}">
                @csrf
                <h5 class="text-danger">Los campos con asterísco(*) son obligatorios</h5>
                <div class="col-md-12">
                    <h3>Información Personal</h3>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Tipo Documento*</label>
                            <select class="form-control" name="tipodoc_id" required="">
                                @foreach($tipodoc as $key=>$value)
                                <option value="{{$key}}">{{$value}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Número de Identidad*</label>
                            <input class="form-control" type="text" required="" name="numero_documento">
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
                            <label>Dirección de Residencia</label>
                            <input class="form-control" type="text" name="direccion">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Correo Electrónico*</label>
                            <input class="form-control" type="email" name="mail" required="">
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
                    <h3>Información de Procedencia</h3>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Fecha de Nacimiento</label>
                            <input class="form-control" type="date" name="fecha_nacimiento">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>País de Nacimiento</label>
                            <select class="form-control" id="paispn_id" name="paispn_id" onchange="getEstados('paispn_id', 'estadopn_id', 'ciudadpn_id')">
                                @foreach($paises as $key=>$value)
                                <option value="{{$key}}">{{$value}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Estado/Departamento de Nacimiento</label>
                            <select class="form-control" id="estadopn_id" name="estadopn_id" onchange="getCiudades('estadopn_id', 'ciudadpn_id')">
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Ciudad de Nacimiento</label>
                            <select class="form-control" id="ciudadpn_id" name="ciudadpn_id">
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <h3>Información Complementaria</h3>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Libreta Militar</label>
                            <input type="text" class="form-control" name="libreta_militar" />
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Distrito Militar</label>
                            <input type="text" class="form-control" name="distrito_militar" />
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Clase Libreta Militar</label>
                            <input type="text" class="form-control" name="clase_libreta" placeholder="1 CLASE, RESERVISTA, ETC" />
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Edad</label>
                            <input type="number" class="form-control" name="edad" />
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
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Otra Nacionalidad</label>
                            <input type="text" class="form-control" name="otra_nacionalidad" />
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Número de Pasaporte</label>
                            <input type="text" class="form-control" name="numero_pasaporte" />
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Nivel de Estudio(Primaria, Secundaria, Universitario, Etc)</label>
                            <input type="text" class="form-control" name="nivel_estudio" />
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Profesión</label>
                            <select class="form-control select2" name="profesion">
                                @foreach($profesions as $key=>$value)
                                <option value="{{$value}}">{{$value}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-12" style="margin-top: 20px !important">
                    <div class="form-group">
                        <button class="btn btn-success icon-btn pull-left" type="submit"><i class="fa fa-fw fa-lg fa-save"></i>Guardar</button>
                        <button class="btn btn-info icon-btn pull-left" type="reset"><i class="fa fa-fw fa-lg fa-trash-o"></i>Limpiar</button>
                        <a class="btn btn-danger icon-btn pull-left" href="{{route('personanatural.index')}}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancelar</a>
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
                <p>Esta funcionalidad permite al usuario administrar las personas naturales de la institución.</p>
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