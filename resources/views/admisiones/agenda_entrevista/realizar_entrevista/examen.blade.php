@extends('layouts.admin')
@section('breadcrumb')
<h1>
    Bienvenido
    <small>Sr(a). {{Auth::user()->nombres}}</small>
</h1>
<ol class="breadcrumb">
    <li><a href="{{route('home')}}"><i class="fa fa-home"></i> Inicio</a></li>
    <li><a href="{{route('menu.admisiones')}}"><i class="fa fa-users"></i> Admisiones</a></li>
    <li><a href="{{route('menu.admisiones')}}"><i class="fa fa-calendar-plus-o"></i> Agenda & Entrevista</a></li>
    <li><a href="{{route('realizarentrevista.index')}}"><i class="fa fa-check"></i> Realizar Entrevista de Admisión</a></li>
    <li><a href="{{route('realizarentrevista.listaraspirantes',[$a->unidad_id,$a->periodoacademico_id,$a->jornada_id,$a->grado_id])}}"><i class="fa fa-user"></i> Aspirantes</a></li>
    <li class="active"><a> Entrevista</a></li>
</ol>
@endsection
@section('content')
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">ENTREVISTA DE ADMISIÓN</h3>
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
            <h3>Datos Aspirante</h3>
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr class="info">
                            <th>IDENTIFICACIÓN</th>
                            <th>ASPIRANTE</th>
                            <th>PERÍODO</th>
                            <th>JORNADA</th>
                            <th>UNIDAD</th>
                            <th>GRADO</th>
                            <th>ESTADO</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{$a->tipodoc->abreviatura." - ".$a->numero_documento}}</td>
                            <td>{{$a->primer_nombre." ".$a->segundo_nombre." ".$a->primer_apellido." ".$a->segundo_apellido}}</td>
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
        <form class="form" role='form' method="POST" action="{{route('realizarentrevista.store')}}">
            @csrf
            <input type="hidden" value="{{$a->id}}" name="aspirante_id" />
            <input type="hidden" value="{{$e->id}}" name="entrevista_id" />
            <div class="col-md-12">
                <h3>Datos Entrevista</h3>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr class="info">
                                <th>ENTREVISTA</th>
                                <th>ANOTACIONES ENTREVISTA</th>
                                <th>ESTADO</th>
                                <th>CITA</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{$e->nombre." - ".$e->descripcion}}</td>
                                <td><input class="form-control" placeholder="Anotaciones aquí..." value="{{$e->anotaciones}}" name="anotaciones" /></td>
                                <td>
                                    <select name="estado" class="form-control" required>
                                        @foreach($estados as $key=>$value)
                                        @if($e->estado==$key)
                                        <option value="{{$key}}" selected>{{$value}}</option>
                                        @else
                                        <option value="{{$key}}">{{$value}}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                </td>
                                <td>{{$e->agendacita->fecha." - DE ".$horai." A ".$horaf}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            @if($c!=null)
            <input type="hidden" name="cuestionarioentrevista_id" value="{{$c->id}}" />
            <div class="col-md-12">
                <h3>Datos del Cuestionario</h3>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr class="info">
                                <th>CUESTIONARIO</th>
                                <th>ESTADO</th>
                                <th>CIRCUNSCRIPCIÓN</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{$c->nombre." - ".$c->descripcion}}</td>
                                <td>{{$c->estado}}</td>
                                <td>{{$c->circunscripcion->nombre." - ".$c->circunscripcion->descripcion}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            @if($e->estado=='PENDIENTE' || $e->estado=='APLAZADA')
            <div class="col-md-12">
                <h3>Responda las Siguientes Preguntas</h3>
                <div class="col-md-12">
                    @if(count($preguntas)>0)
                    <ol>
                        @foreach($preguntas as $p)
                        @if($p['pregunta']->estado=='ACTIVA')
                        <li>{{$p['pregunta']->pregunta}}</li>
                        <input type="hidden" name="preguntas[]" value="{{$p['pregunta']->id}}" />
                        <input type="hidden" name="tipos[]" value="{{$p['pregunta']->tipo}}" />
                        @if($p['pregunta']->tipo=='NORMAL')
                        <select class="form-control" name="respuestas[]">
                            @foreach($p['respuestas'] as $r)
                            <option value="{{$r->id}}">{{$r->respuesta}}</option>
                            @endforeach
                        </select>
                        @endif
                        @if($p['pregunta']->tipo=='OTRA-PREGUNTA')
                        <select class="form-control" name="respuestas[]">
                            @foreach($p['respuestas'] as $r)
                            <option value="{{$r->id}}">{{$r->respuesta}}</option>
                            @endforeach
                        </select>
                        <h4>{{$p['pregunta']->segunda_pregunta}}</h4>
                        <input type="text" name="segunda_{{$p['pregunta']->id}}" class="form-control" />
                        @endif
                        @if($p['pregunta']->tipo=='RESPONDA')
                        <input type="text" name="respuestas[]" class="form-control" />
                        @endif
                        @endif
                        @endforeach
                    </ol>
                    @else
                    <h3 class="text text-danger text-center">No hay preguntas en el cuestionario</h3>
                    @endif
                </div>
            </div>
            <div class="col-md-12" style="margin-top: 20px !important">
                <div class="form-group">
                    <button class="btn btn-success icon-btn pull-left" type="submit"><i class="fa fa-fw fa-lg fa-save"></i>Guardar</button>
                    <button class="btn btn-info icon-btn pull-left" type="reset"><i class="fa fa-fw fa-lg fa-trash-o"></i>Limpiar</button>
                    <a class="btn btn-danger icon-btn pull-left" href="{{route('realizarentrevista.listaraspirantes',[$a->unidad_id,$a->periodoacademico_id,$a->jornada_id,$a->grado_id])}}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancelar</a>
                </div>
            </div>
            @else
            <h3 class="text text-danger text-center">La entrevista ya fue realizada y su estado es {{$e->estado}} con las siguientes anotaciones: {{$e->anotaciones}}</h3>
            @endif
            @else
            <!-- No hay cuestionario -->
            <h3 class="text text-danger text-center">No hay cuestionario asociado a la entrevista, debe indicar el cuestionario a realizar.</h3>
            <h4 class="text text-danger text-center">Usted puede asignar el cuestionario asociado a la circunscripción del aspirante o puede seleccionar otro formulario si lo desea.</h4>
            <div class="col-md-6">
                <div class="form-group">
                    <button class="btn btn-primary btn-block" type="button" onclick="cargar(1)"> Cargar de la Circunscripción</button>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <button class="btn btn-primary btn-block" type="button" onclick="cargar(2)"> Cargar Todos Los Cuestionarios</button>
                </div>
            </div>
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr class="info">
                                <th>CUESTIONARIO</th>
                                <th>ESTADO</th>
                                <th>CIRCUNSCRIPCIÓN</th>
                                <th>ASIGNAR</th>
                            </tr>
                        </thead>
                        <tbody id="rta">

                        </tbody>
                    </table>
                </div>
            </div>
            @endif
        </form>
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
                <p>Esta funcionalidad permite al usuario realizar las entrevistas para la admisión de los aspirantes y documentar el proceso.</p>
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
    });


    function cargar(source) {
        switch (source) {
            case 1:
                circunscripcion();
                break;
            case 2:
                todos();
                break;
        }
    }

    function circunscripcion() {
        $("#rta").html("");
        $.ajax({
            type: 'GET',
            url: url + "admisiones/realizarentrevista/inicio/aspirantes/{{$a->circunscripcion_id}}/CIRCUNSCRIPCION/cargarcuestionario",
            data: {},
        }).done(function(msg) {
            var m = JSON.parse(msg);
            if (m.error == "NO") {
                var html = "";
                $.each(m.data, function(index, item) {
                    html = html + "<tr><td>" + item.nombre + " - " + item.descripcion + "</td><td>" + item.estado + "</td><td>" + item.circunscripcion.nombre + " - " + item.circunscripcion.descripcion + "</td><td>" +
                        "<a href='" + url + "admisiones/realizarentrevista/inicio/aspirantes/{{$a->id}}/{{$e->id}}/" + item.id + "/cargarcuestionario/asignarcuestionario'>ASIGNAR</a></td></tr>";
                });
                $("#rta").html(html);
            } else {
                notify('Atención', m.mensaje, 'error');
            }
        });
    }

    function todos() {
        $("#rta").html("");
        $.ajax({
            type: 'GET',
            url: url + "admisiones/realizarentrevista/inicio/aspirantes/0/TODOS/cargarcuestionario",
            data: {},
        }).done(function(msg) {
            var m = JSON.parse(msg);
            if (m.error == "NO") {
                var html = "";
                $.each(m.data, function(index, item) {
                    html = html + "<tr><td>" + item.nombre + " - " + item.descripcion + "</td><td>" + item.estado + "</td><td>" + item.circunscripcion.nombre + " - " + item.circunscripcion.descripcion + "</td><td>" +
                        "<a href='" + url + "admisiones/realizarentrevista/inicio/aspirantes/{{$a->id}}/{{$e->id}}/" + item.id + "/cargarcuestionario/asignarcuestionario'>ASIGNAR</a></td></tr>";
                });
                $("#rta").html(html);
            } else {
                notify('Atención', m.mensaje, 'error');
            }
        });
    }
</script>
@endsection