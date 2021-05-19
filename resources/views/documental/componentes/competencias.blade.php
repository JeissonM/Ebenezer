@extends('layouts.admin')
@section('breadcrumb')
<h1>
    Bienvenido
    <small>Sr(a). {{Auth::user()->nombres}}</small>
</h1>
<ol class="breadcrumb">
    <li><a href="{{route('inicio')}}"><i class="fa fa-home"></i> Inicio</a></li>
    <li><a href="{{route('menu.documental')}}"><i class="fa fa-book"></i> Documental</a></li>
    <li><a href="{{route('componente.index')}}"><i class="fa fa-bookmark-o"></i> Componentes</a></li>
    <li class="active"><a> Competencias</a></li>
</ol>
@endsection
@section('content')
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">LISTADO DE COMPONENTES</h3>
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
                <table id="example1" class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr class="bg-purple">
                            <th>COMPONENTE</th>
                            <th>COMPETENCIAS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $d)
                        <tr>
                            <td>
                                <a onclick="ponerComponente(this.id)" id="{{$d->id}}" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#modal2"><i style="font-size: 16px;" class="fa fa-plus-circle"></i></a>
                                {{$d->componente}}
                            </td>
                            <td>
                                @if(count($d->componentecompetencias)>0)
                                @foreach($d->componentecompetencias as $comp)
                                <a href="{{route('componente.deletecompetencias',$comp->id)}}" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Eliminar"><i style="font-size: 16px;" class="fa fa-trash-o"></i></a>
                                {{$comp->competencia->competencia}}
                                <hr>
                                @endforeach
                                @endif
                            </td>
                        </tr>
                        @endforeach
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
                <p>Esta funcionalidad permite gestionar las competencias que tendrá asociado cada componente.</p>
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

<div class="modal fade" id="modal2">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Agregar Competencia</h4>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table id="example2" class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr class="info">
                                <th>COMPETENCIA</th>
                                <th>AGREGAR</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($competencias as $c)
                            <tr>
                                <td>{{$c->competencia}}</td>
                                <td>
                                    <a onclick="agregar(this.id)" id="{{$c->id}}" style="margin-left: 10px; cursor: pointer;" data-toggle="tooltip" title="Agregar Competencia" style="margin-left: 10px;"><i class="fa fa-arrow-right"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
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
        $('#example2').DataTable();
        //$(document.body).attr('class', 'skin-blue sidebar-mini sidebar-collapse');
    });

    var componente = 0;

    function ponerComponente(id) {
        componente = id;
    }

    function agregar(id) {
        if (componente != 0) {
            location.href = url + "documental/componente/competencias/" + componente + "/" + id + "/agregar";
        } else {
            notify('Atención', 'No hay componente indicado', 'warning');
        }
    }
</script>
@endsection