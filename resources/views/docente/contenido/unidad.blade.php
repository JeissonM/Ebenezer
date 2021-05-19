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
    <li class="active"><a>Configurar Unidad</a></li>
</ol>
@endsection
@section('content')
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">CONFIGURAR UNIDAD</h3>
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
                            <th>AUTOR UNIDAD</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{$grado->etiqueta}}</td>
                            <td>{{$materia->codigomateria." - ".$materia->nombre}}</td>
                            <td>{{$unidad->nombre}}</td>
                            <td>{{$unidad->user->nombres." ".$unidad->user->apellidos}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-12" style="border:1px solid; padding: 10px;">
                <h4>Menú Unidad (Solo puede editar una unidad creada por usted)</h4>
                <div class="col-md-3">
                    @if($unidad->user_id!=Auth::user()->id)
                    <a disabled='disabled' title="Editar Unidad" class="btn btn-danger btn-raised btn-block btn-flat"> EDITAR UNIDAD</a>
                    @else
                    <a data-toggle="modal" data-target="#modal2" title="Editar Unidad" class="btn btn-danger btn-raised btn-block btn-flat"> EDITAR UNIDAD</a>
                    @endif
                </div>
                <div class="col-md-3">
                    <a data-toggle="modal" data-target="#modal4" title="Crear Tema" class="btn btn-danger btn-raised btn-block btn-flat"> CREAR TEMA</a>
                </div>
                <div class="col-md-3">
                    <a data-toggle="modal" data-target="#modal3" title="Asignar Estándar" class="btn btn-danger btn-raised btn-block btn-flat"> ASIGNAR ESTÁNDAR</a>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <br>
            <h3 style="border-left: 10px solid; border-color: #f44336; background-color: #f7968f; padding: 5px;">Estándares en la Unidad</h3>
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <tbody>
                        @if($aprendizajes!=null)
                        @foreach($aprendizajes as $eu)
                        <tr class="bg-blue">
                            <th><label class="bg-orange">EST-{{$eu['estandar_id']}}</label> {{$eu['estandar']}}</th>
                            <th>
                                <a href="{{route('contenido.componentesEstandar',[$grado->id,$materia->id,$unidad->id,$eu['ctunidadestandar_id']])}}" title="Definir los Aprendizajes en el Estándar" class="btn btn-xs btn-primary btn-raised"><i class="fa fa-arrow-right"></i> Definir los Aprendizajes en el Estándar</a>
                                <a href="{{route('contenido.deleteEstandar',[$grado->id,$materia->id,$unidad->id,$eu['ctunidadestandar_id']])}}" title="Retirar Estándar de Unidad (No debe tener componentes asociados)" class="btn btn-xs btn-danger btn-raised"><i class="fa fa-trash-o"></i> Retirar Estándar de Unidad</a>
                            </th>
                        </tr>
                        @if($eu['componentes']!=null)
                        @foreach($eu['componentes'] as $compo)
                        <tr class="bg-light-blue">
                            <td style="padding: 1px;" colspan="2">COMPONENTE: {{$compo['componente']}}</td>
                        </tr>
                        @if($compo['competencias']!=null)
                        <tr>
                            <th style="padding: 1px;">COMPETENCIAS</th>
                            <th style="padding: 1px;">APRENDIZAJES</th>
                        </tr>
                        @foreach($compo['competencias'] as $compe)
                        <tr>
                            <td style="padding: 1px;">{{$compe['competencia']}}</td>
                            <td style="padding: 1px;">
                                @if($compe['aprendizajes']!=null)
                                <ul>
                                    @foreach($compe['aprendizajes'] as $a)
                                    <li>{!!$a!!}</li>
                                    @endforeach
                                </ul>
                                @else
                                ---
                                @endif
                            </td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="2" style="color: red;">No hay competencias en el componente</td>
                        </tr>
                        @endif
                        @endforeach
                        @else
                        <tr>
                            <td colspan="2" style="color: red;">No hay componentes en el estándar</td>
                        </tr>
                        @endif
                        @endforeach
                        @else
                        <tr>
                            <td colspan="2" style="color: red;">No hay estándares configurados en la unidad</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-md-12">
            <br>
            <h3 style="border-left: 10px solid; border-color: #f44336; background-color: #f7968f; padding: 5px;">Nucleo Temático</h3>
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr class="bg-primary">
                            <th>TEMA</th>
                            <th>DURACIÓN</th>
                            <th style="text-align: center;">CONFIGURAR</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($temas)>0)
                        @foreach($temas as $te)
                        <tr>
                            <td>{{$te->titulo}}</td>
                            <td>{{$te->duracion}}</td>
                            <td style="padding: 0px; text-align: center;"><a href="{{route('contenido.temaConfigurar',[$grado->id,$materia->id,$unidad->id,$te->id])}}" style="margin: 1px 1px !important;" class="btn btn-primary btn-raised"><i class="fa fa-arrow-right"></i> CONTINUAR</a></td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="3" style="color: red;">No hay temas en la unidad</td>
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
                <p>Esta funcionalidad permite configurar la unidad, sus contenidos, estándares, logros y todo lo relacionado a la unidad.</p>
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
                <h4 class="modal-title">Editar Unidad</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <form class="form" id="unidadForm" role='form' method="POST" action="{{route('contenido.actualizar')}}">
                        @csrf
                        <input type="hidden" name="unidad_id" value="{{$unidad->id}}">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Título</label>
                                <input type="text" class="form-control" value="{{$unidad->nombre}}" id="nombre" name="nombre" required>
                            </div>
                            <div class="form-group">
                                <label>Resumen de la Unidad</label>
                                <textarea class="form-control" name="resumen" id="resumen" required>{{$unidad->resumen}}</textarea>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Como lo Vas a Desarrollar</label>
                                <input type="text" class="form-control" value="{{$unidad->como_desarrollar}}" name="como_desarrollar">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Cuándo lo Vas a Desarrollar</label>
                                <input type="text" class="form-control" value="{{$unidad->cuando_desarrollar}}" name="cuando_desarrollar">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Dónde lo Vas a Desarrollar</label>
                                <input type="text" class="form-control" value="{{$unidad->donde_desarrollar}}" name="donde_desarrollar">
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
                <h4 class="modal-title">Asignar Estándar a Unidad</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr class="bg-red">
                                    <th>ESTÁNDAR</th>
                                    <th>RESUMEN</th>
                                    <th>ASIGNAR</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($estandaresTodos)>0)
                                @foreach($estandaresTodos as $et)
                                <tr>
                                    <td><label class="bg-orange">EST-{{$et->id}}</label> {{$et->titulo}}</td>
                                    <td>{{$et->descripcion}}</td>
                                    <td><a href="{{route('contenido.addEstandar',[$unidad->id,$et->id])}}" style="margin-left: 10px; color: blue; cursor: pointer;"><i class="fa fa-check"></i></a></td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="3">No hay estándares configurados en el área {{$materia->area->nombre}}</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
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



<div class="modal fade" id="modal4">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Crear Tema</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <form class="form" id="temaForm" role='form' method="POST" action="{{route('contenido.temaStore')}}">
                        @csrf
                        <input type="hidden" name="ctunidad_id" value="{{$unidad->id}}">
                        <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Título</label>
                                <input type="text" class="form-control" id="ttitulo" name="titulo" required>
                            </div>
                            <div class="form-group">
                                <label>Introducción</label>
                                <textarea class="form-control" name="introduccion" id="tintroduccion" required></textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Duración</label>
                                <input type="text" class="form-control" name="duracion" id="tduracion" required>
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

    function enviar2() {
        if ($("#ttitulo").val().length == 0 || $("#tintroduccion").val().length == 0 || $("#tduracion").val().length == 0) {
            notify('Alerta', 'Debe indicar título, introducción y duración para guardar', 'error');
            return;
        }
        $("#temaForm").submit();
    }
</script>
@endsection