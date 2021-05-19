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
    <li><a href="{{route('agendacita.index')}}"><i class="fa fa-calendar-check-o"></i> Programar Agenda</a></li>
    <li class="active"><a>Fechas Programadas</a></li>
</ol>
@endsection
@section('content')
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">LISTADO DE FECHAS PROGRAMADAS</h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-toggle="modal" data-target="#modal" title="Ayuda">
                <i class="fa fa-question"></i></button>
            <a href="{{route('agendacita.crear',$aso->id)}}" class="btn btn-box-tool" data-toggle="tooltip" data-original-title="Agregar Fecha">
                <i class="fa fa-plus-circle"></i></a>
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
                            <th>PERÍODO ACADÉMICO</th>
                            <th>UNIDAD</th>
                            <th>JORNADA</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{$aso->periodoacademico->etiqueta." - ".$aso->periodoacademico->anio}}</td>
                            <td>{{$aso->unidad->nombre." - ".$aso->unidad->ciudad->nombre}}</td>
                            <td>{{$aso->jornada->descripcion}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-md-12">
            <div class="table-responsive">
                <table id="example1" class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr class="info">
                            <th>FECHA</th>
                            <th>HORA INICIO</th>
                            <th>HORA FIN</th>
                            <th>ESTADO</th>
                            <th>RETIRAR</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($agenda as $a)
                        <tr>
                            <td>{{$a->fecha}}</td>
                            <td>{{$a->horainicio}}</td>
                            <td>{{$a->horafin}}</td>
                            <td>{{$a->estado}}</td>
                            <td>
                                <a href="{{route('agendacita.delete',$a->id)}}" style="color: red; margin-left: 10px;" data-toggle="tooltip" title="Eliminar Horario" style="margin-left: 10px;"><i class="fa fa-trash-o"></i></a>
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
                <p>En éste apartado realice la asignación de fechas y horas para la realización de las entrevistas de admisión. Cuando un acudiente realice la inscripción del aspirante, es a partir de estas fechas donde podrá elegir el día y la hora para la entrevista del proceso de admisión..</p>
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
@endsection
@section('script')
<script type="text/javascript">
    $(document).ready(function () {
        $('#example1').DataTable();
    });
</script>
@endsection