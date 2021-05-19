@extends('layouts.admin')
@section('breadcrumb')
<h1>
    Bienvenido
    <small>Sr(a). {{Auth::user()->nombres}}</small>
</h1>
<ol class="breadcrumb">
    <li><a href="{{route('menu.admisiones')}}"><i class="fa fa-users"></i> Admisiones</a></li>
    <li><a href="{{route('menu.admisiones')}}"><i class="fa fa-cogs"></i> Datos Básicos</a></li>
    <li><a href="{{route('pais.index')}}"><i class="fa fa-globe"></i> Paises</a></li>
    <li class="active"><a>Editar</a></li>
</ol>
@endsection
@section('content')
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">EDITAR PAIS</h3>
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
             <form class="form" role='form' method="POST" action="{{route('pais.update',$pais->id)}}">
                @csrf
                <input name="_method" type="hidden" value="PUT" />
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Codigo del Pais</label>
                        <input class="form-control" type="text" placeholder="Ejemplo: para colombia el código sería COL, abrebiatura de 3 caracteres" required="required" name="codigo" value="{{$pais->codigo}}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nombre de Pais</label>
                        <input class="form-control" type="text" required="required" name="nombre" value="{{$pais->nombre}}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Continente (Opcional)</label>
                        <input class="form-control" type="text" name="continente">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Región Continental (Opcional)</label>
                        <input class="form-control" type="text" placeholder="Ejemplo: para colombia el código sería SURAMERICA" name="region" value="{{$pais->region}}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Área Km2 (Opcional)</label>
                        <input class="form-control" type="number" name="area" value="{{$pais->area}}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Año de Independencia</label>
                        <input class="form-control" type="number" name="continente" value="{{$pais->continente}}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Población (Opcional)</label>
                        <input class="form-control" type="number" name="poblacion" value="{{$pais->poblacion}}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Expectativa de Vida (Opcional)</label>
                        <input class="form-control" type="number" placeholder="Porcentaje sobre 100 que indique la probabilidad de la expectativa de vida" name="expectativa_vida" value="{{$pais->expectativa_vida}}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Producto Interno Bruto (Opcional)</label>
                        <input class="form-control" type="number" name="producto_interno_bruto" value="{{$pais->producto_interno_bruto}}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Producto Interno Bruto Antiguo (Opcional)</label>
                        <input class="form-control" type="number" name="producto_interno_bruto_antiguo" value="{{$pais->producto_interno_bruto_antiguo}}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nombre Local (Opcional)</label>
                        <input class="form-control" type="text" placeholder="Nombre que se le asigna a una nación internamente" name="nombre_local" value="{{$pais->nombre_local}}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Tipo de Gobierno (Opcional)</label>
                        <input class="form-control" type="text" placeholder="Tipo de gobierno: Estado Federal, Republica Democratica, etc." name="gobierno" value="{{$pais->gobierno}}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Jefe de Estado(Opcional)</label>
                        <input class="form-control" type="text" name="jefe_estado" value="{{$pais->jefe_estado}}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Código Segundo (Opcional)</label>
                        <input class="form-control" type="text" placeholder="Ejemplo: para colombia el código sería CO, abrebiatura de dos caracteres" name="jefe_estado" value="{{$pais->codigo_dos}}">
                    </div>
                </div>
                <div class="col-md-12" style="margin-top: 20px !important">
                    <div class="form-group">
                        <button class="btn btn-success icon-btn pull-left" type="submit"><i class="fa fa-fw fa-lg fa-save"></i>Guardar</button>
                        <button class="btn btn-info icon-btn pull-left" type="reset"><i class="fa fa-fw fa-lg fa-trash-o"></i>Limpiar</button>
                        <a class="btn btn-danger icon-btn pull-left" href="{{route('pais.index')}}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancelar</a>
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
                <p>Edite los datos de los paises, recuerde que los campos código y nombre son requeridos.</p>
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
