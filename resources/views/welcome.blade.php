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
                    <h2>Bienvenido!</h2>
                    <h3>Ingrese a la plataforma o inicie su proceso de inscripción en línea...</h3>
                </div>
            </div>
        </div>
        <section style="padding-top: 20px;">
            <div class="container">
                <div class="row bort text-center">
                    <div class="social">
                        <ul>
                            <li data-toggle="tooltip" data-placement="top" title="Registro de Acudiente" class="sb"><a href="{{ route('register') }}"><i class="fa fa-arrow-right"></i></a></li>
                            <li data-toggle="tooltip" data-placement="top" title="Ingresar al Sistema" class="sb"><a href="{{ url('/login') }}"><i class="fa fa-sign-in"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
        <footer class="footer">
            <div class="container">
                <div class="row bort">
                    <div class="copyright">
                        © 2020 {{config('app.name')}}. Todos los Derechos Reservados.
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