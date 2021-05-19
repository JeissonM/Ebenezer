@extends('layouts.admin')
@section('breadcrumb')
<h1>
    Bienvenido
    <small>Sr(a). {{Auth::user()->nombres}}</small>
</h1>
<ol class="breadcrumb">
    <li><a href="{{route('home')}}"><i class="fa fa-home"></i> Inicio</a></li>
    <li><a href="{{route('menu.admisiones')}}"><i class="fa fa-users"></i> Admisiones</a></li>
    <li><a href="{{route('menu.admisiones')}}"><i class="fa fa-list-ul"></i> Datos de Admisión y Matrícula</a></li>
    <li class="active"><a>Documentos anexos</a></li>
</ol>
@endsection
@section('content')
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">LISTADO DE DOCUMENTOS ANEXOS</h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-toggle="modal" data-target="#modal" title="Ayuda">
                <i class="fa fa-question"></i></button>
            <a href="{{route('documentosanexos.create')}}" class="btn btn-box-tool" data-toggle="tooltip" data-original-title="Agregar Documento Anexo">
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
                        <th>CREADO</th>
                        <th>MODIFICADO</th>
                        <th>ACCIONES</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($documentoanexo as $documentoanexo)
                    <tr>
                        <td>{{$documentoanexo->id}}</td>
                        <td>{{$documentoanexo->nombre}}</td>
                        <td>{{$documentoanexo->created_at}}</td>
                        <td>{{$documentoanexo->updated_at}}</td>
                        <td>
                            <a href="{{route('documentosanexos.edit',$documentoanexo->id)}}" style="margin-left: 10px;" data-toggle="tooltip" title="Editar Documento Anexo" style="margin-left: 10px;"><i class="fa fa-edit"></i></a>
                            <a href="{{route('documentosanexos.delete',$documentoanexo->id)}}" style="color: red; margin-left: 10px;" data-toggle="tooltip" title="Eliminar Documento Anexo" style="margin-left: 10px;"><i class="fa fa-trash-o"></i></a>
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
                <p>Esta funcionalidad permitirá al usuario crear los documentos requeridos en cada uno de los procesos académicos (inscripción en línea, matrícula, entre otros) y que son exigidos por los respectivos grados en la institución.</p>
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