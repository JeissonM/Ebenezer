<?php

namespace App\Http\Controllers;

use App\Actividad;
use App\Asignaractividad;
use App\Estudiante;
use App\Grupomateriadocente;
use App\Persona;
use App\Pregunta;
use App\Resactividadresp;
use App\Resultadoactividad;
use App\Sistemaevaluacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RealizaractividadController extends Controller
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
        $fechas = null;
        foreach ($eval as $e) {
            if ($e->actividades != null) {
                foreach ($e->actividades as $a) {
                    $a->vencida = $this->vencida($a->id);
                }
            }
        }
        return view('aula_virtual.estudiante.realizaractividad_index')
            ->with('location', 'aulavirtual')
            ->with('gmd', $gmd)
            ->with('se', $se)
            ->with('evals', $eval);
    }

    //determina si una actividad está vencida
    public static function vencida($id) {
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

    //ver actividad
    public function ver($id, $a) {
        $gmd = Grupomateriadocente::find($id);
        $aa = Asignaractividad::find($a);
        return view('aula_virtual.estudiante.realizaractividad_ver')
            ->with('location', 'aulavirtual')
            ->with('gmd', $gmd)
            ->with('se', $aa->evaluacionacademica->sistemaevaluacion)
            ->with('eval', $aa->evaluacionacademica)
            ->with('actividad', $aa->actividad)
            ->with('aa', $aa);
    }

    //realizar actividad
    public function realizar($id, $a) {
        $gmd = Grupomateriadocente::find($id);
        $aa = Asignaractividad::find($a);
        $u = Persona::where('numero_documento', Auth::user()->identificacion)->first();
        $est = $u->personanatural->estudiante;
        return view('aula_virtual.estudiante.realizaractividad_realizar')
            ->with('location', 'aulavirtual')
            ->with('gmd', $gmd)
            ->with('se', $aa->evaluacionacademica->sistemaevaluacion)
            ->with('eval', $aa->evaluacionacademica)
            ->with('aa', $aa)
            ->with('actividad', $aa->actividad)
            ->with('est', $est);
    }

    //subir resultado
    public function subirresultado(Request $request) {
        $aa = Asignaractividad::find($request->asignaractividad_id);
        $r = null;
        if (count($aa->resultadoactividads) > 0) {
            $r = $aa->resultadoactividads[0];
        } else {
            $r = new Resultadoactividad($request->all());
        }
        $r->calificacion = 0;
        $r->anotaciones_sistema = "La calificación actual es 0, debe esperar que el docente asigne calificación a la actividad";
        $r->anotaciones_docente = "SIN ANOTACIONES";
        if (isset($request->recurso)) {
            if (count($aa->resultadoactividads) > 0) {
                unlink(public_path() . "/documentos/aulavirtual/" . $aa->resultadoactividads[0]->recurso);
            }
            $file = $request->file('recurso');
            $name = "Recurso_" . $r->asignaractividad_id . $r->estudiante_id . "." . $file->getClientOriginalExtension();
            $path = public_path() . "/documentos/aulavirtual/";
            $file->move($path, $name);
            $r->recurso = $name;
            if ($r->save()) {
                flash('Documento procesado con éxito')->success();
                return redirect()->route('realizaractividad.realizar', [$request->gmd_id, $request->asignaractividad_id]);
            } else {
                flash('El documento no pudo ser procesado, intente de nuevo.')->error();
                return redirect()->route('realizaractividad.realizar', [$request->gmd_id, $request->asignaractividad_id]);
            }
        } else {
            flash('No hay documento para proceder')->warning();
            return redirect()->route('realizaractividad.realizar', [$request->gmd_id, $request->asignaractividad_id]);
        }
    }

    //subir resultado
    public function pedircalificacion(Request $request) {
        $aa = Asignaractividad::find($request->asignaractividad_id);
        if (count($aa->resultadoactividads) > 0) {
            flash('La actividad ya tiene calificación asignada')->warning();
            return redirect()->route('realizaractividad.realizar', [$request->gmd_id, $request->asignaractividad_id]);
        } else {
            $r = new Resultadoactividad($request->all());
            $r->calificacion = 0;
            $r->anotaciones_sistema = "La calificación actual es 0, debe esperar que el docente asigne calificación a la actividad";
            $r->anotaciones_docente = "SIN ANOTACIONES";
            $r->recurso = "NO";
            if ($r->save()) {
                flash('Petición procesada con éxito')->success();
                return redirect()->route('realizaractividad.realizar', [$request->gmd_id, $request->asignaractividad_id]);
            } else {
                flash('La solicitud no pudo ser procesada, intente de nuevo.')->error();
                return redirect()->route('realizaractividad.realizar', [$request->gmd_id, $request->asignaractividad_id]);
            }
        }
    }

    //guardar examen
    public function guardarexamen(Request $request) {
        $aa = Asignaractividad::find($request->asignaractividad_id);
        if (count($aa->resultadoactividads) > 0) {
            flash('Usted ya realizó el(la) exámen/prueba ebeduc, no puede realizarla dos o más veces')->warning();
            return redirect()->route('realizaractividad.realizar', [$request->gmd_id, $request->asignaractividad_id]);
        } else {
            $r = new Resultadoactividad($request->all());
            $r->tipo = $request->tipoa;
            $r->anotaciones_docente = "SIN ANOTACIONES";
            $r->recurso = "NO";
            //guardar examen o ebeduc
            $total = count($request->pregunta_id);
            $cuantas = 0;
            $totalpts = 0;
            $totalptsobtenidos = 0;
            if ($r->save()) {
                foreach ($request->pregunta_id as $key => $p) {
                    $po = Pregunta::find($p);
                    $totalpts = $totalpts + $po->puntos;
                    $pr = new Resactividadresp();
                    $pr->tipo = $po->tipo;
                    $pr->pregunta_id = $p;
                    $pr->resultadoactividad_id = $r->id;
                    $clave = "respuesta_" . $p;
                    if ($po->tipo == 'RESPONDA') {
                        if (isset($request->$clave[0])) {
                            $pr->respuesta = $request->$clave[0];
                        } else {
                            $pr->respuesta = "EL ESTUDIANTE NO RESPONDIÓ";
                        }
                        $pr->estado = "SIN CALIFICAR";
                        $pr->puntos_obtenidos = 0;
                    } else {
                        if (isset($request->$clave[0])) {
                            $pr->respuesta_id = $request->$clave[0];
                        } else {
                            $pr->respuesta_id = null;
                        }
                        $pr->estado = "CALIFICADA";
                        $pr->puntos_obtenidos = 0;
                        if ($pr->respuesta_id == $po->respuesta_id) {
                            if ($po->respuesta_id != null) {
                                $pr->puntos_obtenidos = $po->puntos;
                                $totalptsobtenidos = $totalptsobtenidos + $po->puntos;
                            }
                        }
                    }
                    if ($pr->save()) {
                        $cuantas = $cuantas + 1;
                    }
                }
                // si  $totalpts           === nota_max de calificacion
                //     $totalptsobtenidos  === x de calificacion
                //  x=(10*$totalptsobtenidos)/$totalpts;
                $r->calificacion = ($r->evaluacionacademica->sistemaevaluacion->nota_final * $totalptsobtenidos) / $totalpts;
                $r->anotaciones_sistema = "La calificación actual es " . $r->calificacion . ", si hubo preguntas tipo RESPONDA en el examen, debe esperar que el docente asigne calificación a dichas preguntas para obtener la calificacíon final de la actividad. PUNTOS OBTENIDOS: " . $totalptsobtenidos . "/" . $totalpts . " -- RESPUESTAS ALMACENADAS: " . $cuantas . "/" . $total;
                $r->save();
                flash($r->anotaciones_sistema)->info();
                return redirect()->route('realizaractividad.realizar', [$request->gmd_id, $request->asignaractividad_id]);
            } else {
                flash('Las respuestas no pudieron ser procesadas, intente de nuevo.')->error();
                return redirect()->route('realizaractividad.realizar', [$request->gmd_id, $request->asignaractividad_id]);
            }
        }
    }
}
