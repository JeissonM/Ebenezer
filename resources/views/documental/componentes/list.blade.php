@extends('layouts.admin')
@section('breadcrumb')
<h1>
    Bienvenido
    <small>Sr(a). {{Auth::user()->nombres}}</small>
</h1>
<ol class="breadcrumb">
    <li><a href="{{route('home')}}"><i class="fa fa-home"></i> Inicio</a></li>
    <li><a href="{{route('menu.documental')}}"><i class="fa fa-book"></i> Documental</a></li>
    <li class="active"><a> Componentes</a></li>
</ol>
@endsection
@section('content')
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">LISTADO DE COMPONENTES</h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-toggle="modal" data-target="#modal" title="Ayuda">
                <i class="fa fa-question"></i></button>
            <a href="{{route('componente.create')}}" class="btn btn-box-tool" data-toggle="tooltip" data-original-title="Agregar Nuevo Componente">
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
                <table id="example1" class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr class="bg-purple">
                            <th>COMPONENTE</th>
                            <th>DESCRIPCIÓN</th>
                            <th>ÁREA</th>
                            <th>ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $d)
                        <tr>
                            <td>{{$d->componente}}</td>
                            <td>{{$d->descripcion}}</td>
                            <td>{{$d->area->nombre}}</td>
                            <td>
                                <a href="{{route('componente.edit',$d->id)}}" style="margin-left: 10px; color: blue;" data-toggle="tooltip" title="Editar" style="margin-left: 10px;"><i class="fa fa-edit"></i></a>
                                <a href="{{route('componente.delete',$d->id)}}" style="margin-left: 10px; color: red;" data-toggle="tooltip" title="Eliminar" style="margin-left: 10px;"><i class="fa fa-trash-o"></i></a>
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
                <p>Esta funcionalidad permite gestionar los componentes para los estándares.</p>
            </div>
            <div class="modal-footer" style="background-color: #d2d6de !important; opacity: .65;">
                <button type="button" class="btn btn-block btn-danger btn-flat pull-right" data-dismiss="modal"><i class="fa fa-reply"></i> Regresar
                </button>
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
        //$('#tb2').DataTable();
        //$(document.body).attr('class', 'skin-blue sidebar-mini sidebar-collapse');
    });
</script>
@endsection