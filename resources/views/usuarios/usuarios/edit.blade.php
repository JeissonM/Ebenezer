@extends('layouts.admin')
@section('breadcrumb')
<h1>
    Bienvenido
    <small>Sr(a). {{Auth::user()->nombres}}</small>
</h1>
<ol class="breadcrumb">
    <li><a href="{{route('home')}}"><i class="fa fa-home"></i> Inicio</a></li>
    <li><a href="{{route('menu.usuarios')}}"><i class="fa fa-users"></i> Usuarios</a></li>
    <li class="active"><a>Editar Usuario</a></li>
</ol>
@endsection
@section('content')
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">EDITAR, ELIMINAR USUARIO</h3>
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
            <form class="form" role='form' method="POST" action="{{route('usuario.update',$user->id)}}">
                @csrf
                <input name="_method" type="hidden" value="PUT" />
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Identificación del Usuario</label>
                        <input type="text" name="identificacion" value="{{$user->identificacion}}" class="form-control" placeholder="Escriba el número de identificación del usuario, con éste tendrá acceso al sistema" required="required" />
                    </div>
                    <div class="form-group">
                        <label>Nombres del Usuario</label>
                        <input type="text" name="nombres" value="{{$user->nombres}}" class="form-control" placeholder="Escriba los nombres del usuario" required="required" />
                    </div>
                    <div class="form-group">
                        <label>Apellidos del Usuario</label>
                        <input type="text" name="apellidos" value="{{$user->apellidos}}" class="form-control" placeholder="Escriba los apellidos del usuario" required="required" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>E-mail del Usuario</label>
                        <input type="email" name="email" value="{{$user->email}}" class="form-control" placeholder="Escriba el correo electrónico del usuario" required="required" />
                    </div>
                    <div class="form-group">
                        <label>Seleccione Estado del Usuario</label>
                        <select class="form-control" name="estado" required="required">
                            <option value="0">-- Seleccione una opción --</option>
                            @if($user->estado=='ACTIVO')
                            <option value="ACTIVO" selected>ACTIVO</option>
                            <option value="INACTIVO">INACTIVO</option>
                            @else
                            <option value="ACTIVO">ACTIVO</option>
                            <option value="INACTIVO" selected>INACTIVO</option>
                            @endif
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Seleccione los Grupos o Roles de Usuarios</label>
                        <select class="form-control select2" name="grupos[]" required="required" multiple>
                            @foreach($grupos as $key=>$value)
                            <?php
                            $existe = false;
                            ?>
                            @foreach($user->grupousuarios as $g)
                            @if($g->id==$key)
                            <?php
                            $existe = true;
                            ?>
                            @endif
                            @endforeach
                            @if($existe)
                            <option value="{{$key}}" selected>{{$value}}</option>
                            @else
                            <option value="{{$key}}">{{$value}}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <a class="btn btn-danger icon-btn pull-left" href="{{route('menu.usuarios')}}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancelar</a>
                        <button class="btn btn-info icon-btn pull-left" type="reset"><i class="fa fa-fw fa-lg fa-trash-o"></i>Limpiar</button>
                        <button class="btn btn-success icon-btn pull-left" type="submit"><i class="fa fa-fw fa-lg fa-save"></i>Guardar</button>
                        <a href="{{ route('usuario.delete',$user->id)}}" class="btn btn-danger icon-btn pull-left"><i class="fa fa-fw fa-lg fa-remove"></i>Eliminar Usuario</a>
                    </div>
                </div>                                        
            </form>
        </div>
    </div>
</div>
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">CAMBIAR CONTRASEÑA</h3>
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
            <form class="form" role="form" method="POST" action="{{route('usuario.cambiarPass')}}">
                @csrf
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Identificación del Usuario</label>
                        <input type="text" name="identificacion2" value="{{$user->identificacion}}" class="form-control" readonly required="required" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Escriba la Nueva Contraseña</label>
                        <input type="password" name="pass1" class="form-control" placeholder="Mínimo 6 caracteres"required="required" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Vuelva a Escribir La Nueva Contraseña</label>
                        <input type="password" name="pass2" class="form-control" placeholder="Mínimo 6 caracteres"required="required" />
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <button class="btn btn-info icon-btn pull-left" type="reset"><i class="fa fa-fw fa-lg fa-trash-o"></i>Limpiar</button>
                        <button class="btn btn-success icon-btn pull-left" type="submit"><i class="fa fa-fw fa-lg fa-save"></i>Guardar</button>
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
                <p>Modifique o elimine un usuario del sistema. Además puede usted cambiar la contraseña al usuario.</p>
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
        $(".select2").select2();
    });
</script>
@endsection
