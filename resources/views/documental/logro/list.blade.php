@extends('layouts.admin')
@section('breadcrumb')
    <h1>
        Bienvenido
        <small>Sr(a). {{Auth::user()->nombres}}</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{route('home')}}"><i class="fa fa-home"></i> Inicio</a></li>
        <li><a href="{{route('menu.documental')}}"><i class="fa fa-book"></i> Documental</a></li>
        <li><a href="{{route('logro.index')}}"><i class="fa fa-edit"></i> Logros</a></li>
        <li class="active"><a> Listar Logros</a></li>
    </ol>
@endsection
@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">LOGROS</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-toggle="modal" data-target="#modal" title="Ayuda">
                    <i class="fa fa-question"></i></button>
                <a href="{{route('logro.crear',[$gm,$gmd])}}" class="btn btn-box-tool"
                   data-toggle="tooltip" data-original-title="Agregar Nuevo Requisito">
                    <i class="fa fa-plus-circle"></i></a>
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
                        <tr class="bg-purple">
                            <th>UNIDAD</th>
                            <th>PERÍODO</th>
                            <th>JORNADA</th>
                            <th>GRADO</th>
                            <th>GRUPO</th>
                            <th>MATERIA</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>{{$gm->unidad->nombre}}</td>
                            <td>{{$gm->periodoacademico->etiqueta."-".$gm->periodoacademico->anio}}</td>
                            <td>{{$gm->jornada->descripcion." - ".$gm->jornada->jornadasnies}}</td>
                            <td>{{$gm->grado->etiqueta}}</td>
                            <td>{{$gmd->grupo->nombre}}</td>
                            <td>{{$gm->materia->codigomateria."-".$gm->materia->nombre}}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-6">
                <div class="callout bg-purple-gradient" style="padding: 5px; padding-left: 20px; text-align: center;">
                    <h2>Banco de Logros</h2>
                </div>
                <div class="table-responsive">
                    <table id="tb" class="table table-bordered table-striped table-hover">
                        <thead>
                        <tr class="bg-purple">
                            <th>ID</th>
                            <th>DESCRIPCIÓN</th>
                            <th>ACCIONES</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($logros as $e)
                            <tr>
                                <td>{{$e->id}}</td>
                                <td>{{$e->descripcion}}</td>
                                <td>
                                    @if($user->id == $e->user_id)
                                        <a href="{{route('logro.editar',[$e->id,$gmd->id])}}"
                                           style="margin-left: 10px; color: blue;"
                                           data-toggle="tooltip" title="Editar" style="margin-left: 10px;"><i
                                                class="fa fa-edit"></i></a>
                                    @endif
                                        <a href="{{route('logro.asignar',[$e->id,$gmd->id,$gm->periodoacademico_id])}}"
                                           style="margin-left: 10px; color: green;"
                                           data-toggle="tooltip" title="Asignar" style="margin-left: 10px;"><i
                                                class="fa fa-check"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-6">
                <div class="callout bg-purple-gradient" style="padding: 5px; padding-left: 20px; text-align: center;">
                    <h2>Logros Asignados</h2>
                </div>
                <div class="alert alert-warning" role="alert">
                    <strong>Nota:</strong> Son los logros que apareceran en los boletines, si desea personalizar un logro a un estudiante diríjase a Documental/Personalizar Logro Estudiante.
                </div>
                <div class="table-responsive">
                    <table id="tb2" class="table table-bordered table-striped table-hover">
                        <thead>
                        <tr class="bg-purple">
                            <th>ID</th>
                            <th>DESCRIPCIÓN</th>
                            <th>ACCIONES</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($asignados as $e)
                            <tr>
                                <td>{{$e->id}}</td>
                                <td>{{$e->logro->descripcion}}</td>
                                <td>
                                    @if($user->id == $e->logro->user_id)
                                        <a href="{{route('logro.retirar',[$e->id,$gmd->id])}}"
                                           style="margin-left: 10px; color: red;"
                                           data-toggle="tooltip" title="Retirar" style="margin-left: 10px;"><i
                                                class="fa fa-remove"></i></a>
                                    @endif
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
                    <p>Esta funcionalidad permite gestionar los logros para una materia.</p>
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
            $('#tb2').DataTable();
            $(document.body).attr('class', 'skin-blue sidebar-mini sidebar-collapse');
        });
    </script>
@endsection
