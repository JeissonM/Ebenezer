@extends('layouts.admin') <!-- plantilla principal --> 
@section('breadcrumb')<!-- navegación --> 
<h1>
    Bienvenido
    <small>Sr(a). {{Auth::user()->nombres}}</small>
</h1>
<ol class="breadcrumb">
    <li><a href="{{route('home')}}"><i class="fa fa-home"></i> Inicio</a></li>
    <li><a href="{{route('menu.usuarios')}}"><i class="fa fa-users"></i> Usuarios</a></li>
    <li class="active"><a>Privilegios</a></li>
</ol>
@endsection
@section('content') <!-- contenido --> 
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">ASIGNAR PERMISOS A GRUPOS DE USUARIOS(ROLES)</h3>
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
            <div class="col-md-12">
                <div class="form-group">
                    <label>Seleccione Grupo o Rol de Usuario</label>
                    <select class="form-control" onchange="traerData()" id="grupousuario_id">
                        <option value="0">-- Seleccione una opción --</option>
                        @foreach($grupos as $key=>$value)
                        <option value="{{$key}}">{{$value}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-12" style="margin-top: 20px;">
                <div class="callout callout-success" style="padding: 5px; background-color: #3c8dbc !important; padding-left: 20px; text-align: center;">
                    <h2>Páginas del Sistema</h2>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <select class="form-control" name="paginas[]" multiple="multiple" size="20" id="paginas" style="height: 400px !important;">
                            @foreach($paginas as $key=>$value)
                            <option value="{{$key}}">{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-12" style="margin-top:20px">
                <center>
                    <button type="button" class="btn btn-success btn-flat btn-raised" onclick="agregar()"> Agregar </button>
                    <button type="button" class="btn btn-danger btn-flat btn-raised" onclick="retirar()"> Quitar </button>
                    <button type="button" class="btn btn-success btn-flat btn-raised" onclick="agregarTodas()"> Agregar Todo </button>
                    <button type="button" class="btn btn-danger btn-flat btn-raised" onclick="retirarTodas()"> Quitar Todo </button>
                </center>
            </div>
            <div class="col-md-12" style="margin-top: 20px;">
                <div class="callout callout-success" style="padding: 5px; background-color: #3c8dbc !important; padding-left: 20px; text-align: center;">
                    <h2>Privilegios del Grupo</h2>
                </div>
                <form class="form" role='form' method="POST" action="{{route('grupousuario.guardar')}}" id="form-privilegios">
                    @csrf
                    <input type="hidden" id="id" name="id" />
                    <div class="col-md-12">
                        <div class="form-group">
                            <select class="form-control" name="privilegios[]" id="privilegios" multiple="multiple" size="20" style="height: 400px !important;" required="required"></select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <br/><button type="submit" id="btn-enviar" class="btn btn-info btn-flat btn-raised btn-block">Guardar los Cambios Para el Grupo Seleccionado</button>
                        </div>
                    </div>
                </form>
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
                <P>Los privilegios a páginas son los permisos que se deben asignar a los grupos de usuarios o roles para acceder a las funciones específicas de los módulos, es decir, sus páginas. En este sentido, si añade páginas a un grupo de usuario usted le estaría concediendo permisos al grupo para actuar sobre dichas páginas.</P>
                <P><B>Modo de Operar:</b> Seleccione un grupo de usuario y agregue permisos de izquierda a derecha o elimine privilegios del grupo pasando de derecha a izquierda.</P>
            </div>
            <div class="modal-footer" style="background-color: #d2d6de !important; opacity: .65;">
                <button type="button"  class="btn btn-block btn-danger btn-flat pull-right" data-dismiss="modal"> <i class="fa fa-reply"></i> Regresar</button>
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
        $("#btn-enviar").click(function (e) {
            validar(e);
        });
    });

    function validar(e) {
        e.preventDefault();
        var id = $("#id").val();
        if (id.length === 0) {
            notify('Atención', 'Debe seleccionar un grupo de usuarios para agregar privilegios.', 'warning');
        } else {
            $('#privilegios option').each(function () {
                var valor = $(this).attr('value');
                $("#privilegios").find("option[value='" + valor + "']").prop("selected", true);
            });
            $("#form-privilegios").submit();
        }
    }

    function agregar() {
        var id = $("#grupousuario_id").val();
        if (id === null) {
            notify('Atención', 'Debe seleccionar un grupo de usuarios para agregar privilegios.', 'warning');
        } else {
            $.each($('#paginas :selected'), function () {
                var valor = $(this).val();
                var texto = $(this).text();
                if (!existe(valor)) {
                    $("#privilegios").append("<option value='" + valor + "'>" + texto + "</option>");
                    $("#paginas").find("option[value='" + valor + "']").prop("disabled", true);
                }
            });
        }
    }

    function agregarTodas() {
        var id = $("#grupousuario_id").val();
        if (id === null) {
            notify('Atención', 'Debe seleccionar un grupo de usuarios para agregar privilegios.', 'warning');
        } else {
            $('#paginas option').each(function () {
                var valor = $(this).attr('value');
                var texto = $(this).text();
                if (texto !== "-- Seleccione una opción --") {
                    if (!existe(valor)) {
                        $("#privilegios").append("<option value='" + valor + "'>" + texto + "</option>");
                        $("#paginas").find("option[value='" + valor + "']").prop("disabled", true);
                    }
                }
            });
        }
    }

    function existe(valor) {
        var array = [];
        $("#privilegios option").each(function () {
            array.push($(this).attr('value'));
        });
        var index = $.inArray(valor, array);
        if (index !== -1) {
            return true;
        } else {
            return false;
        }
    }

    function retirar() {
        $.each($('#privilegios :selected'), function () {
            var valor = $(this).val();
            $("#paginas").find("option[value='" + valor + "']").prop("disabled", false);
            $(this).remove();
        });
    }

    function retirarTodas() {
        $('#privilegios option').each(function () {
            var valor = $(this).attr('value');
            $("#paginas").find("option[value='" + valor + "']").prop("disabled", false);
            $(this).remove();
        });
    }

    function traerData() {
        var id = $("#grupousuario_id").val();
        $("#id").val(id);
        $.ajax({
            type: 'GET',
            url: url + "usuarios/grupousuario/" + id + "/privilegios",
            data: {},
        }).done(function (msg) {
            $('#privilegios option').each(function () {
                $(this).remove();
            });
            if (msg !== "null") {
                var m = JSON.parse(msg);
                $('#paginas option').each(function () {
                    var valor = $(this).attr('value');
                    $("#paginas").find("option[value='" + valor + "']").prop("disabled", false);
                });
                $.each(m, function (index, item) {
                    $("#privilegios").append("<option value='" + item.id + "'>" + item.value + "</option>");
                    $("#paginas").find("option[value='" + item.id + "']").prop("disabled", true);
                });
            } else {
                notify('Atención', 'El grupo de usuarios seleccionado no tiene privilegios asignados aún.', 'error');
                $('#paginas option').each(function () {
                    var valor = $(this).attr('value');
                    $("#paginas").find("option[value='" + valor + "']").prop("disabled", false);
                });
            }
        });
    }
</script>
@endsection
