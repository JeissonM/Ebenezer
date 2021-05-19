<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Lista de Calificaciones</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
    <style>
        body {
            font-size: 12px;
        }

        .bar {
            padding: 3px 3px 3px 3px;
            width: 100%;
            color: #FFFFFF;
            text-align: center;
            font-size: 14px;
            font-weight: bold;
        }

        .bar-a {
            background-color: red !important;
        }

        .bar-n {
            background-color: #1c84c6 !important;
        }

        .bar-x {
            background-color: #f0f3f4 !important;
        }

        .tb {
            text-align: center;
        }

        table {
            width: 100%;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="col-md-12">
        <p style="text-align: left;">Fecha de Generación: {{$fecha}} - Ebenezer - Valledupar</p>
    </div>
    <div class="bar bar-a">Lista de Calificaciones</div>
    <div style="text-align: left">
        <table>
            <thead>
            <tr>
                <th align="left" style="width: 33.33%">UNIDAD ACADÉMICA</th>
                <th align="left" style="width: 33.33%">JORNADA</th>
                <th align="left" style="width: 33.33%">PERÍODO</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td style="width: 33.33%">{{$unidad->nombre}}</td>
                <td style="width: 33.33%">{{$jornada->descripcion}}</td>
                <td style="width: 33.33%">{{$periodo->etiqueta." ".$periodo->anio}}</td>
            </tr>
            </tbody>
        </table>
        <table>
            <thead>
            <tr>
                <th align="left" style="width: 33.33%">DOCENTE</th>
                <th align="left" style="width: 33.33%">GRADO</th>
                <th align="left" style="width: 33.33%">GRUPO</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td style="width: 33.33%">{{$docente->personanatural->primer_nombre." ".$docente->personanatural->segundo_nombre." ".$docente->personanatural->primer_apellido." ".$docente->personanatural->segundo_apellido}}</td>
                <td style="width: 33.33%">{{$grado->etiqueta}}</td>
                <td style="width: 33.33%">{{$grupo->nombre}}</td>
            </tr>
            </tbody>
        </table>
    </div>
    <div>
        <table>
            <tbody>
            <tr>
                <td class="bar bar-n" style="width:100%;padding: 5px;text-align: center"><b>ESTUDIANTES</b>
                </td>
            </tr>
            </tbody>
        </table>
        <table>
            <tbody>
            @if($estudiantes != null)
                @foreach($estudiantes as $c)
                    <tr>
                        <td style="width: 50%; border: 1px solid black;border-collapse: collapse;">{{$c}}</td>
                        @for($i=1;$i<=10;$i++)
                            <td style="border: 1px solid black;border-collapse: collapse; width: 5%"></td>
                        @endfor
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
