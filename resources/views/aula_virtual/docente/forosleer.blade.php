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
    <li><a href="{{route('aulavirtual.menuauladocente',$gmd->id)}}"><i class="fa fa-vimeo"></i> Panel Aula Virtual</a></li>
    <li><a href="{{route('forodiscusion.docenteinicio',$gmd->id)}}"><i class="fa fa-bullhorn"></i> Foros de Discusión</a></li>
    <li class="active"><a>Leer Tema</a></li>
</ol>
@endsection
@section('content')
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">FOROS DE DISCUSIÓN</h3>
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
    </div>
</div>
<div class="box box-danger direct-chat direct-chat-danger">
    <div class="box-header with-border">
        <h3 class="box-title">Tema: {{$foro->titulo}}</h3>

        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
            <button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="" data-widget="chat-pane-toggle" data-original-title="Participantes">
                <i class="fa fa-comments"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <!-- Conversations are loaded here -->
        <div class="direct-chat-messages">
            <!-- Message. Default to the left -->
            <div class="direct-chat-msg">
                <div class="direct-chat-info clearfix">
                    <span class="direct-chat-name pull-left">{{$foro->user->nombres." ".$foro->user->apellidos}}</span>
                    <span class="direct-chat-timestamp pull-right">{{$foro->created_at}}</span>
                </div>
                <!-- /.direct-chat-info -->
                <img class="direct-chat-img" src="{{asset('dist/img/avatar5.png')}}" alt="Message User Image"><!-- /.direct-chat-img -->
                <div class="direct-chat-text">
                    <b>{{$foro->titulo}}</b>
                    {!!$foro->contenido!!}
                </div>
                <!-- /.direct-chat-text -->
            </div>
            <!-- /.direct-chat-msg -->
            @if(count($foro->forodiscusionrespuestas)>0)
            @foreach($foro->forodiscusionrespuestas as $r)
            <!-- Message to the right -->
            <div class="direct-chat-msg right">
                <div class="direct-chat-info clearfix">
                    <span class="direct-chat-name pull-right">{{$r->user->nombres." ".$r->user->apellidos}}</span>
                    <span class="direct-chat-timestamp pull-left">{{$r->created_at}}</span>
                </div>
                <!-- /.direct-chat-info -->
                <img class="direct-chat-img" src="{{asset('dist/img/avatar5.png')}}" alt="Message User Image"><!-- /.direct-chat-img -->
                <div class="direct-chat-text">
                    {!!$r->contenido!!}
                </div>
                <!-- /.direct-chat-text -->
            </div>
            <!-- /.direct-chat-msg -->
            @endforeach
            @endif
        </div>
        <!--/.direct-chat-messages-->

        <!-- Contacts are loaded here -->
        <div class="direct-chat-contacts">
            <ul class="contacts-list">
                <li>
                    <a href="#">
                        <img class="contacts-list-img" src="{{asset('dist/img/avatar5.png')}}" alt="User Image">

                        <div class="contacts-list-info">
                            <span class="contacts-list-name">
                                {{$docente->personanatural->primer_nombre." ".$docente->personanatural->segundo_nombre." ".$docente->personanatural->primer_apellido." ".$docente->personanatural->segundo_apellido}}
                                <small class="contacts-list-date pull-right">Grupo Asignado: {{$docente->created_at}}</small>
                            </span>
                            <span class="contacts-list-msg">DOCENTE</span>
                        </div>
                        <!-- /.contacts-list-info -->
                    </a>
                </li>
                @if(count($contactos)>0)
                @foreach($contactos as $c)
                <li>
                    <a href="#">
                        <img class="contacts-list-img" src="{{asset('dist/img/avatar5.png')}}" alt="User Image">

                        <div class="contacts-list-info">
                            <span class="contacts-list-name">
                                {{$c->estudiante->personanatural->primer_nombre." ".$c->estudiante->personanatural->segundo_nombre." ".$c->estudiante->personanatural->primer_apellido." ".$c->estudiante->personanatural->segundo_apellido}}
                                <small class="contacts-list-date pull-right">Matriculado: {{$c->created_at}}</small>
                            </span>
                            <span class="contacts-list-msg">ESTUDIANTE</span>
                        </div>
                        <!-- /.contacts-list-info -->
                    </a>
                </li>
                @endforeach
                @endif
                <!-- End Contact Item -->
            </ul>
            <!-- /.contatcts-list -->
        </div>
        <!-- /.direct-chat-pane -->
    </div>
    <!-- /.box-body -->
    <div class="box-footer">
        <form action="{{route('forodiscusion.storerespuesta')}}" method="post">
            <input type="hidden" name="forodiscusion_id" value="{{$foro->id}}" />
            @csrf
            <div class="input-group">
                <div class="form-group is-empty"><input type="text" name="contenido" placeholder="Escriba su respuesta ..." class="form-control"></div>
                <span class="input-group-btn">
                    <button type="submit" class="btn btn-danger btn-flat">Enviar</button>
                </span>
            </div>
        </form>
    </div>
    <!-- /.box-footer-->
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
                <p>Esta funcionalidad permite la comunicación entre docentes y estudiantes con respecto a temáticas de la materia.</p>
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
        // $('#tb').DataTable();
        //CKEDITOR.replace('editor1')
        //bootstrap WYSIHTML5 - text editor
        //$('.textarea').wysihtml5()
    });
</script>
@endsection