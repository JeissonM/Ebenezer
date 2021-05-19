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
    <li class="active"><a>Ciclos</a></li>
</ol>
@endsection
@section('content')
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">LISTADO DE CICLOS</h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-toggle="modal" data-target="#modal" title="Ayuda">
                <i class="fa fa-question"></i></button>
            <a href="{{route('ciclo.create')}}" class="btn btn-box-tool" data-toggle="tooltip" data-original-title="Agregar Ciclo">
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
                        <th>CICLO</th>
                        <th>DESCRIPCIÓN</th>
                        <th>ÁREAS</th>
                        <th>GRADOS</th>
                        <th>ACCIONES</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $c)
                    <tr>
                        <td>{{$c->ciclo}}</td>
                        <td>{{$c->descripcion}}</td>
                        <td>
                            @if(count($c->cicloareas)>0)
                            @foreach($c->cicloareas as $ca)
                            {{$ca->area->nombre}} <br>
                            @endforeach
                            @endif
                        </td>
                        <td>
                            @if(count($c->ciclogrados)>0)
                            @foreach($c->ciclogrados as $ca)
                            {{$ca->grado->etiqueta}} <br>
                            @endforeach
                            @endif
                        </td>
                        <td>
                            <a href="{{route('ciclo.show',$c->id)}}" style="color: green; margin-left: 10px;" data-toggle="tooltip" title="Configurar Áreas del Ciclo" style="margin-left: 10px;"><i class="fa fa-arrow-right"></i></a>
                            <a href="{{route('ciclo.grados',$c->id)}}" style="color:blueviolet; margin-left: 10px;" data-toggle="tooltip" title="Configurar Grados del Ciclo" style="margin-left: 10px;"><i class="fa fa-bookmark-o"></i></a>
                            <a href="{{route('ciclo.edit',$c->id)}}" style="margin-left: 10px;" data-toggle="tooltip" title="Editar Ciclo" style="margin-left: 10px;"><i class="fa fa-edit"></i></a>
                            <a href="{{route('ciclo.delete',$c->id)}}" style="color: red; margin-left: 10px;" data-toggle="tooltip" title="Eliminar Ciclo" style="margin-left: 10px;"><i class="fa fa-trash-o"></i></a>
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
                <p>Gestione los diferentes ciclos para los grados (ejemplo: ciclo 1ro a 3ro).</p>
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