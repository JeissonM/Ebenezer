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
    <li><a href="{{route('agendacita.index')}}"><i class="fa fa-calendar-check-o"></i> Programar Agenda</a></li>
    <li><a href="{{route('agendacita.edit',$aso->id)}}"><i class="fa fa-calendar-times-o"></i> Fechas Programadas</a></li>
    <li class="active"><a>Agregar Fecha</a></li>
</ol>
@endsection
@section('content')
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">AGREGAR NUEVA FECHA</h3>
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
                            <th>PERÍODO ACADÉMICO</th>
                            <th>UNIDAD</th>
                            <th>JORNADA</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{$aso->periodoacademico->etiqueta." - ".$aso->periodoacademico->anio}}</td>
                            <td>{{$aso->unidad->nombre." - ".$aso->unidad->ciudad->nombre}}</td>
                            <td>{{$aso->jornada->descripcion}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-md-12">
            <form class="form" role='form' method="POST" action="{{route('agendacita.store')}}">
                <input type="hidden" value="{{$aso->id}}" name="periodounidad_id" />
                @csrf
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Fecha a Programar</label>
                        <input class="form-control" type="date" required="required" name="fecha">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Hora Inicio (Formato 24 Horas, sin los 2 puntos ":", ejemplo: 0800)</label>
                        <input class="form-control" type="text" placeholder="Hora en que da inicio la entrevista" maxlength="4" name="horainicio" id="horainicio">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Hora Fin (Formato 24 Horas, sin los 2 puntos ":", ejemplo 1400)</label>
                        <input class="form-control" type="text" placeholder="Hora en que da fin la entrevista" maxlength="4" name="horafin" id="horafin">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label></label>
                        <button class="btn btn-success icon-btn pull-left" type="button" onclick="add()"><i class="fa fa-fw fa-lg fa-plus-square-o"></i>Agregar Horario</button>
                    </div>
                </div>
                <div class="col-md-12">
                    <h4>Lista de horarios para la fecha seleccionada</h4>
                    <div class="table-responsive">
                        <table id="fechasf" class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr class="info">
                                    <th>HORA INICIO</th>
                                    <th>HORA FIN</th>
                                    <th>RETIRAR</th>
                                </tr>
                            </thead>
                            <tbody id="fechas">

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-12" style="margin-top: 20px !important">
                    <div class="form-group">
                        <button class="btn btn-success icon-btn pull-left" type="submit"><i class="fa fa-fw fa-lg fa-save"></i>Guardar</button>
                        <button class="btn btn-info icon-btn pull-left" type="reset"><i class="fa fa-fw fa-lg fa-trash-o"></i>Limpiar</button>
                        <a class="btn btn-danger icon-btn pull-left" href="{{route('agendacita.edit',$aso->id)}}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancelar</a>
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
                <p>Seleccione una fecha del calendario y configure el listado de horarios disposibles para entrevistas ese día, cada horario se compone de <b>Hora Inicio y Hora Fin</b>, la hora debe ser escrita en formato 24 horas; inicia a las 00:00 y termina en las 24:00. No debe colocar los dos puntos "<b>:</b>" en la hora, la hora debe escribirse así, por ejemplo: para escribir 8AM usted debe escribir 0800, para escribir 3PM usted debe escribir 1500, para escribir 7PM usted debe escribir 1900, etc.</p>
            </div>
            <div class="modal-footer" style="background-color: #d2d6de !important; opacity: .65;">
                <button type="button"  class="btn btn-block btn-danger btn-flat pull-right" data-dismiss="modal"> <i class="fa fa-reply"></i> Regresar</button>
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
    });
    $(document).on('click', '.borrar', function (event) {
        event.preventDefault();
        $(this).closest('tr').remove();
    });
    function add() {
        var hi = $("#horainicio").val();
        var hf = $("#horafin").val();
        if (hi.length !== 4 || hf.length !== 4) {
            notify('Error', 'Las horas deben tener 4 caracteres!', 'error');
        } else if (hi.length == 0 || hf.length == 0) {
            notify('Error', 'No debe dejar las horas vacías!', 'error');
        } else if (hi >= hf) {
            notify('Error', 'La hora final debe ser mayor a la hora inicial!', 'error');
        } else {
            var html = "<tr><td><input type='text' name='hora_inicio[]' value='" + hi + "' class='form-control' /></td><td><input type='text' name='hora_fin[]' value='" + hf + "' class='form-control' /></td><td><a style='color: red; margin-left: 10px;' data-toggle='tooltip' title='Quitar Horario' style='margin-left: 10px;' class='btn borrar'><i class='fa fa-trash-o'></i></a></td></tr>";
            $('#fechasf tbody').append(html);
        }
    }
</script>
@endsection