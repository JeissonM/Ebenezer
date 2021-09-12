<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Ebenezer') }}</title>
    <link href='https://fonts.googleapis.com/css?family=Lobster|Open+Sans:400,400italic,300italic,300|Raleway:300,400,600' rel='stylesheet' type='text/css'>
    <!-- Bootstrap -->
    <link href="{{asset('plugins/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{asset('plugins/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{asset('css/animate.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/style.css')}}">
</head>

<body>
    <div class="content">
        <div class="container wow fadeInUp delay-03s">
            <div class="row">
                <div class="logo text-center">
                    <img src="{{asset('images/logo.png')}}" alt="logo" width="350">
                    <h2>Hola, Bienvenido!</h2>
                    <h3>¿Qué desea hacer? Ingrese a la plataforma o inicie su proceso de inscripción en línea</h3>
                </div>
            </div>
        </div>
        <section style="padding-top: 20px;">
            <div class="container">
                <div class="col-xs-12 col-sm-6 col-md-3"></div>

                <div class="col-xs-12 col-sm-6 col-md-3">
                    <div class="image-flip">
                        <div class="mainflip flip-0" style="background-color: transparent;">
                            <div class="frontside" style="border-radius: 20px; background-color: #fff !important; opacity: 0.8;">
                                <div class="cardTeam">
                                    <div class="cardTeam-body text-center">
                                        <p><img class="img-fluid" src="{{asset('images/login.png')}}" alt="cardTeam image"></p>
                                        <h4 class="cardTeam-title">Ingresar al Sistema</h4>
                                        <p class="cardTeam-text" style="color: #000 !important;">Ingresa a tu panel Ebenezer</p>
                                    </div>
                                </div>
                            </div>
                            <div class="backside" style="border-radius: 20px; background-color: #fff !important; opacity: 0.8;">
                                <div class="cardTeam">
                                    <div class="cardTeam-body text-center mt-4">
                                        <h4 class="cardTeam-title">Ingresar al Sistema</h4>
                                        <p class="cardTeam-text" style="color: #000 !important;">Ingresa al sistema y accede a todas tus funciones de Vortal según tu rol</p>
                                        <a href="{{ url('/login') }}" class="btn btn-danger"><i class="fa fa-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-6 col-md-3">
                    <div class="image-flip">
                        <div class="mainflip flip-0" style="background-color: transparent;">
                            <div class="frontside" style="border-radius: 20px; background-color: #fff !important; opacity: 0.8;">
                                <div class="cardTeam">
                                    <div class="cardTeam-body text-center">
                                        <p><img class="img-fluid" src="{{asset('images/docente.png')}}" alt="cardTeam image"></p>
                                        <h4 class="cardTeam-title">Regístrate en el sistema!</h4>
                                        <p class="cardTeam-text" style="color: #000 !important;">Registro de Acudiente y Aspirantes</p>
                                    </div>
                                </div>
                            </div>
                            <div class="backside" style="border-radius: 20px; background-color: #fff !important; opacity: 0.8;">
                                <div class="cardTeam">
                                    <div class="cardTeam-body text-center mt-4">
                                        <h4 class="cardTeam-title">Registro en el sistema</h4>
                                        <p class="cardTeam-text" style="color: #000 !important;">Date prisa! Registra un usuario como acudiente, procede a llenar tus datos y registrar a tus hijos para pertenecer a la insitución. ¿Qué esperas?</p>
                                        <a href="{{ route('register') }}" class="btn btn-danger"><i class="fa fa-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-xs-12 col-sm-6 col-md-3"></div>
            </div>
        </section>
        <footer class="footer">
            <div class="container">
                <div class="row bort">
                    <div class="copyright">
                        © 2021 {{config('app.name')}}. Todos los Derechos Reservados.
                        <div class="credits">Desarrollado por <a href="#">Jeisson Mandón</a>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    <!-- jQuery -->
    <script src="{{ asset('plugins/jquery/dist/jquery.min.js')}}"></script>
    <!-- Bootstrap -->
    <script src="{{ asset('plugins/bootstrap/dist/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('js/wow.js')}}"></script>
    <script src="{{asset('js/login.js')}}"></script>
</body>

</html>