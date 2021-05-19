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
    <li><a href="{{route('cargagrados.index')}}"><i class="fa fa-cogs"></i> Carga Académica de los Grados</a></li>
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
        <div class="col-md-6">
            <div class="callout callout-danger" style="padding: 5px; padding-left: 20px; text-align: center;">
                <h2>Todas las Materias</h2>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <input type="number" placeholder="Peso de la materia dentro del área" class="form-control" id="peso" />
                </div>
            </div>
            <div class="col-md-12">
                <div class="table-responsive">
                    <table id="tb" class="table table-bordered table-striped table-hover">
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
                                <td>{{$m->codigomateria}}</td>
                                <td>{{$m->nombre." (".$m->area->nombre.")"}}</td>
                                <td>
                                    <a onclick="agregar(this.id)" id="{{$unidad->id.';'.$periodo->id.';'.$jornada->id.';'.$grado->id.';'.$m->id}}" style="margin-left: 10px; cursor: pointer;" data-toggle="tooltip" title="Agregar Materia" style="margin-left: 10px;"><i class="fa fa-check"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="callout callout-danger" style="padding: 5px; padding-left: 20px; text-align: center;">
                <h2>Materias Cargadas al Grado</h2>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr class="danger">
                            <th>CÓDIGO</th>
                            <th>MATERIA</th>
                            <th>PESO</th>
                            <th>RETIRAR</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($materiassi as $ms)
                        <tr>
                            <td>{{$ms->materia->codigomateria}}</td>
                            <td>{{$ms->materia->nombre." (".$ms->materia->area->nombre.")"}}</td>
                            <td>{{$ms->peso}}%</td>
                            <td>
                                <a href="{{route('cargagrados.delete',$ms->id)}}" style="margin-left: 10px; color:red;" data-toggle="tooltip" title="Retirar Materia"><i class="fa fa-times"></i></a>
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
                <p>Esta funcionalidad permite al usuario gestionar la carga académica para cada uno de los grados, este proceso es necesario para realizar la matrícula académica.</p>
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
        $(document.body).attr('class', 'skin-blue sidebar-mini sidebar-collapse');
    });

    function agregar(id) {
        var peso = $("#peso").val();
        if (peso == '') {
            notify('Información', 'Debe indicar el peso de la materia dentro del área', 'warning');
            return;
        }
        var a = id.split(";");
        location.href = url + "academico/cargagrados/" + a[0] + "/" + a[1] + "/" + a[2] + "/" + a[3] + "/" + a[4] + "/" + peso + "/agregar";
    }
</script>
@endsection