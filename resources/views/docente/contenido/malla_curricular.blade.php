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
    <li><a href="{{route('cargaacademica.gestionar_contenido',[$grado->id,$materia->id])}}"><i class="fa fa-edit"></i> Gestionar Contenido Temático</a></li>
    <li class="active"><a>Malla Curricular</a></li>
</ol>
@endsection
@section('content')
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">MALLA CURRICULAR</h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-toggle="modal" data-target="#modal" title="Ayuda">
                <i class="fa fa-question"></i></button>
            <a class="btn btn-box-tool" data-toggle="modal" data-target="#modal2" title="Configurar Malla (Asignar Unidad a Período)">
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
            <div class="col-md-12" style="margin-top: 20px;">
                <h4>Listado de Unidades Asociadas a Período</h4>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr class="bg-red">
                                <th>PERÍODO</th>
                                <th>UNIDADES</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($unidadesya!=null)
                            @foreach($unidadesya as $key=>$unds)
                            <tr>
                                <td>{{$key}}</td>
                                <td>
                                    @if($unds!=null)
                                    <ol style="list-style: none;">
                                        @foreach($unds as $u)
                                        <li><a href="{{route('cargaacademica.malla_eliminarunidad',[$grado->id,$materia->id,$u->id])}}" class="btn btn-xs btn-danger btn-raised" title="Retirar Unidad"> <i class="fa fa-remove"></i> </a> {{$u->ctunidad->nombre}} <b>({{$u->user->nombres." ".$u->user->apellidos}})</b></li>
                                        @endforeach
                                    </ol>
                                    @else
                                    <h5><i style="color: yellow;" class="fa fa-warning"></i> Sin unidades en el período</h5>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr style="border-left: 5px solid; border-color: #dd4b39 !important; background-color: #f5a298; padding: 10px;">
                                <td colspan="2"><i style="color: yellow;" class="fa fa-warning"></i> Sin unidades</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
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
                <p>Esta funcionalidad permite asignar las unidades creadas a los períodos o evaluaciones académicas.</p>
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
                <h4 class="modal-title">Asignar Unidad a Período</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <form class="form" id="unidadForm" role='form' method="POST" action="{{route('cargaacademica.malla_asignarunidad')}}">
                        @csrf
                        <input type="hidden" name="grado_id" value="{{$grado->id}}">
                        <input type="hidden" name="materia_id" value="{{$materia->id}}">
                        <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Unidad</label>
                                <select class="form-control select2" style="width: 100%;" name="ctunidad_id" id="ctunidad_id" required>
                                    @if(count($unidades)>0)
                                    @foreach($unidades as $u)
                                    <option value="{{$u->id}}">{{$u->nombre}} ({{$u->user->nombres." ".$u->user->apellidos}})</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Período (Evaluación Académica)</label>
                                <select class="form-control select2" style="width: 100%;" name="evaluacionacademica_id" id="evaluacionacademica_id" required>
                                    @if(count($evaluaciones)>0)
                                    @foreach($evaluaciones as $e)
                                    <option value="{{$e->id}}">{{$e->nombre." - ".$e->peso."%"}} ({{$e->sistemaevaluacion->nombre}})</option>
                                    @endforeach
                                    @endif
                                </select>
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
        $('.select2').select2();
    });

    function enviar() {
        if ($("#ctunidad_id").val().length == 0 || $("#evaluacionacademica_id").val().length == 0) {
            notify('Alerta', 'Debe indicar unidad y evaluación para guardar', 'error');
            return;
        }
        $("#unidadForm").submit();
    }
</script>
@endsection