<?php

namespace App\Http\Controllers;

use App\Ciclogrado;
use App\Color;
use App\Estudiante;
use App\Gradomateria;
use App\Grupomateriadocente;
use App\Jornada;
use App\Periodoacademico;
use App\Persona;
use App\Unidad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CargaacademicaController extends Controller
{
    //carga del estudiante
    public function estudiante()
    {
        $u = Auth::user();
        $est = Persona::where('numero_documento', $u->identificacion)->first()->personanatural->estudiante;
        $materias = Gradomateria::where([['periodoacademico_id', $est->periodoacademico_id], ['grado_id', $est->grado_id], ['unidad_id', $est->unidad_id], ['jornada_id', $est->jornada_id]])->get();
        return view('estudiante.carga_academica.cargaacademica')
            ->with('location', 'academico_e_a')
            ->with('est', $est)
            ->with('materias', $materias);
    }

    //carga del estudiante por parte del acudiente
    public function acudiente($est)
    {
        $est = Estudiante::find($est);
        $materias = Gradomateria::where([['periodoacademico_id', $est->periodoacademico_id], ['grado_id', $est->grado_id], ['unidad_id', $est->unidad_id], ['jornada_id', $est->jornada_id]])->get();
        return view('acudiente.academico.cargaacademica')
            ->with('location', 'academicoacudiente')
            ->with('est', $est)
            ->with('materias', $materias);
    }

    //carga del docente
    public function docente()
    {
        $u = Auth::user();
        $p = Persona::where('numero_documento', $u->identificacion)->first();
        if ($p != null) {
            $pn = $p->personanatural;
            if ($pn != null) {
                $d = $pn->docente;
                if ($d != null) {
                    $periodos = $unidades = $jornadas = null;
                    $perds = Periodoacademico::all()->sortByDesc('anio');
                    if (count($perds) > 0) {
                        foreach ($perds as $p) {
                            $periodos[$p->id] = $p->etiqueta . " - " . $p->anio;
                        }
                    } else {
                        flash("No hay períodos académicos")->error();
                        return redirect()->route('menu.academicodocente');
                    }
                    $unds = Unidad::all();
                    if (count($unds) > 0) {
                        foreach ($unds as $u) {
                            $unidades[$u->id] = $u->nombre . " - " . $u->descripcion . " - " . $u->ciudad->nombre;
                        }
                    } else {
                        flash("No hay unidades o sedes definidas")->error();
                        return redirect()->route('menu.academicodocente');
                    }
                    $jnds = Jornada::all();
                    if (count($jnds) > 0) {
                        foreach ($jnds as $j) {
                            $jornadas[$j->id] = $j->descripcion . " - " . $j->jornadasnies;
                        }
                    } else {
                        flash("No hay jornadas académicas definidas")->error();
                        return redirect()->route('menu.academicodocente');
                    }
                    return view('docente.carga_academica.cargaacademica')
                        ->with('location', 'academicodocente')
                        ->with('periodos', $periodos)
                        ->with('jornadas', $jornadas)
                        ->with('unidades', $unidades);
                } else {
                    flash('Usted no es un docente de la institución')->error();
                    return redirect()->route('menu.academicodocente');
                }
            } else {
                flash('Usted no se encuentra registrado como persona natural en la base de datos')->error();
                return redirect()->route('menu.academicodocente');
            }
        } else {
            flash('Usted no se encuentra registrado como persona en la base de datos')->error();
            return redirect()->route('menu.academicodocente');
        }
    }

    //carga academica del docente
    public function getcarga($unidad, $periodo, $jornada)
    {
        $gradomaterias = Gradomateria::where([['unidad_id', $unidad], ['periodoacademico_id', $periodo], ['jornada_id', $jornada]])->get();
        if (count($gradomaterias) > 0) {
            $materias = null;
            $u = Auth::user();
            $p = Persona::where('numero_documento', $u->identificacion)->first();
            $d = $p->personanatural->docente;
            foreach ($gradomaterias as $g) {
                $gmds = Grupomateriadocente::where([['gradomateria_id', $g->id], ['docente_id', $d->id]])->get();
                if (count($gmds) > 0) {
                    foreach ($gmds as $gmd) {
                        $ciclos = null;
                        $cic = $g->materia->area->cicloareas;
                        if (count($cic) > 0) {
                            foreach ($cic as $c) {
                                //verificamos que el ciclo este en el grado
                                if ($this->gradoEnCiclo($g->grado_id, $c->ciclo_id)) {
                                    $ciclos[] = $c->ciclo;
                                }
                            }
                        }
                        $color = new Color();
                        $materias[] = [
                            'materia_id' => $g->materia_id,
                            'codigo' => $g->materia->codigomateria,
                            'materia' => $g->materia->nombre,
                            'grupo' => $gmd->grupo->nombre,
                            'grado' => $g->grado->etiqueta,
                            'gmd_id' => $gmd->id,
                            'area' => $g->materia->area->nombre,
                            'area_id' => $g->materia->area_id,
                            'ciclos' => $ciclos,
                            'grupo_id' => $gmd->grupo_id,
                            'grado_id' => $g->grado_id,
                            'color' => $color->color(rand(0, $color->maximo()))
                        ];
                    }
                }
            }
            if ($materias != null) {
                return json_encode($materias);
            } else {
                return "null";
            }
        } else {
            return "null";
        }
    }

    //verifica si un grado pertenece a un ciclo
    public function gradoEnCiclo($grado, $ciclo)
    {
        if (Ciclogrado::where([['ciclo_id', $ciclo], ['grado_id', $grado]])->first() != null) {
            return true;
        }
        return false;
    }
}
