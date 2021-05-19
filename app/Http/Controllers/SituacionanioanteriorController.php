<?php

namespace App\Http\Controllers;

use App\Situacionanioanterior;
use App\Auditoriaadmision;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class SituacionanioanteriorController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $situaciones = Situacionanioanterior::all();
        return view('admisiones.admision_matricula.situacion_anio_anterior.list')
                        ->with('location', 'admisiones')
                        ->with('situaciones', $situaciones);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('admisiones.admision_matricula.situacion_anio_anterior.create')
                        ->with('location', 'admisiones');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $situacion = new Situacionanioanterior($request->all());
        foreach ($situacion->attributesToArray() as $key => $value) {
            $situacion->$key = strtoupper($value);
        }
        $u = Auth::user();
        $situacion->user_change = $u->identificacion;
        $result = $situacion->save();
        if ($result) {
            $aud = new Auditoriaadmision();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "INSERTAR";
            $str = "CREACIÓN DE SITUACIÓN DEL AÑO ANTERIOR. DATOS: ";
            foreach ($situacion->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("La situación <strong>" . $situacion->etiqueta . "</strong> fue almacenada de forma exitosa!")->success();
            return redirect()->route('situacionanterior.index');
        } else {
            flash("La situación <strong>" . $situacion->etiqueta . "</strong> no pudo ser almacenada. Error: " . $result)->error();
            return redirect()->route('situacionanterior.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Situacionanioanterior  $situacionanioanterior
     * @return \Illuminate\Http\Response
     */
    public function show(Situacionanioanterior $situacionanioanterior) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Situacionanioanterior  $situacionanioanterior
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $situacion = Situacionanioanterior::find($id);
        return view('admisiones.admision_matricula.situacion_anio_anterior.edit')
                        ->with('location', 'admisiones')
                        ->with('situacion', $situacion);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Situacionanioanterior  $situacionanioanterior
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $situacion = Situacionanioanterior::find($id);
        $m = new Situacionanioanterior($situacion->attributesToArray());
        foreach ($situacion->attributesToArray() as $key => $value) {
            if (isset($request->$key)) {
                $situacion->$key = strtoupper($request->$key);
            }
        }
        $u = Auth::user();
        $situacion->user_change = $u->identificacion;
        $result = $situacion->save();
        if ($result) {
            $aud = new Auditoriaadmision();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ACTUALIZAR DATOS";
            $str = "EDICION DE SITUACIÓN DEL AÑO ANTERIOR. DATOS NUEVOS: ";
            $str2 = " DATOS ANTIGUOS: ";
            foreach ($m->attributesToArray() as $key => $value) {
                $str2 = $str2 . ", " . $key . ": " . $value;
            }
            foreach ($situacion->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str . " - " . $str2;
            $aud->save();
            flash("La situación <strong>" . $situacion->etiqueta . "</strong> fue modificada de forma exitosa!")->success();
            return redirect()->route('situacionanterior.index');
        } else {
            flash("La situación <strong>" . $situacion->etiqueta . "</strong> no pudo ser modificada. Error: " . $result)->error();
            return redirect()->route('situacionanterior.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Situacionanioanterior  $situacionanioanterior
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        // if (count($situacion->paginas) > 0 || count($grupo->modulos) > 0 || count($grupo->users) > 0) {
//            flash("El Grupo de usuario <strong>" . $grupo->nombre . "</strong> no pudo ser eliminado porque tiene permisos o usuarios asociados.")->warning();
//            return redirect()->route('grupousuario.index');
//        } else {
        $situacion = Situacionanioanterior::find($id);
        $result = $situacion->delete();
        if ($result) {
            $aud = new Auditoriaadmision();
            $u = Auth::user();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ELIMINAR";
            $str = "ELIMINACIÓN DE SITUACIÓN DEL AÑO ANTERIOR. DATOS ELIMINADOS: ";
            foreach ($situacion->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("La situación <strong>" . $situacion->etiqueta . "</strong> fue eliminada de forma exitosa!")->success();
            return redirect()->route('situacionanterior.index');
        } else {
            flash("La situación <strong>" . $situacion->etiqueta . "</strong> no pudo ser eliminada. Error: " . $result)->error();
            return redirect()->route('situacionanterior.index');
        }
//        }
    }

}
