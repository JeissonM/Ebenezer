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
    <li class="active"><a>Cuestionarios Entrevista</a></li>
</ol>
@endsection
@section('content')
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">LISTADO DE CUESTIONARIOS DE ENTREVISTAS</h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-toggle="modal" data-target="#modal" title="Ayuda">
                <i class="fa fa-question"></i></button>
            <a href="{{route('cuestionarioentrevista.create')}}" class="btn btn-box-tool" data-toggle="tooltip" data-original-title="Agregar Cuestionario">
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
                        <th>CUESTIONARIO</th>
                        <th>ESTADO</th>
                        <th>CIRCUNSCRIPCIÓN</th>
                        <th>ACIONES</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cuestionarios as $c)
                    <tr>
                        <td>{{$c->nombre." - ".$c->descripcion}}</td>
                        <td>@if($c->estado=='ACTIVA') <b class="text-success">{{$c->estado}}</b> @else <b class="text-danger">{{$c->estado}}</b> @endif</td>
                        <td>{{$c->circunscripcion->nombre." - ".$c->circunscripcion->descripcion}}</td>
                        <td>
                            <a href="{{route('cuestionarioentrevista.edit',$c->id)}}" style="margin-left: 10px;" data-toggle="tooltip" title="Modificar Cuestionario"><i class="fa fa-edit"></i></a>
                            <a href="{{route('cuestionarioentrevista.show',$c->id)}}" style="margin-left: 10px; color: green;" data-toggle="tooltip" title="Ver Cuestionario"><i class="fa fa-eye"></i></a>
                            <a href="{{route('cuestionarioentrevista.continuar',$c->id)}}" style="margin-left: 10px; color: blue;" data-toggle="tooltip" title="Gestionar Cuestionario"><i class="fa fa-arrow-right"></i></a>
                            <a href="{{route('cuestionarioentrevista.delete',$c->id)}}" style="margin-left: 10px; color: red;" data-toggle="tooltip" title="Eliminar Cuestionario"><i class="fa fa-trash-o"></i></a>
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
                <p>Esta funcionalidad permite al usuario crear, configurar y gestionar los cuestionarios que se realizarán a los aspirantes en la entrevista de admisión.</p>
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