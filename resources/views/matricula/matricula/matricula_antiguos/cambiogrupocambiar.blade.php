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
    <li><a href="{{route('matricularantiguos.create')}}"><i class="fa fa-reply"></i> Cambio de Grupo Matriculado</a></li>
    <li class="active"><a>Cambiar</a></li>
</ol>
@endsection
@section('content')
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">CAMBIAR GRUPO MATRICULADO</h3>
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
            <h3>Estudiante</h3>
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr class="danger">
                            <th>IDENTIFICACIÓN</th>
                            <th>ESTUDIANTE</th>
                            <th>SITUACIÓN</th>
                            <th>CATEGORÍA</th>
                            <th>ESTADO</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{$e->personanatural->persona->numero_documento}}</td>
                            <td>{{$e->personanatural->primer_nombre." ".$e->personanatural->segundo_nombre." ".$e->personanatural->primer_apellido." ".$e->personanatural->segundo_apellido}}</td>
                            <td>{{$e->situacionestudiante->nombre}}</td>
                            <td>{{$e->categoria->nombre}}</td>
                            <td>{{$e->estado}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-md-12">
            <h3>Matrícula Académica</h3>
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr class="danger">
                            <th>UNIDAD</th>
                            <th>PERÍODO</th>
                            <th>JORNADA</th>
                            <th>GRADO</th>
                            <th>GRUPO MATRICULADO</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{$grupo->unidad->nombre}}</td>
                            <td>{{$grupo->periodoacademico->etiqueta." - ".$grupo->periodoacademico->anio}}</td>
                            <td>{{$grupo->jornada->descripcion}}</td>
                            <td>{{$grupo->grado->etiqueta}}</td>
                            <td>{{$grupo->nombre}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-md-12">
            <h3>Grupos Disponibles</h3>
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr class="danger">
                            <th>GRUPO</th>
                            <th>CUPO</th>
                            <th>CUPO USADO</th>
                            <th>CAMBIAR A ÉSTE GRUPO</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($grupos as $g)
                        <tr>
                            <td>{{$g->nombre}}</td>
                            <td>{{$g->cupo}}</td>
                            <td>{{$g->cupousado}}</td>
                            <td>
                                @if($grupo->id!=$g->id)
                                <a href="{{route('matricularantiguos.cambiar',[$grupo->eg_id,$g->id])}}" style='margin-left: 10px; cursor: pointer;' data-toggle='tooltip' title='Cambiar'><i class='fa fa-reply'></i> CAMBIAR GRUPO</a>
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
                <p>Esta funcionalidad permite al usuario cambiar de un grupo a otro a un estudiante matriculado.</p>
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

    function matricular(estudiante) {
        var grupo = $('#grupo').val();
        if (grupo == null) {
            notify('Atención', 'Seleccione grupo para continuar', 'warning');
            return;
        }
        $.ajax({
            type: 'GET',
            url: url + "matricula/matricularantiguos/matricula/estudiantes/antiguos/" + grupo + "/" + estudiante + "/matricular",
            data: {},
        }).done(function(msg) {
            var m = JSON.parse(msg);
            notify('Atención', m.mensaje, m.tipo);
            cargarConMatricula();
            cargarSinMatricula();
        });
    }
</script>
@endsection