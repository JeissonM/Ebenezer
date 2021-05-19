@extends('layouts.admin')
@section('breadcrumb')
<h1>
    Bienvenido
    <small>Sr(a). {{Auth::user()->nombres}}</small>
</h1>
<ol class="breadcrumb">
    <li><a href="{{route('menu.admisiones')}}"><i class="fa fa-users"></i> Admisiones</a></li>
    <li><a href="{{route('menu.admisiones')}}"><i class="fa fa-cogs"></i> Datos Básicos</a></li>
    <li><a href="{{route('entidadsalud.index')}}"><i class="fa fa-plus-square"></i> Entidades de Salud</a></li>
    <li class="active"><a>Editar</a></li>
</ol>
@endsection
@section('content')
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">EDITAR ENTIDAD</h3>
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
            <form class="form" role='form' method="POST" action="{{route('entidadsalud.update',$salud->id)}}">
                @csrf
                <input name="_method" type="hidden" value="PUT" />
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Codigo</label>
                        <input class="form-control" type="text" value="{{$salud->codigo}}" required="required" name="codigo" placeholder="Codigo de la entidad de salud">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Nombre</label>
                        <input class="form-control" type="text" value="{{$salud->nombre}}" placeholder="Nombre de la entidad" name="nombre">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Acronimo    </label>
                        <input class="form-control" type="text" value="{{$salud->acronimo}}" placeholder="Abreviatura" name="acronimo">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Tipo</label>
                        <select class="form-control" required="required" name="tipoentidad">
                            <option>-- Seleccione una opción --</option>
                            @if($salud->tipoentidad == 'IPS')
                            <option value="IPS" selected>IPS</option>
                            <option value="EPS">EPS</option>
                            <option value="ARS">ARS</option>
                            @elseif($salud->tipoentidad == 'EPS')
                            <option value="IPS">IPS</option>
                            <option value="EPS" selected>EPS</option>
                            <option value="ARS">ARS</option>
                            @else
                            <option value="IPS">IPS</option>
                            <option value="EPS">EPS</option>
                            <option value="ARS" selected>ARS</option>
                            @endif
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Sector</label>
                        <select class="form-control" name="sector">
                            <option>-- Seleccione una opción --</option>
                            @if($salud->sector == 'MIXTO')
                            <option value="MIXTO" selected>MIXTO</option>
                            <option value="PRIVADO">PRIVADO</option>
                            <option value="PUBLICO">PUBLICO</option>
                            @elseif($salud == 'PRIVADO')
                            <option value="MIXTO">MIXTO</option>
                            <option value="PRIVADO" selected>PRIVADO</option>
                            <option value="PUBLICO">PUBLICO</option>
                            @else
                            <option value="MIXTO">MIXTO</option>
                            <option value="PRIVADO">PRIVADO</option>
                            <option value="PUBLICO" selected>PUBLICO</option>
                            @endif
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Estado Registro</label>
                        <select class="form-control" required="required" name="estado">
                            <option>-- Seleccione una opción --</option>
                            @if($salud->estado == 1)
                            <option value="1" selected>ACTIVO</option>
                            <option value="0">INACTIVO</option>
                            @else
                            <option value="1">ACTIVO</option>
                            <option value="0" selected>INACTIVO</option>
                            @endif
                        </select>
                    </div>
                </div>
                <div class="col-md-12" style="margin-top: 20px !important">
                    <div class="form-group">
                        <button class="btn btn-success icon-btn pull-left" type="submit"><i class="fa fa-fw fa-lg fa-save"></i>Guardar</button>
                        <button class="btn btn-info icon-btn pull-left" type="reset"><i class="fa fa-fw fa-lg fa-trash-o"></i>Limpiar</button>
                        <a class="btn btn-danger icon-btn pull-left" href="{{route('entidadsalud.index')}}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancelar</a>
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
                <p>Esta funcionalidad permite al usuario diligenciar la información referente a las entidades de salud. Cambia o actualiza los datos de la entidad ya seleccionada.</p>
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