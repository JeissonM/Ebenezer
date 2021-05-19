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
        <li><a href="{{route('sistemaevaluacion.index')}}"><i class="fa fa-edit"></i> Sistema de Evaluación</a></li>
        <li class="active"><a> Crear</a></li>
    </ol>
@endsection
@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">CREAR NUEVO SISTEMA DE EVALUACIÓN</h3>
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
                @component('layouts.errors')
                @endcomponent
            </div>
            <div class="col-md-12">
                <form class="form" role='form' method="POST" action="{{route('sistemaevaluacion.store')}}">
                    @csrf
                    <div class="col-md-8">
                        <div class="form-group">
                            <label>Nombre</label>
                            <input class="form-control" type="text" placeholder="Nombre del sistema de evaluacion"
                                   name="nombre">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Nota Inicial</label>
                            <input class="form-control" type="number" step="0.01"
                                   placeholder="Nota inicial del sistema de evaluación" name="nota_inicial">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Nota Final</label>
                            <input class="form-control" type="number" step="0.01" placeholder="Nota final del sistema de evaluación"
                                   name="nota_final">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Nota Aprobatoria</label>
                            <input class="form-control" type="number" step="0.01"
                                   placeholder="Nota aprobatoria del sistema de evaluación" name="nota_aprobatoria">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Estado</label>
                            <select class="form-control" name="estado">
                                    <option value="EN DESUSO">EN DESUSO</option>
                                    <option value="ACTUAL">ACTUAL</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12" style="margin-top: 20px !important">
                        <div class="form-group">
                            <button class="btn btn-success icon-btn pull-left" type="submit"><i
                                    class="fa fa-fw fa-lg fa-save"></i>Guardar
                            </button>
                            <button class="btn btn-info icon-btn pull-left" type="reset"><i
                                    class="fa fa-fw fa-lg fa-trash-o"></i>Limpiar
                            </button>
                            <a class="btn btn-danger icon-btn pull-left" href="{{route('sistemaevaluacion.index')}}"><i
                                    class="fa fa-fw fa-lg fa-times-circle"></i>Cancelar</a>
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
                    <p>Esta funcionalidad permite crear y actualizar el sistema de evaluación en el cual se determina la
                        forma como se asignará la calificación  aprobatoria, no aprobatoria y el comportamiento mismo del sistema.
                        <br>Agregue nuevos sitemas de evaluación. <br><strong>Nota:</strong> Solo un sistema de evaluación
                        puede ser el actual.</p>
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

        });
    </script>
@endsection
