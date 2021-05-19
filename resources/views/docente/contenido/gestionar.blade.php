@extends('layouts.admin')
@section('breadcrumb')
<h1>
    Bienvenido
    <small>Sr(a). {{Auth::user()->nombres}}</small>
</h1>
<ol class="breadcrumb">
    <li><a href="{{route('home')}}"><i class="fa fa-home"></i> Inicio</a></li>
    <li><a href="{{route('menu.academicodocente')}}"><i class="fa fa-vimeo"></i> Académico</a></li>
    <li><a href="{{route('cargaacademica.contenido')}}"><i class="fa fa-book"></i> Contenido Temático</a></li>
    <li class="active"><a>Gestionar Contenido (Unidades)</a></li>
</ol>
@endsection
@section('content')
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">GESTIONAR CONTENIDO TEMÁTICO (UNIDADES)</h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-toggle="modal" data-target="#modal" title="Ayuda">
                <i class="fa fa-question"></i></button>
            <a class="btn btn-box-tool" data-toggle="modal" data-target="#modal2" title="Agregar Nueva Unidad">
                <i class="fa fa-plus-circle"></i></a>
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Minimizar">
                <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Cerrar">
                <i class="fa fa-times"></i></button>
        </div>
    </div>
    <div class="box-body">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr class="bg-red">
                            <th>GRADO</th>
                            <th>MATERIA</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{$grado->etiqueta}}</td>
                            <td>{{$materia->codigomateria." - ".$materia->nombre}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-12" style="border:1px solid; padding: 10px;">
                <h4>Menú Núcleo Temático</h4>
                <div class="col-md-3">
                    <a data-toggle="modal" data-target="#modal2" title="Crear Unidad" class="btn btn-danger btn-raised btn-block btn-flat"> CREAR UNIDAD</a>
                </div>
                <div class="col-md-6">
                    <a href="{{route('cargaacademica.malla_curricular',[$grado->id,$materia->id])}}" title="Malla Curricular" class="btn btn-danger btn-raised btn-block btn-flat"> MALLA CURRICULAR (ASIGNAR UNIDAD A PERÍODO)</a>
                </div>
            </div>
            <div class="col-md-12" style="margin-top: 20px;">
                <h4>Banco de Unidades en la Materia y Grado</h4>
                @if(count($unidades)>0)
                @foreach($unidades as $u)
                <div class="col-lg-4 col-xs-6">
                    <!-- small box -->
                    <div class="small-box {{$u->color}}">
                        <div class="inner">
                            <h3>Unidad</h3>
                            <p>{{str_limit($u->nombre,36,'...')}}</p>
                            <p>AUTOR: {{$u->user->nombres." ".$u->user->apellidos}}</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-book"></i>
                        </div>
                        <a href="{{route('contenido.configurar',[$grado->id,$materia->id,$u->id])}}" class="small-box-footer">Configurar Unidad <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                @endforeach
                @else
                <h4 style="border-left: 5px solid; border-color: #dd4b39 !important; background-color: #f5a298; padding: 10px;"><i style="color: yellow;" class="fa fa-warning"></i> Sin unidades</h4>
                @endif
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
                <p>Esta funcionalidad permite crear unidades temáticas y configurar en ellas sus contenidos, estándares, logros y todo lo relacionado a la unidad.</p>
            </div>
            <div class="modal-footer" style="background-color: #d2d6de !important; opacity: .65;">
                <button type="button" class="btn btn-block btn-danger btn-flat pull-right" data-dismiss="modal"><i class="fa fa-reply"></i> Regresar
                </button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<div class="modal fade" id="modal2">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Crear Unidad</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <form class="form" id="unidadForm" role='form' method="POST" action="{{route('contenido.store')}}">
                        @csrf
                        <input type="hidden" name="grado_id" value="{{$grado->id}}">
                        <input type="hidden" name="materia_id" value="{{$materia->id}}">
                        <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Título</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" required>
                            </div>
                            <div class="form-group">
                                <label>Resumen de la Unidad</label>
                                <textarea class="form-control" name="resumen" id="resumen" required></textarea>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Como lo Vas a Desarrollar</label>
                                <input type="text" class="form-control" name="como_desarrollar">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Cuándo lo Vas a Desarrollar</label>
                                <input type="text" class="form-control" name="cuando_desarrollar">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Dónde lo Vas a Desarrollar</label>
                                <input type="text" class="form-control" name="donde_desarrollar">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer" style="background-color: #d2d6de !important; opacity: .65;">
                <button class="btn btn-success icon-btn pull-right" onclick="enviar()"><i class="fa fa-fw fa-lg fa-save"></i>Guardar</button>
                <button type="button" class="btn btn-block btn-danger btn-flat pull-right" data-dismiss="modal"><i class="fa fa-reply"></i> Regresar
                </button>
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
        //$('#example1').DataTable();
        $(document.body).attr('class', 'skin-blue sidebar-mini sidebar-collapse');
    });

    function enviar() {
        if ($("#nombre").val().length == 0 || $("#resumen").val().length == 0) {
            notify('Alerta', 'Debe indicar título y resumen para guardar', 'error');
            return;
        }
        $("#unidadForm").submit();
    }
</script>
@endsection