@extends('layouts.admin')
@section('breadcrumb')
<h1>
    Bienvenido
    <small>Sr(a). {{Auth::user()->nombres}}</small>
</h1>
<ol class="breadcrumb">
    <li><a href="{{route('home')}}"><i class="fa fa-home"></i> Inicio</a></li>
    <li><a href="{{route('menu.matricula')}}"><i class="fa fa-check"></i> Matrícula</a></li>
    <li><a href="{{route('menu.matricula')}}"><i class="fa fa-check-circle-o"></i> Matrícula</a></li>
    <li class="active"><a>Matricular Estudiantes Nuevos</a></li>
</ol>
@endsection
@section('content')
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">MATRICULAR ESTUDIANTES NUEVOS</h3>
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
            <div class="col-md-6">
                <div class="form-group">
                    <label>Unidad Académica o Sede</label>
                    <select class="form-control" id="unidad_id">
                        @foreach($unidades as $key=>$value)
                        <option value="{{$key}}">{{$value}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Período Académico</label>
                    <select class="form-control" id="periodoacademico_id">
                        @foreach($periodos as $key=>$value)
                        <option value="{{$key}}">{{$value}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Jornada</label>
                    <select class="form-control" id="jornada_id">
                        @foreach($jornadas as $key=>$value)
                        <option value="{{$key}}">{{$value}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Grado</label>
                    <select class="form-control" id="grado_id">
                        @foreach($grados as $key=>$value)
                        <option value="{{$key}}">{{$value}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-check"></i> Tenga en cuenta!</h4>
                Está a punto de realizar matrícula académica a los estudiantes nuevos del grado indicado. Es necesario primero crear grupos y asignar carga académica para el período.
            </div>
            <div class="alert alert-warning alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-check"></i> Tenga en cuenta!</h4>
                Éste proceso puede tardar varios minutos y la página parecerá no estar haciendo nada, no recargue la página, no la cierre, solo tenga paciencia. Se le notificará una vez termine el proceso y se le permitirá descargar un archivo con la información de todo el procedimiento.
            </div>
        </div>
        <div class="col-md-12" style="margin-top: 20px !important">
            <div class="form-group">
                <button class="btn btn-success icon-btn pull-left" onclick="ir()"><i class="fa fa-fw fa-lg fa-save"></i>Procesar Estudiantes</button>
                <a class="btn btn-danger icon-btn pull-left" href="{{route('menu.matricula')}}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancelar</a>
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
                <p>Esta funcionalidad permite al usuario realizar la matrícula académica a los estudiantes nuevos de la institución, éste proceso requiere que se gestione primero grupos para los grados y carga académica asignada a los grupos.</p>
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

    function ir() {
        location.href = url + "matricula/matricularnuevos/" + $("#unidad_id").val() + "/" + $("#periodoacademico_id").val() + "/" + $("#jornada_id").val() + "/" + $("#grado_id").val() + "/continuar";
    }
</script>
@endsection