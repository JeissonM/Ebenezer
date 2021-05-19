@extends('layouts.admin')
@section('breadcrumb')
<h1>
    Bienvenido
    <small>Sr(a). {{Auth::user()->nombres}}</small>
</h1>
<ol class="breadcrumb">
    <li><a href="{{route('home')}}"><i class="fa fa-home"></i> Inicio</a></li>
    <li><a href="{{route('menu.admisiones')}}"><i class="fa fa-users"></i> Admisiones</a></li>
    <li><a href="{{route('menu.admisiones')}}"><i class="fa fa-list-ul"></i> Calendario, Procesos y Convocatorias</a></li>
    <li><a href="{{route('periodounidad.index')}}"><i class="fa fa-map-pin"></i> Programar Período Académico</a></li>
    <li class="active"><a>Gestionar Fechas de Procesos</a></li>
</ol>
@endsection
@section('content')
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">GESTIONAR FECHAS DE PROCESOS</h3>
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
                <table class="table table-hover table-responsive table-condensed" width="100%" cellspacing="0">
                    <thead>
                        <tr class="info">
                            <th>Unidad</th>
                            <th>Jornada</th>
                            <th>Ciudad</th>
                            <th>Año</th>
                            <th>Período</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>@if($perund->unidad_id !==null){{$perund->unidad->nombre}}@endif</td>
                            <td>@if($perund->jornada_id !==null){{$perund->jornada->descripcion." - ".$perund->jornada->jornadasnies}}@endif</td>
                            <td>@if($perund->unidad->ciudad!==null){{$perund->unidad->ciudad->nombre}}@endif</td>
                            <td>@if($perund->periodoacademico!==null){{$perund->periodoacademico->anio}}@endif</td>
                            <td>@if($perund->periodoacademico!==null){{$perund->periodoacademico->etiqueta}}@endif</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <div class="col-md-12">
                    <label>Proceso Académico en la Unidad y Período Indicado</label>
                    <select class="form-control" style="width: 100%;" name="procesosacademico_id2" id="procesosacademico_id2" required="required" onchange="getData()">
                        <option value="0">-- Seleccione una opción --</option>
                        @foreach($procesos as $key=>$value)
                        <option value="{{$key}}">{{$value}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="col-md-6" style="margin-top: 25px;">
                <div class="responsive-table">
                    <table class="table table-hover table-responsive table-bordered table-condensed" width="100%" cellspacing="0">
                        <thead>
                            <tr class="info">
                                <th>Fecha Inicial</th>
                                <th>Fecha Final</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tbrta">
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-6">
                <div id="form1">
                    <div class="col-md-12">
                        <div class="callout callout-success" style="background-color: #3c8dbc !important; text-align: center;">
                            <h4>NUEVAS FECHAS</h4>
                        </div>
                    </div>
                    <form class="form-horizontal form-label-left" role='form' method="POST" action="{{route('fechaprocesos.store')}}">
                        @csrf
                        <input type="hidden" value="" name="procesosacademico_id" id="procesosacademico_id" required="required" />
                        <input type="hidden" name="periodounidad" id="periodounidad" value="{{$perund->id}}" />
                        <input type="hidden" name="periodoacademico_id" id="periodoacademico_id" value="{{$perund->periodoacademico_id}}" />
                        <input type="hidden" name="unidad_id" id="unidad_id" value="{{$perund->unidad_id}}" />
                        <input type="hidden" name="jornada_id" id="jornada_id" value="{{$perund->jornada_id}}" />
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Fecha y Hora Inicial</label>
                                <input class="form-control" type="datetime-local" name="fecha_inicio" required="required" />
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Fecha y Hora Final</label>
                                <input class="form-control" type="datetime-local" name="fecha_fin" required="required" />
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <button class="btn icon-btn pull-left" style="color: #3c8dbc;" type="submit"><i class="fa fa-fw fa-lg fa-save"></i>Registrar</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div id="form2">
                    <div class="col-md-12">
                        <div class="callout callout-success" style="background-color: #3c8dbc !important; text-align: center;">
                            <h4>EDICIÓN DE FECHAS</h4>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <form class="form-horizontal" role='form' method="POST" action="{{route('fechaprocesos.set')}}">
                            @csrf
                            <input type="hidden" value="" name="procesosacademico_id3" id="procesosacademico_id3" required="required" />
                            <input type="hidden" name="periodounidad3" id="periodounidad3" value="{{$perund->id}}" />
                            <input type="hidden" name="periodoacademico_id3" id="periodoacademico_id3" value="" />
                            <input type="hidden" name="unidad_id3" id="unidad_id3" value="" />
                            <input type="hidden" name="jornada_id3" id="jornada_id3" value="" />
                            <input type="hidden" value="" name="iddd" id="iddd" />
                            <div class="col-md-12">
                                <p style="color:red;">NOTA: Si no desea actualizar el valor de las fechas, no seleccione ningun valor en los controles de fecha</p>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Fecha y Hora Inicial -- ACTUAL: <i id="f1"></i></label>
                                    <input class="form-control" type="datetime-local" name="fecha_inicioo" id="fecha_inicioo" />
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Fecha y Hora Final -- ACTUAL: <i id="f2"></i></label>
                                    <input class="form-control" type="datetime-local" name="fecha_finn" id="fecha_finn" />
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="col-md-6" style="margin-top: 30px;">
                                        <button class="btn icon-btn pull-left" style="color: #3c8dbc;" type="submit"><i class="fa fa-fw fa-lg fa-save"></i>Modificar</button>
                                    </div>
                                    <div class="col-md-6" style="margin-top: 30px;">
                                        <p class='btn btn-3d btn-danger btn-block' onclick='volver()'>Cancelar</p>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
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
                <p>Defina las fechas de los procesos académicos para un programa, un período y una unidad específica.</p>
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
        $('.select2').select2();
        $('#tabla').DataTable();
        $("#form2").hide();
    });

    function change() {
        $("#form1").fadeOut();
        $("#form2").fadeIn();
    }

    function volver() {
        $("#form2").fadeOut();
        $("#form1").fadeIn();
    }

    function getData() {
        $("#tbrta").html("");
        var idp = $("#procesosacademico_id2").val();
        var ppu = $("#periodoacademico_id").val();
        var jor = $("#jornada_id").val();
        var unid = $("#unidad_id").val();
        $("#procesosacademico_id").val(idp);
        $.ajax({
            type: 'GET',
            url: url + "admisiones/fechaprocesos/" + ppu + "/" + idp + "/" + jor + "/" + unid + "/fechas",
            data: {},
        }).done(function(msg) {
            var m = JSON.parse(msg);
            if (m.error === 'NO') {
                var html = "";
                $.each(m.data, function(index, item) {
                    html = html + "<tr><td>" + item.fecha_inicio + "</td><td>" + item.fecha_fin + "</td>";
                    var botones = "<td><a onclick='editar(" + item.id + ")'  style='margin-left: 10px; cursor:pointer;' data-toggle='tooltip' data-placement='top' title='Editar Datos'><i class='fa fa-edit'></i></a> ";
                    botones = botones + "<a onclick='eliminar(" + item.id + ")' style='color: red; margin-left: 10px; cursor:pointer;' data-toggle='tooltip' data-placement='top' title='Eliminar Datos'><i class='fa fa-remove'></i></a></td>";
                    html = html + botones + "</tr>";
                });
                $("#tbrta").html(html);
            } else {
                notify('Alerta', 'No se han definido fechas para el proceso y programa seleccionado.', 'error');
            }
        });
    }

    function editar(id) {
        change();
        $.ajax({
            type: 'GET',
            url: url + "admisiones/fechaprocesos/" + id + "/edit",
            data: {},
        }).done(function(msg) {
            if (msg !== 'ERROR') {
                var m = JSON.parse(msg);
                $("#f1").html(m.data.fecha_inicio);
                $("#f2").html(m.data.fecha_fin);
                $("#iddd").val(m.data.id);
                $("#procesosacademico_id3").val(m.data.procesosacademico_id);
                $("#periodoacademico_id3").val(m.data.periodoacademico_id);
                $("#unidad_id3").val(m.data.unidad_id);
                $("#jornada_id3").val(m.data.jornada_id);
            } else {
                notify('Alerta', 'No se pudo encontrar el elemento para modificar', 'error');
            }
        });
    }

    function eliminar(id) {
        $.ajax({
            type: 'GET',
            url: url + "admisiones/fechaprocesos/" + id + "/delete",
            data: {},
        }).done(function(msg) {
            if (msg === 'true') {
                notify('Alerta', 'Fecha eliminada con exito!', 'success');
                getData();
            } else {
                notify('Alerta', 'No se pudo eliminar la fecha.', 'error');
            }
        });
    }
</script>
@endsection