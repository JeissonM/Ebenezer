<?php

namespace App\Http\Controllers;

use App\Estudiante;
use Illuminate\Http\Request;
use App\Matriculaauditoria;
use Illuminate\Support\Facades\Auth;
use App\Unidad;
use App\Periodoacademico;
use App\Jornada;
use App\Grado;
use App\Estudiantegrupo;
use App\Grupo;
use App\Grupousuario;

class MatricularnuevosController extends Controller
{
    //index
    public function index()
    {
        $periodos = $unidades = $jornadas = null;
        $perds = Periodoacademico::all()->sortByDesc('anio');
        if (count($perds) > 0) {
            foreach ($perds as $p) {
                $periodos[$p->id] = $p->etiqueta . " - " . $p->anio;
            }
        } else {
            flash("No hay períodos académicos")->error();
            return redirect()->route('menu.matricula');
        }
        $unds = Unidad::all();
        if (count($unds) > 0) {
            foreach ($unds as $u) {
                $unidades[$u->id] = $u->nombre . " - " . $u->descripcion . " - " . $u->ciudad->nombre;
            }
        } else {
            flash("No hay unidades o sedes definidas")->error();
            return redirect()->route('menu.matricula');
        }
        $grados = Grado::all()->pluck('etiqueta', 'id');
        $jnds = Jornada::all();
        if (count($jnds) > 0) {
            foreach ($jnds as $j) {
                $jornadas[$j->id] = $j->descripcion . " - " . $j->jornadasnies;
            }
        } else {
            flash("No hay jornadas académicas definidas")->error();
            return redirect()->route('menu.matricula');
        }
        if (count($grados) <= 0) {
            flash("No hay grados académicos definidos")->error();
            return redirect()->route('menu.matricula');
        }
        return view('matricula.matricula.matricula_nuevos.list')
            ->with('location', 'matricula')
            ->with('periodos', $periodos)
            ->with('jornadas', $jornadas)
            ->with('unidades', $unidades)
            ->with('grados', $grados);
    }


    //continuar
    public function continuar($un, $p, $j, $g)
    {
        $estudiantes = Estudiante::where([['unidad_id', $un], ['periodoacademico_id', $p], ['jornada_id', $j], ['grado_id', $g], ['estado', 'NUEVO']])->get();
        if (count($estudiantes) > 0) {
            $response = null;
            $hoy = getdate();
            $periodo = Periodoacademico::find($p);
            $jornada = Jornada::find($j);
            $unidad = Unidad::find($un);
            $grado = Grado::find($g);
            $fecha = $hoy["year"] . "/" . $hoy["mon"] . "/" . $hoy["mday"];
            $response[] = "*********************************************************************************************************";
            $response[] = "PROCESO DE MATRÍCULA MASIVO - MATRÍCULA DE ESTUDIANTES NUEVOS. FECHA: " . $hoy["year"] . "/" . $hoy["mon"] . "/" . $hoy["mday"];
            $response[] = "UNIDAD: " . $unidad->nombre . " - JORNADA: " . $jornada->descripcion . " - PERÍODO: " . $periodo->etiqueta . " " . $periodo->anio . " - GRADO: " . $grado->etiqueta;
            $response[] = "*********************************************************************************************************";
            $response[] = "                                                                        ";
            $response[] = "                                                                        ";
            $u = Auth::user();
            $grupos2 = Grupo::where([['unidad_id', $un], ['periodoacademico_id', $p], ['jornada_id', $j], ['grado_id', $g]])->get();
            if (count($grupos2) > 0) {
                foreach ($estudiantes as $e) {
                    $grupos = Grupo::where([['unidad_id', $un], ['periodoacademico_id', $p], ['jornada_id', $j], ['grado_id', $g]])->get();
                    $response[] = "----- MATRICULANDO AL ESTUDIANTE " . $e->personanatural->persona->numero_documento . "  -  " . $e->personanatural->primer_nombre . " " . $e->personanatural->primer_apellido;
                    $eg = new Estudiantegrupo();
                    $eg->user_change = $u->identificacion;
                    $eg->estudiante_id = $e->id;
                    $gr = $this->buscarGrupo($grupos);
                    if ($gr != null) {
                        $eg->grupo_id = $gr->id;
                        if ($eg->save()) {
                            $gr->cupousado = $gr->cupousado + 1;
                            $gr->save();
                            $e->estado = 'MATRICULADO';
                            $e->grado_anterior = $g;
                            $e->save();
                            $this->setAuditoriamatricula('INSERTAR', 'MATRICULA DE ESTUDIANTES NUEVOS. DATOS: ', $eg);
                            $response[] = "[OK] ESTUDIANTE MATRICULADO CON EXITO EN EL GRUPO " . $gr->nombre;
                        } else {
                            $response[] = "[X] EL ESTUDIANTE NO PUDO SER MATRICULADO, DEBE REPETIR EL PROCESO PARA ÉL.";
                        }
                    } else {
                        $response[] = "[--] NO HAY CUPO DISPONIBLE EN LOS GRUPOS PARA EL ESTUDIANTE, NO SE REALIZO LA MATRÍCULA";
                    }
                    $response[] = "*********************************************************************************************************";
                    $response[] = "                                                                                          ";
                }
                //creo el archivo fisico
                $archivo = "MATRICULA_ESTUDIANTES_NUEVOS_" . $grado->etiqueta . "_" . $periodo->etiqueta . "-" . $periodo->anio . "_" . $hoy["year"] . $hoy["mon"] . $hoy["mday"] . $hoy["hours"] . $hoy["minutes"] . $hoy["seconds"] . ".txt";
                $file = fopen(public_path() . "/documentos/log/" . $archivo, 'w+');
                foreach ($response as $value) {
                    fwrite($file, $value . PHP_EOL);
                }
                fclose($file);
                $response["archivo"] = $archivo;
                $response["resultado"] = $response;
                return view('matricula.matricula.matricula_nuevos.resultado')
                    ->with('location', 'matricula')
                    ->with('response', $response);
            } else {
                flash("No hay grupos disponibles para los parámetros indicados, no se realizó el proceso de matrícula.")->error();
                return redirect()->route('matricularnuevos.index');
            }
        } else {
            flash("No hay estudiantes nuevos sin matrícula para los parámetros indicados")->error();
            return redirect()->route('matricularnuevos.index');
        }
    }

    //busca un grupo
    public function buscarGrupo($grupos)
    {
        foreach ($grupos as $gr) {
            if ($gr->cupousado < $gr->cupo) {
                return $gr;
            }
        }
        return null;
    }

    /*
     * set Auditoria matricula
     */

    public function setAuditoriamatricula($operacion, $string1, $r)
    {
        $u = Auth::user();
        $aud = new Matriculaauditoria();
        $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
        $aud->operacion = $operacion;
        $str = $string1;
        foreach ($r->attributesToArray() as $key => $value) {
            $str = $str . ", " . $key . ": " . $value;
        }
        $aud->detalles = $str;
        $aud->save();
    }
}
