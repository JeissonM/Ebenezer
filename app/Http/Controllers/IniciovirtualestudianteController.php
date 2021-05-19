<?php

namespace App\Http\Controllers;

use App\Gradomateria;
use App\Grupomateriadocente;
use App\Jornada;
use App\Periodoacademico;
use App\Persona;
use App\Unidad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IniciovirtualestudianteController extends Controller
{
    //inicio estudiante
    public function inicioestudiante()
    {
        $u = Auth::user();
        $p = Persona::where('numero_documento', $u->identificacion)->first();
        if ($p != null) {
            $pn = $p->personanatural;
            if ($pn != null) {
                $e = $pn->estudiante;
                if ($e != null) {
                    return view('aula_virtual.estudiante.index')
                        ->with('location', 'aulavirtual')
                        ->with('estudiante', $e);
                } else {
                    flash('Usted no es un estudiante de la institución')->error();
                    return redirect()->route('menu.aulavirtual');
                }
            } else {
                flash('Usted no se encuentra registrado como persona natural en la base de datos')->error();
                return redirect()->route('menu.aulavirtual');
            }
        } else {
            flash('Usted no se encuentra registrado como persona en la base de datos')->error();
            return redirect()->route('menu.aulavirtual');
        }
    }

    //get materias de estudiante
    public function materiasestudiante($unidad, $periodo, $jornada, $grado)
    {
        $gradomaterias = Gradomateria::where([['unidad_id', $unidad], ['periodoacademico_id', $periodo], ['jornada_id', $jornada], ['grado_id', $grado]])->get();
        if (count($gradomaterias) > 0) {
            $materias = null;
            $u = Auth::user();
            $p = Persona::where('numero_documento', $u->identificacion)->first();
            $e = $p->personanatural->estudiante;
            $grupos = $e->estudiantegrupos;
            $gr = null;
            if (count($grupos) > 0) {
                foreach ($grupos as $g) {
                    if ($g->grupo->grado_id == $e->grado_id && $g->grupo->periodoacademico_id == $e->periodoacademico_id && $g->grupo->unidad_id == $e->unidad_id && $g->grupo->jornada_id == $e->jornada_id) {
                        $gr = $g->grupo;
                    }
                }
            }
            foreach ($gradomaterias as $g) {
                $materias[] = [
                    'materia_id' => $g->materia_id,
                    'codigo' => $g->materia->codigomateria,
                    'materia' => $g->materia->nombre,
                    'grupo' => $gr->nombre,
                    'gmd_id' => Grupomateriadocente::where([['gradomateria_id', $g->id], ['grupo_id', $gr->id]])->first()->id
                ];
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

    //menu aula estudiante
    public function menuaulaestudiante($id)
    {
        $gmd = Grupomateriadocente::find($id);
        $contactos = $gmd->grupo->estudiantegrupos;
        $docente = $gmd->docente;
        return view('aula_virtual.estudiante.panel')
            ->with('location', 'aulavirtual')
            ->with('gmd', $gmd)
            ->with('contactos', $contactos)
            ->with('docente', $docente);
    }
}
