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
        <li><a href="{{route('ceremonia.index')}}"><i class="fa fa-graduation-cap"></i> Ceremonia</a></li>
        <li class="active"><a> Crear</a></li>
    </ol>
@endsection
@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">EDITAR CEREMONIA</h3>
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
                <form class="form" role='form' method="POST"
                      action="{{route('ceremonia.update',$ceremonia->id)}}">
                    @csrf
                    <input name="_method" type="hidden" value="PUT"/>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Titulo</label>
                            <input class="form-control" type="text" placeholder="Titulo de la ceremonia" required="required"
                                   value="{{$ceremonia->titulo}}" name="titulo">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Lugar</label>
                            <input class="form-control" type="text" value="{{$ceremonia->lugar}}" required="required"
                                   placeholder="Lugar de la ceremonia" name="lugar">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Fecha Inicial Actual({{$ceremonia->fechahorainicio}})</label>
                            <input class="form-control" type="datetime-local" value="{{$ceremonia->fechahorainicio}}"
                                   placeholder="Fecha y hora inical" name="fechahorainicio">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Fecha Final Actual({{$ceremonia->fechahorafin}})</label>
                            <input class="form-control" type="datetime-local" placeholder="Fecha y hora final"
                                   value="{{$ceremonia->fechahorafin}}" name="fechahorafin">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Grado</label>
                            <select class="form-control" id="grado_id" name="grado_id" required="required">
                                @foreach($grados as $key=>$value)
                                    @if($key == $ceremonia->grado_id)
                                        <option selected value="{{$key}}">{{$value}}</option>
                                    @else
                                        <option value="{{$key}}">{{$value}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Unidad Académica o Sede</label>
                            <select class="form-control" id="unidad_id" name="unidad_id" required="required">
                                @foreach($unidades as $key=>$value)
                                    @if($key == $ceremonia->unidad_id)
                                        <option selected value="{{$key}}">{{$value}}</option>
                                    @else
                                        <option value="{{$key}}">{{$value}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Jornada</label>
                            <select class="form-control" id="jornada_id" name="jornada_id" required="required">
                                @foreach($jornadas as $key=>$value)
                                    @if($key == $ceremonia->jornada_id)
                                        <option selected value="{{$key}}">{{$value}}</option>
                                    @else
                                        <option value="{{$key}}">{{$value}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Período Académico</label>
                            <select class="form-control" id="periodoacademicop_id" name="periodoacademico_id" required="required">
                                @foreach($periodos as $key=>$value)
                                    @if($key == $ceremonia->periodoacademico_id)
                                        <option selected value="{{$key}}">{{$value}}</option>
                                    @else
                                        <option value="{{$key}}">{{$value}}</option>
                                    @endif
                                @endforeach
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
                            <a class="btn btn-danger icon-btn pull-left" href="{{route('ceremonia.index')}}"><i
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
                        forma como se asignará la calificación aprobatoria, no aprobatoria y el comportamiento mismo del
                        sistema.
                        <br>Edite el sitemas de evaluación seleccionado. <br><strong>Nota:</strong> Solo un sistema de
                        evaluación
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
