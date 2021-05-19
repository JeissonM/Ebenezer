<?php

namespace App\Http\Controllers;

use App\Actividad;
use App\Asignaractividad;
use App\Evaluacionacademica;
use App\Grupomateriadocente;
use App\Sistemaevaluacion;
use Illuminate\Http\Request;

class AsignaractividadController extends Controller
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
        return view('aula_virtual.docente.asignaractividad_index')
            ->with('location', 'aulavirtual')
            ->with('gmd', $gmd)
            ->with('se', $se)
            ->with('evals', $eval);
    }

    //asignar actividad
    public function asignar($id, $e)
    {
        $gmd = Grupomateriadocente::find($id);
        $acts = Actividad::where([['evaluacionacademica_id', $e], ['grado_id', $gmd->gradomateria->grado_id], ['materia_id', $gmd->gradomateria->materia_id], ['ebeduc', 'NO']])->get();
        if (count($acts) > 0) {
            $ev = Evaluacionacademica::find($e);
            return view('aula_virtual.docente.asignaractividad_asignar')
                ->with('location', 'aulavirtual')
                ->with('gmd', $gmd)
                ->with('se', Sistemaevaluacion::find($ev->sistemaevaluacion_id))
                ->with('ev', $ev)
                ->with('acts', $acts);
        } else {
            flash('No hay actividades creadas para la evaluación indicada')->warning();
            return redirect()->route('asignaractividad.index', $id);
        }
    }

    //guarda la actividad asignada
    public function asignarstore(Request $request)
    {
        $gmd = Grupomateriadocente::find($request->gmd_id);
        $ya = Asignaractividad::where([['periodoacademico_id', $gmd->gradomateria->periodoacademico_id], ['evaluacionacademica_id', $request->e], ['grupo_id', $gmd->grupo_id], ['materia_id', $gmd->gradomateria->materia_id]])->get();
        $total = 0;
        if (count($ya) > 0) {
            foreach ($ya as $y) {
                $total = $total + $y->peso;
            }
        }
        if (($total + $request->peso) > 100) {
            flash('El peso de la actividad supera la capacidad de la evaluación académica, solo puede asignar como peso ' . (100 - $total))->warning();
            return redirect()->route('asignaractividad.index', $gmd->id);
        }
        $aa = new Asignaractividad($request->all());
        $aa->periodoacademico_id = $gmd->gradomateria->periodoacademico_id;
        $aa->evaluacionacademica_id = $request->e;
        $aa->grupo_id = $gmd->grupo_id;
        $aa->materia_id = $gmd->gradomateria->materia_id;
        $aa->ebeduc = "NO";
        if ($aa->save()) {
            flash('Actividad asignada con éxito')->success();
            return redirect()->route('asignaractividad.index', $gmd->id);
        } else {
            flash('La actividad no pudo ser asignada')->error();
            return redirect()->route('asignaractividad.index', $gmd->id);
        }
    }

    //asignar ebeduc
    public function asignarebeduc($id, $e)
    {
        $gmd = Grupomateriadocente::find($id);
        $acts = Actividad::where([['evaluacionacademica_id', $e], ['grado_id', $gmd->gradomateria->grado_id], ['materia_id', $gmd->gradomateria->materia_id], ['ebeduc', 'SI']])->get();
        if (count($acts) > 0) {
            $ev = Evaluacionacademica::find($e);
            return view('aula_virtual.docente.asignarebeduc_asignar')
                ->with('location', 'aulavirtual')
                ->with('gmd', $gmd)
                ->with('se', Sistemaevaluacion::find($ev->sistemaevaluacion_id))
                ->with('ev', $ev)
                ->with('acts', $acts);
        } else {
            flash('No hay pruebas ebeduc creadas para la evaluación indicada')->warning();
            return redirect()->route('asignaractividad.index', $id);
        }
    }

    //guarda la ebeduc asignada
    public function asignarebeducstore(Request $request)
    {
        $gmd = Grupomateriadocente::find($request->gmd_id);
        $ya = Asignaractividad::where([['periodoacademico_id', $gmd->gradomateria->periodoacademico_id], ['evaluacionacademica_id', $request->e], ['grupo_id', $gmd->grupo_id], ['materia_id', $gmd->gradomateria->materia_id]])->get();
        $total = 0;
        if (count($ya) > 0) {
            foreach ($ya as $y) {
                $total = $total + $y->peso;
            }
        }
        if (($total + $request->peso) > 100) {
            flash('El peso de la prueba supera la capacidad de la evaluación académica, solo puede asignar como peso ' . (100 - $total))->warning();
            return redirect()->route('asignaractividad.index', $gmd->id);
        }
        $aa = new Asignaractividad($request->all());
        $aa->periodoacademico_id = $gmd->gradomateria->periodoacademico_id;
        $aa->evaluacionacademica_id = $request->e;
        $aa->grupo_id = $gmd->grupo_id;
        $aa->materia_id = $gmd->gradomateria->materia_id;
        $aa->ebeduc = "SI";
        if ($aa->save()) {
            flash('Prueba asignada con éxito')->success();
            return redirect()->route('asignaractividad.index', $gmd->id);
        } else {
            flash('La prueba no pudo ser asignada')->error();
            return redirect()->route('asignaractividad.index', $gmd->id);
        }
    }
}
