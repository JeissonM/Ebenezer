@extends('layouts.admin')
<link href='https://fonts.googleapis.com/css?family=Lobster|Open+Sans:400,400italic,300italic,300|Raleway:300,400,600'
      rel='stylesheet' type='text/css'>
{{--<link href="{{asset('plugins/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">--}}
<!-- Font Awesome -->
<link href="{{asset('plugins/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="{{asset('css/animate.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/style.css')}}">
@section('breadcrumb')
    <h1>
        Bienvenido
        <small>Sr(a). {{Auth::user()->nombres}}</small>
    </h1>
    <ol class="breadcrumb">
        <li class="active"><a href="{{route('home')}}"><i class="fa fa-home"></i> Inicio</a></li>
        <li><a>Inscripción</a></li>
    </ol>
@endsection
@section('content')
    <div class="alert alert-success alert-dismissible" style="font-size: 16px; color: #FFFFFF;">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-info"></i> Detalles!</h4>
        Realice el proceso de inscripción para su/sus hijo(s), gestione la información básica del acudiente, agende la
        entrevista para cada aspirante, configure el responsable financiero del estudiante, entre otras funciones.
    </div>
    <div class="box" style="background-color: transparent !important;">
        <div class="box-header with-border">
            <h3 class="box-title">MENÚ INSCRIPCIÓN</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                        title="Minimizar">
                    <i class="fa fa-minus"></i></button>
                <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip"
                        title="Cerrar">
                    <i class="fa fa-times"></i></button>
            </div>
        </div>
        <div class="box-body">
            @if(session()->exists('PAG_PANELACUDIENTE-INSCRIPCION-INFORMACIONACUDIENTE'))
                <div class="col-xs-12 col-sm-6 col-md-3">
                    <div class="image-flip">
                        <div class="mainflip flip-0" style="background-color: transparent;">
                            <div class="frontside"
                                 style="border-radius: 20px; background-color: #fff !important; opacity: 0.8;">
                                <div class="cardTeam">
                                    <div class="cardTeam-body text-center">
                                        <div class="badge bg-blue-gradient" style="font-size: 60px">1</div>
                                        <h4 class="cardTeam-title"><strong>Datos del acudiente</strong></h4>
                                        <p class="cardTeam-text" style="color: #000 !important;">Ingresar los datos del
                                            acudiente</p>
                                    </div>
                                </div>
                            </div>
                            <div class="backside"
                                 style="border-radius: 20px; background-color: #fff !important; opacity: 0.8;">
                                <div class="cardTeam">
                                    <div class="cardTeam-body text-center mt-4">
                                        <h4 class="cardTeam-title"><strong>Datos del acudiente</strong></h4>
                                        <p class="cardTeam-text" style="color: #000 !important;">Ingresa al sistema y
                                            accede a todas tus funciones de Vortal según tu rol</p>
                                        <a href="{{route('inscripcion.index') }}" class="badge btn-danger"><i
                                                class="fa fa-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            @if(session()->exists('PAG_PANELACUDIENTE-INSCRIPCION-INSCRIBIRASPIRANTE'))
                <div class="col-xs-12 col-sm-6 col-md-3">
                    <div class="image-flip">
                        <div class="mainflip flip-0" style="background-color: transparent;">
                            <div class="frontside"
                                 style="border-radius: 20px; background-color: #fff !important; opacity: 0.8;">
                                <div class="cardTeam">
                                    <div class="cardTeam-body text-center">
                                        <div class="badge bg-aqua-gradient" style="font-size: 60px">2</div>
                                        <h4 class="cardTeam-title" style="color: #00c0ef !important;"><strong>Inscribir
                                                aspirante</strong></h4>
                                        <p class="cardTeam-text" style="color: #000 !important;">Ingresar los datos del
                                            aspirante</p>
                                    </div>
                                </div>
                            </div>
                            <div class="backside"
                                 style="border-radius: 20px; background-color: #fff !important; opacity: 0.8;">
                                <div class="cardTeam">
                                    <div class="cardTeam-body text-center mt-4">
                                        <h4 class="cardTeam-title" style="color: #00c0ef !important;"><strong>Inscribir
                                                aspirante</strong></h4>
                                        <p class="cardTeam-text" style="color: #000 !important;">Ingresa al sistema y
                                            accede a todas tus funciones de Vortal según tu rol</p>
                                        <a href="{{route('inscripcion.aspirante') }}" class="badge btn-danger"><i
                                                class="fa fa-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            @if(session()->exists('PAG_PANELACUDIENTE-INSCRIPCION-PADRESASPIRANTES'))
                <div class="col-xs-12 col-sm-6 col-md-3">
                    <div class="image-flip">
                        <div class="mainflip flip-0" style="background-color: transparent;">
                            <div class="frontside"
                                 style="border-radius: 20px; background-color: #fff !important; opacity: 0.8;">
                                <div class="cardTeam">
                                    <div class="cardTeam-body text-center">
                                        <div class="badge bg-green-gradient" style="font-size: 60px">3</div>
                                        <h4 class="cardTeam-title" style="color: #00a65a !important;"><strong>Padres
                                                aspirante</strong></h4>
                                        <p class="cardTeam-text" style="color: #000 !important;">Ingresar los datos del
                                           los padres</p>
                                    </div>
                                </div>
                            </div>
                            <div class="backside"
                                 style="border-radius: 20px; background-color: #fff !important; opacity: 0.8;">
                                <div class="cardTeam">
                                    <div class="cardTeam-body text-center mt-4">
                                        <h4 class="cardTeam-title" style="color: #00a65a !important;"><strong>Padres
                                                aspirante</strong></h4>
                                        <p class="cardTeam-text" style="color: #000 !important;">Ingresa al sistema y
                                            accede a todas tus funciones de Vortal según tu rol</p>
                                        <a href="{{route('padresaspirantes.index') }}" class="badge btn-danger"><i
                                                class="fa fa-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            @if(session()->exists('PAG_PANELACUDIENTE-INSCRIPCION-RESPONSABLEFINANCIERO'))
                <div class="col-xs-12 col-sm-6 col-md-3">
                    <div class="image-flip">
                        <div class="mainflip flip-0" style="background-color: transparent;">
                            <div class="frontside"
                                 style="border-radius: 20px; background-color: #fff !important; opacity: 0.8;">
                                <div class="cardTeam">
                                    <div class="cardTeam-body text-center">
                                        <div class="badge bg-teal-gradient" style="font-size: 60px">4</div>
                                        <h4 class="cardTeam-title" style="color: #39cccc !important;"><strong>Responsable
                                                financiero aspirante</strong></h4>
                                        <p class="cardTeam-text" style="color: #000 !important;">Ingresar los datos del
                                            responsable financiero</p>
                                    </div>
                                </div>
                            </div>
                            <div class="backside"
                                 style="border-radius: 20px; background-color: #fff !important; opacity: 0.8;">
                                <div class="cardTeam">
                                    <div class="cardTeam-body text-center mt-4">
                                        <h4 class="cardTeam-title" style="color: #39cccc !important;"><strong>Responsable
                                                financiero aspirante</strong></h4>
                                        <p class="cardTeam-text" style="color: #000 !important;">Ingresa al sistema y
                                            accede a todas tus funciones de Vortal según tu rol</p>
                                        <a href="{{route('responsablefaspirante.index') }}" class="badge btn-danger"><i
                                                class="fa fa-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            @if(session()->exists('PAG_PANELACUDIENTE-INSCRIPCION-AGENDARCITA'))
                <div class="col-xs-12 col-sm-6 col-md-3">
                    <div class="image-flip">
                        <div class="mainflip flip-0" style="background-color: transparent;">
                            <div class="frontside"
                                 style="border-radius: 20px; background-color: #fff !important; opacity: 0.8;">
                                <div class="cardTeam">
                                    <div class="cardTeam-body text-center">
                                        <div class="badge bg-maroon-gradient" style="font-size: 60px">5</div>
                                        <h4 class="cardTeam-title" style="color: #d81b60 !important;"><strong>Programar
                                                entrevista</strong></h4>
                                        <p class="cardTeam-text" style="color: #000 !important;">Seleccione la fecha y hora para la entrevista</p>
                                    </div>
                                </div>
                            </div>
                            <div class="backside"
                                 style="border-radius: 20px; background-color: #fff !important; opacity: 0.8;">
                                <div class="cardTeam">
                                    <div class="cardTeam-body text-center mt-4">
                                        <h4 class="cardTeam-title" style="color: #d81b60 !important;"><strong>Programar
                                                entrevista</strong></h4>
                                        <p class="cardTeam-text" style="color: #000 !important;">Ingresa al sistema y
                                            accede a todas tus funciones de Vortal según tu rol</p>
                                        <a href="{{route('entrevistaa.index') }}" class="badge btn-danger"><i
                                                class="fa fa-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            @if(session()->exists('PAG_PANELACUDIENTE-INSCRIPCION-MODIFICARASPIRANTE'))
                <div class="col-xs-12 col-sm-6 col-md-3">
                    <div class="image-flip">
                        <div class="mainflip flip-0" style="background-color: transparent;">
                            <div class="frontside"
                                 style="border-radius: 20px; background-color: #fff !important; opacity: 0.8;">
                                <div class="cardTeam">
                                    <div class="cardTeam-body text-center">
                                        <div class="badge bg-yellow-gradient" style="font-size: 60px">6</div>
                                        <h4 class="cardTeam-title" style="color: #f39c12 !important;"><strong>Modificar
                                                datos de los aspirantes</strong></h4>
                                        <p class="cardTeam-text" style="color: #000 !important;">Actualiza los datos del
                                            aspirante</p>
                                    </div>
                                </div>
                            </div>
                            <div class="backside"
                                 style="border-radius: 20px; background-color: #fff !important; opacity: 0.8;">
                                <div class="cardTeam">
                                    <div class="cardTeam-body text-center mt-4">
                                        <h4 class="cardTeam-title" style="color: #f39c12 !important;"><strong>Modificar
                                                datos de los aspirantes</strong></h4>
                                        <p class="cardTeam-text" style="color: #000 !important;">Ingresa al sistema y
                                            accede a todas tus funciones de Vortal según tu rol</p>
                                        <a href="{{route('aspirante.lista') }}" class="badge btn-danger"><i
                                                class="fa fa-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            @if(session()->exists('PAG_PANELACUDIENTE-INSCRIPCION-DOCUMENTOSANEXOS'))
                <div class="col-xs-12 col-sm-6 col-md-3">
                    <div class="image-flip">
                        <div class="mainflip flip-0" style="background-color: transparent;">
                            <div class="frontside"
                                 style="border-radius: 20px; background-color: #fff !important; opacity: 0.8;">
                                <div class="cardTeam">
                                    <div class="cardTeam-body text-center">
                                        <div class="badge bg-purple-gradient" style="font-size: 60px">7</div>
                                        <h4 class="cardTeam-title" style="color: #605ca8 !important;"><strong>Ver
                                                documentos anexos al proceso de inscripción</strong></h4>
                                        <p class="cardTeam-text" style="color: #000 !important;">Consultar los documentos del proceso</p>
                                    </div>
                                </div>
                            </div>
                            <div class="backside"
                                 style="border-radius: 20px; background-color: #fff !important; opacity: 0.8;">
                                <div class="cardTeam">
                                    <div class="cardTeam-body text-center mt-4">
                                        <h4 class="cardTeam-title" style="color: #605ca8 !important;"><strong>Ver
                                                documentos anexos al proceso de inscripción</strong></h4>
                                        <p class="cardTeam-text" style="color: #000 !important;">Ingresa al sistema y
                                            accede a todas tus funciones de Vortal según tu rol</p>
                                        <a href="{{route('inscripcion.documentosanexos') }}" class="badge btn-danger"><i
                                                class="fa fa-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            @if(session()->exists('PAG_PANELACUDIENTE-INSCRIPCION-IMPRIMIRFORMULARIO'))
                <div class="col-xs-12 col-sm-6 col-md-3">
                    <div class="image-flip">
                        <div class="mainflip flip-0" style="background-color: transparent;">
                            <div class="frontside"
                                 style="border-radius: 20px; background-color: #fff !important; opacity: 0.8;">
                                <div class="cardTeam">
                                    <div class="cardTeam-body text-center">
                                        <div class="badge bg-red-gradient" style="font-size: 60px">8</div>
                                        <h4 class="cardTeam-title" style="color: #dd4b39 !important;"><strong>Imprimir
                                                formulario de inscripción</strong></h4>
                                        <p class="cardTeam-text" style="color: #000 !important;">Descargar formulario de inscripción</p>
                                    </div>
                                </div>
                            </div>
                            <div class="backside"
                                 style="border-radius: 20px; background-color: #fff !important; opacity: 0.8;">
                                <div class="cardTeam">
                                    <div class="cardTeam-body text-center mt-4">
                                        <h4 class="cardTeam-title" style="color: #dd4b39 !important;"><strong>Imprimir
                                                formulario de inscripción </strong></h4>
                                        <p class="cardTeam-text" style="color: #000 !important;">Ingresa al sistema y
                                            accede a todas tus funciones de Vortal según tu rol</p>
                                        <a href="{{route('inscripcion.formimprimir') }}" class="badge btn-danger"><i
                                                class="fa fa-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('plugins/jquery/dist/jquery.min.js')}}"></script>
    <!-- Bootstrap -->
    <script src="{{ asset('plugins/bootstrap/dist/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('js/wow.js')}}"></script>
    <script src="{{asset('js/login.js')}}"></script>
@endsection
