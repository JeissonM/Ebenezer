@extends('layouts.admin')
@section('breadcrumb')
<h1>
    Bienvenido
    <small>Sr(a). {{Auth::user()->nombres}}</small>
</h1>
<ol class="breadcrumb">
    <li><a href="{{route('home')}}"><i class="fa fa-home"></i> Inicio</a></li>
    <li><a href="{{route('menu.matricula')}}"><i class="fa fa-tasks"></i> Matrícula</a></li>
    <li><a href="{{route('menu.matricula')}}"><i class="fa fa-cogs"></i> Datos Básicos</a></li>
    <li><a href="{{route('contenidoitem.index')}}"><i class="fa fa-book"></i> Contenido de Items de Materia</a></li>
    <li class="active"><a>Continuar</a></li>
</ol>
@endsection
@section('content')
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">LISTADO DE CONTENIDOS DE ITEMS DE LA MATERIA SEECCIONADA</h3>
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
        <div class="table-responsive">
            <table id="example1" class="table table-bordered table-striped table-hover">
                <thead>
                    <tr class="info">
                        <th>CONTENIDO</th>
                        <th>ITEM</th>
                        <th>MATERIA</th>
                        <th>ACCIONES</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($materia->contenidoitems)>0)
                    @foreach($materia->contenidoitems as $a)
                    <tr>
                        <td>{{$a->contenido}}</td>
                        <td>{{$a->itemcontenidomateria->descripcion}}</td>
                        <td>{{$a->materia->nombre}}</td>
                        <td>
                            <a href="{{route('contenidoitem.delete',$a->id)}}" style="margin-left: 10px; color: red;" data-toggle="tooltip" title="Eliminar Contenido" style="margin-left: 10px;"><i class="fa fa-trash-o"></i></a>
                        </td>
                    </tr>
                    @endforeach
                    @endif
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
                <p>Esta funcionalidad permite configurar los contenidos programáticos de cada materia ofertada en la institución. Seleccione la materia a configurar y presione el botón continuar.</p>
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