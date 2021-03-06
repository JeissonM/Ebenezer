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
    <li><a href="{{route('cuestionarioentrevista.index')}}"><i class="fa fa-question"></i> Cuestionarios Entrevista</a></li>
    <li><a href="{{route('cuestionarioentrevista.continuar',$p->cuestionarioentrevista_id)}}"><i class="fa fa-question"></i> Preguntas</a></li>
    <li class="active"><a> Respuestas</a></li>
</ol>
@endsection
@section('content')
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">RESPUESTAS DE LA PREGUNTA INDICADA</h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-toggle="modal" data-target="#modal" title="Ayuda">
                <i class="fa fa-question"></i></button>
            <a href="{{route('cuestionarioentrevista.respuestacreate',$p->id)}}" class="btn btn-box-tool" data-toggle="tooltip" data-original-title="Agregar Respuesta">
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
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr class="info">
                            <th>CUESTIONARIO</th>
                            <th>ESTADO</th>
                            <th>CIRCUNSCRIPCI??N</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{$p->cuestionarioentrevista->nombre." - ".$p->cuestionarioentrevista->descripcion}}</td>
                            <td>@if($p->cuestionarioentrevista->estado=='ACTIVA') <b class="text-success">{{$p->cuestionarioentrevista->estado}}</b> @else <b class="text-danger">{{$p->cuestionarioentrevista->estado}}</b> @endif</td>
                            <td>{{$p->cuestionarioentrevista->circunscripcion->nombre." - ".$p->cuestionarioentrevista->circunscripcion->descripcion}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr class="info">
                            <th>PREGUNTA</th>
                            <th>TIPO</th>
                            <th>ESTADO</th>
                            <th>SEGUNDA PREGUNTA</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{$p->pregunta}}</td>
                            <td>{{$p->tipo}}</td>
                            <td>{{$p->estado}}</td>
                            <td>{{$p->segunda_pregunta}}</td>
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
                            <th>ID</th>
                            <th>RESPUESTA</th>
                            <th>ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($p->cuestionarioprespuestas as $r)
                        <tr>
                            <td>{{$r->id}}</td>
                            <td>{{$r->respuesta}}</td>
                            <th>
                                <a href="{{route('cuestionarioentrevista.respuestadelete',$r->id)}}" style="margin-left: 10px; color: red;" data-toggle="tooltip" title="Eliminar Respuesta"><i class="fa fa-trash-o"></i></a>
                            </th>
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
                <h4 class="modal-title">Informaci??n de Ayuda</h4>
            </div>
            <div class="modal-body">
                <p>Esta funcionalidad permite al usuario crear y configurar las preguntas de los cuestionarios que se realizar??n a los aspirantes en la entrevista de admisi??n.</p>
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