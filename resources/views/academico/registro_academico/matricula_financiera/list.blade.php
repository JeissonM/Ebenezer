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
    <li class="active"><a> Matrícula Financiera</a></li>
</ol>
@endsection
@section('content')
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">MATRÍCULA FINANCIERA</h3>
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
                <table id="tb" class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr class="danger">
                            <th>TIPO Y NÚMERO DOCUMENTO</th>
                            <th>ESTUDIANTE</th>
                            <th>SITUACIÓN</th>
                            <th>CATEGORÍA</th>
                            <th>ESTADO</th>
                            <th>GRADO ACTUAL</th>
                            <th>PAGO</th>
                            <th>PAGAR</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($estudiantes as $e)
                        <tr>
                            <td>{{$e->personanatural->persona->tipodoc->abreviatura." - ".$e->personanatural->persona->numero_documento}}</td>
                            <td>{{$e->personanatural->primer_nombre." ".$e->personanatural->segundo_nombre." ".$e->personanatural->primer_apellido." ".$e->personanatural->segundo_apellido}}</td>
                            <td>{{$e->situacionestudiante->nombre}}</td>
                            <td>{{$e->categoria->nombre}}</td>
                            <td>{{$e->estado}}</td>
                            <td>{{$e->grado->etiqueta}}</td>
                            <td>
                                @if($e->pago=='PAGADO')
                                <label class="label label-success">{{$e->pago}}</label>
                                @else
                                <label class="label label-danger">{{$e->pago}}</label>
                                @endif
                            </td>
                            <td>
                                @if($e->pago=='PENDIENTE')
                                <a href="{{route('matriculafinanciera.show',$e->id)}}" style="margin-left: 10px;" data-toggle="tooltip" title="Registrar Pago" style="margin-left: 10px;"><i class="fa fa-dollar"></i></a>
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
                <p>Esta funcionalidad permite al usuario registrar el pago de la matrícula para cada estudiante.</p>
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
        $('#tb').DataTable();
    });
</script>
@endsection