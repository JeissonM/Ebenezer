<?php

namespace App\Http\Controllers;

use App\Asignaractividad;
use App\Estudiante;
use App\Estudiantegrupo;
use App\Gradomateria;
use App\Grupomateriadocente;
use App\Persona;
use App\Personanatural;
use App\Resultadoactividad;
use App\Sistemaevaluacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CalificacionestudianteController extends Controller
{
    //index
    public function index($id)
    {
        $gmd = Grupomateriadocente::find($id);
        $se = Sistemaevaluacion::where('estado', 'ACTUAL')->first();
        $eval = $se->evaluacionacademicas;
        if (count($eval) > 0) {
            foreach ($eval as $e) {
                $e->actividades = null;
                $acts = Asignaractividad::where([['periodoacademico_id', $gmd->gradomateria->periodoacademico_id], ['evaluacionacademica_id', $e->id], ['grupo_id', $gmd->grupo_id], ['materia_id', $gmd->gradomateria->materia_id]])->get();
                $e->totalact = count($acts);
                if ($e->totalact > 0) {
                    $e->actividades = $acts;
                }
            }
        }
        $u = Auth::user();
        $est = Persona::where('numero_documento', $u->identificacion)->first()->personanatural->estudiante;
        $fechas = null;
        foreach ($eval as $e) {
            if ($e->actividades != null) {
                foreach ($e->actividades as $a) {
                    $a->vencida = $this->vencida($a->id);
                    $r = Resultadoactividad::where([['asignaractividad_id', $a->id], ['estudiante_id', $est->id]])->first();
                    if ($r == null) {
                        $a->calificacion = "0";
                        $a->anotaciones_sistema = "---";
                        $a->anotaciones_docente = "---";
                        if ($a->vencida == "SI") {
                            $r = $this->resultado($a, $est);
                            $a->calificacion = $r->calificacion;
                            $a->anotaciones_sistema = $r->anotaciones_sistema;
                            $a->anotaciones_docente = $r->anotaciones_docente;
                        }
                    } else {
                        $a->calificacion = $r->calificacion;
                        $a->anotaciones_sistema = $r->anotaciones_sistema;
                        $a->anotaciones_docente = $r->anotaciones_docente;
                    }
                }
            }
        }
        return view('aula_virtual.estudiante.calificacionestudiante')
            ->with('location', 'aulavirtual')
            ->with('gmd', $gmd)
            ->with('se', $se)
            ->with('evals', $eval);
    }

    //determina si una actividad está vencida
    public static function vencida($id)
    {
        date_default_timezone_set('America/Bogota');
        $vencida = "NO";
        $a = Asignaractividad::find($id);
        $fecha_actual = strtotime(date("d-m-Y H:i:00", time()));
        $f = date("d-m-Y H:i:00", time());
        if (strtotime($a->fecha_inicio) <= $fecha_actual && $fecha_actual <= strtotime($a->fecha_final)) {
            $vencida = "NO";
        } else {
            $vencida = "SI";
        }
        return $vencida;
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

    //notas del año actual del estudiante
    public function todasestudiante()
    {
        $u = Auth::user();
        $est = Persona::where('numero_documento', $u->identificacion)->first()->personanatural->estudiante;
        $materias = Gradomateria::where([['periodoacademico_id', $est->periodoacademico_id], ['grado_id', $est->grado_id], ['unidad_id', $est->unidad_id], ['jornada_id', $est->jornada_id]])->get();
        $grupos = $est->estudiantegrupos;
        $gr = null;
        if (count($grupos) > 0) {
            foreach ($grupos as $g) {
                if ($g->grupo->periodoacademico_id == $est->periodoacademico_id && $g->grupo->grado_id = $est->grado_id && $est->jornada_id == $g->grupo->jornada_id && $g->grupo->unidad_id == $est->unidad_id) {
                    $gr = $g->grupo;
                }
            }
        }
        if ($gr != null && count($materias) > 0) {
            $data = null;
            $sistema = Sistemaevaluacion::where('estado', 'ACTUAL')->first();
            $evals = $sistema->evaluacionacademicas;
            if (count($evals) > 0) {
                $data = null;
                foreach ($evals as $e) {
                    foreach ($materias as $m) {
                        $acts = Asignaractividad::where([['periodoacademico_id', $est->periodoacademico_id], ['grupo_id', $gr->id], ['evaluacionacademica_id', $e->id], ['materia_id', $m->materia_id]])->get();
                        $data[$e->nombre . " (" . $e->peso . " %)"][] = $this->revisar($acts, $m, $est);
                    }
                }
                return view('estudiante.calificaciones.calificaciones')
                    ->with('location', 'academico_e_a')
                    ->with('est', $est)
                    ->with('data', $data);
            } else {
                flash('No hay evaluaciones académicas actualmente')->warning();
                return redirect()->route('menu.academicoestudiante');
            }
        } else {
            flash('El estudiante no tiene matrícula académica actualmente')->warning();
            return redirect()->route('menu.academicoestudiante');
        }
    }

    //notas del año actual del estudiante por parte del acudiente
    public function todasacudiente($id)
    {
        $u = Auth::user();
        $est = Estudiante::find($id);
        $materias = Gradomateria::where([['periodoacademico_id', $est->periodoacademico_id], ['grado_id', $est->grado_id], ['unidad_id', $est->unidad_id], ['jornada_id', $est->jornada_id]])->get();
        $grupos = $est->estudiantegrupos;
        $gr = null;
        if (count($grupos) > 0) {
            foreach ($grupos as $g) {
                if ($g->grupo->periodoacademico_id == $est->periodoacademico_id && $g->grupo->grado_id = $est->grado_id && $est->jornada_id == $g->grupo->jornada_id && $g->grupo->unidad_id == $est->unidad_id) {
                    $gr = $g->grupo;
                }
            }
        }
        if ($gr != null && count($materias) > 0) {
            $data = null;
            $sistema = Sistemaevaluacion::where('estado', 'ACTUAL')->first();
            $evals = $sistema->evaluacionacademicas;
            if (count($evals) > 0) {
                $data = null;
                foreach ($evals as $e) {
                    foreach ($materias as $m) {
                        $acts = Asignaractividad::where([['periodoacademico_id', $est->periodoacademico_id], ['grupo_id', $gr->id], ['evaluacionacademica_id', $e->id], ['materia_id', $m->materia_id]])->get();
                        $data[$e->nombre . " (" . $e->peso . " %)"][] = $this->revisar($acts, $m, $est);
                    }
                }
                return view('acudiente.academico.calificaciones')
                    ->with('location', 'academicoacudiente')
                    ->with('est', $est)
                    ->with('data', $data);
            } else {
                flash('No hay evaluaciones académicas actualmente')->warning();
                return redirect()->route('menu.academicomenuacudiente', $id);
            }
        } else {
            flash('El estudiante no tiene matrícula académica actualmente')->warning();
            return redirect()->route('menu.academicomenuacudiente', $id);
        }
    }

    //actividades asignadas a una materia
    public function revisar($acts, $m, $est)
    {
        $data = null;
        if (count($acts) > 0) {
            $nota = 0;
            foreach ($acts as $a) {
                if ($a->actividad->materia_id == $m->materia_id) {
                    $c = Resultadoactividad::where([['evaluacionacademica_id', $a->evaluacionacademica_id], ['asignaractividad_id', $a->id], ['estudiante_id', $est->id], ['periodoacademico_id', $est->periodoacademico_id]])->first();
                    $cal = 0;
                    if ($c != null) {
                        $cal = $c->calificacion;
                    }
                    $d = [
                        'peso' => $a->peso,
                        'cal' => $cal
                    ];
                    $nota = $nota + ($cal * ($a->peso / 100));
                    $data[$m->materia->codigomateria . " - " . $m->materia->nombre][] = $d;
                } else {
                    $data[$m->materia->codigomateria . " - " . $m->materia->nombre][] = [
                        'peso' => $a->peso,
                        'cal' => 0
                    ];
                }
            }
        } else {
            $data[$m->materia->codigomateria . " - " . $m->materia->nombre][] = [
                'peso' => 0,
                'cal' => 0
            ];
        }
        $response = null;
        if ($data != null) {
            foreach ($data as $i => $d) {
                $nota = 0;
                if (count($d) > 0) {
                    foreach ($d as $j) {
                        $nota = $nota + ($j['cal'] * ($j['peso'] / 100));
                    }
                }
                $response[$i] = $nota;
            }
        }
        return $response;
    }
}
