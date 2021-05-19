<html>

<head>
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
    </style>
</head>

<body>
    <div class="row">
        <div class="col-md-12">
            <p style="text-align: left;">Fecha de Generación: {{$hoy}} - Ebenezer - Valledupar</p>
        </div>
        <div class="bar bar-a">Inscripcion en Linea</div>
        <div class="bar bar-n">Datos Institucionales</div>
        <div style="width: 65%; display: block; float: left;">
            <table class="table tb">
                <thead>
                    <tr>
                        <th align="center" align="center">UNIDAD ACADÉMICA</th>
                        <th align="center" align="center">JORNADA</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{$unidad['nombre']}}</td>
                        <td>{{$jornada['descripcion']}}</td>
                    </tr>
                </tbody>
            </table>
            <table class="table tb">
                <thead>
                    <tr>
                        <th align="center" align="center">PERÍODO</th>
                        <th align="center" align="center">GRADO</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{$periodoacademico['etiqueta']." ".$periodoacademico['anio']}}</td>
                        <td>{{$grado['etiqueta']}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div  style="width: 25%; display: block; float:right;">
            @if($foto!='NO')
            <img src="{{asset('images/fotos/'.$foto)}}" width="100px" />
            @else
            <img src="{{asset('images/fotos/avatar.jpg')}}" width="100px" />
            @endif
        </div>
        <div class="bar bar-n">Datos Personales</div>
        <div>
            <table class="table tb">
                <thead>
                    <tr>
                        <th align="center" align="center">IDENTIFICACIÓN</th>
                        <th align="center" align="center">TIPO DOCUMENTO</th>
                        <th align="center" align="center">FECHA EXPEDICIÓN</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{$numero_documento}}</td>
                        <td>{{$tipodoc['descripcion']}}</td>
                        <td>{{$fecha_expedicion}}</td>
                    </tr>
                </tbody>
            </table>
            <table class="table tb">
                <thead>
                    <tr>
                        <th align="center" align="center">LUGAR EXPEDICIÓN</th>
                        <th align="center" align="center">GÉNERO</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{$lugar_expedicion}}</td>
                        <td>{{$sexo['nombre']}}</td>
                    </tr>
                </tbody>
            </table>
            <table class="table tb">
                <thead>
                    <tr>
                        <th align="center">PRIMER NOMBRE</th>
                        <th align="center">SEGUNDO NOMBRE</th>
                        <th align="center">PRIMER APELLIDO</th>
                        <th align="center">SEGUNDO APELLIDO</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{$primer_nombre}}</td>
                        <td>{{$segundo_nombre}}</td>
                        <td>{{$primer_apellido}}</td>
                        <td>{{$segundo_apellido}}</td>
                    </tr>
                </tbody>
            </table>
            <table class="table tb">
                <thead>
                    <tr>
                        <th align="center">FECHA NACIMIENTO</th>
                        <th align="center">GRUPO SANGUÍNEO Y FACTOR</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{$fecha_nacimiento}}</td>
                        <td>{{$rh}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="bar bar-n">Datos De Ubicación</div>
        <div>
            <table class="table tb">
                <thead>
                    <tr>
                        <th align="center">PAÍS</th>
                        <th align="center">ESTADO</th>
                        <th align="center">CIUDAD</th>
                        <th align="center">BARRIO RESIDENCIA</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>@if($paisa!=null){{$paisa['nombre']}}@endif</td>
                        <td>@if($estadoa!=null){{$estadoa['nombre']}}@endif</td>
                        <td>@if($ciudada!=null){{$ciudada['nombre']}}@endif</td>
                        <td>{{$barrio_residencia}}</td>
                    </tr>
                </tbody>
            </table>
            <table class="table tb">
                <thead>
                    <tr>
                        <th align="center">DIRECCIÓN RESIDENCIA</th>
                        <th align="center">CORREO</th>
                        <th align="center">TELÉFONO</th>
                        <th align="center">CELULAR</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{$direccion_residencia}}</td>
                        <td>{{$correo}}</td>
                        <td>{{$telefono}}</td>
                        <td>{{$celular}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="bar bar-n">Datos Complementarios</div>
        <div>
            <table class="table tb">
                <thead>
                    <tr>
                        <th align="center">CIRCUNSCRIPCIÓN</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{$circunscripcion['nombre']." - ".$circunscripcion['descripcion']}}</td>
                    </tr>
                </tbody>
            </table>
            <table class="table tb">
                <thead>
                    <tr>
                        <th align="center">ESTRATO</th>
                        <th align="center">PADRES SEPARADOS</th>
                        <th align="center">IGLESIA ASISTE</th>
                        <th align="center">PASTOR</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{$estrato['etiqueta']}}</td>
                        <td>@if($d!=null){{$d['padres_separados']}}@endif</td>
                        <td>@if($d!=null){{$d['iglesia_asiste']}}@endif</td>
                        <td>@if($d!=null){{$d['pastor']}}@endif</td>
                    </tr>
                </tbody>
            </table>
            <table class="table tb">
                <thead>
                    <tr>
                        <th align="center">DISCAPACIDAD</th>
                        <th align="center">FAMILIAS EN ACCIÓN</th>
                        <th align="center">VÍCTIMA DEL CONFLICTO ARMADO</th>
                        <th align="center">DESPLAZADO</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>@if($d!=null){{$d['discapacidad']}}@endif</td>
                        <td>@if($d!=null){{$d['familias_en_accion']}}@endif</td>
                        <td>@if($d!=null){{$d['poblacion_victima_conflicto']}}@endif</td>
                        <td>@if($d!=null){{$d['desplazado']}}@endif</td>
                    </tr>
                </tbody>
            </table>
            <table class="table tb">
                <thead>
                    <tr>
                        <th align="center">COLEGIO PROCEDENCIA</th>
                        <th align="center">COMPROMISO ADQUIRIDO</th>
                        <th align="center">ÉTNIA</th>
                        <th align="center">CON QUIÉN VIVE</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>@if($d!=null){{$d['colegio_procedencia']}}@endif</td>
                        <td>@if($d!=null){{$d['compromiso_adquirido']}}@endif</td>
                        <td>@if($d!=null) @if($d['etnia']!=null){{$d['etnia']['nombre']}}@endif @endif</td>
                        <td>@if($d!=null) @if($d['conquienvive']!=null){{$d['conquienvive']['descripcion']}}@endif @endif</td>
                    </tr>
                </tbody>
            </table>
            <table class="table tb">
                <thead>
                    <tr>
                        <th align="center">RANGO SISBEN</th>
                        <th align="center">ENTIDAD DE SALUD</th>
                        <th align="center">SITUACIÓN AÑO ANTERIOR</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>@if($d!=null) @if($d['entidadsalud']!=null){{$d['entidadsalud']['nombre']}}@endif @endif</td>
                        <td>@if($d!=null) @if($d['rangosisben']!=null){{$d['rangosisben']['etiqueta']}}@endif @endif</td>
                        <td>@if($d!=null) @if($d['situacionanioanterior']!=null){{$d['situacionanioanterior']['etiqueta']}}@endif @endif</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="bar bar-n">Padres del Aspirante</div>
        <div>
            @if($padres!=null)
            <table class="table tb">
                <thead>
                    <tr>
                        <th align="center">TIPO DOCUMENTO</th>
                        <th align="center">IDENTIFICACIÓN</th>
                        <th align="center">PADRE/MADRE</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($padres as $p)
                    <tr>
                        <td>{{$p['tipodoc']['descripcion']}}</td>
                        <td>{{$p['numero_documento']}}</td>
                        <td>{{$p['primer_nombre']." ".$p['segundo_nombre']." ".$p['primer_apellido']." ".$p['segundo_apellido']}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
        </div>
        <div class="bar bar-n">Acudiente(s) del Aspirante</div>
        <div>
            @if($acudientesm!=null)
            <table class="table tb">
                <thead>
                    <tr>
                        <th align="center">TIPO DOCUMENTO</th>
                        <th align="center">IDENTIFICACIÓN</th>
                        <th align="center">ACUDIENTE</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($acudientesm as $ac)
                    <tr>
                        <td>{{$ac['tipodoc']}}</td>
                        <td>{{$ac['numero_documento']}}</td>
                        <td>{{$ac['acudiente']}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
        </div>
        <div class="bar bar-n">Responsable Financiero del Aspirante</div>
        <div>
            @if($rf!=null)
            <table class="table tb">
                <thead>
                    <tr>
                        <th align="center">TIPO DOCUMENTO</th>
                        <th align="center">IDENTIFICACIÓN</th>
                        <th align="center">RESPONSABLE FINANCIERO</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{$rf['personanatural']['persona']['tipodoc']['descripcion']}}</td>
                        <td>{{$rf['personanatural']['persona']['numero_documento']}}</td>
                        <td>{{$rf['personanatural']['primer_nombre']." ".$rf['personanatural']['segundo_nombre']." ".$rf['personanatural']['primer_apellido']." ".$rf['personanatural']['segundo_apellido']}}</td>
                    </tr>
                </tbody>
            </table>
            @endif
        </div>
    </div>
</body>

</html>