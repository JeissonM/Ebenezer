@extends('layouts.admin')
@section('breadcrumb')
<h1>
    Bienvenido
    <small>Sr(a). {{Auth::user()->nombres}}</small>
</h1>
<ol class="breadcrumb">
    <li><a href="{{route('home')}}"><i class="fa fa-home"></i> Inicio</a></li>
    <li><a href="{{route('menu.documental')}}"><i class="fa fa-book"></i> Documental</a></li>
    <li><a href="{{route('logro.personalizar_inicio')}}"><i class="fa fa-edit"></i> Personalizar Logros</a></li>
    <li class="active"><a>Personalizar</a></li>
</ol>
@endsection
@section('content')
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">PERSONALIZAR LOGROS</h3>
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
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr class="bg-purple">
                            <th>UNIDAD</th>
                            <th>PERÍODO</th>
                            <th>JORNADA</th>
                            <th>GRADO</th>
                            <th>GRUPO</th>
                            <th>MATERIA</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{$gmd->gradomateria->unidad->nombre}}</td>
                            <td>{{$gmd->gradomateria->periodoacademico->etiqueta."-".$gmd->gradomateria->periodoacademico->anio}}</td>
                            <td>{{$gmd->gradomateria->jornada->descripcion." - ".$gmd->gradomateria->jornada->jornadasnies}}</td>
                            <td>{{$gmd->gradomateria->grado->etiqueta}}</td>
                            <td>{{$gmd->grupo->nombre}}</td>
                            <td>{{$gmd->gradomateria->materia->codigomateria."-".$gmd->gradomateria->materia->nombre}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr class="bg-purple">
                            <th>IDENTIFICACIÓN</th>
                            <th>ESTUDIANTE</th>
                            <th>UNIDAD</th>
                            <th>PERÍODO ACADÉMICO</th>
                            <th>JORNADA</th>
                            <th>GRADO</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{$est->personanatural->persona->numero_documento}}</td>
                            <td>{{$est->personanatural->primer_nombre." ".$est->personanatural->segundo_nombre." ".$est->personanatural->primer_apellido." ".$est->personanatural->segundo_apellido}}</td>
                            <td>{{$est->unidad->nombre." - ".$est->unidad->ciudad->nombre}}</td>
                            <td>{{$est->periodoacademico->etiqueta." - ".$est->periodoacademico->anio}}</td>
                            <td>{{$est->jornada->descripcion." - ".$est->jornada->jornadasnies}}</td>
                            <td>{{$est->grado->etiqueta." - ".$est->grado->descripcion}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr class="bg-purple">
                            <th>LOGRO ORIGINAL</th>
                            <th>PERSONALIZAR</th>
                            <th>LOGRO PERSONALIZADO</th>
                            <th>QUITAR PERSONALIZADO</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($asignados)>0)
                        @foreach($asignados as $a)
                        <tr>
                            <td>{{$a->logro->descripcion}}</td>
                            <td>
                                @if($a->personalizado==null)
                                <a data-toggle="modal" onclick="ponerDato(this.id)" id="{{$a->id}}" data-target="#exampleModal" style="margin-left: 10px; color: blue; cursor:pointer;" data-toggle="tooltip" title="Personalizar" style="margin-left: 10px;"><i class="fa fa-edit"></i> PERSONALIZAR</a>
                                @else
                                ---
                                @endif
                            </td>
                            <td>@if($a->personalizado!=null) {{$a->personalizado->descripcion}} @else --- NO --- @endif</td>
                            <td>
                                @if($a->personalizado!=null)
                                <a href="{{route('logro.retirarlp',[$gmd->id,$est->id,$a->personalizado->id])}}" style="margin-left: 10px; color: red;" data-toggle="tooltip" title="Quitar Personalizado" style="margin-left: 10px;"><i class="fa fa-remove"></i> RETIRAR</a>
                                @else
                                ---
                                @endif
                            </td>
                        </tr>
                        @endforeach
                        @endif
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
                <p>Esta funcionalidad permite personalizar los logros para un estudiante particular.</p>
            </div>
            <div class="modal-footer" style="background-color: #d2d6de !important; opacity: .65;">
                <button type="button" class="btn btn-block btn-danger btn-flat pull-right" data-dismiss="modal"><i class="fa fa-reply"></i> Regresar
                </button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">Personalizar Logro</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form" id="logro-form" role='form' method="POST" action="{{route('logro.guardarlp')}}">
                    @csrf
                    <input type="hidden" id="asignarlogrogrupomateria_id" name="asignarlogrogrupomateria_id">
                    <input type="hidden" name="estudiante_id" value="{{$est->id}}">
                    <input type="hidden" name="gmd" value="{{$gmd->id}}">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Descripción</label>
                            <textarea class="form-control " name="descripcion" rows="5"></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button onclick="guardar()" type="button" class="btn btn-primary">Guardar</button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script type="text/javascript">
    $(document).ready(function() {
        //$('#example1').DataTable();
        $(document.body).attr('class', 'skin-blue sidebar-mini sidebar-collapse');
    });

    function guardar() {
        $("#logro-form").submit();
    }

    function ponerDato(id) {
        $("#asignarlogrogrupomateria_id").val(id);
    }
</script>
@endsection