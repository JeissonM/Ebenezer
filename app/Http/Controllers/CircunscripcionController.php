<?php

namespace App\Http\Controllers;

use App\Circunscripcion;
use Illuminate\Http\Request;
use App\Http\Requests\CircunscripcionRequest;
use Illuminate\Support\Facades\Auth;
use App\Auditoriaadmision;

class CircunscripcionController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $circunscripcion = Circunscripcion::all();
        return view('admisiones.calendario_procesos_convocatoria.circunscripcion.list')
                        ->with('location', 'admisiones')
                        ->with('circunscripcion', $circunscripcion);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('admisiones.calendario_procesos_convocatoria.circunscripcion.create')
                        ->with('location', 'admisiones');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CircunscripcionRequest $request) {
        $circunscripcion = new Circunscripcion($request->all());
        foreach ($circunscripcion->attributesToArray() as $key => $value) {
            $circunscripcion->$key = strtoupper($value);
        }
        $u = Auth::user();
        $circunscripcion->user_change = $u->identificacion;
        $result = $circunscripcion->save();
        if ($result) {
            $aud = new Auditoriaadmision();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "INSERTAR";
            $str = "CREACIÓN DE CIRCUNSCRIPCIÓN. DATOS: ";
            foreach ($circunscripcion->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("La circunscripción <strong>" . $circunscripcion->nombre . "</strong> fue almacenada de forma exitosa!")->success();
            return redirect()->route('circunscripcion.index');
        } else {
            flash("La circunscripción <strong>" . $circunscripcion->nombre . "</strong> no pudo ser almacenada. Error: " . $result)->error();
            return redirect()->route('circunscripción.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Circunscripcion  $circunscripcion
     * @return \Illuminate\Http\Response
     */
    public function show(Circunscripcion $circunscripcion) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Circunscripcion  $circunscripcion
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $circunscripcion = Circunscripcion::find($id);
        return view('admisiones.calendario_procesos_convocatoria.circunscripcion.edit')
                        ->with('location', 'admisiones')
                        ->with('circunscripcion', $circunscripcion);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Circunscripcion  $circunscripcion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $circunscripcion = Circunscripcion::find($id);
        $m = new Circunscripcion($circunscripcion->attributesToArray());
        foreach ($circunscripcion->attributesToArray() as $key => $value) {
            if (isset($request->$key)) {
                $circunscripcion->$key = strtoupper($request->$key);
            }
        }
        $u = Auth::user();
        $circunscripcion->user_change = $u->identificacion;
        $result = $circunscripcion->save();
        if ($result) {
            $aud = new Auditoriaadmision();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ACTUALIZAR DATOS";
            $str = "EDICION DE LAS CIRCUNSCRIPCIONES. DATOS NUEVOS: ";
            $str2 = " DATOS ANTIGUOS: ";
            foreach ($m->attributesToArray() as $key => $value) {
                $str2 = $str2 . ", " . $key . ": " . $value;
            }
            foreach ($circunscripcion->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str . " - " . $str2;
            $aud->save();
            flash("La circunscipcion <strong>" . $circunscripcion->nombre . "</strong> fue modificada de forma exitosa!")->success();
            return redirect()->route('circunscripcion.index');
        } else {
            flash("La circunscripcion <strong>" . $circunscripcion->nombre . "</strong> no pudo ser modificada. Error: " . $result)->error();
            return redirect()->route('circunscripcion.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Circunscripcion  $circunscripcion
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $circunscripcion = Circunscripcion::find($id);
        $result = $circunscripcion->delete();
        if ($result) {
            $aud = new Auditoriaadmision();
            $u = Auth::user();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ELIMINAR";
            $str = "ELIMINACIÓN DE LA CIRCUNSCRIPCIÓN. DATOS ELIMINADOS: ";
            foreach ($circunscripcion->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("La circunscripción <strong>" . $circunscripcion->nombre . "</strong> fue eliminada de forma exitosa!")->success();
            return redirect()->route('circunscripcion.index');
        } else {
            flash("La circunscripción <strong>" . $circunscripcion->nombre . "</strong> no pudo ser eliminada. Error: " . $result)->error();
            return redirect()->route('circunscripcion.index');
        }
    }

}
