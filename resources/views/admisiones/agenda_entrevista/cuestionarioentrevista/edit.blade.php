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
    <li><a href="{{route('cuestionarioentrevista.index')}}"><i class="fa fa-question"></i> Cuestionarios Entrevista</a></li>
    <li class="active"><a>Modificar Cuestionario</a></li>
</ol>
@endsection
@section('content')
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">MODIFICAR CUESTIONARIO</h3>
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
            <form class="form" role='form' method="POST" action="{{route('cuestionarioentrevista.update',$c)}}">
                @csrf
                <input name="_method" type="hidden" value="PUT" />
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Circunscripción*</label>
                        <select class="form-control" name="circunscripcion_id" required>
                            @foreach($circunscripciones as $key=>$value)
                            @if($c->circunscripcion_id==$key)
                            <option selected value="{{$key}}">{{$value}}</option>
                            @else
                            <option value="{{$key}}">{{$value}}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Nombre*</label>
                        <input class="form-control" value="{{$c->nombre}}" type="text" name="nombre" required />
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Descripción</label>
                        <input class="form-control" value="{{$c->descripcion}}" type="text" name="descripcion" />
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Estado Cuestionario*</label>
                        <select class="form-control" name="estado" required>
                            @if($c->estado=='ACTIVA')
                            <option selected value="ACTIVA">ACTIVA</option>
                            <option value="INACTIVA">INACTIVA</option>
                            @else
                            <option value="ACTIVA">ACTIVA</option>
                            <option selected value="INACTIVA">INACTIVA</option>
                            @endif
                        </select>
                    </div>
                </div>
                <div class="col-md-12" style="margin-top: 20px !important">
                    <div class="form-group">
                        <button class="btn btn-success icon-btn pull-left" type="submit"><i class="fa fa-fw fa-lg fa-save"></i>Guardar</button>
                        <button class="btn btn-info icon-btn pull-left" type="reset"><i class="fa fa-fw fa-lg fa-trash-o"></i>Limpiar</button>
                        <a class="btn btn-danger icon-btn pull-left" href="{{route('cuestionarioentrevista.index')}}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancelar</a>
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
                <p>Esta funcionalidad permite al usuario crear, configurar y gestionar los cuestionarios que se realizarán a los aspirantes en la entrevista de admisión.</p>
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
        CKEDITOR.replace('contrato');
    });
</script>
@endsection