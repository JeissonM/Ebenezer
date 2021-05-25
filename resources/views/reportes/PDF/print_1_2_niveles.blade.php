<html>
<head>
    <link rel="shortcut icon" href="{{asset('images/logo.png')}}">
    <style>
        body {
            font-size: 10px;
        }

        .container {
            width: 100%;
        }

        .row {
            width: 100%;
            border-left: 1px solid;
            border-right: 1px solid;
            border-bottom: 1px solid;
            padding: 5px;
        }

    </style>
</head>
<body>
<div class="container">
    Fecha de Generación: {{$fecha}} - COLOEGIO EVANGELICO EBENEZER
    <div class="row" style="border-top: 1px solid">
        <table style="width: 100%">
            <tr>
                <td style="width: 15%;">
                    <img width="150px" height="40px" src="{{asset('images/logo.png')}}"/>
                </td>
                <td style="width: 85%; text-align: center;">
                    <b style="font-size:18px;">{{$titulo}}</b>
                </td>
            </tr>
        </table>
    </div>
    <?php
    if ($encabezado !== null) {
    if (count($encabezado) > 0) {
    ?>
    <div class="row">
        <table style="width: 100%;">
            <?php
            $i = $total = $van = 0;
            $html = $row1 = $row2 = "";
            $total = count($encabezado);
            foreach ($encabezado as $key => $value) {
                $i = $i + 1;
                $van = $van + 1;
                $row1 = $row1 . "<th style='width: 33.3% !important; background-color: darkblue; color:#FFFFFF;'>" . $key . "</th>";
                $row2 = $row2 . "<th style='width: 33.3%; text-align: center; background-color:#2196F3; color:#FFFFFF;'>" . $value . "</th>";
                if ($i === 3) {
                    $i = 0;
                    $html = $html . "<tr>" . $row1 . "</tr><tr>" . $row2 . "</tr>";
                    $row1 = $row2 = "";
                } else {
                    if ($van === $total) {
                        $html = $html . "<tr>" . $row1 . "</tr><tr>" . $row2 . "</tr>";
                        $row1 = $row2 = "";
                    }
                }
            }
            echo $html;
            ?>
        </table>
    </div>
    <?php
    }
    }
    if ($filtros !== null) {
    if (count($filtros) > 0) {
    ?>
    <div class="row">
        <table style="width: 100%;">
            <?php
            $i = $total = $van = 0;
            $html = $row1 = $row2 = "";
            $total = count($filtros);
            foreach ($filtros as $key => $value) {
                $i = $i + 1;
                $van = $van + 1;
                $row1 = $row1 . "<th style='width: 33.3% !important; background-color: darkblue; color:#FFFFFF;'>" . $key . "</th>";
                $row2 = $row2 . "<td style='width: 33.3%; text-align: center; background-color:#2196F3; color:#FFFFFF;'>" . $value . "</td>";
                if ($i === 3) {
                    $i = 0;
                    $html = $html . "<tr>" . $row1 . "</tr><tr>" . $row2 . "</tr>";
                    $row1 = $row2 = "";
                } else {
                    if ($van === $total) {
                        $html = $html . "<tr>" . $row1 . "</tr><tr>" . $row2 . "</tr>";
                        $row1 = $row2 = "";
                    }
                }
            }
            echo $html;
            ?>
        </table>
    </div>
    <?php
    }
    }
    if ($data !== null) {
    if (count($data) > 0) {
    ?>
    <div class="row">
        <?php
        if ($nivel === 1) {
            //nivel 1
            //nivel 1
            $html = "<table style='width: 100%;'><thead><tr>";
            $i = $total = $van = 0;
            $total = count($cabeceras);
            foreach ($cabeceras as $c) {
                $i = $i + 1;
                $van = $van + 1;
                $html = $html . "<th style='width: 16.6% !important; background-color:#2196F3; color:#FFFFFF;'>" . $c . "</th>";
                if ($i === 7) {
                    $i = 0;
                    $html = $html . "</tr><tr>";
                } else {
                    if ($van === $total) {
                        $html = $html . "</tr>";
                    }
                }
            }
            $html = $html . "</thead><tbody>";
            $parastilo = 0;
            foreach ($data as $value) {
                if (get_class($value) == 'stdClass') {
                    $value = (array)$value;
                    if (isset($v['docente']))
                        unset($v['docente']);
//                            $v = json_decode(json_encode($v), true);
                }
                $i2 = $van2 = 0;
                $parastilo = $parastilo + 1;
                $total2 = count($value);
                if ($parastilo % 2 == 0) {
                    $html = $html . "<tr style='width: 16.6% !important; background-color: #ecf0f1;'>";
                } else {
                    $html = $html . "<tr style='width: 16.6% !important;'>";
                }
                foreach ($value as $t) {
                    $i2 = $i2 + 1;
                    $van2 = $van2 + 1;
                    $html = $html . "<td>" . $t . "</td>";
                    if ($i2 === 7) {
                        $i2 = 0;
                        if ($parastilo % 2 == 0) {
                            $html = $html . "</tr><tr style='width: 16.6% !important; background-color: #ecf0f1;'>";
                        } else {
                            $html = $html . "</tr><tr>";
                        }
                    } else {
                        if ($van2 === $total2) {
                            $html = $html . "</tr>";
                        }
                    }
                }
            }
            echo $html . "</tbody></table>";
        } else {
            //nivel 2
            $html = "";
            foreach ($data as $key => $value) {
                $html = $html . "<table style='width: 100%;'><tr><th style='width: 100% !important; background-color: red; color:#FFFFFF;'>" . $key . "</th></tr></table>";
                if (count($value) > 0) {
                    $html = $html . "<table style='width: 100%;'><tr>";
                    $i = $total = $van = 0;
                    $total = count($cabeceras);
                    foreach ($cabeceras as $c) {
                        $i = $i + 1;
                        $van = $van + 1;
                        $html = $html . "<th style='width: 20% !important; background-color:#2196F3; color:#FFFFFF;'>" . $c . "</th>";
                        if ($i === 5) {
                            $i = 0;
                            $html = $html . "</tr><tr>";
                        } else {
                            if ($van === $total) {
                                $html = $html . "</tr>";
                            }
                        }
                    }
                    $html = $html . "</table><table style='width: 100%;'>";
                    $parastilo = 0;
                    foreach ($value as $v) {
                        if (get_class($v) == 'stdClass') {
                            $v = (array)$v;
                            if (isset($v['docente']))
                                unset($v['docente']);
//                            $v = json_decode(json_encode($v), true);
                        }

                        $html = $html . "<tr>";
                        $parastilo = $parastilo + 1;
                        $i2 = $total2 = $van2 = 0;
                        $total2 = count($v);
                        foreach ($v as $t) {
                            $i2 = $i2 + 1;
                            $van2 = $van2 + 1;
                            if ($parastilo % 2 == 0) {
                                $html = $html . "<td style='width: 20% !important; background-color: #ecf0f1;'>" . $t . "</td>";
                            } else {
                                $html = $html . "<td style='width: 20% !important;'>" . $t . "</td>";
                            }
                            if ($i2 === 5) {
                                $i2 = 0;
                                $html = $html . "</tr><tr>";
                            } else {
                                if ($van2 === $total2) {
                                    $html = $html . "</tr>";
                                }
                            }
                        }
                    }
                    $html = $html . "</table>";
                }
            }
            echo $html;
        }
        ?>
    </div>
    <?php
    }
    }
    ?>
</div>
</body>
</html>
