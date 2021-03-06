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
    <li><a href="{{route('jornada.index')}}"><i class="fa fa-calendar-plus-o"></i> Jornada</a></li>
    <li class="active"><a>Crear</a></li>
</ol>
@endsection
@section('content')
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">CREAR NUEVA JORNADA</h3>
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
            <form class="form" role='form' method="POST" action="{{route('jornada.store')}}">
                @csrf
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Nombre de la Jornada</label>
                        <input class="form-control" type="text" placeholder="Puede ser: diurna, nocturna, etc." required="required" name="descripcion">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Jornada SNIES</label>
                        <select class="form-control"  style="width: 100%;" name="jornadasnies">
                            <option value="0">-- Seleccione una opci??n --</option>
                            <option value="DIURNA">DIURNA</option>
                            <option value="NOCTURNA">NOCTURNA</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Hora Inicio (Formato 24 Horas)</label>
                        <input class="form-control" type="text" placeholder="Hora en que da inicio la jornada" maxlength="5" name="horainicio">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Hora Fin (Formato 24 Horas)</label>
                        <input class="form-control" type="text" placeholder="Hora en que da fin la jornada" maxlength="5" name="horafin">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Fin de Semana</label>
                        <select class="form-control"  style="width: 100%;" name="findesemana" required="required">
                            <option value="0">-- Seleccione una opci??n --</option>
                            <option value="SI">SI</option>
                            <option value="NO">NO</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-12" style="margin-top: 20px !important">
                    <div class="form-group">
                        <button class="btn btn-success icon-btn pull-left" type="submit"><i class="fa fa-fw fa-lg fa-save"></i>Guardar</button>
                        <button class="btn btn-info icon-btn pull-left" type="reset"><i class="fa fa-fw fa-lg fa-trash-o"></i>Limpiar</button>
                        <a class="btn btn-danger icon-btn pull-left" href="{{route('jornada.index')}}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancelar</a>
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
                <h4 class="modal-title">Informaci??n de Ayuda</h4>
            </div>
            <div class="modal-body">
                <p>Las jornadas de trabajo y estudio definen los horarios generales de la instituci??n. La Jornada Diurna por ejemplo se define as??: si el horario de clases para los alumnos de un programa acad??mico oscila entre las 6:00 a.m. y las 6:00 p.m. Agregue nuevas jornadas.</p>
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
        $('.select2').select2();
    });
</script>
@endsection