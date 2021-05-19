@extends('layouts.admin')
@section('breadcrumb')
<h1>
    Bienvenido
    <small>Sr(a). {{Auth::user()->nombres}}</small>
</h1>
<ol class="breadcrumb">
    <li><a href="{{route('home')}}"><i class="fa fa-home"></i> Inicio</a></li>
    <li><a href="{{route('menu.usuarios')}}"><i class="fa fa-users"></i> Usuarios</a></li>
    <li class="active"><a>Creación de Usuarios de Forma Automática</a></li>
</ol>
@endsection
@section('content')
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">CREAR USUARIOS AUTOMÁTICOS</h3>
        <div class="box-tools pull-right">
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
                @if($data['actor']=='ESTUDIANTE')
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fa fa-check"></i> Tenga en cuenta!</h4>
                    <p>Esta funcionalidad permite al usuario convertir en usuarios del sistema de forma automática a todos los estudiantes nuevos o estudiantes que no tengan usuario asignado todavía. El usuario para acceder al sistema será el número de identificación y la contraseña será también su número de identificación que deberá cambiar el usuario una vez ingrese al sistema por seguridad.</p>
                </div>
                @endif
                @if($data['actor']=='DOCENTE')
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fa fa-check"></i> Tenga en cuenta!</h4>
                    <p>Esta funcionalidad permite al usuario convertir en usuarios del sistema de forma automática a todos los docentes que no tengan usuario asignado todavía. El usuario para acceder al sistema será el número de identificación y la contraseña será también su número de identificación que deberá cambiar el usuario una vez ingrese al sistema por seguridad.</p>
                </div>
                @endif
                <div class="alert alert-warning alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fa fa-check"></i> Tenga en cuenta!</h4>
                    Éste proceso puede tardar varios minutos y la página parecerá no estar haciendo nada, no recargue la página, no la cierre, solo tenga paciencia. Se le notificará una vez termine el proceso y se le permitirá descargar un archivo con la información de todo el procedimiento.
                </div>
                <form class="form" role="form" method="POST" action="{{route($data['route'])}}">
                    @csrf
                    <input type="hidden" name="actor" value="{{$data['actor']}}" />
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Seleccione los Grupos o Roles</label>
                            <select class="form-control select2" multiple="multiple" style="width: 100%;" required="required" name="grupos[]">
                                <option value="0">-- Seleccione una opción --</option>
                                @foreach($data['grupos'] as $key=>$value)
                                <option value="{{$key}}">{{$value}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12" style="margin-top: 20px !important">
                        <div class="form-group">
                            <button class="btn btn-success icon-btn pull-left" type="submit"><i class="fa fa-fw fa-lg fa-save"></i>Guardar</button>
                            <button class="btn btn-info icon-btn pull-left" type="reset"><i class="fa fa-fw fa-lg fa-trash-o"></i>Limpiar</button>
                            <a class="btn btn-danger icon-btn pull-left" href="{{route('menu.usuarios')}}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancelar</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script type="text/javascript">
    $(document).ready(function() {
        $('.select2').select2();
    });
</script>
@endsection