<html>

<head>
    <link rel="stylesheet" type="text/css" href="{{ asset('bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
    <style>
        body {
            font-size: 12px;
        }

        .bar {
            padding: 3px 3px 3px 3px;
            color: #FFFFFF;
            text-align: left;
            font-size: 12px;
            font-weight: bold;
        }

        .bar-a {
            background-color: #f96b6b !important;
        }

        .bar-n {
            background-color: #1c84c6 !important;
        }

        .bar-x {
            background-color: #f0f3f4 !important;
        }

        .tb {
            color: #FFFFFF;
            text-align: left;
            font-size: 12px;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="row">
        <div>
            <div style="width: 50%; display: block; float: left;">
                <img src="{{asset('images/logo.png')}}" width="240px" />
            </div>
            <div style="width: 50%; display: block; float: right; font-size: 10px; text-align: right; line-height: 1px;">
                <p>Nit: 892300787-1 | Dane: 320001001234</p>
                <p>Licencia No 000692 DEL 11 mar--2013</p>
                <p>Período: {{$periodo." - ".$evaluacion}}</p>
                <p>Jornada: {{$jornada}}</p>
            </div>
        </div>
    </div>
    <div class="row">
        <table class="table tb" style="margin-bottom: 0px !important; font-size: 12px;">
            <thead>
                <tr>
                    <th style="width: 8%; background-color: #f96b6b !important; padding: 2px;">CÓDIGO</th>
                    <th style="width: 13%; background-color: #f96b6b !important; padding: 2px;">{{$identificacion}}</th>
                    <th style="width: 12%; background-color: #f96b6b !important; padding: 2px;">ESTUDIANTE</th>
                    <th style="width: 40%; background-color: #f96b6b !important; padding: 2px;">{{$estudiante}}</th>
                    <th style="width: 10%; background-color: #f96b6b !important; padding: 2px;">PROMEDIO</th>
                    <th style="width: 5%; background-color: #f96b6b !important; padding: 2px;">{{$promedio}}</th>
                    <th style="width: 8%; background-color: #f96b6b !important; padding: 2px;">PUESTO</th>
                    <th style="width: 4%; background-color: #f96b6b !important; padding: 2px;">{{$puesto}}</th>
                </tr>
            </thead>
        </table>
        <table class="table tb" style="margin-top: 0px !important; margin-bottom: 0px !important;">
            <thead>
                <tr>
                    <th style="width: 20%; background-color: #f96b6b !important; padding: 2px;">ÁREA/ASIGNATURA</th>
                    <th style="width: 5%; background-color: #f96b6b !important; padding: 2px;">I.H.</th>
                    <th style="width: 5%; background-color: #f96b6b !important; padding: 2px;">F.L.</th>
                    <th style="width: 70%; background-color: #f96b6b !important; padding: 2px; text-align: center;">INFORME DESCRIPTIVO-DESEMPEÑOS</th>
                </tr>
            </thead>
        </table>
        <br>
        @foreach($areas as $a)
        <table class="table tb" style="margin-top: 0px !important; margin-bottom: 0px !important;">
            <thead>
                <tr>
                    <th style="width: 70%; border-bottom: 1px solid; background-color: #1c84c6 !important; padding: 2px;">{{$a['area']}}</th>
                    <th style="width: 15%; border-bottom: 1px solid; background-color: #1c84c6 !important; padding: 2px;">{{number_format($a['nota'],1)}}</th>
                    <th style="width: 15%; border-bottom: 1px solid; background-color: #1c84c6 !important; padding: 2px;">{{$a['equivalencia']}}</th>
                </tr>
            </thead>
        </table>
        @foreach($a['materias'] as $m)
        <table class="table" style="margin-top: 0px !important; color: #000 !important; margin-bottom: 0px !important;">
            <thead>
                <tr>
                    <td style="width: 20%; border-bottom: 1px solid; background-color: #e6e7ef !important; padding: 2px; text-align: left;">{{$m['materia']." (".$m['peso']."%)"}} <br><b style="font-weight: bold !important;">{{number_format($m['nota'],1)." - ".$m['equivalencia']}}</b></td>
                    <td style="width: 5%; border-bottom: 1px solid; background-color: #e6e7ef !important; padding: 2px;">{{$m['ih']}}</td>
                    <td style="width: 5%; border-bottom: 1px solid; background-color: #e6e7ef !important; padding: 2px;">{{$m['fallas']}}</td>
                    <td style="width: 70%; border-bottom: 1px solid; background-color: #e6e7ef !important; padding: 2px;">
                        @if($m['logros']!=null)
                        <ul>
                            @foreach($m['logros'] as $l)
                            <li>{{$l}}</li>
                            @endforeach
                        </ul>
                        @else
                        ---
                        @endif
                    </td>
                </tr>
            </thead>
        </table>
        @endforeach
        @endforeach
        <table class="table" style="margin-top: 0px !important; color: #000 !important; margin-bottom: 0px !important;">
            <thead>
                <tr>
                    <td style="width: 50%; border-bottom: 1px solid; background-color: #e6e7ef !important; padding: 2px; text-align: left; position: absolute; bottom: 0px;"><br><br><br>{{$docente}}<br>Firma del Director de Grupo</td>
                    <td style="width: 50%; border-bottom: 1px solid; background-color: #e6e7ef !important; padding: 2px;">
                        <p>UNIDAD: {{$unidad}}</p>
                        <p>JORNADA: {{$jornada}}</p>
                        <p>PERÍODO: {{$periodo}}</p>
                        <p>EVALUACIÓN: {{$evaluacion}}</p>
                        <p>GRUPO: {{$grupo}}</p>
                    </td>
                </tr>
            </thead>
        </table>
        <br>
        <p style="text-align: right;">{{$unidad}} - Impreso {{$hoy}}</p>
    </div>
</body>

</html>