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
    <li><a href="{{route('docente.index')}}"><i class="fa fa-user"></i> Docentes</a></li>
    <li class="active"><a> Crear Docente</a></li>
</ol>
@endsection
@section('content')
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">CREAR NUEVO DOCENTE</h3>
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
            <form class="form" role='form' method="POST" action="{{route('docente.store')}}">
                @csrf
                <h3>Buscar por datos personales</h3>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Buscar Por...</label>
                        <select class="form-control" name="clave" id="clave">
                            <option value="IDENTIFICACION">IDENTIFICACION</option>
                            <option value="NOMBRES">NOMBRES Y APELLIDOS</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Valor de Busqueda...</label>
                        <input type="text" class="form-control" id="valor" />
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Realizar Busqueda...</label>
                        <button type="button" onclick="buscar()" class="btn btn-primary btn-sm btn-block">Buscar</button>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Defina la Situación Administrativa Para el Docente</label>
                        <select class="form-control" id="situacion">
                            @if($situaciones!=null)
                            @foreach($situaciones as $key=>$value)
                            <option value="{{$key}}">{{$value}}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                <div style="margin-top: 40px;" class="col-md-12">
                    <h3>Resultado de la busqueda...</h3>
                    <div class="table-responsive" id="rta">

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
                <p>Esta funcionalidad permite al usuario administrar los docentes de la institución.</p>
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

    function buscar() {
        $("#rta").html("");
        var clave = $("#clave").val();
        var valor = $("#valor").val();
        if (clave == null || valor.length <= 0) {
            notify('Alerta', 'Debe indicar el campo de busqueda y el valor del campo para continuar', 'error');
            return;
        }
        $.ajax({
            type: 'GET',
            url: url + "academico/docente/NATURAL/" + clave + "/" + valor + "/buscar",
            data: {},
        }).done(function(msg) {
            if (msg !== "null") {
                var m = JSON.parse(msg);
                var html = "<table id='tabla' class='table table-bordered table-striped table-hover' width='100%' cellspacing='0'>" +
                    "<thead><tr><th>Identificación</th><th>Nombres y Apellidos</th>" +
                    "<th>Situación</th><th>Acciones</th></tr></thead><tbody>";
                $.each(m, function(index, item) {
                    html = html + "<tr>" +
                        "<td>" + item.ident + "</td>" +
                        "<td>" + item.persona + "</td>" +
                        "<td>" + item.situacion + "</td>" +
                        "<td><a onclick='ir(this.id)' id='" + item.id + "' style='margin-left: 10px; cursor: pointer;' data-toggle='tooltip' title='Hacer Docente'><i class='fa fa-user'></i></a></td>" +
                        "</tr>";
                });
                html = html + "</tbody></html>";
                $("#rta").html(html);
                $('#tabla').DataTable();
            } else {
                notify('Atención', 'Persona no encontrada o relación de parámetros inválidos.', 'error');
            }
        });
    }

    function ir(pn) {
        var s = $("#situacion").val();
        if (s == null) {
            notify('Alerta', 'Debe indicar la situación del docente para continuar...', 'error');
            return;
        }
        location.href = url + "academico/docente/" + pn + "/" + s + "/agregar";
    }
</script>
@endsection