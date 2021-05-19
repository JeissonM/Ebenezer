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
    <li class="active"><a>Ver Cuestionario</a></li>
</ol>
@endsection
@section('content')
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">VER CUESTIONARIO</h3>
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
        <div class="col-md-12">
            @component('layouts.errors')
            @endcomponent
        </div>
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr class="info">
                            <th>CUESTIONARIO</th>
                            <th>ESTADO</th>
                            <th>CIRCUNSCRIPCIÓN</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{$c->nombre." - ".$c->descripcion}}</td>
                            <td>@if($c->estado=='ACTIVA') <b class="text-success">{{$c->estado}}</b> @else <b class="text-danger">{{$c->estado}}</b> @endif</td>
                            <td>{{$c->circunscripcion->nombre." - ".$c->circunscripcion->descripcion}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-md-12">
            <h3>Preguntas del Cuestionario</h3>
            @if(count($c->cuestionariopreguntas)>0)
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr class="info">
                            <th>PREGUNTA</th>
                            <th>TIPO</th>
                            <th>ESTADO</th>
                            <th>SEGUNDA PREGUNTA</th>
                            <th>RESPUESTAS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($c->cuestionariopreguntas as $p)
                        @if($p->estado!='ELIMINADA')
                        <tr>
                            <td>{{$p->pregunta}}</td>
                            <td>{{$p->tipo}}</td>
                            <td>{{$p->estado}}</td>
                            <td>{{$p->segunda_pregunta}}</td>
                            <th>
                                @if(count($p->cuestionarioprespuestas)>0)
                                    <ol>
                                        @foreach($p->cuestionarioprespuestas as $r)
                                        <li>{{$r->respuesta}}</li>
                                        @endforeach
                                    </ol>
                                @else
                                <h5 class="text text-danger">Sin respuestas</h5>
                                @endif
                            </tr>
                        @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <h4 class="text text-danger">El cuestionario no tiene preguntas definidas</h4>
            @endif
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
        CKEDITOR.replace('contrato');
    });
</script>
@endsection