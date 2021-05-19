@extends('layouts.admin')
@section('breadcrumb')
<h1>
    Bienvenido
    <small>Sr(a). {{Auth::user()->nombres}}</small>
</h1>
<ol class="breadcrumb">
    <li><a href="{{route('menu.admisiones')}}"><i class="fa fa-users"></i> Admisiones</a></li>
    <li><a href="{{route('menu.admisiones')}}"><i class="fa fa-calendar-plus-o"></i> Agenda & Entrevista</a></li>
    <li><a href="{{route('admitiraspirantes.index')}}"><i class="fa fa-check"></i> Admitir Aspirantes</a></li>
    <li><a href="{{route('admitiraspirantes.listaraspirantes',[$a->unidad_id,$a->periodoacademico_id,$a->jornada_id,$a->grado_id])}}"><i class="fa fa-user"></i> Aspirantes</a></li>
    <li class="active"><a> Admitir</a></li>
</ol>
@endsection
@section('content')
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">ADMITIR</h3>
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
        <div class="col-md-12">
            <h3>Requisitos</h3>
            @if($requisitos!=null)
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr class="info">
                            <th>REQUISITO</th>
                            <th style="text-align: center;">CUMPLIDO</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($requisitos as $r)
                        <tr>
                            <td>{{$r->documentoanexo->nombre}}</td>
                            <td style="text-align: center;">
                                @if($r->esta=='SI')
                                <a><i style="color: green; font-size: 18px;" class="fa fa-check"></i></a>
                                @else
                                <a><i style="color: red; font-size: 18px;" class="fa fa-times"></i></a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <h3 class="text text-center text-danger">No hay requisitos definidos para el aspirante.</h3>
            @endif
        </div>
        <div class="col-md-12">
            <h3>Entrevista</h3>
            @if($e!=null)
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr class="info">
                            <th>ENTREVISTA</th>
                            <th>ANOTACIONES ENTREVISTA</th>
                            <th>ESTADO</th>
                            <th>CITA</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{$e->nombre." - ".$e->descripcion}}</td>
                            <td>{{$e->anotaciones}}</td>
                            <td><b>{{$e->estado}}</b></td>
                            <td>{{$e->agendacita->fecha." - DE ".$horai." A ".$horaf}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            @else
            <h3 class="text text-center text-danger">No hay entrevista definida para el aspirante.</h3>
            @endif
        </div>
        <div class="col-md-12">
            <h3>Examen Admisión</h3>
            @if($examen!=null)
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr class="info">
                            <th>CALIFICACIÓN</th>
                            <th>ESTADO</th>
                            <th>ANOTACIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{$examen->calificacion." - ".$examen->valor_c}}</td>
                            <td><b>{{$examen->estado}}</b></td>
                            <td>{{$examen->anotaciones}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr class="info">
                            <th>ÁREA</th>
                            <th>CALIFICACIÓN</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($examen->examenadmisionareas as $c)
                        <tr>
                            <td>{{$c->areaexamenadmisiongrado->areaexamenadmision->nombre}}</td>
                            <td>{{$c->calificacion}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <h3 class="text text-center text-danger">No hay examen de admisión definido para el aspirante.</h3>
            @endif
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <a href="{{route('admitiraspirantes.admitir',[$a->id,'ADMITIDO'])}}" class="btn btn-success icon-btn pull-left"><i class="fa fa-fw fa-lg fa-check"></i>ADMITIR</a>
                <a href="{{route('admitiraspirantes.admitir',[$a->id,'RECHAZADO'])}}" class="btn btn-info icon-btn pull-left"><i class="fa fa-fw fa-lg fa-times"></i>RECHAZAR</a>
                <a class="btn btn-danger icon-btn pull-left" href="{{route('admitiraspirantes.listaraspirantes',[$a->unidad_id,$a->periodoacademico_id,$a->jornada_id,$a->grado_id])}}"><i class="fa fa-fw fa-lg fa-times-circle"></i>CANCELAR</a>
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
                <p>Esta funcionalidad permite al usuario realizar la admisión o rechazo de los aspirantes a la institución.</p>
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