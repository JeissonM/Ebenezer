@extends('layouts.admin')
@section('breadcrumb')
<h1>
    Bienvenido
    <small>Sr(a). {{Auth::user()->nombres}}</small>
</h1>
<ol class="breadcrumb">
    <li><a href="{{route('home')}}"><i class="fa fa-home"></i> Inicio</a></li>
    <li><a href="{{route('menu.academico')}}"><i class="fa fa-book"></i> Académico</a></li>
    <li><a href="{{route('menu.academico')}}"><i class="fa fa-bookmark"></i> Carga Académica</a></li>
    <li><a href="{{route('cargagrupomatdoc.index')}}"><i class="fa fa-user"></i> Carga Académica de los Docentes</a></li>
    <li class="active"><a>Definir Carga</a></li>
</ol>
@endsection
@section('content')
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">DEFINIR CARGA</h3>
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
                        <tr class="danger">
                            <th>UNIDAD</th>
                            <th>PERÍODO ACADÉMICO</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{$unidad->nombre." - ".$unidad->ciudad->nombre}}</td>
                            <td>{{$periodo->etiqueta." - ".$periodo->anio}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr class="danger">
                            <th>JORNADA</th>
                            <th>GRADO</th>
                            <th>GRUPO</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{$jornada->descripcion." - ".$jornada->jornadasnies}}</td>
                            <td>{{$grado->etiqueta}}</td>
                            <td>@if($grupo!=null){{$grupo->nombre}}@endif</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-md-5">
            <div class="callout callout-danger" style="padding: 5px; padding-left: 20px; text-align: center;">
                <h2>Materias del Grado</h2>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr class="danger">
                            <th>CÓDIGO</th>
                            <th>MATERIA</th>
                            <th>AGREGAR</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($materias as $m)
                        <tr>
                            <td>{{$m->materia->codigomateria}}</td>
                            <td>{{$m->materia->nombre}}</td>
                            <td>
                                @if($grupo!=null)
                                <a href="{{route('cargagrupomatdoc.agregar',[$m->id,$grupo->id])}}" style="margin-left: 10px;" data-toggle="tooltip" title="Agregar Materia" style="margin-left: 10px;"><i class="fa fa-check"></i></a>
                                @else
                                NO HAY GRUPO
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-md-7">
            <div class="callout callout-danger" style="padding: 5px; padding-left: 20px; text-align: center;">
                <h2>Materias Cargadas al Grupo</h2>
            </div>
            <h4><b>Nota</b> Al seleccionar un docente nuevo, este será asignado automáticamente como el docente que dicta la cátedra.</h4>
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr class="danger">
                            <th>MATERIA & DOCENTE ACTUAL</th>
                            <th>CAMBIAR DOCENTE</th>
                            <th>RETIRAR</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($materiassi!=null)
                        @foreach($materiassi as $ms)
                        <tr>
                            <td>
                                {{$ms->gradomateria->materia->codigomateria." - ".$ms->gradomateria->materia->nombre}} --
                                @if($ms->docente!=null){{$ms->docente->personanatural->primer_nombre." ".$ms->docente->personanatural->segundo_nombre." ".$ms->docente->personanatural->primer_apellido." ".$ms->docente->personanatural->segundo_apellido}} @else SIN DOCENTE @endif
                            </td>
                            <td>
                                @if($docentes!=null)
                                <select class="select2" id="docente_id" onchange="cambiarDocente(this.value)">
                                    <option value="0_0">-- Seleccione Docente --</option>
                                    @foreach($docentes as $key=>$value)
                                    <option value="{{$key.'_'.$ms->id}}">{{$value}}</option>
                                    @endforeach
                                </select>
                                @else
                                NO HAY DOCENTES
                                @endif
                            </td>
                            <td>
                                <a href="{{route('cargagrupomatdoc.delete',$ms->id)}}" style="margin-left: 10px; color:red;" data-toggle="tooltip" title="Retirar Materia"><i class="fa fa-times"></i></a>
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
                <p>Esta funcionalidad permite al usuario gestionar la carga académica para cada uno de los docentes, este proceso es necesario para realizar la matrícula académica. <b>Antes de realizar éste proceso, debe diligenciar la carga académica para los grados</b></p>
                <p>Esta funcionalidad permite cargarle materias a los grupos y definir el docente que impartirá cada cátedra.</p>
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
        $('.select2').select2();
    });


    function cambiarDocente(id) {
        if (id != "0_0") {
            var v = id.split("_");
            location.href = url + "academico/cargagrupomatdoc/" + v[1] + "/" + v[0] + "/docente";
        } else {
            notify('Atención', 'Debe seleccionar un docente para proceder', 'error');
        }
    }
</script>
@endsection