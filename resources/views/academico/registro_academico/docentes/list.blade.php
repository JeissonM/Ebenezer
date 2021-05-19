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
    <li class="active"><a> Docentes</a></li>
</ol>
@endsection
@section('content')
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">DOCENTES</h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-toggle="modal" data-target="#modal" title="Ayuda">
                <i class="fa fa-question"></i></button>
            <a href="{{route('docente.create')}}" class="btn btn-box-tool" data-toggle="tooltip" data-original-title="Agregar Docente">
                <i class="fa fa-plus-circle"></i></a>
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Minimizar">
                <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Cerrar">
                <i class="fa fa-times"></i></button>
        </div>
    </div>
    <div class="box-body">
        <div class="col-md-12">
            <h4>Para actualizar la información del docente vaya a <b>Académico > Carga Administrativa > Personas Naturales</b></h4>
            <div class="table-responsive">
                <table id="tb" class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr class="danger">
                            <th>TIPO DOCUMENTO</th>
                            <th>NÚMERO DOCUMENTO</th>
                            <th>DOCENTE</th>
                            <th>SITUACIÓN</th>
                            <th>CAMBIAR SITUACIÓN</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($docentes as $d)
                        <tr>
                            <td>{{$d->personanatural->persona->tipodoc->descripcion}}</td>
                            <td>{{$d->personanatural->persona->numero_documento}}</td>
                            <td>{{$d->personanatural->primer_nombre." ".$d->personanatural->segundo_nombre." ".$d->personanatural->primer_apellido." ".$d->personanatural->segundo_apellido}}</td>
                            <td>
                                <select id="situacion">
                                    @if($situaciones!=null)
                                    @foreach($situaciones as $key=>$value)
                                    @if($d->situacionadministrativa_id==$key)
                                    <option selected value="{{$key}}">{{$value}}</option>
                                    @else
                                    <option value="{{$key}}">{{$value}}</option>
                                    @endif
                                    @endforeach
                                    @endif
                                </select>
                            </td>
                            <td>
                                <a onclick="ir(this.id)" id="{{$d->id}}" style="margin-left: 10px; cursor: pointer;" data-toggle="tooltip" title="Cambiar Situación" style="margin-left: 10px;"><i class="fa fa-reply"></i></a>
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
                <p>Esta funcionalidad permite al usuario administrar los docentes de la institución.</p>
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

    function ir(id) {
        var s = $("#situacion").val();
        location.href = url + "academico/docente/" + id + "/" + s + "/situacion/cambiar";
    }
</script>
@endsection