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
        <li><a href="{{route('padresestudiante.inicio',$a->id)}}"><i class="fa fa-users"></i> Padres</a></li>
        <li class="active"><a>Crear Padre</a></li>
    </ol>
@endsection
@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">INGRESAR LOS DATOS DEL PADRE/MADRE</h3>
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
                <form class="form" role='form' method="POST" action="{{route('padresestudiante.store')}}">
                    @csrf
                    <input type="hidden" name="estudiante_id" value="{{$a->id}}" />
                    <h5 class="text-danger">Los campos con asterísco(*) son obligatorios</h5>
                    @if($acu!=null)
                        <div class="col-md-12">
                            <h4 style="color: green;"><i style="color: green;" class="fa fa-warning"></i> Usted es acudiente del estudiante seleccionado, ¿desea registrarse como padre/madre sin tener que llenar el formulario? si la respuesta es si: escriba los datos obligatorios para verificar su identidad y de click en GUARDAR</a></h4>
                        </div>
                        <input type="hidden" name="automatico" value="{{$acu->id}}" />
                    @endif
                    <div class="col-md-12">
                        <h3>Información Personal</h3>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Tipo Documento*</label>
                                <select class="form-control" name="tipodoc_id" required="">
                                    @foreach($tipodoc as $key=>$value)
                                        <option value="{{$key}}">{{$value}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Número de Identidad*</label>
                                <input class="form-control" type="text" required="" name="numero_documento">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Lugar de Expedición</label>
                                <input class="form-control" type="text" name="lugar_expedicion">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Fecha de Expedición</label>
                                <input class="form-control" type="date" name="fecha_expedicion">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Primer Nombre*</label>
                                <input class="form-control" type="text" required="required" name="primer_nombre">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Segundo Nombre</label>
                                <input class="form-control" type="text" name="segundo_nombre">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Primer Apellido*</label>
                                <input class="form-control" type="text" required="required" name="primer_apellido">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Segundo Apellido</label>
                                <input class="form-control" type="text" name="segundo_apellido">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Sexo</label>
                                <select class="form-control" name="sexo_id">
                                    @foreach($sexos as $key=>$value)
                                        <option value="{{$key}}">{{$value}}</option>
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
                                <input class="form-control" type="text" name="direccion_residencia">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Barrio de Residencia</label>
                                <input class="form-control" type="text" name="barrio_residencia">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Correo Electrónico</label>
                                <input class="form-control" type="email" name="correo">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Teléfono</label>
                                <input class="form-control" type="tel" name="telefono">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Celular</label>
                                <input class="form-control" type="number" name="celular">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <h3>Información Complementaria</h3>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>¿Vive?</label>
                                <select class="form-control" name="vive">
                                    <option value="SI">SI</option>
                                    <option value="NO">NO</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>¿Es Acudiente?</label>
                                <select class="form-control" name="acudiente">
                                    <option value="SI">SI</option>
                                    <option value="NO">NO</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Padre/Madre*</label>
                                <select class="form-control" name="padre_madre" required>
                                    <option value="PADRE">PADRE</option>
                                    <option value="MADRE">MADRE</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Profesión/Ocupación</label>
                                <select class="form-control select2" name="ocupacion_id">
                                    @foreach($profesions as $key=>$value)
                                        <option value="{{$key}}">{{$value}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12" style="margin-top: 20px !important">
                        <div class="form-group">
                            <button class="btn btn-success icon-btn pull-left" type="submit"><i class="fa fa-fw fa-lg fa-save"></i>Guardar</button>
                            <button class="btn btn-info icon-btn pull-left" type="reset"><i class="fa fa-fw fa-lg fa-trash-o"></i>Limpiar</button>
                            <a class="btn btn-danger icon-btn pull-left" href="{{route('padresestudiante.inicio',$a->id)}}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancelar</a>
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
                    <p>Esta funcionalidad permitirá al usuario gestionar la información de los padres deL estudiante seleccionado.</p>
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
