<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Auditoriaadmision;
use App\Unidad;
use App\Jornada;
use App\Periodoacademico;
use App\Grado;
use App\Aspirante;
use App\Agendacitas;
use App\Cuestionarioentrevista;
use App\Entrevista;
use App\Entrevistapreres;

class RealizarentrevistaController extends Controller
{
    //formulario de inicio
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
            return redirect()->route('menu.admisiones');
        }
        $unds = Unidad::all();
        if (count($unds) > 0) {
            foreach ($unds as $u) {
                $unidades[$u->id] = $u->nombre . " - " . $u->descripcion . " - " . $u->ciudad->nombre;
            }
        } else {
            flash("No hay unidades o sedes definidas")->error();
            return redirect()->route('menu.admisiones');
        }
        $grados = Grado::all()->pluck('etiqueta', 'id');
        $jnds = Jornada::all();
        if (count($jnds) > 0) {
            foreach ($jnds as $j) {
                $jornadas[$j->id] = $j->descripcion . " - " . $j->jornadasnies;
            }
        } else {
            flash("No hay jornadas académicas definidas")->error();
            return redirect()->route('menu.admisiones');
        }
        if (count($grados) <= 0) {
            flash("No hay grados académicos definidos")->error();
            return redirect()->route('menu.admisiones');
        }
        return view('admisiones.agenda_entrevista.realizar_entrevista.list')
            ->with('location', 'admisiones')
            ->with('periodos', $periodos)
            ->with('jornadas', $jornadas)
            ->with('unidades', $unidades)
            ->with('grados', $grados);
    }

    //Lista los aspirantes por unidad, periodo, jornada, grado
    public function listaraspirantes($u, $p, $j, $g)
    {
        $aspirantes = Aspirante::where([['unidad_id', $u], ['periodoacademico_id', $p], ['jornada_id', $j], ['grado_id', $g]])->get();
        if (count($aspirantes) > 0) {
            return view('admisiones.agenda_entrevista.realizar_entrevista.aspirantes')
                ->with('location', 'admisiones')
                ->with('periodo', Periodoacademico::find($p))
                ->with('jornada', Jornada::find($j))
                ->with('unidad', Unidad::find($u))
                ->with('grado', Grado::find($g))
                ->with('aspirantes', $aspirantes);
        } else {
            flash("No hay aspirantes para los parámetros indicados")->error();
            return redirect()->route('realizarentrevista.index');
        }
    }

    //permite mostrar el formulario para hacer la entrevista
    public function show($id)
    {
        $a = Aspirante::find($id);
        $e = $a->entrevista;
        $c = $preguntas = null;
        $c = $e->cuestionarioentrevista;
        if ($c != null) {
            //hay cuestionario
            $pre = $c->cuestionariopreguntas;
            if (count($pre) > 0) {
                foreach ($pre as $p) {
                    $preguntas[] = [
                        'pregunta' => $p,
                        'respuestas' => $p->cuestionarioprespuestas
                    ];
                }
            }
        }
        $estados = [
            'PENDIENTE' => 'PENDIENTE',
            'APROBADA' => 'APROBADA',
            'REPROBADA' => 'REPROBADA',
            'APLAZADA' => 'APLAZADA',
            'RECHAZADA' => 'RECHAZADA'
        ];
        $horai = $horaf = "";
        $hi = (string) $e->agendacita->horainicio;
        $hf = (string) $e->agendacita->horafin;
        if (strlen($hi) < 4) {
            $horai = "0" . $hi[0] . ":" . $hi[1] . $hi[2];
        } else {
            $horai = $hi[0] . $hi[1] . ":" . $hi[2] . $hi[3];
        }
        if (strlen($hf) < 4) {
            $horaf = "0" . $hf[0] . ":" . $hf[1] . $hf[2];
        } else {
            $horaf = $hf[0] . $hf[1] . ":" . $hf[2] . $hf[3];
        }
        //devolvemos aspirante, entrevista, cuestionarioentrevista (preguntas y respuestas)
        return view('admisiones.agenda_entrevista.realizar_entrevista.examen')
            ->with('location', 'admisiones')
            ->with('a', $a)
            ->with('e', $e)
            ->with('c', $c)
            ->with('horai', $horai)
            ->with('horaf', $horaf)
            ->with('estados', $estados)
            ->with('preguntas', $preguntas);
    }

    //carga cuestionarios
    public function cargarcuestionario($id, $source)
    {
        $response = ['error' => 'NO'];
        $cuestionarios = null;
        if ($source == 'CIRCUNSCRIPCION') {
            $cuestionarios = Cuestionarioentrevista::where('circunscripcion_id', $id)->get();
        } else {
            $cuestionarios = Cuestionarioentrevista::all();
        }
        if (count($cuestionarios) > 0) {
            foreach ($cuestionarios as $c) {
                $c->circunscripcion;
            }
            $response = [
                'error' => 'NO',
                'data' => $cuestionarios
            ];
        } else {
            $response = [
                'mensaje' => 'No hay cuestionarios para la circunscripción del aspirante',
                'error' => 'SI'
            ];
        }
        return json_encode($response);
    }

    //asigna un cuestionario
    public function asignarcuestionario($a, $e, $c)
    {
        $ent = Entrevista::find($e);
        $ent->cuestionarioentrevista_id = (int) $c;
        if ($ent->save()) {
            flash("Cuestionario asignado con éxito")->success();
            return redirect()->route('realizarentrevista.show', $a);
        } else {
            flash("El cuestionario no pudo ser asignado")->error();
            return redirect()->route('realizarentrevista.show', $a);
        }
    }

    //almacena la entrevista
    public function store(Request $request)
    {
        if (isset($request->preguntas)) {
            $e = Entrevista::find($request->entrevista_id);
            $e->estado = $request->estado;
            $e->anotaciones = strtoupper($request->anotaciones);
            $u = Auth::user();
            if ($e->save()) {
                $todas = $si = 0;
                $todas = count($request->preguntas);
                foreach ($request->preguntas as $key => $value) {
                    $pr = new Entrevistapreres();
                    $tipo = $request->tipos[$key];
                    $pr->tipo = $tipo;
                    $pr->user_change = $u->identificacion;
                    $pr->cuestionariopregunta_id = (int) $value;
                    $pr->entrevista_id = $e->id;
                    if ($tipo == 'NORMAL') {
                        $pr->cuestionarioprespuesta_id = (int) $request->respuestas[$key];
                    }
                    if ($tipo == 'OTRA-PREGUNTA') {
                        $pr->cuestionarioprespuesta_id = (int) $request->respuestas[$key];
                        $var = "segunda_" . $value;
                        $pr->respuesta = strtoupper($request->$var);
                    }
                    if ($tipo == 'RESPONDA') {
                        $pr->respuesta = strtoupper($request->respuestas[$key]);
                    }
                    if ($pr->save()) {
                        $si = $si + 1;
                    }
                }
                flash("La entrevista se guardó con exito y procesó " . $si . " de " . $todas . " preguntas")->success();
                return redirect()->route('realizarentrevista.show', $request->aspirante_id);
            } else {
                flash("La entrevista no se guardó, debe realizarla nuevamente")->error();
                return redirect()->route('realizarentrevista.show', $request->aspirante_id);
            }
        } else {
            flash("No respondió la entrevista correctamente, debe realizarla de nuevo")->error();
            return redirect()->route('realizarentrevista.show', $request->aspirante_id);
        }
    }
}
