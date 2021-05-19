<?php

namespace App\Http\Controllers;

use App\Fechasprocesosacademico;
use App\Jornada;
use App\Unidad;
use App\Periodoacademico;
use App\Procesosacademicos;
use App\Periodounidad;
use App\Auditoriaadmision;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\FechasprocesosacademicoRequest;
use Illuminate\Http\Request;

class FechasprocesosacademicoController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id) {
        $perund = Periodounidad::find($id);
        $procesos = Procesosacademicos::all()->pluck('nombre', 'id');
        return view('admisiones.calendario_procesos_convocatoria.programar_periodo.fechaprocesos')
                        ->with('location', 'admisiones')
                        ->with('perund', $perund)
                        ->with('procesos', $procesos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FechasprocesosacademicoRequest $request) {
        $fecha = new Fechasprocesosacademico();
        $fecha->periodoacademico_id = $request->periodoacademico_id;
        $fecha->procesosacademico_id = $request->procesosacademico_id;
        $fecha->unidad_id = $request->unidad_id;
        $fecha->jornada_id = $request->jornada_id;
        $fecha->fecha_inicio = $request->fecha_inicio;
        $fecha->fecha_fin = $request->fecha_fin;
        $u = Auth::user();
        $fecha->user_change = $u->identificacion;
        $result = $fecha->save();
        if ($result) {
            $aud = new Auditoriaadmision();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "INSERTAR";
            $str = "CREACIÓN DE FECHAS DE PROCESOS ACADÉMICOS. DATOS: ";
            foreach ($fecha->attributesToArray() as $key => $value) {
                if ($key == 'procesosacademico_id') {
                    $str = $str . ", " . $key . ": " . $value . ", proceso:" . $fecha->procesosacademico->nombre;
                } else if ($key == 'unidad_id') {
                    $str = $str . ", " . $key . ": " . $value . ", unidad:" . $fecha->unidad->nombre;
                } else if ($key == 'periodoacademico_id') {
                    $str = $str . ", " . $key . ": " . $value . ", periodoacademico:" . $fecha->periodoacademico->etiqueta . " - " . $fecha->periodoacademico->anio;
                } else if ($key == 'jornada_id') {
                    $str = $str . ", " . $key . ": " . $value . ", jornada:" . $fecha->jornada->descripcion;
                } else {
                    $str = $str . ", " . $key . ": " . $value;
                }
            }
            $aud->detalles = $str;
            $aud->save();
            flash("Fechas agregadas de forma exitosa!")->success();
            return redirect()->route('fechaprocesos.index2', $request->periodounidad);
        } else {
            flash("Las fechas no pudieron ser agregadas. Error: " . $result)->error();
            return redirect()->route('fechaprocesos.index2', $request->periodounidad);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Fechasprocesosacademico  $fechasprocesosacademico
     * @return \Illuminate\Http\Response
     */
    public function show(Fechasprocesosacademico $fechasprocesosacademico) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Fechasprocesosacademico  $fechasprocesosacademico
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $fecha = Fechasprocesosacademico::find($id);
        if ($fecha !== null) {
            $response["data"] = $fecha->toArray();
            return json_encode($response);
        } else {
            return "ERROR";
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Fechasprocesosacademico  $fechasprocesosacademico
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Fechasprocesosacademico $fechasprocesosacademico) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Fechasprocesosacademico  $fechasprocesosacademico
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $fecha = Fechasprocesosacademico::find($id);
        $result = $fecha->delete();
        if ($result) {
            $aud = new Auditoriaadmision();
            $u = Auth::user();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ELIMINAR";
            $str = "ELIMINACIÓN DE FECHA DE PROCESO ACADÉMICO. DATOS ELIMINADOS: ";
            foreach ($fecha->attributesToArray() as $key => $value) {
                if ($key == 'procesosacademico_id') {
                    $str = $str . ", " . $key . ": " . $value . ", proceso:" . $fecha->procesosacademico->nombre;
                } else if ($key == 'unidad_id') {
                    $str = $str . ", " . $key . ": " . $value . ", unidad:" . $fecha->unidad->nombre;
                } else if ($key == 'periodoacademico_id') {
                    $str = $str . ", " . $key . ": " . $value . ", periodoacademico:" . $fecha->periodoacademico->etiqueta . " - " . $fecha->periodoacademico->anio;
                } else if ($key == 'jornada_id') {
                    $str = $str . ", " . $key . ": " . $value . ", jornada:" . $fecha->jornada->descripcion;
                } else {
                    $str = $str . ", " . $key . ": " . $value;
                }
            }
            $aud->detalles = $str;
            $aud->save();
            return "true";
        } else {
            return "false";
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function set(Request $request) {
        $p = Fechasprocesosacademico::find($request->iddd);
        $m = new Fechasprocesosacademico($p->attributesToArray());
        if ($request->fecha_inicioo !== null) {
            $p->fecha_inicio = $request->fecha_inicioo;
        }
        if ($request->fecha_finn !== null) {
            $p->fecha_fin = $request->fecha_finn;
        }
        $u = Auth::user();
        $p->user_change = $u->identificacion;
        if ($p->save()) {
            $aud = new Auditoriaadmision();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ACTUALIZAR DATOS";
            $str = "EDICION DE FECHA DE PROCESOS ACADÉMICOS. DATOS NUEVOS: ";
            $str2 = " DATOS ANTIGUOS: ";
            foreach ($m->attributesToArray() as $key => $value) {
                if ($key == 'procesosacademico_id') {
                    $str2 = $str2 . ", " . $key . ": " . $value . ", proceso:" . $m->procesosacademico->nombre;
                } else if ($key == 'unidad_id') {
                    $str2 = $str2 . ", " . $key . ": " . $value . ", unidad:" . $m->unidad->nombre;
                } else if ($key == 'periodoacademico_id') {
                    $str2 = $str2 . ", " . $key . ": " . $value . ", periodoacademico:" . $m->periodoacademico->etiqueta . " - " . $m->periodoacademico->anio;
                } else if ($key == 'jornada_id') {
                    $str2 = $str2 . ", " . $key . ": " . $value . ", jornada:" . $m->jornada->descripcion;
                } else {
                    $str2 = $str2 . ", " . $key . ": " . $value;
                }
            }
            foreach ($p->attributesToArray() as $key => $value) {
                if ($key == 'procesosacademico_id') {
                    $str = $str . ", " . $key . ": " . $value . ", proceso:" . $p->procesosacademico->nombre;
                } else if ($key == 'unidad_id') {
                    $str = $str . ", " . $key . ": " . $value . ", unidad:" . $p->unidad->nombre;
                } else if ($key == 'periodoacademico_id') {
                    $str = $str . ", " . $key . ": " . $value . ", periodoacademico:" . $p->periodoacademico->etiqueta . " - " . $p->periodoacademico->anio;
                } else if ($key == 'jornada_id') {
                    $str = $str . ", " . $key . ": " . $value . ", jornada:" . $p->jornada->descripcion;
                } else {
                    $str = $str . ", " . $key . ": " . $value;
                }
            }
            $aud->detalles = $str . " - " . $str2;
            $aud->save();
            flash("Fechas modificadas con exito!")->success();
            return redirect()->route('fechaprocesos.index2', $request->periodounidad3);
        } else {
            flash("Las fechas no pudieron ser modificadas.")->error();
            return redirect()->route('fechaprocesos.index2', $request->periodounidad3);
        }
    }

    public function listID($per, $pro, $jor, $und) {
        $fecha = Fechasprocesosacademico::where([['periodoacademico_id', $per], ['procesosacademico_id', $pro], ['jornada_id', $jor], ['unidad_id', $und]])->get();
        $response["error"] = "NO";
        if (count($fecha) > 0) {
            $arr = null;
            foreach ($fecha as $value) {
                $arr[] = $value;
            }
            $response["data"] = $arr;
        } else {
            $response["error"] = "SI";
        }
        return json_encode($response);
    }

}
