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
    <li class="active"><a>Grupos</a></li>
</ol>
@endsection
@section('content')
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">GRUPOS</h3>
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
                            <td>{{$unidad->nombre." - ".$unidad->ciudad->nombre}}</td>
                            <td>{{$periodo->etiqueta." - ".$periodo->anio}}</td>
                            <td>{{$jornada->descripcion." - ".$jornada->jornadasnies}}</td>
                            <td>{{$grado->etiqueta}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-md-12">
            <h3>Crear Grupo</h3>
            <form class="form" role='form' method="POST" action="{{route('grupo.store')}}">
                <input type="hidden" name="jornada_id" value="{{$jornada->id}}" />
                <input type="hidden" name="unidad_id" value="{{$unidad->id}}" />
                <input type="hidden" name="grado_id" value="{{$grado->id}}" />
                <input type="hidden" name="periodoacademico_id" value="{{$periodo->id}}" />
                @csrf
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nombre</label>
                        <input class="form-control" type="text" required="required" maxlength="50" name="nombre">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Cupo</label>
                        <input class="form-control" type="number" name="cupo" required>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <button class="btn btn-success icon-btn pull-left" type="submit"><i class="fa fa-fw fa-lg fa-save"></i>Guardar</button>
                        <button class="btn btn-info icon-btn pull-left" type="reset"><i class="fa fa-fw fa-lg fa-trash-o"></i>Limpiar</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-12">
            <h3>Grupos en la Configuración Seleccionada</h3>
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr class="info">
                            <th>NOMBRE</th>
                            <th>CUPO</th>
                            <th>CUPO USADO</th>
                            <th>DIRECTOR DE GRUPO</th>
                            <th>ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($grupos as $g)
                        <tr>
                            <td>{{$g->nombre}}</td>
                            <td>{{$g->cupo}}</td>
                            <td>{{$g->cupousado}}</td>
                            <td>
                                @if($g->docente!=null)
                                {{$g->docente->personanatural->primer_nombre." ".$g->docente->personanatural->segundo_nombre." ".$g->docente->personanatural->primer_apellido." ".$g->docente->personanatural->segundo_apellido}}
                                @else
                                SIN DIRECTOR
                                @endif
                            </td>
                            <td>
                                @if($g->cupousado==0)
                                <a href="{{route('grupo.delete',$g->id)}}" style="margin-left: 10px; color:red;" data-toggle="tooltip" title="Eliminar Grupo" style="margin-left: 10px;"><i class="fa fa-trash-o"></i></a>
                                @endif
                                <a href="{{route('grupo.show',$g->id)}}" style="margin-left: 10px;" data-toggle="tooltip" title="Director de Grupo" style="margin-left: 10px;"><i class="fa fa-user"></i></a>
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
                <p>Esta funcionalidad permite al usuario crear y gestionar grupos o cursos para cada uno de los grados, este proceso es necesario para realizar la matrícula académica. Además puede asignar el docente director a cada grupo.</p>
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