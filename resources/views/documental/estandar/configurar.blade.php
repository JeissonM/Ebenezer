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
    <li><a href="{{route('estandar.listar',[$estandar->area_id,$grupo->id])}}"><i class="fa fa-bookmark-o"></i> Estándares en el Área </a></li>
    <li class="active"><a> Configurar Estándar</a></li>
</ol>
@endsection
@section('content')
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">CONFIGURAR ESTÁNDAR (GESTIONAR COMPONENTES Y COMPETENCIAS)</h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-toggle="modal" data-target="#modal" title="Ayuda">
                <i class="fa fa-question"></i></button>
            <button type="button" class="btn btn-box-tool" data-toggle="modal" data-target="#modal2" title="Agregar Componente">
                <i class="fa fa-plus-circle"></i></button>
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
                    <tbody>
                        <tr class="bg-purple">
                            <th>ÁREA</th>
                            <th>DESCRIPCIÓN</th>
                            <th>GRADO</th>
                        </tr>
                        <tr>
                            <td>{{$area->nombre}}</td>
                            <td>{{$area->descripcion}}</td>
                            <td>{{$grupo->grado->etiqueta}}</td>
                        </tr>
                        <tr class="bg-purple">
                            <th>ESTÁNDAR</th>
                            <th colspan="2">DESCRIPCIÓN</th>
                        </tr>
                        <tr>
                            <td>{{$estandar->titulo}}</td>
                            <td colspan="2">{{$estandar->descripcion}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <h2>Componentes en el Estándar</h2>
            <div class="col-md-12">
                @if($componentesya!=null)
                @foreach($componentesya as $cy)
                <h5 style="background-color: #6dd4de; color: #057a86; border-color: #057a86; border-left: 10px solid; padding: 10px;">
                    <b>{{$cy['ce']->componente->componente}}</b> <br> {{$cy['ce']->componente->descripcion}} <br>
                    <a href="{{route('estandar.removeComponente',[$estandar->id,$grupo->id,$cy['ce']->id])}}" class="btn btn-social-icon btn-google"><i class="fa fa-remove"></i></a>
                </h5>
                @if($cy['competencias']!=null)
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr class="bg-purple">
                                <th>COMPETENCIAS</th>
                                <th>LOGROS(APRENDIZAJES) E INDICADORES DE LOGROS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cy['competencias'] as $comp)
                            <tr>
                                <td>
                                    <a id="{{$comp->id.';'.$cy['ce']->id}}" onclick="poner(this.id)" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#modal3" title="Agregar Logro/Aprendizaje"><i style="font-size: 16px;" class="fa fa-plus-circle"></i></a>
                                    {{$comp->competencia->competencia}}
                                </td>
                                <td>
                                    @if(count($comp->logros)>0)
                                    @foreach($comp->logros as $l)
                                    <div class="box box-solid collapsed-box">
                                        <div class="box-header with-border">
                                            <h5 class="box-title" style="font-size: 12px !important;">
                                                <ul>
                                                    <li>
                                                        <a style="margin: 0px !important; padding: 0px 10px !important;" href="{{route('estandar.removeLogro',[$estandar->id,$grupo->id,$l->id])}}" class="btn btn-danger btn-xs" title="Eliminar Logro/Aprendizaje"><i style="font-size: 16px;" class="fa fa-remove"></i></a>
                                                        <b class="bg-orange">LOGRO: </b> {{$l->logro}}
                                                    </li>
                                                    <li style="padding-top: 10px;"><b class="bg-orange">LOGRO NEGATIVO: </b> {{$l->logro_negativo}})</li>
                                                </ul>
                                            </h5>
                                            <div class="box-tools">
                                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="box-body no-padding">
                                            <h4 style="padding: 10px; font-weight: bold;">
                                                <a id="{{$l->id}}" onclick="poner2(this.id)" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#modal4" title="Agregar Indicador"><i style="font-size: 16px;" class="fa fa-plus-circle"></i></a>
                                                INDICADORES DE LOGROS
                                            </h4>
                                            @if(count($l->indicadors)>0)
                                            <ul class="nav nav-pills nav-stacked">
                                                @foreach($l->indicadors as $i)
                                                <li><a><i class="fa fa-circle-o text-light-blue"></i> {{$i->indicador}} <span class="label label-danger pull-right" style="cursor: pointer;" onclick="eliminarIndicador(this.id)" id="{{$i->id}}"><i class="fa fa-remove"></i> ELIMINAR</span></a></li>
                                                @endforeach
                                            </ul>
                                            @else
                                            <h4 style="padding: 10px; font-weight: bold;">---</h4>
                                            @endif
                                        </div>
                                        <!-- /.box-body -->
                                    </div>
                                    @endforeach
                                    @else
                                    ---
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
                @endforeach
                @else
                <h4 style="background-color: #f7b7b7; color: #ff0000; border-color: #ff0000; border-left: 5px solid; padding: 10px;">El estándar no tiene componentes</h4>
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
                <p>Esta funcionalidad permite configurar los estándares; gestionar sus componentes y definir competencias dentro de ellos, agregar logros y definir los indicadores de logros.</p>
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
                <h4 class="modal-title">Agregar Componente</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <table id="example2" class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr class="bg-purple">
                                <th>COMPONENTE</th>
                                <th>DESCRIPCIÓN</th>
                                <th>AGREGAR</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($componentes)>0)
                            @foreach($componentes as $c)
                            <tr>
                                <td>{{$c->componente}}</td>
                                <td>{{$c->descripcion}}</td>
                                <td><a href="{{route('estandar.addComponente',[$estandar->id,$grupo->id,$c->id])}}" data-toggle="toltip" title="Agregar Componente al Estándar" class="btn btn-primary"><i class="fa fa-arrow-right"></i></a></td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
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


