@extends('layouts.admin')
@section('breadcrumb')
<h1>
    Bienvenido
    <small>Sr(a). {{Auth::user()->nombres}}</small>
</h1>
<ol class="breadcrumb">
    <li><a href="{{route('home')}}"><i class="fa fa-home"></i> Inicio</a></li>
    <li><a href="{{route('menu.matricula')}}"><i class="fa fa-check"></i> Matrícula</a></li>
    <li><a href="{{route('menu.matricula')}}"><i class="fa fa-check-circle-o"></i> Matrícula</a></li>
    <li><a href="{{route('grupo.index')}}"><i class="fa fa-users"></i> Gestión de Grupos</a></li>
    <li><a href="{{route('grupo.continuar',[$g->unidad_id,$g->periodoacademico_id,$g->jornada_id,$g->grado_id])}}"><i class="fa fa-bookmark"></i> Grupos</a></li>
    <li class="active"><a>Director de Grupo</a></li>
</ol>
@endsection
@section('content')
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">DIRECTOR DE GRUPO</h3>
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
                        <tr class="info">
                            <th>UNIDAD</th>
                            <th>PERÍODO ACADÉMICO</th>
                            <th>JORNADA</th>
                            <th>GRADO</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{$g->unidad->nombre." - ".$g->unidad->ciudad->nombre}}</td>
                            <td>{{$g->periodoacademico->etiqueta." - ".$g->periodoacademico->anio}}</td>
                            <td>{{$g->jornada->descripcion." - ".$g->jornada->jornadasnies}}</td>
                            <td>{{$g->grado->etiqueta}}</td>
                        </tr>
                    </tbody>
                </table>
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr class="info">
                            <th>GRUPO</th>
                            <th>CUPO PERMITIDO</th>
                            <th>CUPO USADO</th>
                            <th>DIRECTOR ACTUAL</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{$g->nombre}}</td>
                            <td>{{$g->cupo}}</td>
                            <td>{{$g->cupousado}}</td>
                            <td>@if($g->docente!=null){{$g->docente->personanatural->primer_nombre." ".$g->docente->personanatural->segundo_nombre." ".$g->docente->personanatural->primer_apellido." ".$g->docente->personanatural->segundo_apellido}}@else SIN DIRECTOR @endif</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-md-12">
            <h3>Docentes que pueden ser director</h3>
            <div class="table-responsive">
                <table id="tb" class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr class="info">
                            <th>DOCENTE</th>
                            <th>SELECCIONAR COMO DIRECTOR</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($docentes!=null)
                        @foreach($docentes as $d)
                        <tr>
                            <td>{{$d->personanatural->primer_nombre." ".$d->personanatural->segundo_nombre." ".$d->personanatural->primer_apellido." ".$d->personanatural->segundo_apellido}}</td>
                            <td>
                                <a href="{{route('grupo.asignardirector',[$g->id,$d->id])}}" style="margin-left: 10px;" data-toggle="tooltip" title="Seleccionar Como Director de Grupo" style="margin-left: 10px;"><i class="fa fa-check"></i></a>
                            </td>
                        </tr>
                        @endforeach
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
                <p>Esta funcionalidad permite al usuario asignar el docente director a cada grupo.</p>
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
        $('#tb').DataTable();
    });
</script>
@endsection