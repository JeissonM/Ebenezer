@extends('layouts.admin')
@section('breadcrumb')
<h1>
    Bienvenido
    <small>Sr(a). {{Auth::user()->nombres}}</small>
</h1>
<ol class="breadcrumb">
    <li><a href="{{route('home')}}"><i class="fa fa-home"></i> Inicio</a></li>
    <li><a href="{{route('menu.admisiones')}}"><i class="fa fa-users"></i> Admisiones</a></li>
    <li><a href="{{route('menu.admisiones')}}"><i class="fa fa-list-ul"></i> Calendario, Procesos y Convocatorias</a></li>
    <li><a href="{{route('convocatoria.index')}}"><i class="fa fa-calendar-plus-o"></i> Convocatorias</a></li>
    <li class="active"><a>Crear</a></li>
</ol>
@endsection
@section('content')
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">LISTADO DE CONVOCATORIAS</h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-toggle="modal" data-target="#modal" title="Ayuda">
                <i class="fa fa-question"></i></button>
            <button type="button" class="btn btn-box-tool" data-toggle="modal" data-target="#crear" title="Agregar Convocatoria">
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

            <div class="box-body">
                <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr class="info">
                                <th>ESTADO</th>
                                <th>CUPO</th>
                                <th>CUPO USADO</th>
                                <th>INSCRITOS</th>
                                <th>GRADO</th>
                                <th>PERIODO</th>
                                <th>UNIDAD</th>
                                <th>JORNADA</th>
                                <th>ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($conv as $p)
                            <tr>
                                <td>{{$p->estado}}</td>
                                <td>{{$p->cupo}}</td>
                                <td>{{$p->cupousado}}</td>
                                <td>{{$p->inscritos}}</td>
                                <td>{{$p->grado->etiqueta." - ".$p->grado->descripcion}}</td>
                                <td>{{$p->periodoacademico->etiqueta. " - ".$p->periodoacademico->anio}}</td>   
                                <td>{{$p->unidad->nombre." - ".$p->unidad->ciudad->nombre}}</td>
                                <td>{{$p->jornada->descripcion}}</td>
                                <td>
                                    <a href="{{route('convocatoria.edit',$p->id)}}" style="margin-left: 10px;" data-toggle="tooltip" title="Etidar Convocatoria" style="margin-left: 10px;"><i class="fa fa-edit"></i></a>
                                    <a href="{{route('convocatoria.delete',$p->id)}}" style="color: red; margin-left: 10px;" data-toggle="tooltip" title="Eliminar Convocatoria" style="margin-left: 10px;"><i class="fa fa-trash-o"></i></a>
                                </td>
                            </tr>
                            @endforeach
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
                <p>Gestione las convocatorias de inscripción, sus estados y asociela a los grados.</p>
            </div>
            <div class="modal-footer" style="background-color: #d2d6de !important; opacity: .65;">
                <button type="button"  class="btn btn-block btn-danger btn-flat pull-right" data-dismiss="modal"> <i class="fa fa-reply"></i> Regresar</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<!-- modal -->
<div class="modal fade" id="crear">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Nueva Convocatoria</h4>
            </div>
            <div class="modal-body">
                <form class="form" role='form' method="POST" action="{{route('convocatoria.store')}}">
                    @csrf
                    <input type="hidden" name="pu" value="{{$perund}}">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Cupo</label>
                            <input class="form-control" type="number" required="required" name="cupo">
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <label>Estado</label>
                            <select class="form-control"  style="width: 100%;" name="estado">
                                <option value="0">-- Seleccione una opción --</option>
                                <option value="CERRADA">CERRADA</option>
                                <option value="ABIERTA">ABIERTA</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Grados</label>
                            <select class="form-control select2" multiple="multiple" style="width: 100%;" name="grados[]" required="required">
                                <option value="0">-- Seleccione una opción --</option>
                                @foreach($grados as $key=>$value)
                                <option value="{{$key}}">{{$value}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12" style="margin-top: 20px !important">
                        <div class="form-group">
                            <button class="btn btn-success icon-btn pull-left" type="submit"><i class="fa fa-fw fa-lg fa-save"></i>Guardar</button>
                            <button class="btn btn-info icon-btn pull-left" type="reset"><i class="fa fa-fw fa-lg fa-trash-o"></i>Limpiar</button>
                            <button type="button"  class="btn btn-danger icon-btn pull-left" data-dismiss="modal"> <i class="fa fa-fw fa-lg fa-times-circle"></i> Cancelar</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
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
        $('.select2').select2();
    });
</script>
@endsection