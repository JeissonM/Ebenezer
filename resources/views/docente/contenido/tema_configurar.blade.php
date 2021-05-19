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
    <li><a href="{{route('cargaacademica.gestionar_contenido',[$grado->id,$materia->id])}}"><i class="fa fa-book"></i> Gestionar Contenido (Unidades)</a></li>
    <li><a href="{{route('contenido.configurar',[$grado->id,$materia->id,$unidad->id])}}"><i class="fa fa-book"></i> Configurar Unidad</a></li>
    <li class="active"><a>Configurar Tema</a></li>
</ol>
@endsection
@section('content')
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">CONFIGURAR TEMA</h3>
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
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr class="bg-red">
                            <th>GRADO</th>
                            <th>MATERIA</th>
                            <th>UNIDAD</th>
                            <th>TEMA</th>
                            <th>DURACIÓN - AUTOR</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{$grado->etiqueta}}</td>
                            <td>{{$materia->codigomateria." - ".$materia->nombre}}</td>
                            <td>{{$unidad->nombre}}</td>
                            <td>{{$tema->titulo}}</td>
                            <td>{{$tema->duracion." - ".$tema->user->nombres." ".$tema->user->apellidos}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-12" style="border:1px solid; padding: 10px;">
                <h4>Menú SubTema (Solo puede editar un subtema creado por usted)</h4>
                <div class="col-md-3">
                    @if($tema->user_id!=Auth::user()->id)
                    <a disabled='disabled' title="Editar Tema" class="btn btn-danger btn-raised btn-block btn-flat"> EDITAR TEMA</a>
                    @else
                    <a data-toggle="modal" data-target="#modal2" title="Editar Tema" class="btn btn-danger btn-raised btn-block btn-flat"> EDITAR TEMA</a>
                    @endif
                </div>
                <div class="col-md-3">
                    <a data-toggle="modal" data-target="#modal3" title="Crear Subtema" class="btn btn-danger btn-raised btn-block btn-flat"> CREAR SUBTEMA</a>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <br>
            <h3 style="border-left: 10px solid; border-color: #f44336; background-color: #f7968f; padding: 5px;">Contenidos en el Tema (SubTemas)</h3>
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>SUBTEMA</th>
                            <th>ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($tema->ctunidadtemasubtemas)>0)
                        @foreach($tema->ctunidadtemasubtemas as $sbtm)
                        <tr>
                            <td>{{$sbtm->titulo}}</td>
                            <td style="padding: 0px;">
                                <a data-toggle="modal" id="{{$sbtm}}" data-target="#modal4" onclick="ponerSubtema(this.id)" class="btn btn-xs btn-raised btn-primary" title="Ver Subtema"><i class="fa fa-eye"></i></a>
                                @if($sbtm->user_id==Auth::user()->id)
                                <a data-toggle="modal" id="{{$sbtm}}" data-target="#modal5" onclick="ponerData(this.id)" class="btn btn-xs btn-raised btn-success" title="Editar Subtema"><i class="fa fa-edit"></i></a>
                                <a href="{{route('contenido.subtema_eliminar',[$tema->id,$sbtm->id])}}" class="btn btn-xs btn-raised btn-danger" title="Eliminar Subtema"><i class="fa fa-remove"></i></a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td class="bg-danger" colspan="2"><i class="fa fa-warning"></i> No hay contenidos en el tema</td>
                        </tr>
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
                <p>Esta funcionalidad permite configurar los temas dentro de una unidad: crear subtemas, editar el tema principal, etc.</p>
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
                <h4 class="modal-title">Editar Tema</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <form class="form" id="temaForm" role='form' method="POST" action="{{route('contenido.temaActualizar')}}">
                        @csrf
                        <input type="hidden" name="ctunidadtema_id" value="{{$tema->id}}">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Título</label>
                                <input type="text" class="form-control" value="{{$tema->titulo}}" id="titulo" name="titulo" required>
                            </div>
                            <div class="form-group">
                                <label>Introducción</label>
                                <textarea class="form-control" name="introduccion" id="introduccion" required>{{$tema->introduccion}}</textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Duración</label>
                                <input type="text" class="form-control" value="{{$tema->duracion}}" name="duracion" id="duracion" required>
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


