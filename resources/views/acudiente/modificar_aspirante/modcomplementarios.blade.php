@extends('layouts.admin')
@section('breadcrumb')
<h1>
    Bienvenido
    <small>Sr(a). {{Auth::user()->nombres}}</small>
</h1>
<ol class="breadcrumb">
    <li><a href="{{route('home')}}"><i class="fa fa-home"></i> Inicio</a></li>
    <li><a href="{{route('menu.inscripcion')}}"><i class="fa fa-edit"></i> Inscripción</a></li>
    <li><a href="{{route('aspirante.lista')}}"><i class="fa fa-edit"></i> Modificar Aspirantes</a></li>
    <li><a href="{{route('aspirante.menu',$a->id)}}"><i class="fa fa-list"></i> Menú</a></li>
    <li class="active"><a>Datos Complementarios</a></li>
</ol>
@endsection
@section('content')
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">DATOS COMPLEMENTARIOS</h3>
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
                            <td>{{$a->tipodoc->abreviatura." - ".$a->numero_documento}}</td>
                            <td>{{$a->primer_nombre." ".$a->segundo_nombre." ".$a->primer_apellido." ".$a->segundo_apellido}}</td>
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
            <form class="form" role='form' method="POST" action="{{route('aspirante.modificarcomp')}}">
                @csrf
                <input type="hidden" name="id" value="{{$a->id}}" />
                <h5 class="text-danger">Los campos con asterísco(*) son obligatorios</h5>
                <div class="col-md-12">
                    <h3>Información Complementaria</h3>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>¿Padres Separados?</label>
                            <select class="form-control" name="padres_separados">
                                @if($d->padres_separados=='SI')
                                <option selected value="SI">SI</option>
                                <option value="NO">NO</option>
                                @else
                                <option value="SI">SI</option>
                                <option selected value="NO">NO</option>
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Iglesia a la que Asistes</label>
                            <input type="text" class="form-control" value="{{$d->iglesia_asiste}}" name="iglesia_asiste" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Pastor</label>
                            <input type="text" class="form-control" value="{{$d->pastor}}" name="pastor" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>¿Discapacidad?</label>
                            <select class="form-control" name="discapacidad">
                                @if($d->discapacidad=='SI')
                                <option selected value="SI">SI</option>
                                <option value="NO">NO</option>
                                @else
                                <option value="SI">SI</option>
                                <option selected value="NO">NO</option>
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Étnia</label>
                            <select class="form-control" name="etnia_id">
                                @foreach($etnias as $key=>$value)
                                @if($d->etnia_id==$key)
                                <option selected value="{{$key}}">{{$value}}</option>
                                @else
                                <option value="{{$key}}">{{$value}}</option>
                                @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>¿Familias en Acción?</label>
                            <select class="form-control" name="familias_en_accion">
                                @if($d->familias_en_accion=='SI')
                                <option selected value="SI">SI</option>
                                <option value="NO">NO</option>
                                @else
                                <option value="SI">SI</option>
                                <option selected value="NO">NO</option>
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>¿Población Víctima del Conflicto?</label>
                            <select class="form-control" name="poblacion_victima_conflicto">
                                @if($d->poblacion_victima_conflicto=='SI')
                                <option selected value="SI">SI</option>
                                <option value="NO">NO</option>
                                @else
                                <option value="SI">SI</option>
                                <option selected value="NO">NO</option>
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>¿Desplazado?</label>
                            <select class="form-control" name="desplazado">
                                @if($d->desplazado=='SI')
                                <option selected value="SI">SI</option>
                                <option value="NO">NO</option>
                                @else
                                <option value="SI">SI</option>
                                <option selected value="NO">NO</option>
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Colegio de Procedencia</label>
                            <input type="text" class="form-control" value="{{$d->colegio_procedencia}}" name="colegio_procedencia" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>¿Compromiso Adquirido?</label>
                            <select class="form-control" name="compromiso_adquirido">
                                @if($d->compromiso_adquirido=='SI')
                                <option selected value="SI">SI</option>
                                <option value="NO">NO</option>
                                @else
                                <option value="SI">SI</option>
                                <option selected value="NO">NO</option>
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>¿Con Quién Vives?</label>
                            <select class="form-control" name="conquienvive_id">
                                @foreach($conquienvives as $key=>$value)
                                @if($d->conquienvive_id==$key)
                                <option selected value="{{$key}}">{{$value}}</option>
                                @else
                                <option value="{{$key}}">{{$value}}</option>
                                @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Rango SISBEN</label>
                            <select class="form-control select2" name="rangosisben_id">
                                @foreach($sisben as $key=>$value)
                                @if($d->rangosisben_id==$key)
                                <option selected value="{{$key}}">{{$value}}</option>
                                @else
                                <option value="{{$key}}">{{$value}}</option>
                                @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Entidad Salud</label>
                            <select class="form-control select2" name="entidadsalud_id">
                                @foreach($entidades as $key=>$value)
                                @if($d->entidadsalud_id==$key)
                                <option selected value="{{$key}}">{{$value}}</option>
                                @else
                                <option value="{{$key}}">{{$value}}</option>
                                @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Situación Año Anterior</label>
                            <select class="form-control select2" name="situacionanioanterior_id">
                                @foreach($situaciones as $key=>$value)
                                @if($d->situacionanioanterior_id==$key)
                                <option selected value="{{$key}}">{{$value}}</option>
                                @else
                                <option value="{{$key}}">{{$value}}</option>
                                @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-12" style="margin-top: 20px !important">
                    <div class="form-group">
                        <button class="btn btn-success icon-btn pull-left" type="submit"><i class="fa fa-fw fa-lg fa-save"></i>Guardar</button>
                        <button class="btn btn-info icon-btn pull-left" type="reset"><i class="fa fa-fw fa-lg fa-trash-o"></i>Limpiar</button>
                        <a class="btn btn-danger icon-btn pull-left" href="{{route('aspirante.menu',$a->id)}}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancelar</a>
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
                <p>Esta funcionalidad permitirá al usuario modificar los datos de los aspirantes siempre y cuando no se haya programado una cita para la entrevista.</p>
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