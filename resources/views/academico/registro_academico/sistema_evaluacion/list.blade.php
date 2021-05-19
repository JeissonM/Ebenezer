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
        <li class="active"><a> Sistema de Evaluación</a></li>
    </ol>
@endsection
@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">SISTEMA DE EVALUACIÓN</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-toggle="modal" data-target="#modal" title="Ayuda">
                    <i class="fa fa-question"></i></button>
                <a href="{{route('sistemaevaluacion.create')}}" class="btn btn-box-tool"
                   data-toggle="tooltip" data-original-title="Agregar Nuevo Sistema de Evaluación">
                    <i class="fa fa-plus-circle"></i></a>
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
                    <table id="tb" class="table table-bordered table-striped table-hover">
                        <thead>
                        <tr class="danger">
                            <th>NOMBRE</th>
                            <th>NOTA INICIAL</th>
                            <th>NOTA FINAL</th>
                            <th>NOTA APROBATORIA</th>
                            <th>ESTADO</th>
                            <th>ACCIONES</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($sistemas as $e)
                            <tr>
                                <td>{{$e->nombre}}</td>
                                <td>{{$e->nota_inicial}}</td>
                                <td>{{$e->nota_final}}</td>
                                <td>{{$e->nota_aprobatoria}}</td>
                                <td>
                                    @if($e->estado == 'ACTUAL')
                                        <label class="label label-success">{{$e->estado}}</label>
                                    @else
                                        <label class="label label-danger">{{$e->estado}}</label>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{route('sistemaevaluacion.edit',$e->id)}}"
                                       style="margin-left: 10px; color: green;"
                                       data-toggle="tooltip" title="Editar" style="margin-left: 10px;"><i
                                            class="fa fa-edit"></i></a>
                                    <a href="{{route('sistemaevaluacion.delete',$e->id)}}"
                                       style="margin-left: 10px; color: red;"
                                       data-toggle="tooltip" title="Eliminar" style="margin-left: 10px;"><i
                                            class="fa fa-trash"></i></a>
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
                    <p>Esta funcionalidad permite crear y actualizar el sistema de evaluación en el cual se determina la
                        forma como se asignará la calificación aprobatoria, no aprobatoria y el comportamiento mismo del sistema.</p>
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
            $('#tb').DataTable();
        });
    </script>
@endsection
