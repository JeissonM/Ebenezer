@extends('layouts.admin')
@section('breadcrumb')
    <h1>
        Bienvenido
        <small>Sr(a). {{Auth::user()->nombres}}</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{route('home')}}"><i class="fa fa-home"></i> Inicio</a></li>
        <li><a href="{{route('menu.academico')}}"><i class="fa fa-book"></i> Académico</a></li>
        <li><a href="{{route('menu.academico')}}"><i class="fa fa-edit"></i> Registro Académico</a></li>
        <li><a href="{{route('hojadevida.index')}}"><i class="fa fa-edit"></i> Hoja de Vida Estudiante</a></li>
        <li><a href="{{route('menu.hojadevidaestudiante',$a->id)}}"><i class="fa fa-edit"></i> Menú</a></li>
        <li class="active"><a>Responsable Financiero</a></li>
    </ol>
@endsection
@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">RESPONSABLE FINANCIERO</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-toggle="modal" data-target="#modal" title="Ayuda">
                    <i class="fa fa-question"></i></button>
                <a href="{{route('responsablefestudiante.crear',$a->id)}}" class="btn btn-box-tool"
                   data-toggle="tooltip" data-original-title="Agregar Padre/Madre">
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
                @component('layouts.errors')
                @endcomponent
            </div>
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                        <tr class="danger">
                            <th>IDENTIFICACIÓN</th>
                            <th>ESTUDIANTE</th>
                            <th>PERÍODO</th>
                            <th>JORNADA</th>
                            <th>UNIDAD</th>
                            <th>GRADO</th>
                            <th>ESTADO</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>{{$pn->persona->tipodoc->abreviatura." - ".$pn->persona->numero_documento}}</td>
                            <td>{{$pn->primer_nombre." ".$pn->segundo_nombre." ".$pn->primer_apellido." ".$pn->segundo_apellido}}</td>
                            <td>{{$a->periodoacademico->etiqueta." - ".$a->periodoacademico->anio}}</td>
                            <td>{{$a->jornada->descripcion." - ".$a->jornada->jornadasnies}}</td>
                            <td>{{$a->unidad->nombre}}</td>
                            <td>{{$a->grado->etiqueta}}</td>
                            <td>{{$a->estado}}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-12">
                <h3>Listado de Responsables Financieros</h3>
                <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-striped table-hover">
                        <thead>
                        <tr class="danger">
                            <th>DOCUMENTO</th>
                            <th>RESPONSABLE</th>
                            <th>CORREO</th>
                            <th>CELULAR</th>
                            <th>OCUPACIÓN</th>
                            <th>EMPRESA</th>
                            <th>DIRECCIÓN LABORAL</th>
                            <th>ACCIONES</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($res != null)
                            <tr>
                                <td>{{$res->personanatural->persona->numero_documento}}</td>
                                <td>{{$res->personanatural->primer_nombre." ".$res->personanatural->segundo_nombre." ".$res->personanatural->primer_apellido." ".$res->personanatural->segundo_apellido}}</td>
                                <td>{{$res->personanatural->persona->mail}}</td>
                                <td>{{$res->personanatural->persona->celular}}</td>
                                <td>{{$res->ocupacion->descripcion}}</td>
                                <td>{{$res->empresa_labora}}</td>
                                <td>{{$res->direccion_trabajo}}</td>
                                <td>
                                    <a href="{{route('responsablefestudiante.delete',$res->id)}}"
                                       style="margin-left: 10px; color:red;" data-toggle="tooltip"
                                       title="Eliminar Responsable Financiero"><i class="fa fa-trash-o"></i></a>
                                </td>
                            </tr>
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
                    <p>Esta funcionalidad permitirá al usuario gestionar la información del responsable financiero del
                        estudiante.</p>
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
            $('#example1').DataTable();
            $('.select2').select2();
        });
    </script>
@endsection