<div class="modal fade" id="modal3">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Agregar Aprendizaje o Logro</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <form class="form" id="estandarForm" role='form' method="POST" action="{{route('estandar.addLogro')}}">
                        @csrf
                        <input type="hidden" name="estandar_id" value="{{$estandar->id}}">
                        <input type="hidden" name="grupo_id" value="{{$grupo->id}}">
                        <input type="hidden" id="componentecompetencia_id" name="componentecompetencia_id">
                        <input type="hidden" id="estandarcomponente_id" name="estandarcomponente_id">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Aprendizaje</label>
                                <input type="text" class="form-control" id="logro" name="logro" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Aprendizaje Negativo (Logro a mostrar si se reprueba)</label>
                                <input type="text" class="form-control" id="logro_negativo" name="logro_negativo" required>
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


<div class="modal fade" id="modal4">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Agregar Indicador de Logro</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <form class="form" id="indicadorForm" role='form' method="POST" action="{{route('estandar.addIndicador')}}">
                        @csrf
                        <input type="hidden" name="estandar_id" value="{{$estandar->id}}">
                        <input type="hidden" name="grupo_id" value="{{$grupo->id}}">
                        <input type="hidden" id="aprendizaje_id" name="aprendizaje_id">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Indicador de Logro</label>
                                <input type="text" class="form-control" id="indicador" name="indicador" required>
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
        $('#example2').DataTable();
        $(document.body).attr('class', 'skin-blue sidebar-mini sidebar-collapse');
    });

    function enviar() {
        if ($("#logro").val().length == 0 || $("#logro_negativo").val().length == 0) {
            notify('Alerta', 'Debe indicar el aprendizaje positivo y el negativo para guardar', 'error');
            return;
        }
        $("#estandarForm").submit();
    }

    function enviar2() {
        if ($("#indicador").val().length == 0) {
            notify('Alerta', 'Debe indicar el indicador de aprendizaje para guardar', 'error');
            return;
        }
        $("#indicadorForm").submit();
    }

    function poner(e) {
        var m = e.split(";");
        $("#componentecompetencia_id").val(m[0]);
        $("#estandarcomponente_id").val(m[1]);
    }

    function poner2(id) {
        $("#aprendizaje_id").val(id);
    }

    function eliminarIndicador(id) {
        location.href = url + "/documental/estandar/{{$estandar->id}}/{{$grupo->id}}/configurar/logro/remover/" + id + "/indicador";
    }
</script>
@endsection