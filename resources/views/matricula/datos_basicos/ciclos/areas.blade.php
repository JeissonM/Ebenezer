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
    <li><a href="{{route('ciclo.index')}}"><i class="fa fa-bookmark"></i> Ciclos</a></li>
    <li class="active"><a>Áreas del Ciclo</a></li>
</ol>
@endsection
@section('content')
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">LISTADO DE ÁREAS DEL CICLO</h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-toggle="modal" data-target="#modal" title="Ayuda">
                <i class="fa fa-question"></i></button>
            <button type="button" class="btn btn-box-tool" data-toggle="modal" data-target="#modal2" title="Agregar Área">
                <i class="fa fa-plus-circle"></i></button>
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
                            <th>CICLO</th>
                            <th>DESCRIPCIÓN</th>
                            <th>TOTAL ÁREAS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{$ciclo->ciclo}}</td>
                            <td>{{$ciclo->descripcion}}</td>
                            <td>{{count($ciclo->cicloareas)}}</td>
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
                            <th>ÁREA</th>
                            <th>DESCRIPCIÓN</th>
                            <th>RETIRAR</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($ciclo->cicloareas)>0)
                        @foreach($ciclo->cicloareas as $a)
                        <tr>
                            <td>{{$a->area->nombre}}</td>
                            <td>{{$a->area->descripcion}}</td>
                            <td>
                                <a href="{{route('ciclo.deleteArea',$a->id)}}" style="color: red; margin-left: 10px;" data-toggle="tooltip" title="Eliminar Área del Ciclo" style="margin-left: 10px;"><i class="fa fa-trash-o"></i></a>
                            </td>
                        </tr>
                        @endforeach
                        @endif
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
                <p>Administre las áreas que componen un ciclo</p>
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


<div class="modal fade" id="modal2">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Agregar Área</h4>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table id="example2" class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr class="info">
                                <th>ÁREA</th>
                                <th>AGREGAR</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($areas as $key=>$value)
                            <tr>
                                <td>{{$value}}</td>
                                <td>
                                    <a href="{{route('ciclo.agregarArea',[$key,$ciclo->id])}}" style="margin-left: 10px;" data-toggle="tooltip" title="Agregar Área" style="margin-left: 10px;"><i class="fa fa-check"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
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
        $('#example2').DataTable();
    });
</script>
@endsection