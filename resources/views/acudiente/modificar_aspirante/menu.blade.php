@extends('layouts.admin')
@section('breadcrumb')
<h1>
    Bienvenido
    <small>Sr(a). {{Auth::user()->nombres}}</small>
</h1>
<ol class="breadcrumb">
    <li><a href="{{route('home')}}"><i class="fa fa-home"></i> Inicio</a></li>
    <li><a href="{{route('menu.inscripcion')}}"><i class="fa fa-edit"></i> Inscripción</a></li>
    <li><a href="{{route('aspirante.lista')}}"><i class="fa fa-edit"></i> Modificar Aspirantes</a></li>
    <li class="active"><a>Menú</a></li>
</ol>
@endsection
@section('content')
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">MENÚ MODIFICAR ASPIRANTES</h3>
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
            @component('layouts.errors')
            @endcomponent
        </div>
        <div class="col-md-12">
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
            <div class="col-md-6">
                <a href="{{route('aspirante.modaspirante',$a->id)}}" class="btn btn-success btn-raised btn-block btn-flat"> DATOS PERSONALES Y ACADÉMICOS DEL ASPIRANTE</a>
            </div>
            <div class="col-md-6">
                <a href="{{route('aspirante.modcomplementarios',$a->id)}}" class="btn btn-success btn-raised btn-block btn-flat"> DATOS COMPLEMENTARIOS DEL ASPIRANTE</a>
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
                <p>Esta funcionalidad permitirá al usuario modificar los datos de los aspirantes siempre y cuando no se haya programado una cita para la entrevista.</p>
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
        $('.select2').select2();
    });
</script>
@endsection