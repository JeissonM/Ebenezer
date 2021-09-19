@extends('layouts.admin')
@section('breadcrumb')
<h1>
    Bienvenido
    <small>Sr(a). {{Auth::user()->nombres}}</small>
</h1>
<ol class="breadcrumb">
    <li><a href="{{route('home')}}"><i class="fa fa-home"></i> Inicio</a></li>
    <li><a href="{{route('menu.inscripcion')}}"><i class="fa fa-edit"></i> Inscripción</a></li>
    <li class="active"><a>Inscribir Aspirante</a></li>
</ol>
@endsection
@section('content')
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">INSCRIBIR ASPIRANTE</h3>
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
        @if($contrato!=null)
        <div class="col-md-12" id="form1">
            <h3 class="text-success">Lea cuidadosamente el contrato de inscripción y acepte los términos para continuar con el proceso de inscripción</h3>
            {!!$contrato->contrato!!}
            <div class="col-md-12" style="margin-top: 20px !important">
                <div class="form-group">
                    <button class="btn btn-success icon-btn pull-left" onclick="aceptar()"><i class="fa fa-fw fa-lg fa-save"></i>Aceptar</button>
                    <a href="{{route('menu.inscripcion')}}" class="btn btn-danger icon-btn pull-left"><i class="fa fa-fw fa-lg fa-replly"></i>Cancelar</a>
                </div>
            </div>
        </div>
        <div class="col-md-12" id="form2" style="display: none;">
            <div class="col-md-12">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Indique la Sede en la que Desea Estudiar</label>
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
                        <label>Grado al que Aspira</label>
                        <select class="form-control" id="grado_id">
                            @foreach($grados as $key=>$value)
                            <option value="{{$key}}">{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Tipo Documento de Identidad</label>
                        <select class="form-control" id="tipodoc_id">
                            @foreach($tipodoc as $key=>$value)
                            <option value="{{$key}}">{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Número Documento Aspirante</label>
                        <input class="form-control" id="numero_documento" />
                    </div>
                </div>
            </div>
            <div class="col-md-12" style="margin-top: 20px !important">
                <div class="form-group">
                    <button class="btn btn-success icon-btn pull-left" onclick="ir()"><i class="fa fa-fw fa-lg fa-save"></i>Aceptar</button>
                    <button class="btn btn-info icon-btn pull-left" type="reset"><i class="fa fa-fw fa-lg fa-trash-o"></i>Limpiar</button>
                    <a class="btn btn-danger icon-btn pull-left" href="{{route('menu.inscripcion')}}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancelar</a>
                </div>
            </div>
        </div>
        @else
        <div class="col-md-12">
            <div class="col-md-12">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Indique la Sede en la que Desea Estudiar</label>
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
                        <label>Grado al que Aspira</label>
                        <select class="form-control" id="grado_id">
                            @foreach($grados as $key=>$value)
                            <option value="{{$key}}">{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Tipo Documento de Identidad</label>
                        <select class="form-control" id="tipodoc_id">
                            @foreach($tipodoc as $key=>$value)
                            <option value="{{$key}}">{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Número Documento Aspirante</label>
                        <input class="form-control" id="numero_documento" />
                    </div>
                </div>
            </div>
            <div class="col-md-12" style="margin-top: 20px !important">
                <div class="form-group">
                    <button class="btn btn-success icon-btn pull-left" onclick="ir()"><i class="fa fa-fw fa-lg fa-save"></i>Aceptar</button>
                    <button class="btn btn-info icon-btn pull-left" type="reset"><i class="fa fa-fw fa-lg fa-trash-o"></i>Limpiar</button>
                    <a class="btn btn-danger icon-btn pull-left" href="{{route('menu.inscripcion')}}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancelar</a>
                </div>
            </div>
        </div>
        @endif
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
                <p>Esta funcionalidad permitirá al usuario inscribir uno a varios aspirantes siempre y cuando haya fechas definidas para el proceso de inscripción y convocatorias abiertas de inscripción.</p>
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

    function ir() {
        var doc = $("#numero_documento").val();
        if (doc.length > 0) {
            location.href = url + "acudiente/inscripcion/aspirante/inscribir/" + $("#unidad_id").val() + "/" + $("#grado_id").val() + "/" + $("#periodoacademico_id").val() + "/" + $("#jornada_id").val() + "/" + $("#tipodoc_id").val() + "/" + doc + "/inicio";
        } else {
            notify('Alerta', 'Debe indicar el número de documento del aspirante', 'error');
        }
    }

    function aceptar(){
        $("#form1").fadeOut();
        $("#form2").fadeIn();
    }
</script>
@endsection
