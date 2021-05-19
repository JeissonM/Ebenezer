@extends('layouts.admin')
@section('breadcrumb')
<h1>
    Bienvenido
    <small>Sr(a). {{Auth::user()->nombres}}</small>
</h1>
<ol class="breadcrumb">
    <li><a href="{{route('home')}}"><i class="fa fa-home"></i> Inicio</a></li>
    <li><a href="{{route('menu.admisiones')}}"><i class="fa fa-users"></i> Admisiones</a></li>
    <li><a href="{{route('menu.admisiones')}}"><i class="fa fa-list-ul"></i> Calendario, Procesos y Convocatorias</a></li>
    <li class="active"><a>Jornadas</a></li>
</ol>
@endsection
@section('content')
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">LISTADO DE JORNADAS</h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-toggle="modal" data-target="#modal" title="Ayuda">
                <i class="fa fa-question"></i></button>
            <a href="{{route('jornada.create')}}" class="btn btn-box-tool" data-toggle="tooltip" data-original-title="Agregar jornada">
                <i class="fa fa-plus-circle"></i></a>
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Minimizar">
                <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Cerrar">
                <i class="fa fa-times"></i></button>
        </div>
    </div>
    <div class="box-body">
        <div class="table-responsive">
            <table id="example1" class="table table-bordered table-striped table-hover">
                <thead>
                    <tr class="info">
                        <th>NOMBRE</th>
                        <th>DESDE - HASTA</th>
                        <th>JORNADA SNIES</th>
                        <th>FIN DE SEMANA</th>
                        <th>CREADO</th>
                        <th>MODIFICADO</th>
                        <th>ACCIONES</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($jornadas as $jornada)
                    <tr>
                        <td>{{$jornada->descripcion}}</td>
                        <td>{{$jornada->horainicio. " - ".$jornada->horafin}}</td>
                        <td>
                            @if($jornada->jornadasnies =='DIURNA')
                            {{"DIURNA"}}
                            @elseif($jornada->jornadasnies=='NOCTURNA')
                            {{"NOCTURNA"}}
                            @else
                            {{""}}
                            @endif
                        </td>
                        <td>
                            @if($jornada->findesemana=='SI')
                            <label class="label label-success">SI</label>
                            @elseif($jornada->findesemana=='NO')
                            <label class="label label-danger">NO</label>
                            @else
                            {{""}}
                            @endif
                        </td>
                        <td>{{$jornada->created_at}}</td>
                        <td>{{$jornada->updated_at}}</td>
                        <td>
                            <a href="{{route('jornada.edit',$jornada->id)}}" style="margin-left: 10px;" data-toggle="tooltip" title="Editar Jornada" style="margin-left: 10px;"><i class="fa fa-edit"></i></a>
                            <a href="{{route('jornada.delete',$jornada->id)}}" style="color: red; margin-left: 10px;" data-toggle="tooltip" title="Eliminar jornada" style="margin-left: 10px;"><i class="fa fa-trash-o"></i></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
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
                <p>Las jornadas de trabajo y estudio definen los horarios generales de la institución. La Jornada Diurna por ejemplo se define así: si el horario de clases para los alumnos de un programa académico oscila entre las 6:00 a.m. y las 6:00 p.m.</p>
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