@extends('layouts.admin')
@section('breadcrumb')
    <h1>
        Bienvenido
        <small>Sr(a). {{Auth::user()->nombres}}</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{route('home')}}"><i class="fa fa-home"></i> Inicio</a></li>
        <li><a href="{{route('menu.aulavirtual')}}"><i class="fa fa-vimeo"></i> Aula Virtual</a></li>
        <li><a href="{{route('aulavirtual.docenteinicio')}}"><i class="fa fa-home"></i> Inicio Docente</a></li>
        <li><a href="{{route('aulavirtual.menuauladocente',$gmd->id)}}"><i class="fa fa-list"></i> Panel Aula
                Virtual</a></li>
        <li><a href="{{route('actividad.index',$gmd->id)}}"><i class="fa fa-list-ol"></i> Banco de Actividades</a></li>
        <li class="active"><a> Ver</a></li>
    </ol>
@endsection
@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">BANCO DE ACTIVIDADES</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-toggle="modal" data-target="#modal" title="Ayuda">
                    <i class="fa fa-question"></i></button>
                <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                        title="Minimizar">
                    <i class="fa fa-minus"></i></button>
                <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip"
                        title="Cerrar">
                    <i class="fa fa-times"></i></button>
            </div>
        </div>
        <div class="box-body">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                        <tr class="danger">
                            <th>UNIDAD</th>
                            <th>PERÍODO ACADÉMICO</th>
                            <th>JORNADA</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>{{$gmd->gradomateria->unidad->nombre." - ".$gmd->gradomateria->unidad->ciudad->nombre}}</td>
                            <td>{{$gmd->gradomateria->periodoacademico->etiqueta." - ".$gmd->gradomateria->periodoacademico->anio}}</td>
                            <td>{{$gmd->gradomateria->jornada->descripcion." - ".$gmd->gradomateria->jornada->jornadasnies}}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                        <tr class="danger">
                            <th>GRADO</th>
                            <th>GRUPO</th>
                            <th>MATERIA</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>{{$gmd->gradomateria->grado->etiqueta}}</td>
                            <td>{{$gmd->grupo->nombre}}</td>
                            <td>{{$gmd->gradomateria->materia->codigomateria." - ".$gmd->gradomateria->materia->nombre}}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-12">
                <h4>Datos de la Actividad</h4>
                <table class="table table-hover">
                    <tbody>
                    <tr class="read">
                        <td class="contact"><b>Id</b></td>
                        <td class="subject">{{$a->id}}</td>
                    </tr>
                    <tr class="read">
                        <td class="contact"><b>Nombre</b></td>
                        <td class="subject">{{$a->nombre}}</td>
                    </tr>
                    <tr class="read">
                        <td class="contact"><b>Descripción</b></td>
                        <td class="subject">{{$a->descripcion}}</td>
                    </tr>
                    <tr class="read">
                        <td class="contact"><b>¿Es un Documento?</b></td>
                        <td class="subject">@if($a->recurso!='NO')<span class="label label-success">SI</span>@else<span
                                class="label label-danger">NO</span>@endif</td>
                    </tr>
                    <tr class="read">
                        <td class="contact"><b>Tipo de Actividad</b></td>
                        <td class="subject">{{$a->tipo}}</td>
                    </tr>
                    <tr class="read">
                        <td class="contact"><b>Autor</b></td>
                        <td class="subject">{{$a->user->nombres." ".$a->user->apellidos}}</td>
                    </tr>
                    <tr class="read">
                        <td class="contact"><b>Evaluación Académica</b></td>
                        <td class="subject">{{$a->evaluacionacademica->nombre." (".$a->evaluacionacademica->peso."%)"}}</td>
                    </tr>
                    <tr class="read">
                        <td class="concact"><b>Unidad</b></td>
                        <td class="subject">{{$a->ctunidadtema->ctunidad->nombre}}</td>
                    </tr>
                    <tr class="read">
                        <td class="concact"><b>Tema</b></td>
                        <td class="subject">{{$a->ctunidadtema->titulo}}</td>
                    </tr>
                    <tr class="read">
                        <td class="contact"><b>Creado</b></td>
                        <td class="subject">{{$a->created_at}}</td>
                    </tr>
                    <tr class="read">
                        <td class="contact"><b>Modificado</b></td>
                        <td class="subject">{{$a->updated_at}}</td>
                    </tr>
                    @foreach($a->ctunidadestandaraprendizajes as $item)
                        <tr class="read">
                            <td class="contact danger" colspan="2" style="border-radius: 10px;font-size: 12px">
                                <center><b>{{$item->aprendizaje->logro}}</b></center>
                            </td>
                        </tr>
                        <tr class="read">
                            <td class="contact"><b>Estandar</b></td>
                            <td class="subject">{{$item->aprendizaje->estandarcomponente->estandar->titulo}}</td>
                        </tr>
                        <tr class="read">
                            <td class="contact"><b>Componente</b></td>
                            <td class="subject">{{$item->aprendizaje->componentecompetencia->componente->componente}}</td>
                        </tr>
                        <tr class="read">
                            <td class="contact"><b>Competencia</b></td>
                            <td class="subject">{{$item->aprendizaje->componentecompetencia->competencia->competencia}}</td>
                        </tr>
                        </br>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col-md-12">
                @if($a->tipo=='EXAMEN')
                    <h4>Cuestionario</h4>
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                <tr class="danger">
                                    <th>PREGUNTA</th>
                                    <th>PUNTOS</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(count($a->actividadpreguntas)>0)
                                    @foreach($a->actividadpreguntas as $py)
                                        <tr>
                                            <td>{!! str_limit($py->pregunta->pregunta, $limit = 100, $end = '...') !!}</td>
                                            <td>{{$py->pregunta->puntos}}</td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
                @if($a->tipo=='ACTIVIDAD-RECURSO')
                    <h4>Recurso Descargable</h4>
                    <h4 class="text-center text-danger">Solo se visualizan documentos PDF, si el documento de la
                        actividad no se visualiza correctamente puede descargarlo desde <a
                            href="{{asset('documentos/aulavirtual/'.$a->recurso)}}" download="{{$a->recurso}}">aquí.</a>
                    </h4>
                    <iframe src="{{asset('documentos/aulavirtual/'.$a->recurso)}}" width="100%" height="800px"></iframe>
                @endif
                @if($a->tipo=='ACTIVIDAD-ESCRITA')
                    <h4>Actividad</h4>
                    <div class="col-md-12"
                         style="border: 1px solid; border-color: #eee; padding: 50px;-webkit-box-shadow: 0px 0px 20px -4px rgba(0,0,0,0.75);-moz-box-shadow: 0px 0px 20px -4px rgba(0,0,0,0.75);box-shadow: 0px 0px 20px -4px rgba(0,0,0,0.75);">
                        <h3>{{$a->nombre}}</h3><br/>
                        <h4>{{$a->descripcion}}</h4><br/>
                        {!!$a->recurso!!}
                    </div>
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
                    <p>Esta funcionalidad permite gestionar un completo banco de actividades para una materia, grado y
                        evaluación académica en particular.</p>
                </div>
                <div class="modal-footer" style="background-color: #d2d6de !important; opacity: .65;">
                    <button type="button" class="btn btn-block btn-danger btn-flat pull-right" data-dismiss="modal"><i
                            class="fa fa-reply"></i> Regresar
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
        $(document).ready(function () {
            $('#tb').DataTable();
        });
    </script>
@endsection
