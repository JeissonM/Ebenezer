@extends('layouts.admin')
@section('breadcrumb')
<h1>
    Bienvenido
    <small>Sr(a). {{Auth::user()->nombres}}</small>
</h1>
<ol class="breadcrumb">
    <li><a href="{{route('home')}}"><i class="fa fa-home"></i> Inicio</a></li>
    <li><a href="{{route('menu.usuarios')}}"><i class="fa fa-users"></i> Usuarios</a></li>
    <li class="active"><a>Resultados Creación de Usuarios de Forma Automática Para {{$actor}}</a></li>
</ol>
@endsection
@section('content')
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">RESULTADOS CREAR USUARIOS AUTOMÁTICOS</h3>
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
            <div class="col-md-12" style="margin-top: 40px;">
                <h4>Proceso de conversión finalizado. Los resultados fueron cargados en un archivo que puede descargar desde el siguiente enlace: <a href="{{asset('documentos/log/'.$response['archivo'])}}" target="_blank">Descargar Archivo</a></h4>
            </div>
            <div class="col-md-12" style="margin-top: 20px; background-color: #000000; color: #ffffff;">
                <h4>Resultado Proceso</h4>
                <br />
                @foreach($response['resultado'] as $r)
                <p>{{$r}}</p>
                @endforeach
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