<div class="modal fade" id="modal3">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Crear un Nuevo SubTema</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <h5 style="border-left: 10px solid; border-color: #f44336; background-color: #f7968f; padding: 5px;">Importante: si tienes imágenes que colocar en tu tema te recomendamos copiar desde word o desde la web (desde donde tengas tu contenido) y pegar directamente en el editor de tema</h5>
                    <form class="form" id="subtemaForm" role='form' method="POST" action="{{route('contenido.subtema_crear')}}">
                        @csrf
                        <input type="hidden" name="ctunidadtema_id" value="{{$tema->id}}">
                        <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Título</label>
                                <input type="text" class="form-control" id="sttitulo" name="titulo" required>
                            </div>
                            <div class="form-group">
                                <label>Desarrollo del Tema</label>
                                <textarea class="form-control" name="desarrollo" id="stdesarrollo" rows='10' cols='80' required></textarea>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer" style="background-color: #d2d6de !important; opacity: .65;">
                <button class="btn btn-success icon-btn pull-right" onclick="enviar2()"><i class="fa fa-fw fa-lg fa-save"></i>Guardar</button>
                <button type="button" class="btn btn-block btn-danger btn-flat pull-right" data-dismiss="modal"><i class="fa fa-reply"></i> Regresar
                </button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->


<div class="modal fade" id="modal4">
    <div class="modal-dialog modal-lg" style="width: 80% !important;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Ver SubTema</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12" style="margin: 2.5%; width: 95%; padding: 50px;
		-webkit-box-shadow: 0px 0px 20px -3px rgba(0, 0, 0, 0.9);
		-moz-box-shadow: 0px 0px 20px -3px rgba(0, 0, 0, 0.9);
		box-shadow: 0px 0px 20px -3px rgba(0, 0, 0, 0.9);
		font-size: 12px;">
                        <h3><b id="mostrarTitulo">Titulo</b></h3>
                        <div id="mostrarDesarrollo">Desarrollo del tema</div>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="background-color: #d2d6de !important; opacity: .65;">
                <button type="button" class="btn btn-block btn-danger btn-flat pull-right" data-dismiss="modal"><i class="fa fa-reply"></i> Regresar</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->


<div class="modal fade" id="modal5">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Editar SubTema</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <h5 style="border-left: 10px solid; border-color: #f44336; background-color: #f7968f; padding: 5px;">Importante: si tienes imágenes que colocar en tu tema te recomendamos copiar desde word o desde la web (desde donde tengas tu contenido) y pegar directamente en el editor de tema</h5>
                    <form class="form" id="subtemaEditarForm" role='form' method="POST" action="{{route('contenido.subtema_actualizar')}}">
                        @csrf
                        <input type="hidden" name="ctunidadtema_id" value="{{$tema->id}}">
                        <input type="hidden" name="ctunidadtemasubtema_id" id="ctunidadtemasubtema_id">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Título</label>
                                <input type="text" class="form-control" id="sttituloeditar" name="titulo" required>
                            </div>
                            <div class="form-group" id="txtdesarrollo">

                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer" style="background-color: #d2d6de !important; opacity: .65;">
                <button class="btn btn-success icon-btn pull-right" onclick="enviar3()"><i class="fa fa-fw fa-lg fa-save"></i>Guardar</button>
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
        CKEDITOR.replace('stdesarrollo');
    });

    function enviar() {
        if ($("#titulo").val().length == 0 || $("#introduccion").val().length == 0 || $("#duracion").val().length == 0) {
            notify('Alerta', 'Debe indicar título, introducción y duración para guardar', 'error');
            return;
        }
        $("#temaForm").submit();
    }

    function enviar2() {
        if ($("#sttitulo").val().length == 0) {
            notify('Alerta', 'Debe indicar título y desarrollo del tema para guardar', 'error');
            return;
        }
        $("#subtemaForm").submit();
    }

    function ponerSubtema(data) {
        var subtema = JSON.parse(data);
        $("#mostrarTitulo").html(subtema.titulo);
        $("#mostrarDesarrollo").html(subtema.desarrollo);
    }

    function ponerData(data) {
        var subtema = JSON.parse(data);
        $("#ctunidadtemasubtema_id").val(subtema.id);
        $("#sttituloeditar").val(subtema.titulo);
        $("#txtdesarrollo").html("<label>Desarrollo del Tema</label><textarea class='form-control' name='desarrollo' id='stdesarrolloeditar' rows='10' cols='80' required></textarea>");
        $("#stdesarrolloeditar").val(subtema.desarrollo);
        CKEDITOR.replace('stdesarrolloeditar');
    }

    function enviar3() {
        if ($("#sttituloeditar").val().length == 0) {
            notify('Alerta', 'Debe indicar título y desarrollo del tema para guardar', 'error');
            return;
        }
        $("#subtemaEditarForm").submit();
    }
</script>
@endsection