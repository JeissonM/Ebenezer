@extends('layouts.admin')
@section('breadcrumb')
<h1>
    Bienvenido
    <small>Sr(a). {{Auth::user()->nombres}}</small>
</h1>
<ol class="breadcrumb">
    <li><a href="{{route('home')}}"><i class="fa fa-home"></i> Inicio</a></li>
    <li><a href="{{route('menu.inscripcion')}}"><i class="fa fa-edit"></i> Inscripción</a></li>
    <li><a href="{{route('padresaspirantes.index')}}"><i class="fa fa-users"></i> Padres del Aspirante</a></li>
    <li><a href="{{route('padresaspirantes.lista',$p->aspirante->id)}}"><i class="fa fa-users"></i> Padres</a></li>
    <li class="active"><a>Editar Padre</a></li>
</ol>
@endsection
@section('content')
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">EDITAR LOS DATOS DEL PADRE/MADRE</h3>
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
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr class="info">
                            <th>IDENTIFICACIÓN</th>
                            <th>ASPIRANTE</th>
                            <th>PERÍODO</th>
                            <th>JORNADA</th>
                            <th>UNIDAD</th>
                            <th>GRADO</th>
                            <th>ESTADO</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{$p->aspirante->tipodoc->abreviatura." - ".$p->aspirante->numero_documento}}</td>
                            <td>{{$p->aspirante->primer_nombre." ".$p->aspirante->segundo_nombre." ".$p->aspirante->primer_apellido." ".$p->aspirante->segundo_apellido}}</td>
                            <td>{{$p->aspirante->periodoacademico->etiqueta." - ".$p->aspirante->periodoacademico->anio}}</td>
                            <td>{{$p->aspirante->jornada->descripcion." - ".$p->aspirante->jornada->jornadasnies}}</td>
                            <td>{{$p->aspirante->unidad->nombre}}</td>
                            <td>{{$p->aspirante->grado->etiqueta}}</td>
                            <td>{{$p->aspirante->estado}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-md-12">
            <form class="form" role='form' method="POST" action="{{route('padresaspirantes.update',$p)}}">
                @csrf
                <input name="_method" type="hidden" value="PUT" />
                <h5 class="text-danger">Los campos con asterísco(*) son obligatorios</h5>
                <div class="col-md-12">
                    <h3>Información Personal</h3>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Tipo Documento*</label>
                            <select class="form-control" name="tipodoc_id" required="">
                                @foreach($tipodoc as $key=>$value)
                                @if($key==$p->tipodoc_id)
                                <option selected value="{{$key}}">{{$value}}</option>
                                @else
                                <option value="{{$key}}">{{$value}}</option>
                                @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Número de Identidad*</label>
                            <input class="form-control" type="text" value="{{$p->numero_documento}}" required="" name="numero_documento">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Lugar de Expedición</label>
                            <input class="form-control" type="text" value="{{$p->lugar_expedicion}}" name="lugar_expedicion">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Fecha de Expedición</label>
                            <input class="form-control" type="date" value="{{$p->fecha_expedicion}}" name="fecha_expedicion">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Primer Nombre*</label>
                            <input class="form-control" type="text" value="{{$p->primer_nombre}}" required="required" name="primer_nombre">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Segundo Nombre</label>
                            <input class="form-control" type="text" value="{{$p->segundo_nombre}}" name="segundo_nombre">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Primer Apellido*</label>
                            <input class="form-control" type="text" value="{{$p->primer_apellido}}" required="required" name="primer_apellido">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Segundo Apellido</label>
                            <input class="form-control" type="text" value="{{$p->segundo_apellido}}" name="segundo_apellido">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Sexo</label>
                            <select class="form-control" name="sexo_id">
                                @foreach($sexos as $key=>$value)
                                @if($key==$p->sexo_id)
                                <option selected value="{{$key}}">{{$value}}</option>
                                @else
                                <option value="{{$key}}">{{$value}}</option>
                                @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <h3>Información de Ubicación</h3>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Dirección de Residencia</label>
                            <input class="form-control" type="text" value="{{$p->direccion_residencia}}" name="direccion_residencia">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Barrio de Residencia</label>
                            <input class="form-control" type="text" value="{{$p->barrio_residencia}}" name="barrio_residencia">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Correo Electrónico</label>
                            <input class="form-control" type="email" value="{{$p->correo}}" name="correo">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Teléfono</label>
                            <input class="form-control" type="tel" value="{{$p->telefono}}" name="telefono">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Celular</label>
                            <input class="form-control" type="number" value="{{$p->celular}}" name="celular">
                        </div>
                    </div>
                </div>
{{--                <div class="col-md-12">--}}
{{--                    <h3>Información Complementaria</h3>--}}
{{--                    <div class="col-md-4">--}}
{{--                        <div class="form-group">--}}
{{--                            <label>¿Vive?</label>--}}
{{--                            <select class="form-control" name="vive">--}}
{{--                                @if($p->vive=='SI')--}}
{{--                                <option selected value="SI">SI</option>--}}
{{--                                <option value="NO">NO</option>--}}
{{--                                @else--}}
{{--                                <option value="SI">SI</option>--}}
{{--                                <option selected value="NO">NO</option>--}}
{{--                                @endif--}}
{{--                            </select>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="col-md-4">--}}
{{--                        <div class="form-group">--}}
{{--                            <label>¿Es Acudiente?</label>--}}
{{--                            <select class="form-control" name="acudiente">--}}
{{--                                @if($p->acudiente=='SI')--}}
{{--                                <option selected value="SI">SI</option>--}}
{{--                                <option value="NO">NO</option>--}}
{{--                                @else--}}
{{--                                <option value="SI">SI</option>--}}
{{--                                <option selected value="NO">NO</option>--}}
{{--                                @endif--}}
{{--                            </select>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="col-md-4">--}}
{{--                        <div class="form-group">--}}
{{--                            <label>Padre/Madre*</label>--}}
{{--                            <select class="form-control" name="padre_madre" required>--}}
{{--                                @if($p->padre_madre=='PADRE')--}}
{{--                                <option selected value="PADRE">PADRE</option>--}}
{{--                                <option value="MADRE">MADRE</option>--}}
{{--                                @else--}}
{{--                                <option value="PADRE">PADRE</option>--}}
{{--                                <option selected value="MADRE">MADRE</option>--}}
{{--                                @endif--}}
{{--                            </select>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="col-md-12">--}}
{{--                        <div class="form-group">--}}
{{--                            <label>Profesión/Ocupación</label>--}}
{{--                            <select class="form-control select2" name="ocupacion_id">--}}
{{--                                @foreach($profesions as $key=>$value)--}}
{{--                                @if($key==$p->ocupacion_id)--}}
{{--                                <option selected value="{{$key}}">{{$value}}</option>--}}
{{--                                @else--}}
{{--                                <option value="{{$key}}">{{$value}}</option>--}}
{{--                                @endif--}}
{{--                                @endforeach--}}
{{--                            </select>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
                <div class="col-md-12" style="margin-top: 20px !important">
                    <div class="form-group">
                        <button class="btn btn-success icon-btn pull-left" type="submit"><i class="fa fa-fw fa-lg fa-save"></i>Guardar</button>
                        <button class="btn btn-info icon-btn pull-left" type="reset"><i class="fa fa-fw fa-lg fa-trash-o"></i>Limpiar</button>
                        <a class="btn btn-danger icon-btn pull-left" href="{{route('padresaspirantes.lista',$p->aspirante_id)}}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancelar</a>
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
                <p>Esta funcionalidad permitirá al usuario gestionar la información de los padres de cada aspirante.</p>
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
        $('.select2').select2();
    });
</script>
@endsection
