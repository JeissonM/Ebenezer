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
    <li class="active"><a>Paises</a></li>
</ol>
@endsection
@section('content')
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">LISTADO DE PAISES</h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-toggle="modal" data-target="#modal" title="Ayuda">
                <i class="fa fa-question"></i></button>
            <a href="{{route('pais.create')}}" class="btn btn-box-tool" data-toggle="tooltip" data-original-title="Agregar Pais">
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
                        <th>ID</th>
                        <th>NOMBRE</th>
                        <th>CÓDIGO</th>
                        <th>CÓDIGO DANE</th>
                        <th>CREADO</th>
                        <th>MODIFICADO</th>
                        <th>ACCIONES</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($paises as $pais)
                    <tr>
                        <td>{{$pais->id}}</td>
                        <td>{{$pais->nombre}}</td>
                        <td>{{$pais->codigo}}</td>
                        <td>{{$pais->codigo_dos}}</td>
                        <td>{{$pais->created_at}}</td>
                        <td>{{$pais->updated_at}}</td>
                        <td>
                            <a href="{{route('pais.edit',$pais->id)}}" style="margin-left: 10px;" data-toggle="tooltip" title="Editar Pais" style="margin-left: 10px;"><i class="fa fa-edit"></i></a>
                            <a href="{{route('pais.show',$pais->id)}}" style="color: green; margin-left: 10px;" data-toggle="tooltip" title="Ver Pais" style="margin-left: 10px;"><i class="fa fa-eye"></i></a>
                            <a href="{{route('pais.delete',$pais->id)}}" style="color: red; margin-left: 10px;" data-toggle="tooltip" title="Eliminar Pais" style="margin-left: 10px;"><i class="fa fa-trash-o"></i></a>
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
                <p>Gestione los paises de todo el mundo.</p>
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