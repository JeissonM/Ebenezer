<?php

namespace App\Http\Controllers;

use App\Unidad;
use App\Ciudad;
use App\Estado;
use App\Auditoriaadmision;
use App\Http\Requests\UnidadRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UnidadController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $unidades = Unidad::all();
        $unidades->each(function($item) {
            $item->ciudad;
        });
        return view('admisiones.calendario_procesos_convocatoria.unidad.list')
                        ->with('location', 'admisiones')
                        ->with('unidades', $unidades);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $estados = Estado::where('pais_id', 191)->get();
        $ciudades = null;
        if (count($estados) > 0) {
            foreach ($estados as $e) {
                $data = null;
                $data = Ciudad::where('estado_id', $e->id)->get();
                if ($data !== null) {
                    foreach ($data as $d) {
                        $ciudades[$d->id] = $d->nombre;
                    }
                }
            }
        }
        return view('admisiones.calendario_procesos_convocatoria.unidad.create')
                        ->with('location', 'admisiones')
                        ->with('ciudades', $ciudades);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UnidadRequest $request) {
        $unidad = new Unidad($request->all());
        foreach ($unidad->attributesToArray() as $key => $value) {
            $unidad->$key = strtoupper($value);
        }
        $u = Auth::user();
        $unidad->user_change = $u->identificacion;
        $result = $unidad->save();
        if ($result) {
            $aud = new Auditoriaadmision();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "INSERTAR";
            $str = "CREACIÓN DE UNIDAD. DATOS: ";
            foreach ($unidad->attributesToArray() as $key => $value) {
                if ($key == 'ciudad_id') {
                    $str = $str . ", " . $key . ": " . $value . ", ciudad:" . $unidad->ciudad->nombre;
                } else {
                    $str = $str . ", " . $key . ": " . $value;
                }
            }
            $aud->detalles = $str;
            $aud->save();
            flash("La unidad <strong>" . $unidad->nombre . "</strong> fue almacenada de forma exitosa!")->success();
            return redirect()->route('unidad.index');
        } else {
            flash("La unidad <strong>" . $unidad->nombre . "</strong> no pudo ser almacenada. Error: " . $result)->error();
            return redirect()->route('unidad.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Unidad  $unidad
     * @return \Illuminate\Http\Response
     */
    public function show(Unidad $unidad) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Unidad  $unidad
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $unidad = Unidad::find($id);
        $estados = Estado::where('pais_id', 191)->get();
        $ciudades = null;
        if (count($estados) > 0) {
            foreach ($estados as $e) {
                $data = null;
                $data = Ciudad::where('estado_id', $e->id)->get();
                if ($data !== null) {
                    foreach ($data as $d) {
                        $ciudades[$d->id] = $d->nombre;
                    }
                }
            }
        }
        return view('admisiones.calendario_procesos_convocatoria.unidad.edit')
                        ->with('location', 'admisiones')
                        ->with('unidad', $unidad)
                        ->with('ciudades', $ciudades);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Unidad  $unidad
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $unidad = Unidad::find($id);
        $m = new Unidad($unidad->attributesToArray());
        foreach ($unidad->attributesToArray() as $key => $value) {
            if (isset($request->$key)) {
                $unidad->$key = strtoupper($request->$key);
            }
        }
        $u = Auth::user();
        $unidad->user_change = $u->identificacion;
        $result = $unidad->save();
        if ($result) {
            $aud = new Auditoriaadmision();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ACTUALIZAR DATOS";
            $str = "EDICION DE UNIDAD. DATOS NUEVOS: ";
            $str2 = " DATOS ANTIGUOS: ";
            foreach ($m->attributesToArray() as $key => $value) {
                if ($key == 'ciudad_id') {
                    $str2 = $str2 . ", " . $key . ": " . $value . ", ciudad:" . $m->ciudad->nombre;
                } else {
                    $str2 = $str2 . ", " . $key . ": " . $value;
                }
            }
            foreach ($unidad->attributesToArray() as $key => $value) {
                if ($key == 'ciudad_id') {
                    $str = $str . ", " . $key . ": " . $value . ", ciudad:" . $unidad->ciudad->nombre;
                } else {
                    $str = $str . ", " . $key . ": " . $value;
                }
            }
            $aud->detalles = $str . " - " . $str2;
            $aud->save();
            flash("La unidad <strong>" . $unidad->nombre . "</strong> fue modificada de forma exitosa!")->success();
            return redirect()->route('unidad.index');
        } else {
            flash("La unidad <strong>" . $unidad->nombre . "</strong> no pudo ser modificada. Error: " . $result)->error();
            return redirect()->route('unidad.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Unidad  $unidad
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        // if (count($unidad->paginas) > 0 || count($grupo->modulos) > 0 || count($grupo->users) > 0) {
//            flash("El Grupo de usuario <strong>" . $grupo->nombre . "</strong> no pudo ser eliminado porque tiene permisos o usuarios asociados.")->warning();
//            return redirect()->route('grupousuario.index');
//        } else {
        $unidad = Unidad::find($id);
        $result = $unidad->delete();
        if ($result) {
            $aud = new Auditoriaadmision();
            $u = Auth::user();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ELIMINAR";
            $str = "ELIMINACIÓN DE UNIDAD. DATOS ELIMINADOS: ";
            foreach ($unidad->attributesToArray() as $key => $value) {
                if ($key == 'ciudad_id') {
                    $str = $str . ", " . $key . ": " . $value . ", ciudad:" . $unidad->ciudad->nombre;
                } else {
                    $str = $str . ", " . $key . ": " . $value;
                }
            }
            $aud->detalles = $str;
            $aud->save();
            flash("La unidad <strong>" . $unidad->nombre . "</strong> fue eliminada de forma exitosa!")->success();
            return redirect()->route('unidad.index');
        } else {
            flash("La unidad <strong>" . $unidad->nombre . "</strong> no pudo ser eliminada. Error: " . $result)->error();
            return redirect()->route('unidad.index');
        }
//        }
    }

}
