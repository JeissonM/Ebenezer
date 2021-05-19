@extends('layouts.admin')
@section('breadcrumb')
<h1>
    Bienvenido
    <small>Sr(a). {{Auth::user()->nombres}}</small>
</h1>
<ol class="breadcrumb">
    <li><a href="{{route('menu.admisiones')}}"><i class="fa fa-users"></i> Admisiones</a></li>
    <li><a href="{{route('menu.admisiones')}}"><i class="fa fa-cogs"></i> Datos Básicos</a></li>
    <li><a href="{{route('ciudad.index')}}"><i class="fa fa-globe"></i> Ciudades</a></li>
    <li class="active"><a>Editar</a></li>
</ol>
@endsection
@section('content')
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">EDITAR CIUDAD</h3>
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
            <form class="form" role='form' method="POST" action="{{route('ciudad.update',$ciudad->id)}}">
                @csrf
                <input name="_method" type="hidden" value="PUT" />
                <div class="col-md-8">
                    <div class="form-group">
                        <label>Código DANE de la Ciudad</label>
                        <input class="form-control" type="text" placeholder="Código de la ciudad (en el caso de colombia equivale al código que el DANE asigna a la ciudad)" name="codigo_dane" value="{{$ciudad->codigo_dane}}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Nombre de la Ciudad</label>
                        <input class="form-control" type="text" required="required" name="nombre" value="{{$ciudad->nombre}}">
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="form-group">
                        <label>Código del Pais</label>
                        <input class="form-control" type="text" placeholder="Ejemplo: para colombia el código sería COL, abrebiatura de 3 caracteres" required="required" name="codigo_pais" value="{{$ciudad->codigo_pais}}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Seleccione Situación de la Ciudad</label>
                        <select class="form-control" required="required"name="estado_dpto">
                            <option>-- Seleccione una opción --</option>
                            @if($ciudad->estado_dpto == 0)
                            <option value="0" selected>INACTIVA</option>
                            <option value="1">ACTIVA</option>
                            @else
                            <option value="0">INACTIVA</option>
                            <option value="1" selected>ACTIVA</option>
                            @endif
                        </select>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="form-group">
                        <label>Nombre del Distrito</label>
                        <input class="form-control" type="text" placeholder="Nombre del distrito al que pertenece la ciudad" name="distrito" value="{{$ciudad->distrito}}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Población</label>
                        <input class="form-control" type="number"  name="poblacion" value="{{$ciudad->poblacion}}">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Seleccione el Departamento</label>
                        <select class="form-control"  style="width: 100%;" name="estado_id" required="required">
                            <option value="0">-- Seleccione una opción --</option>
                            @foreach($estados as $key=>$value)
                            @if($ciudad->estado_id == $key)
                            <option value="{{$key}}" selected>{{$value}}</option>
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
                        <a class="btn btn-danger icon-btn pull-left" href="{{route('ciudad.index')}}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancelar</a>
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
                <p>Edite los datos de las ciudades. Si el estado al cual pertenece la ciudad que va a agregar no aparece en la lista de estados diríjase al módulo de gestión de estados y agréguelo, si no conoce el estado seleccione la opción OTRO. Las ciudades son usadas para funciones de admisiones y otros.</p>
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
