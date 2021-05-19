@extends('layouts.admin')
@section('breadcrumb')
<h1>
    Bienvenido
    <small>Sr(a). {{Auth::user()->nombres}}</small>
</h1>
<ol class="breadcrumb">
    <li><a href="{{route('home')}}"><i class="fa fa-home"></i> Inicio</a></li>
    <li><a href="{{route('menu.documental')}}"><i class="fa fa-book"></i> Documental</a></li>
    <li><a href="{{route('estandar.index')}}"><i class="fa fa-bookmark"></i> Estándar </a></li>
    <li class="active"><a> Estándares en el Área</a></li>
</ol>
@endsection
@section('content')
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">GESTIÓN DE ESTÁNDAR EN UN ÁREA</h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-toggle="modal" data-target="#modal" title="Ayuda">
                <i class="fa fa-question"></i></button>
            <button type="button" class="btn btn-box-tool" data-toggle="modal" data-target="#modal2" title="Crear Estándar">
                <i class="fa fa-plus-circle"></i></button>
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
                        <tr class="bg-purple">
                            <th>ÁREA</th>
                            <th>DESCRIPCIÓN</th>
                            <th>GRADO</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{$area->nombre}}</td>
                            <td>{{$area->descripcion}}</td>
                            <td>{{$grupo->grado->etiqueta}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <h2>Estándares en el Área Indicada</h2>
            <div class="table-responsive">
                <table id="example1" class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr class="bg-purple">
                            <th>TÍTULO</th>
                            <th>DESCRIPCIÓN</th>
                            <th>GRADO</th>
                            <th>COMPONENTES</th>
                            <th>AUTOR</th>
                            <th>ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($estandares)>0)
                        @foreach($estandares as $e)
                        <tr>
                            <td>{{$e->titulo}}</td>
                            <td>{{$e->descripcion}}</td>
                            <td>{{$e->grado->etiqueta}}</td>
                            <td>
                                @if(count($e->estandarcomponentes)>0)
                                <ul>
                                    @foreach($e->estandarcomponentes as $ec)
                                    <li>{{$ec->componente->componente}}</li>
                                    @endforeach
                                </ul>
                                @else
                                ---
                                @endif
                            </td>
                            <td>{{$e->user->nombres." ".$e->user->apellidos}}</td>
                            <td>
                                <a href="{{route('estandar.configurar',[$e->id, $grupo->id])}}" style="margin-left: 10px; color: green;" data-toggle="tooltip" title="Configurar Estándar" style="margin-left: 10px;"><i class="fa fa-arrow-right"></i></a>
                                @if(Auth::user()->id==$e->user_id)
                                <a id="{{json_encode($e)}}" onclick="poner(this.id)" style="margin-left: 10px; color: blue; cursor: pointer;" data-toggle="modal" data-target="#modal3" title="Editar Estándar" style="margin-left: 10px;"><i class="fa fa-edit"></i></a>
                                <a href="{{route('estandar.delete',[$e->id, $area->id, $grupo->id])}}" style="margin-left: 10px; color: red;" data-toggle="tooltip" title="Eliminar" style="margin-left: 10px;"><i class="fa fa-trash-o"></i></a>
                                @else
                                ---
                                @endif
                            </td>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
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
                <p>Esta funcionalidad permite gestionar los estándares por área; configurar sus componentes y definir competencias dentro de ellos.</p>
                <p><strong>Nota: </strong>Solo puede actuar sobre los estándares creados por usted y que no estén siendo usados</p>
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
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Crear Nuevo Estándar en el Grado {{$grupo->grado->etiqueta}}</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <form class="form" id="estandarForm" role='form' method="POST" action="{{route('estandar.store')}}">
                        @csrf
                        <input type="hidden" name="grado_id" value="{{$grupo->grado_id}}">
                        <input type="hidden" name="area_id" value="{{$area->id}}">
                        <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                        <input type="hidden" name="grupo_id" value="{{$grupo->id}}">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Título</label>
                                <input type="text" maxlength="250" class="form-control" id="titulo" name="titulo" required>
                            </div>
                            <div class="form-group">
                                <label>Descripción (Opcional)</label>
                                <input type="text" class="form-control" name="descripcion">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer" style="background-color: #d2d6de !important; opacity: .65;">
                <button class="btn btn-success icon-btn pull-right" onclick="enviar()"><i class="fa fa-fw fa-lg fa-save"></i>Guardar</button>
                <button type="button" class="btn btn-block btn-danger btn-flat pull-right" data-dismiss="modal"><i class="fa fa-reply"></i> Regresar</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<div class="modal fade" id="modal3">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Editando Estándar en el Grado {{$grupo->grado->etiqueta}}</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <form class="form" id="editForm" role='form' method="POST" action="{{route('estandar.actualizar')}}">
                        @csrf
                        <input type="hidden" name="grado_id" value="{{$grupo->grado_id}}">
                        <input type="hidden" name="area_id" value="{{$area->id}}">
                        <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                        <input type="hidden" name="grupo_id" value="{{$grupo->id}}">
                        <input type="hidden" id="id" name="id" value="0">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Título</label>
                                <input type="text" maxlength="250" class="form-control" id="titulo2" name="titulo" required>
                            </div>
                            <div class="form-group">
                                <label>Descripción (Opcional)</label>
                                <input type="text" class="form-control" id="descripcion2" name="descripcion">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer" style="background-color: #d2d6de !important; opacity: .65;">
                <button class="btn btn-success icon-btn pull-right" onclick="enviar2()"><i class="fa fa-fw fa-lg fa-save"></i>Guardar</button>
                <button type="button" class="btn btn-block btn-danger btn-flat pull-right" data-dismiss="modal"><i class="fa fa-reply"></i> Regresar</button>
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
        //$('#tb2').DataTable();
        //$(document.body).attr('class', 'skin-blue sidebar-mini sidebar-collapse');
    });

    function enviar() {
        if ($("#titulo").val().length == 0) {
            notify('Alerta', 'Debe indicar el título para guardar', 'error');
            return;
        }
        $("#estandarForm").submit();
    }

    function enviar2() {
        if ($("#titulo2").val().length == 0) {
            notify('Alerta', 'Debe indicar el título para guardar', 'error');
            return;
        }
        $("#editForm").submit();
    }

    function poner(e) {
        var es = JSON.parse(e);
        $("#titulo2").val(es.titulo);
        $("#descripcion2").val(es.descripcion);
        $("#id").val(es.id);
    }
</script>
@endsection