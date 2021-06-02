<?php

namespace App\Http\Controllers;

use App\Asignaractividad;
use App\Estudiante;
use App\Grupomateriadocente;
use App\Resactividadresp;
use App\Resultadoactividad;
use App\Sistemaevaluacion;
use Illuminate\Http\Request;

class CalificaciondocenteController extends Controller
{
    //index
    public function index($id) {
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
        return view('aula_virtual.docente.calificar')
            ->with('location', 'aulavirtual')
            ->with('gmd', $gmd)
            ->with('se', $se)
            ->with('evals', $eval);
    }

    //lista estudiantes para calificar
    public function listarestudiantes($id, $a) {
        $gmd = Grupomateriadocente::find($id);
        $act = Asignaractividad::find($a);
        $contactos = $gmd->grupo->estudiantegrupos;
        if (count($contactos) > 0) {
            foreach ($contactos as $c) {
                $si = Resultadoactividad::where([['asignaractividad_id', $a], ['estudiante_id', $c->estudiante_id]])->first();
                $c->realizo = "NO PRESENTO";
                if ($si != null) {
                    $c->realizo = "PRESENTO";
                }
            }
        }
        return view('aula_virtual.docente.calificarlistarestudiantes')
            ->with('location', 'aulavirtual')
            ->with('gmd', $gmd)
            ->with('a', $act)
            ->with('actividad', $act->actividad)
            ->with('contactos', $contactos);
    }

    //vista para calificar
    public function vistacalificar($id, $a, $e) {
        $gmd = Grupomateriadocente::find($id);
        $act = Asignaractividad::find($a);
        $cal = Resultadoactividad::where([['estudiante_id', $e], ['asignaractividad_id', $a]])->first();
        $est = Estudiante::find($e);
        return view('aula_virtual.docente.calificarvistacalificar')
            ->with('location', 'aulavirtual')
            ->with('gmd', $gmd)
            ->with('a', $act)
            ->with('cal', $cal)
            ->with('est', $est);
    }

    //calificar cero
    public function calificarcero(Request $request) {
        $r = new Resultadoactividad($request->all());
        $r->recurso = "NO";
        $r->anotaciones_docente = strtoupper($r->anotaciones_docente);
        $r->anotaciones_sistema = "El estudiante no realizó la actividad y quedó a consideración del docente";
        if ($r->save()) {
            flash('Solicitud procesada con éxito')->success();
            return redirect()->route('calificaciondocente.vistacalificar', [$request->gmd_id, $request->asignaractividad_id, $request->estudiante_id]);
        } else {
            flash('La solicitud no pudo ser procesada, intente de nuevo.')->error();
            return redirect()->route('calificaciondocente.vistacalificar', [$request->gmd_id, $request->asignaractividad_id, $request->estudiante_id]);
        }
    }

    //calificar actividad
    public function calificaractividad(Request $request) {
        $r = Resultadoactividad::find($request->r_id);
        $r->anotaciones_docente = strtoupper($request->anotaciones_docente);
        $r->anotaciones_sistema = "El docente modificó la calificación. Anotaciones anteriores a la modificación: " . $r->anotaciones_sistema;
        $r->calificacion = $request->calificacion;
        if ($r->save()) {
            flash('Solicitud procesada con éxito')->success();
            return redirect()->route('calificaciondocente.vistacalificar', [$request->gmd_id, $request->asignaractividad_id, $request->estudiante_id]);
        } else {
            flash('La solicitud no pudo ser procesada, intente de nuevo.')->error();
            return redirect()->route('calificaciondocente.vistacalificar', [$request->gmd_id, $request->asignaractividad_id, $request->estudiante_id]);
        }
    }

    //calificar actividad observaciones
    public function observaciones(Request $request) {
        $r = Resultadoactividad::find($request->r_id);
        $r->anotaciones_docente = strtoupper($request->anotaciones_docente);
        $r->anotaciones_sistema = "El docente agregó observaciones a la calificación. Anotaciones anteriores a la modificación: " . $r->anotaciones_sistema;
        if ($r->save()) {
            flash('Solicitud procesada con éxito')->success();
            return redirect()->route('calificaciondocente.vistacalificar', [$request->gmd_id, $request->asignaractividad_id, $request->estudiante_id]);
        } else {
            flash('La solicitud no pudo ser procesada, intente de nuevo.')->error();
            return redirect()->route('calificaciondocente.vistacalificar', [$request->gmd_id, $request->asignaractividad_id, $request->estudiante_id]);
        }
    }

    //devuelve la respuesta correcta
    public static function respuesta_correcta($c, $p) {
        return Resactividadresp::where([['resultadoactividad_id', $c], ['pregunta_id', $p]])->first();
    }

    //solocalificacion
    public function solocalificacion(Request $request) {
        $r = Resactividadresp::find($request->resactividadresp_id);
        $r->estado = "CALIFICADA";
        $r->puntos_obtenidos = $request->puntos_obtenidos;
        if ($r->save()) {
            //Recalificamos el examen
            $this->recalificar($r->resultadoactividad_id);
            flash('Solicitud procesada con éxito')->success();
            return redirect()->route('calificaciondocente.vistacalificar', [$request->gmd_id, $request->asignaractividad_id, $request->estudiante_id]);
        } else {
            flash('La solicitud no pudo ser procesada, intente de nuevo.')->error();
            return redirect()->route('calificaciondocente.vistacalificar', [$request->gmd_id, $request->asignaractividad_id, $request->estudiante_id]);
        }
    }

    //Recalificar
    public function recalificar($id) {
        $r = Resultadoactividad::find($id);
        $a = $r->asignaractividad->actividad;
        $preguntas = $a->actividadpreguntas;
        $totalpts = 0;
        $totalptsobtenidos = 0;
        if (count($preguntas) > 0) {
            foreach ($preguntas as $p) {
                $totalpts = $totalpts + $p->pregunta->puntos;
                $resp = Resactividadresp::where([['resultadoactividad_id', $id], ['pregunta_id', $p->pregunta_id]])->first();
                if ($resp != null) {
                    $totalptsobtenidos = $totalptsobtenidos + $resp->puntos_obtenidos;
                }
            }
        }
        $r->calificacion = ($r->evaluacionacademica->sistemaevaluacion->nota_final * $totalptsobtenidos) / $totalpts;
        $r->anotaciones_sistema = "La calificación actual es " . $r->calificacion . ", PUNTOS OBTENIDOS: " . $totalptsobtenidos . "/" . $totalpts;
        $r->save();
    }
}
