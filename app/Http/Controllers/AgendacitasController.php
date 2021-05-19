<?php

namespace App\Http\Controllers;

use App\Agendacitas;
use Illuminate\Http\Request;
use App\Periodounidad;
use App\Auditoriaadmision;
use Illuminate\Support\Facades\Auth;

class AgendacitasController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $perunid = Periodounidad::all();
        $perunid->each(function($item) {
            $item->jornada;
            $item->periodoacademico;
            $item->unidad;
        });
        return view('admisiones.agenda_entrevista.programar_agenda.list')
                        ->with('location', 'admisiones')
                        ->with('perunid', $perunid);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id) {
        $aso = Periodounidad::find($id);
        return view('admisiones.agenda_entrevista.programar_agenda.create')
                        ->with('location', 'admisiones')
                        ->with('aso', $aso);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $array = null;
        if (isset($request->hora_inicio)) {
            foreach ($request->hora_inicio as $key => $hi) {
                $ac = new Agendacitas();
                $ac->periodounidad_id = $request->periodounidad_id;
                $ac->fecha = $request->fecha;
                $ac->horainicio = $hi;
                $ac->horafin = $request->hora_fin[$key];
                $array[] = $ac;
            }
            if ($array != null) {
                $response = "<h4>Detalles del proceso</h4>";
                foreach ($array as $r) {
                    if (strpos($r->horainicio, ':') == false) {
                        if ($r->save()) {
                            $u = Auth::user();
                            $aud = new Auditoriaadmision();
                            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
                            $aud->operacion = "INSERTAR";
                            $str = "CREACIÓN DE HORARIOS PARA ENTREVISTAS DE ADMISIÓN. DATOS: ";
                            foreach ($r->attributesToArray() as $key => $value) {
                                $str = $str . ", " . $key . ": " . $value;
                            }
                            $aud->detalles = $str;
                            $aud->save();
                            $response = $response . "<p>[OK]  El horario " . $r->horainicio . " - " . $r->horafin . " se guardó con éxito</p>";
                        } else {
                            $response = $response . "<p>[x]  El horario " . $r->horainicio . " - " . $r->horafin . " no se guardó</p>";
                        }
                    } else {
                        $response = $response . "<p>[x]  El horario " . $r->horainicio . " - " . $r->horafin . " no se guardó porque tiene 2 puntos (:)</p>";
                    }
                }
                flash($response)->success();
                return redirect()->route('agendacita.edit', $request->periodounidad_id);
            } else {
                flash('No hay horarios para guardar')->warning();
                return redirect()->route('agendacita.edit', $request->periodounidad_id);
            }
        } else {
            flash('No hay horarios para guardar')->warning();
            return redirect()->route('agendacita.edit', $request->periodounidad_id);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Agendacitas  $agendacitas
     * @return \Illuminate\Http\Response
     */
    public function show(Agendacitas $agendacitas) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Agendacitas  $agendacitas
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $aso = Periodounidad::find($id);
        $agenda = null;
        $agenda = $aso->agendacitas;
        if ($agenda != null) {
            foreach ($agenda as $a) {
                $hi = (string) $a->horainicio;
                $hf = (string) $a->horafin;
                if (strlen($hi) < 4) {
                    $a->horainicio = "0" . $hi[0] . ":" . $hi[1] . $hi[2];
                } else {
                    $a->horainicio = $hi[0] . $hi[1] . ":" . $hi[2] . $hi[3];
                }
                if (strlen($hf) < 4) {
                    $a->horafin = "0" . $hf[0] . ":" . $hf[1] . $hf[2];
                } else {
                    $a->horafin = $hf[0] . $hf[1] . ":" . $hf[2] . $hf[3];
                }
            }
        }
        return view('admisiones.agenda_entrevista.programar_agenda.fechas')
                        ->with('location', 'admisiones')
                        ->with('aso', $aso)
                        ->with('agenda', $agenda);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Agendacitas  $agendacitas
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Agendacitas $agendacitas) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Agendacitas  $agendacitas
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $ac = Agendacitas::find($id);
        $result = $ac->delete();
        if ($result) {
            $aud = new Auditoriaadmision();
            $u = Auth::user();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ELIMINAR";
            $str = "ELIMINACIÓN DE HORARIO DE ENTREVISTAS DE ADMISIÓN. DATOS ELIMINADOS: ";
            foreach ($ac->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash('Eliminado con éxito')->success();
            return redirect()->route('agendacita.edit', $ac->periodounidad_id);
        } else {
            flash("No se pudo eliminar")->error();
            return redirect()->route('agendacita.edit', $ac->periodounidad_id);
        }
    }

}
