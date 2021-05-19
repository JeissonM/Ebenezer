@extends('layouts.admin')
@section('breadcrumb')
<h1>
    Bienvenido
    <small>Sr(a). {{Auth::user()->nombres}}</small>
</h1>
<ol class="breadcrumb">
    <li><a href="{{route('home')}}"><i class="fa fa-home"></i> Inicio</a></li>
    <li><a href="{{route('menu.matricula')}}"><i class="fa fa-tasks"></i> Matrícula</a></li>
    <li><a href="{{route('menu.matricula')}}"><i class="fa fa-book"></i> Datos Básicos</a></li>
    <li class="active"><a>Materia</a></li>
</ol>
@endsection
@section('content')
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">LISTADO DE MATERIAS</h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-toggle="modal" data-target="#modal" title="Ayuda">
                <i class="fa fa-question"></i></button>
            <a href="{{route('materia.create')}}" class="btn btn-box-tool" data-toggle="tooltip" data-original-title="Agregar Materia">
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
                        <th>CODIGO MATERIA</th>
                        <th>NOMBRE</th>
                        <th>I.H.</th>
                        <!--<th>DESCRIPCION</th>-->
                        <th>RECUPERABLE</th>
                        <th>NIVELABLE</th>
                        <th>AREA</th>
                        <th>CREADO</th>
                        <th>MODIFICADO</th>
                        <th>ACCIONES</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($materias as $materia)
                    <tr>
                        <td>{{$materia->codigomateria}}</td>
                        <td>{{$materia->nombre}}</td>
                        <td>{{$materia->ih}}</td>
                        <!--<td>{{$materia->descripcion}}</td>-->
                        <td>{{$materia->recuperable}}</td>
                        <td>{{$materia->nivelable}}</td>
                        <td>{{$materia->area->nombre}}</td>
                        <td>{{$materia->created_at}}</td>
                        <td>{{$materia->updated_at}}</td>
                        <td>
                            <a href="{{route('materia.edit',$materia->id)}}" style="margin-left: 10px;" data-toggle="tooltip" title="Editar Materia" style="margin-left: 10px;"><i class="fa fa-edit"></i></a>
                            <a href="{{route('materia.show',$materia->id)}}" style="color: green; margin-left: 10px;" data-toggle="tooltip" title="Ver Materia" style="margin-left: 10px;"><i class="fa fa-eye"></i></a>
                            <a href="{{route('materia.delete',$materia->id)}}" style="color: red; margin-left: 10px;" data-toggle="tooltip" title="Eliminar Materia" style="margin-left: 10px;"><i class="fa fa-trash-o"></i></a>
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
                <p>Gestione las Areas o Naturalezas de las Materias definidas en el PEI. Escriba las iniciales de Área o naturaleza para agilizar la captura </p>
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