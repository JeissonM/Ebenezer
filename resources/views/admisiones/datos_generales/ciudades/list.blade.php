@extends('layouts.admin')
@section('breadcrumb')
<h1>
    Bienvenido
    <small>Sr(a). {{Auth::user()->nombres}}</small>
</h1>
<ol class="breadcrumb">
    <li><a href="{{route('home')}}"><i class="fa fa-home"></i> Inicio</a></li>
    <li><a href="{{route('menu.admisiones')}}"><i class="fa fa-users"></i> Admisiones</a></li>
    <li><a href="{{route('menu.admisiones')}}"><i class="fa fa-cogs"></i> Datos Básicos</a></li>
    <li class="active"><a>Ciudades</a></li>
</ol>
@endsection
@section('content')
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">LISTADO DE CIUDADES</h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-toggle="modal" data-target="#modal" title="Ayuda">
                <i class="fa fa-question"></i></button>
            <a href="{{route('ciudad.create')}}" class="btn btn-box-tool" data-toggle="tooltip" data-original-title="Agregar Ciudad">
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
                        <th>ESTADO</th>
                        <th>DEPARTAMENTO</th>
                        <th>CÓDIGO PAIS</th>
                        <th>CREADO</th>
                        <th>MODIFICADO</th>
                        <th>ACCIONES</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($ciudades as $ciudad)
                    <tr>
                        <td>{{$ciudad->nombre}}</td>
                        @if($ciudad->estado_dpto==1)
                        <td><span class="label label-success">ACTIVO</span></td>
                        @else
                        <td><span class="label label-danger">INACTIVO</span></td>
                        @endif
                        @if($ciudad->estado!==null)
                        <td>{{$ciudad->estado->nombre}}</td>
                        @else
                        <td></td>
                        @endif
                        <td>{{$ciudad->codigo_pais}}</td>
                        <td>{{$ciudad->created_at}}</td>
                        <td>{{$ciudad->updated_at}}</td>
                        <td>
                            <a href="{{route('ciudad.edit',$ciudad->id)}}" style="margin-left: 10px;" data-toggle="tooltip" title="Editar Departamento" style="margin-left: 10px;"><i class="fa fa-edit"></i></a>
                            <a href="{{route('ciudad.show',$ciudad->id)}}" style="color: green; margin-left: 10px;" data-toggle="tooltip" title="Ver Departamento" style="margin-left: 10px;"><i class="fa fa-eye"></i></a>
                            <a href="{{route('ciudad.delete',$ciudad->id)}}" style="color: red; margin-left: 10px;" data-toggle="tooltip" title="Eliminar Departamento" style="margin-left: 10px;"><i class="fa fa-trash-o"></i></a>
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
                <p>Gestione las ciudades o municipios de los paises de todo el mundo. Si desea buscar las ciudades de un país escriba en la búsqueda el código abreviado del país, ejemplo: para Colombia escriba COL</p>
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