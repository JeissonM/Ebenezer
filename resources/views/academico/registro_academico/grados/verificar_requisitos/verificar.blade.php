@extends('layouts.admin')
@section('breadcrumb')
    <h1>
        Bienvenido
        <small>Sr(a). {{Auth::user()->nombres}}</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{route('home')}}"><i class="fa fa-home"></i> Inicio</a></li>
        <li><a href="{{route('menu.academico')}}"><i class="fa fa-book"></i> Académico</a></li>
        <li><a href="{{route('menu.academico')}}"><i class="fa fa-edit"></i> Registro Académico</a></li>
        <li><a href="{{route('menu.grados')}}"><i class="fa fa-graduation-cap"></i> Grados</a></li>
        <li><a href="{{route('verificarrequisitogrado.index')}}"><i class="fa fa-check"></i> Verificar Requisitos</a>
        </li>
        <li>
            <a href="{{route('verificarrequisitogrado.listar', [$unidad->id, $periodo->id, $jornada->id, $grado->id])}}"><i
                    class="fa fa-list"></i> Estudiantes</a></li>
        <li class="active"><a> Verificar</a></li>
    </ol>
@endsection
@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">VERIFICAR REQUISITOS DE GRADO</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-toggle="modal" data-target="#modal" title="Ayuda">
                    <i class="fa fa-question"></i></button>
                <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                        title="Minimizar">
                    <i class="fa fa-minus"></i></button>
                <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip"
                        title="Cerrar">
                    <i class="fa fa-times"></i></button>
            </div>
        </div>
        <div class="box-body">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                        <tr class="info">
                            <th>IDENTIFICACIÓN</th>
                            <th>ESTUDIANTE</th>
                            <th>PERÍODO</th>
                            <th>JORNADA</th>
                            <th>UNIDAD</th>
                            <th>GRADO</th>
                            <th>ESTADO</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>{{$a->personanatural->persona->tipodoc->abreviatura." - ".$a->personanatural->persona->numero_documento}}</td>
                            <td>{{$a->personanatural->primer_nombre." ".$a->personanatural->segundo_nombre." ".$a->personanatural->primer_apellido." ".$a->personanatural->segundo_apellido}}</td>
                            <td>{{$periodo->etiqueta." - ".$periodo->anio}}</td>
                            <td>{{$jornada->descripcion." - ".$jornada->jornadasnies}}</td>
                            <td>{{$unidad->nombre}}</td>
                            <td>{{$grado->etiqueta}}</td>
                            <td>{{$a->estado}}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                        <tr class="info">
                            <th>REQUISITO</th>
                            <th style="text-align: center;">CUMPLIDO</th>
                            <th style="text-align: center;">ACCIONES</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($requisitos as $r)
                            <tr>
                                <td>{{$r->requisitogrado->descripcion}}</td>
                                <td style="text-align: center;">
                                    @if($r->esta=='SI')
                                        <a><i style="color: green; font-size: 18px;" class="fa fa-check"></i></a>
                                    @else
                                        <a><i style="color: red; font-size: 18px;" class="fa fa-times"></i></a>
                                    @endif
                                </td>
                                <td>
                                    @if($r->esta=='SI')
                                        <a href="{{route('verificarrequisitogrado.removeRequisito',[$r->requisito,$periodo->id,$jornada->id,$unidad->id,$grado->id])}}"
                                           class="btn btn-sm btn-danger btn-block" style="margin: 0px; color: red;">RETIRAR</a>
                                    @else
                                        <a href="{{route('verificarrequisitogrado.check',[$a->id, $r->id,$periodo->id,$jornada->id,$unidad->id,$grado->id])}}"
                                           class="btn btn-sm btn-succes btn-block" style="margin: 0px; color: green;">CUMPLE</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
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
                    <p>Esta funcionalidad permite al usuario verificar y hacer check a los requisitos de los estudiantes
                        en el proceso de grado.</p>
                </div>
                <div class="modal-footer" style="background-color: #d2d6de !important; opacity: .65;">
                    <button type="button" class="btn btn-block btn-danger btn-flat pull-right" data-dismiss="modal"><i
                            class="fa fa-reply"></i> Regresar
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
        $(document).ready(function () {
            $('#example1').DataTable();
        });
    </script>
@endsection
