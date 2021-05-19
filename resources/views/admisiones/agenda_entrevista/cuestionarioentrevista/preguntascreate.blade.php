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
    <li><a href="{{route('cuestionarioentrevista.continuar',$c->id)}}"><i class="fa fa-question"></i> Preguntas</a></li>
    <li class="active"><a>Crear Pregunta</a></li>
</ol>
@endsection
@section('content')
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">CREAR PREGUNTA</h3>
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
            <form class="form" role='form' method="POST" action="{{route('cuestionarioentrevista.preguntastore')}}">
                @csrf
                <input type="hidden" value="{{$c->id}}" name="cuestionarioentrevista_id" />
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Pregunta*</label>
                        <input class="form-control" type="text" name="pregunta" required />
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Tipo*</label>
                        <select class="form-control" name="tipo" id="tipo" required onchange="mostrar()">
                            <option value="NORMAL">NORMAL</option>
                            <option value="RESPONDA">RESPONDA</option>
                            <option value="OTRA-PREGUNTA">OTRA PREGUNTA</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Estado Pregunta*</label>
                        <select class="form-control" name="estado" required>
                            <option value="ACTIVA">ACTIVA</option>
                            <option value="INACTIVA">INACTIVA</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4" style="display: none;" id="mostrar">
                    <div class="form-group">
                        <label>Segunda Pregunta</label>
                        <input class="form-control" type="text" name="segunda_pregunta" />
                    </div>
                </div>
                <div class="col-md-12" style="margin-top: 20px !important">
                    <div class="form-group">
                        <button class="btn btn-success icon-btn pull-left" type="submit"><i class="fa fa-fw fa-lg fa-save"></i>Guardar</button>
                        <button class="btn btn-info icon-btn pull-left" type="reset"><i class="fa fa-fw fa-lg fa-trash-o"></i>Limpiar</button>
                        <a class="btn btn-danger icon-btn pull-left" href="{{route('cuestionarioentrevista.continuar',$c->id)}}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancelar</a>
                    </div>
                </div>
            </form>
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
                <p>Esta funcionalidad permite al usuario crear y configurar las preguntas de los cuestionarios que se realizarán a los aspirantes en la entrevista de admisión.</p>
                <p>Tenga en cuenta los tipos de pregunta para saber cual se adapta a su necesidad:</p>
                <ol>
                    <li><b>NORMAL</b> Pregunta de selección multiple con única respuesta, tendrá tantas opciones de respuesta como el usuario defina.</li>
                    <li><b>RESPONDA</b> Pregunta que requiere de una respuesta escrita.</li>
                    <li><b>OTRA-PREGUNTA</b> Pregunta de selección multiple con única respuesta dentro de la selección, sin embargo, tendrá una segunda pregunta asociada cuya respuesta deberá ser dada de manera escrita. Por ejemplo: Pregunta 1. ¿Tiene usted algún tipo de discapacidad? A. Física, B. Visual, C. No sabe, D. Otra, Pregunta 2. ¿Escriba Cual?</li>
                </ol>
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


    function mostrar() {
        var op = $("#tipo").val();
        if (op == 'OTRA-PREGUNTA') {
            $("#mostrar").attr('style', 'display: block');
        } else {
            $("#mostrar").attr('style', 'display: none');
        }

    }
</script>
@endsection