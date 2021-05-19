<?php

namespace App\Http\Controllers;

use App\Periodounidad;
use App\Jornada;
use App\Periodoacademico;
use App\Unidad;
use App\Auditoriaadmision;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PeriodounidadRequest;
use Illuminate\Http\Request;

class PeriodounidadController extends Controller {

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
        return view('admisiones.calendario_procesos_convocatoria.programar_periodo.list')
                        ->with('location', 'admisiones')
                        ->with('perunid', $perunid);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $jornadas = Jornada::all()->pluck('descripcion', 'id');
        $perundes = Unidad::all()->pluck('nombre', 'id');
        $per = Periodoacademico::all();
        $periodos = null;
        if (count($per) > 0) {
            $period = $per->sortByDesc('anio');
            foreach ($period as $value) {
                $periodos[$value->id] = $value->anio . " - " . $value->etiqueta;
            }
        }
        return view('admisiones.calendario_procesos_convocatoria.programar_periodo.create')
                        ->with('location', 'admisiones')
                        ->with('periodos', $periodos)
                        ->with('jornadas', $jornadas)
                        ->with('unidades', $perundes);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PeriodounidadRequest $request) {
        $perund = new Periodounidad($request->all());
        foreach ($perund->attributesToArray() as $key => $value) {
            $perund->$key = strtoupper($value);
        }
        $u = Auth::user();
        $perund->user_change = $u->identificacion;
        $result = $perund->save();
        if ($result) {
            $aud = new Auditoriaadmision();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "INSERTAR";
            $str = "CREACIÓN DE PROGRAMAR PERIODO ACADÉMICO. DATOS: ";
            foreach ($perund->attributesToArray() as $key => $value) {
                if ($key == 'jornada_id') {
                    $str = $str . ", " . $key . ": " . $value . ", jornada:" . $perund->jornada->descripcion;
                } else if ($key == 'unidad_id') {
                    $str = $str . ", " . $key . ": " . $value . ", unidad:" . $perund->unidad->nombre;
                } else if ($key == 'periodoacademico_id') {
                    $str = $str . ", " . $key . ": " . $value . ", periodoacademico:" . $perund->periodoacademico->etiqueta . " - " . $perund->periodoacademico->anio;
                } else {
                    $str = $str . ", " . $key . ": " . $value;
                }
            }
            $aud->detalles = $str;
            $aud->save();
            flash("La programación del período <strong>" . $perund->periodoacademico->etiqueta . " - " . $perund->periodoacademico->anio . "</strong> fue almacenada de forma exitosa!")->success();
            return redirect()->route('periodounidad.index');
        } else {
            flash("La programación del período <strong>" . $perund->periodoacademico->etiqueta . " - " . $perund->periodoacademico->anio . "</strong> no pudo ser almacenada. Error: " . $result)->error();
            return redirect()->route('periodounidad.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Periodounidad  $periodounidad
     * @return \Illuminate\Http\Response
     */
    public function show(Periodounidad $periodounidad) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Periodounidad  $periodounidad
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Periodounidad  $periodounidad
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Periodounidad  $periodounidad
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        // if (count($perund->paginas) > 0 || count($grupo->modulos) > 0 || count($grupo->users) > 0) {
//            flash("El Grupo de usuario <strong>" . $grupo->nombre . "</strong> no pudo ser eliminado porque tiene permisos o usuarios asociados.")->warning();
//            return redirect()->route('grupousuario.index');
//        } else {
        $perund = Periodounidad::find($id);
        $result = $perund->delete();
        if ($result) {
            $aud = new Auditoriaadmision();
            $u = Auth::user();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ELIMINAR";
            $str = "ELIMINACIÓN DE PROGRAMACIÓN DE PERÍODO ACADÉMICO. DATOS ELIMINADOS: ";
            foreach ($perund->attributesToArray() as $key => $value) {
                if ($key == 'jornada_id') {
                    $str = $str . ", " . $key . ": " . $value . ", jornada:" . $perund->jornada->descripcion;
                } else if ($key == 'unidad_id') {
                    $str = $str . ", " . $key . ": " . $value . ", unidad:" . $perund->unidad->nombre;
                } else if ($key == 'periodoacademico_id') {
                    $str = $str . ", " . $key . ": " . $value . ", periodoacademico:" . $perund->periodoacademico->etiqueta . " - " . $perund->periodoacademico->anio;
                } else {
                    $str = $str . ", " . $key . ": " . $value;
                }
            }
            $aud->detalles = $str;
            $aud->save();
            flash("La programación del período <strong>" . $perund->periodoacademico->etiqueta . " - " . $perund->periodoacademico->anio . "</strong> fue eliminada de forma exitosa!")->success();
            return redirect()->route('periodounidad.index');
        } else {
            flash("La programación del período <strong>" . $perund->periodoacademico->etiqueta . " - " . $perund->periodoacademico->anio . "</strong> no pudo ser eliminada. Error: " . $result)->error();
            return redirect()->route('periodounidad.index');
        }
//        }
    }

}
