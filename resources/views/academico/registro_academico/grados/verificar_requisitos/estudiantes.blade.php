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
        <li><a href="{{route('menu.grados')}}"><i class="fa fa-graduation-cap"></i> Grados</a></li>
        <li><a href="{{route('verificarrequisitogrado.index')}}"><i class="fa fa-check"></i> Verificar Requisitos</a></li>
        <li class="active"><a>Estudiantes</a></li>
    </ol>
@endsection
@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">VERIFICAR REQUISITOS DE GRADO</h3>
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
                    <table id="example1" class="table table-bordered table-striped table-hover">
                        <thead>
                        <tr class="info">
                            <th>IDENTIFICACIÓN</th>
                            <th>ESTUDIANTE</th>
                            <th>PERÍODO</th>
                            <th>JORNADA</th>
                            <th>UNIDAD</th>
                            <th>GRADO</th>
                            <th>ESTADO</th>
                            <th>REQUISITOS</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($estudiantes as $a)
                            <tr>
                                <td>{{$a->personanatural->persona->tipodoc->abreviatura." - ".$a->personanatural->persona->numero_documento}}</td>
                                <td>{{$a->personanatural->primer_nombre." ".$a->personanatural->segundo_nombre." ".$a->personanatural->primer_apellido." ".$a->personanatural->segundo_apellido}}</td>
                                <td>{{$a->periodoacademico->etiqueta." - ".$a->periodoacademico->anio}}</td>
                                <td>{{$a->jornada->descripcion." - ".$a->jornada->jornadasnies}}</td>
                                <td>{{$a->unidad->nombre}}</td>
                                <td>{{$a->grado->etiqueta}}</td>
                                <td>{{$a->estado}}</td>
                                <td>
                                        <a href="{{route('verificarrequisitogrado.listarrequisitos',[$a->id,$periodo->id,$jornada->id,$unidad->id,$grado->id])}}" style="margin-left: 10px;" data-toggle="tooltip" title="Verificar Requisitos" style="margin-left: 10px;"><i class="fa fa-check"></i></a>
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
                    <p>Esta funcionalidad permite al usuario verificar y hacer check a los requisitos de los estudiantes en el proceso de grado.</p>
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
