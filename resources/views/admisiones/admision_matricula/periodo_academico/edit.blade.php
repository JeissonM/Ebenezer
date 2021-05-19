
@extends('layouts.admin')
@section('breadcrumb')
<h1>
    Bienvenido
    <small>Sr(a). {{Auth::user()->nombres}}</small>
</h1>
<ol class="breadcrumb">
    <li><a href="{{route('home')}}"><i class="fa fa-home"></i> Inicio</a></li>
    <li><a href="{{route('menu.admisiones')}}"><i class="fa fa-users"></i> Admisiones</a></li>
    <li><a href="{{route('menu.admisiones')}}"><i class="fa fa-list-ul"></i> Datos de Admisión y Matrícula</a></li>
    <li><a href="{{route('periodoacademico.index')}}"><i class="fa fa-calendar-check-o"></i> Períodos Académicos</a></li>
    <li class="active"><a>Editar</a></li>
</ol>
@endsection
@section('content')
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">EDITAR PERÍODO ACADÉMICO</h3>
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
            <form class="form" role='form' method="POST" action="{{route('periodoacademico.update',$periodo->id)}}">
                @csrf
                <input name="_method" type="hidden" value="PUT" />
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Etiqueta</label>
                        <input class="form-control" type="text" placeholder="Ej: Año lectivo, período, período anual, etc." required="required" name="etiqueta" value="{{$periodo->etiqueta}}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Año</label>
                        <input class="form-control" type="number" max="4000" placeholder="Año" required="required" name="anio" value="{{$periodo->anio}}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Fecha Inicio</label>
                        <input class="form-control" type="date" placeholder="Fecha de inicio del período" name="fecha_inicio" value="{{$periodo->fecha_inicio}}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Fecha Fin</label>
                        <input class="form-control" type="date" placeholder="Fecha fin del período" name="fecha_fin" value="{{$periodo->fecha_fin}}">
                    </div>
                </div>
                <div class="col-md-12" style="margin-top: 20px !important">
                    <div class="form-group">
                        <button class="btn btn-success icon-btn pull-left" type="submit"><i class="fa fa-fw fa-lg fa-save"></i>Guardar</button>
                        <button class="btn btn-info icon-btn pull-left" type="reset"><i class="fa fa-fw fa-lg fa-trash-o"></i>Limpiar</button>
                        <a class="btn btn-danger icon-btn pull-left" href="{{route('periodoacademico.index')}}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancelar</a>
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
                <p>Gestione los períodos. Edite los datos del período seleccionado.</p>
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

    });
</script>
@endsection