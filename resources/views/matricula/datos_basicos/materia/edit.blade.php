@extends('layouts.admin')
@section('breadcrumb')
<h1>
    Bienvenido
    <small>Sr(a). {{Auth::user()->nombres}}</small>
</h1>
<ol class="breadcrumb">
    <li><a href="{{route('menu.matricula')}}"><i class="fa fa-users"></i> Admisiones</a></li>
    <li><a href="{{route('menu.matricula')}}"><i class="fa fa-cogs"></i> Datos Básicos</a></li>
    <li><a href="{{route('materia.index')}}"><i class="fa fa-book"></i> Materias</a></li>
    <li class="active"><a>Editar</a></li>
</ol>
@endsection
@section('content')
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">EDITAR MATERIA</h3>
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
            <form class="form" role='form' method="POST" action="{{route('materia.update',$materia->id)}}">
                @csrf
                <input name="_method" type="hidden" value="PUT" />
                <div class="col-md-8">
                    <div class="form-group">
                        <label>Código de la Materia</label>
                        <input class="form-control" type="text" value="{{$materia->codigomateria}}" placeholder="Código de la Materia (en el caso del colegio Ebenezer equivale al código asignado por la secretaria de educación )" name="codigomateria">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Nombre de la Materia</label>
                        <input class="form-control" type="text" value="{{$materia->nombre}}" required="required" name="nombre">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Descripción</label>
                        <input class="form-control" type="text" value="{{$materia->descripcion}}" placeholder="Descripción de la Materia (opcional)" name="descripcion">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Intensidad Horaria</label>
                        <input class="form-control" type="number" value="{{$materia->ih}}" name="ih">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Recuperable ?</label>
                        <select class="form-control" required="required"  name="recuperable" value="{{$materia->recuperable}}">
                            <option>-- Seleccione una opción --</option>
                            @if($materia->recuperable=='SI')
                            <option value="SI" selected="true">SI</option>
                            <option value="NO">NO</option>
                            @else
                            <option value="SI">SI</option>
                            <option value="NO" selected="true">NO</option>
                            @endif
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Nivelable ?</label>
                        <select class="form-control" required="required"name="nivelable" >
                            <option>-- Seleccione una opción --</option>
                            @if($materia->nivelable=='SI')
                            <option value="SI" selected="true">SI</option>
                            <option value="NO">NO</option>
                            @else
                            <option value="SI">SI</option>
                            <option value="NO" selected="true">NO</option>
                            @endif
                        </select>
                    </div>
                </div>
                <!--busca areas-->
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Seleccione una Naturaleza (Opcional)</label>
                        <select class="form-control"  style="width: 100%;" name="naturaleza_id">
                            <option value="0">-- Seleccione una opción --</option>
                            @foreach($naturalezas as $key=>$value)
                            @if($materia->naturaleza_id==$key)
                            <option value="{{$key}}" selected="true">{{$value}}</option>
                            @else
                            <option value="{{$key}}">{{$value}}</option>
                            @endif
                            @endforeach
                            
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Seleccione un Área</label>
                        <select class="form-control"  style="width: 100%;" name="area_id" required="required" >
                            <option value="0">-- Seleccione una opción --</option>
                            @foreach($areas as $key=>$value)
                            @if($materia->area_id==$key)
                            <option value="{{$key}}" selected="true">{{$value}}</option>
                            @else
                            <option value="{{$key}}">{{$value}}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-12" style="margin-top: 20px !important">
                    <div class="form-group">
                        <button class="btn btn-success icon-btn pull-left" type="submit"><i class="fa fa-fw fa-lg fa-save"></i>Guardar</button>
                        <button class="btn btn-info icon-btn pull-left" type="reset"><i class="fa fa-fw fa-lg fa-trash-o"></i>Limpiar</button>
                        <a class="btn btn-danger icon-btn pull-left" href="{{route('materia.index')}}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancelar</a>
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
                <p>Edite los datos de la Materia. Si la naturalezas al cual pertenece la Materia que va a agregar no aparece en la lista de estados diríjase al módulo de gestión de naturalezas y agréguelo, si no conoce la naturalezas seleccione la opción OTRO.</p>
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
