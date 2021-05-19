@extends('layouts.admin')
@section('breadcrumb')
<h1>
    Bienvenido
    <small>Sr(a). {{Auth::user()->nombres}}</small>
</h1>
<ol class="breadcrumb">
    <li><a href="{{route('home')}}"><i class="fa fa-home"></i> Inicio</a></li>
    <li><a href="{{route('menu.admisiones')}}"><i class="fa fa-users"></i> Admisiones</a></li>
    <li><a href="{{route('menu.admisiones')}}"><i class="fa fa-calendar-plus-o"></i> Agenda & Entrevista</a></li>
    <li><a href="{{route('examenadmision.index')}}"><i class="fa fa-list"></i> Examen Admisión</a></li>
    <li><a href="{{route('examenadmision.listaraspirantes',[$a->unidad_id,$a->periodoacademico_id,$a->jornada_id,$a->grado_id])}}"><i class="fa fa-user"></i> Aspirantes</a></li>
    <li class="active"><a>Examen</a></li>
</ol>
@endsection
@section('content')
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">EXAMEN DE ADMISIÓN</h3>
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
            <h3>Datos Aspirante</h3>
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr class="info">
                            <th>IDENTIFICACIÓN</th>
                            <th>ASPIRANTE</th>
                            <th>PERÍODO</th>
                            <th>JORNADA</th>
                            <th>UNIDAD</th>
                            <th>GRADO</th>
                            <th>ESTADO</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{$a->tipodoc->abreviatura." - ".$a->numero_documento}}</td>
                            <td>{{$a->primer_nombre." ".$a->segundo_nombre." ".$a->primer_apellido." ".$a->segundo_apellido}}</td>
                            <td>{{$a->periodoacademico->etiqueta." - ".$a->periodoacademico->anio}}</td>
                            <td>{{$a->jornada->descripcion." - ".$a->jornada->jornadasnies}}</td>
                            <td>{{$a->unidad->nombre}}</td>
                            <td>{{$a->grado->etiqueta}}</td>
                            <td>{{$a->estado}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <form class="form" enctype="multipart/form-data" role='form' method="POST" action="{{route('examenadmision.store')}}">
            @csrf
            <input type="hidden" value="{{$a->id}}" name="aspirante_id" />
            <input type="hidden" value="{{$e->id}}" name="examenadmision_id" />
            <div class="col-md-12">
                <h3>Datos Examen</h3>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr class="info">
                                <th>CALIFICACION ACTUAL</th>
                                <th>ANOTACIONES EXAMEN</th>
                                <th>ESTADO</th>
                                <th>DOCUMENTO SOPORTE (OPCIONAL)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{$e->calificacion}} - {{$e->valor_cualitativo}}</td>
                                <td><input class="form-control" placeholder="Anotaciones aquí..." value="{{$e->anotaciones}}" name="anotaciones" /></td>
                                <td>
                                    <select name="estado" class="form-control" required>
                                        @foreach($estados as $key=>$value)
                                        @if($e->estado==$key)
                                        <option value="{{$key}}" selected>{{$value}}</option>
                                        @else
                                        <option value="{{$key}}">{{$value}}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                @if($e->soporte!='NO') <a href="{{asset('/documentos/'.$e->soporte)}}" target="_blank">Ver documento soporte</a> @endif
                                    <div class="form-group">
                                        <label>Documento Soporte (Formatos JPG, PNG, PDF)</label>
                                        <input type="file" name="soporte" accept=".pdf,.jpg,.png" class="form-control" />
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-12">
                <h3>Áreas a Evaluar</h3>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr class="info">
                                <th>ÁREA</th>
                                <th>PESO</th>
                                <th>CALIFICACIÓN</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($areas as $i)
                            <tr>
                                <td>{{$i->areaexamenadmisiongrado->areaexamenadmision->nombre}}</td>
                                <td>{{$i->areaexamenadmisiongrado->peso}} %</td>
                                <td>
                                <input type="hidden" name="areas_id[]" value="{{$i->id}}" />
                                <input type="text" name="areas_val[]" value="{{$i->calificacion}}" />
                            </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-12" style="margin-top: 20px !important">
                <div class="form-group">
                    <button class="btn btn-success icon-btn pull-left" type="submit"><i class="fa fa-fw fa-lg fa-save"></i>Guardar</button>
                    <button class="btn btn-info icon-btn pull-left" type="reset"><i class="fa fa-fw fa-lg fa-trash-o"></i>Limpiar</button>
                    <a class="btn btn-danger icon-btn pull-left" href="{{route('examenadmision.listaraspirantes',[$a->unidad_id,$a->periodoacademico_id,$a->jornada_id,$a->grado_id])}}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancelar</a>
                </div>
            </div>
        </form>
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
                <p>Esta funcionalidad permite al usuario cargar las calificaciones de los aspirantes obtenidas en el examen de admisión.</p>
            </div>
            <div class="modal-footer" style="background-color: #d2d6de !important; opacity: .65;">
                <button type="button" class="btn btn-block btn-danger btn-flat pull-right" data-dismiss="modal"> <i class="fa fa-reply"></i> Regresar</button>
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
    });
</script>
@endsection