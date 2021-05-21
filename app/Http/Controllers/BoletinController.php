<?php

namespace App\Http\Controllers;

use App\Asignaractividad;
use App\Asignarlogrogrupomateria;
use App\Estudiante;
use App\Evaluacionacademica;
use App\Grupo;
use App\Grupomateriadocente;
use App\Jornada;
use App\Logro;
use App\Materia;
use App\Periodoacademico;
use App\Personalizarlogro;
use App\Resultadoactividad;
use App\Sistemaevaluacion;
use App\Unidad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use niklasravnsborg\LaravelPdf\Facades\Pdf;

class BoletinController extends Controller
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
            return redirect()->route('menu.documental');
        }
        $unds = Unidad::all();
        if (count($unds) > 0) {
            foreach ($unds as $u) {
                $unidades[$u->id] = $u->nombre . " - " . $u->descripcion . " - " . $u->ciudad->nombre;
            }
        } else {
            flash("No hay unidades o sedes definidas")->error();
            return redirect()->route('menu.documental');
        }
        $jnds = Jornada::all();
        if (count($jnds) > 0) {
            foreach ($jnds as $j) {
                $jornadas[$j->id] = $j->descripcion . " - " . $j->jornadasnies;
            }
        } else {
            flash("No hay jornadas académicas definidas")->error();
            return redirect()->route('menu.documental');
        }
        $s = Sistemaevaluacion::where('estado', 'ACTUAL')->first();
        $evals = $s->evaluacionacademicas;
        return view('documental.boletines.index')
            ->with('location', 'documental')
            ->with('periodos', $periodos)
            ->with('jornadas', $jornadas)
            ->with('unidades', $unidades)
            ->with('evals', $evals);
    }

    //procesar boletines por grupo
    public function procesar($g, $p, $ev)
    {
        $g = Grupo::find($g);
        $estudiantes = $g->estudiantegrupos;
        $materias = null;
        $mats = Grupomateriadocente::where('grupo_id', $g->id)->get();
        $periodo = Periodoacademico::find($p);
        $evaluacion = Evaluacionacademica::find($ev);
        if (count($mats) > 0) {
            if (count($estudiantes) > 0) {
                foreach ($mats as $m) {
                    $materias[$m->gradomateria->materia->area->nombre][] = $m->gradomateria;
                }
                $response = null;
                foreach ($estudiantes as $e) {
                    //reuno la información del boletin de cada estudiante
                    $data = null;
                    foreach ($materias as $key => $m) {
                        foreach ($m as $mm) {
                            //calculo la nota y la informacion de la materia
                            $nota = $this->calcularMateria($p, $ev, $g, $mm->materia_id, $e->estudiante_id);
                            $data[$key][] = [
                                'materia' => $mm->materia->codigomateria . " - " . $mm->materia->nombre,
                                'nota' => $nota,
                                'peso' => $mm->peso,
                                'ih' => $mm->materia->ih,
                                'equivalencia' => $this->equivalencia($nota),
                                'fallas' => 0,
                                'logros' => $this->logros($g->id, $e->estudiante->grado_id, $e->estudiante->unidad_id, $e->estudiante->jornada_id, $p, $mm->materia_id, $e->estudiante_id)
                            ];
                        }
                    }
                    //calculo promedios de las áreas
                    $array = null;
                    foreach ($data as $key => $d) {
                        $cal = $this->calcularPromedioArea($d);
                        $array[] = [
                            'area' => $key,
                            'materias' => $d,
                            'nota' => $cal,
                            'equivalencia' => $this->equivalencia($cal)
                        ];
                    }
                    //cargamos la información general del estudiante y su promedio
                    $response[] = [
                        'identificacion' => $e->estudiante->personanatural->persona->numero_documento,
                        'estudiante' => $e->estudiante->personanatural->primer_apellido . " " . $e->estudiante->personanatural->segundo_apellido . " " . $e->estudiante->personanatural->primer_nombre . " " . $e->estudiante->personanatural->segundo_nombre,
                        'promedio' => $this->calcularPromedio($array),
                        'areas' => $array,
                        'grupo' => $g->nombre,
                        'jornada' => $e->estudiante->jornada->descripcion,
                        'periodo' => $periodo->etiqueta . " " . $periodo->anio,
                        'evaluacion' => $evaluacion->nombre . " (" . $evaluacion->peso . "%)",
                        'docente' => $this->docenteGrupo($g),
                        'unidad' => $e->estudiante->unidad->nombre
                    ];
                }
                $ordenado = $this->orderMultiDimensionalArray($response, 'promedio', true);
                $result = null;
                $boletin = 1;
                foreach ($ordenado as $o) {
                    $result[] = $this->generaPDF($o, $boletin);
                    $boletin = $boletin + 1;
                }
                $html = "No se generó boletines...";
                if ($result != null) {
                    $html = "<p>Se generarón los boletines para el grupo indicado, descarguelos desde los siguientes enlaces.</p><br><ol>";
                    foreach ($result as $re) {
                        $html = $html . "<li><a href='" . $re . "' target='_blank'>" . $re . "</a></li>";
                    }
                    $html = $html . "</ol>";
                }
                flash($html)->success();
                return redirect()->route('boletines.index');
            } else {
                flash("No hay estudiantes matriculados en el grupo")->error();
                return redirect()->route('boletines.index');
            }
        } else {
            flash("No hay materias asignadas al grupo")->error();
            return redirect()->route('boletines.index');
        }
    }

    //genera boletin pdf
    public function generaPDF($boletin, $i)
    {
        $hoy = getdate();
        $fecha = $hoy["year"] . $hoy["mon"] . $hoy["mday"] . $hoy["hours"] . $hoy["minutes"] . $hoy["seconds"];
        $boletin['hoy'] = $fecha;
        $boletin['puesto'] = $i;
        $pdf = PDF::loadView('documental.boletines.print', $boletin)->output();
        $path = url('') . '/storage/documentos/boletines/BOLETIN_' . $boletin['identificacion'] . "_" . $boletin['periodo'] . "_" . $fecha . ".pdf";
        $name="BOLETIN_" . $boletin['identificacion'] . "_" . $boletin['periodo'] . "_".$fecha. ".pdf";
        Storage::disk('public')->put('documentos/boletines/'.$name, $pdf);
        return $path;
    }

    //ordena arreglos multidimencionales
    public function orderMultiDimensionalArray($toOrderArray, $field, $inverse = false)
    {
        $position = array();
        $newRow = array();
        foreach ($toOrderArray as $key => $row) {
            $position[$key] = $row[$field];
            $newRow[$key] = $row;
        }
        if ($inverse) {
            arsort($position);
        } else {
            asort($position);
        }
        $returnArray = array();
        foreach ($position as $key => $pos) {
            $returnArray[] = $newRow[$key];
        }
        return $returnArray;
    }

    //docente director de un grupo
    public function docenteGrupo($g)
    {
        $docente = "SIN DIRECTOR";
        if ($g->docente != null) {
            $docente = $g->docente->personanatural->primer_nombre . " " . $g->docente->personanatural->segundo_nombre . " " . $g->docente->personanatural->primer_apellido . " " . $g->docente->personanatural->segundo_apellido;
        }
        return $docente;
    }

    //calcular promedio periodo
    public function calcularPromedio($areas)
    {
        $total = count($areas);
        $nota = 0;
        $acumulado = 0;
        foreach ($areas as $a) {
            $acumulado = $acumulado + $a['nota'];
        }
        if ($acumulado > 0) {
            $nota = $acumulado / $total;
        }
        return number_format($nota, 1);
    }

    //logros
    public function logros($g, $grado, $und, $j, $p, $m, $e)
    {
        $logros = Asignarlogrogrupomateria::where([
            ['grupo_id', $g],
            ['grado_id', $grado],
            ['unidad_id', $und],
            ['jornada_id', $j],
            ['periodoacademico_id', $p],
            ['materia_id', $m]
        ])->get();
        $data = null;
        if (count($logros) > 0) {
            foreach ($logros as $l) {
                $text = $l->logro->descripcion;
                $per = Personalizarlogro::where([['asignarlogrogrupomateria_id', $l->id], ['estudiante_id', $e]])->first();
                if ($per != null) {
                    $text = $per->descripcion;
                }
                $data[] = $text;
            }
        }
        return $data;
    }

    //calculos de notas para una materia
    public function calcularMateria($p, $e, $g, $m, $est)
    {
        $data = 0;
        $asga = Asignaractividad::where([['periodoacademico_id', $p], ['evaluacionacademica_id', $e], ['grupo_id', $g->id], ['materia_id', $m]])->get();
        if (count($asga) > 0) {
            $total = 0;
            foreach ($asga as $a) {
                $r = Resultadoactividad::where([['periodoacademico_id', $p], ['evaluacionacademica_id', $e], ['grupo_id', $g->id], ['asignaractividad_id', $a->id], ['estudiante_id', $est]])->first();
                if ($r == null) {
                    $r = $this->resultado($a, Estudiante::find($est));
                }
                $total = $total + ($r->calificacion * ($r->peso / 100));
            }
            $data = $total;
        }
        return $data;
    }

    //calcula promedio de un area
    public function calcularPromedioArea($materias)
    {
        $promedio = 0;
        foreach ($materias as $m) {
            $promedio = $promedio + ($m['nota'] * ($m['peso'] / 100));
        }
        return $promedio;
    }

    //equivalencia
    public function equivalencia($nota)
    {
        $equivalencias = [
            ['etiqueta' => 'BAJO', 'n1' => 0, 'n2' => 6.5],
            ['etiqueta' => 'BASICO', 'n1' => 6.6, 'n2' => 7.9],
            ['etiqueta' => 'ALTO', 'n1' => 8, 'n2' => 9.5],
            ['etiqueta' => 'SUPERIOR', 'n1' => 9.6, 'n2' => 10],
        ];
        foreach ($equivalencias as $e) {
            if ($nota >= $e['n1'] && $nota <= $e['n2']) {
                return $e['etiqueta'];
            }
        }
    }

    //guardar resultado vacío
    public function resultado($a, $est)
    {
        $r = new Resultadoactividad();
        $r->calificacion = 0;
        $r->anotaciones_sistema = "El estudiante no presentó la actividad, su calificación es 0 (calificado por el sistema)";
        $r->anotaciones_docente = "SIN ANOTACIONES";
        $r->recurso = "NO";
        $r->ebeduc = $a->actividad->ebeduc;
        $r->peso = $a->peso;
        $r->tipo = $a->actividad->tipo;
        $r->periodoacademico_id = $a->periodoacademico_id;
        $r->evaluacionacademica_id = $a->evaluacionacademica_id;
        $r->grupo_id = $a->grupo_id;
        $r->asignaractividad_id = $a->id;
        $r->estudiante_id = $est->id;
        $r->save();
        return $r;
    }
}
