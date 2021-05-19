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
    <li class="active"><a>Componentes en Estándar y Unidad</a></li>
</ol>
@endsection
@section('content')
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">COMPONENTES EN ESTÁNDAR Y UNIDAD</h3>
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
                            <th>ESTÁNDAR</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{$grado->etiqueta}}</td>
                            <td>{{$materia->codigomateria." - ".$materia->nombre}}</td>
                            <td>{{$unidad->nombre}}</td>
                            <td><label class="bg-orange">EST-{{$estandar->estandar_id}}</label> {{$estandar->estandar->titulo}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-md-12">
            <br>
            <h3 style="border-left: 10px solid; border-color: #f44336; background-color: #f7968f; padding: 5px;">Aprendizajes/Logros en el Estándar</h3>
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <tbody>
                        @if($aprendizajes!=null)
                        @foreach($aprendizajes as $ap)
                        <tr class="bg-red">
                            <th colspan="2">COMPONENTE: {{$ap['componente']}}</th>
                        </tr>
                        <tr class="bg-red" style="font-size: 11px;">
                            <th colspan="2">DESCRIPCION: {{$ap['descripcion']}}</th>
                        </tr>
                        <tr class="bg-light-blue">
                            <th>COMPETENCIA</th>
                            <th>APRENDIZAJES</th>
                        </tr>
                        @if($ap['competencias']!=null)
                        @foreach($ap['competencias'] as $comp)
                        <tr>
                            <td>{{$comp['competencia']}}</td>
                            <td>
                                @if($comp['aprendizajes']!=null)
                                <ul>
                                    @foreach($comp['aprendizajes'] as $ap)
                                    <li>@if($ap['esta']=='SI') <a href="{{route('contenido.deleteAprendizajeEstandar',[$grado->id,$materia->id,$unidad->id,$estandar->id,$ap['ctunidadestandaraprendizaje_id']])}}" class="btn btn-xs btn-danger btn-raised" title="Retirar Logro"> <i class="fa fa-remove"></i> </a> @else <a href="{{route('contenido.addAprendizajeEstandar',[$grado->id,$materia->id,$unidad->id,$estandar->id,$ap['aprendizaje_id']])}}" class="btn btn-xs btn-primary btn-raised" title="Adicionar Logro"> <i class="fa fa-plus"></i> </a> @endif <b>{{$ap['logro']}} </b>(NEGATIVO: {{$ap['logro_negativo']}})</li>
                                    @endforeach
                                </ul>
                                @else
                                ---
                                @endif
                            </td>
                        </tr>
                        @endforeach
                        @endif
                        @endforeach
                        @else
                        <tr>
                            <td colspan="2">No hay aprendizajes en el estándar</td>
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
                <p>Esta funcionalidad permite asignar los aprendizajes al estándar indicado dentro de una unidad.</p>
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

@endsection
@section('script')
<script type="text/javascript">
    $(document).ready(function() {
        //$('#example1').DataTable();
        $(document.body).attr('class', 'skin-blue sidebar-mini sidebar-collapse');
    });
</script>
@endsection