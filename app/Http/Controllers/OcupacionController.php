<?php

namespace App\Http\Controllers;

use App\Ocupacion;
use App\Auditoriaadmision;
use Illuminate\Http\Request;
use App\Http\Requests\OcupacionRequest;
use Illuminate\Support\Facades\Auth;

class OcupacionController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $ocupaciones = Ocupacion::all();
        return view('admisiones.admision_matricula.ocupacion_laboral.list')
                        ->with('location', 'admisiones')
                        ->with('ocupaciones', $ocupaciones);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('admisiones.admision_matricula.ocupacion_laboral.create')
                        ->with('location', 'admisiones');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OcupacionRequest $request) {
        $ocupacion = new Ocupacion($request->all());
        foreach ($ocupacion->attributesToArray() as $key => $value) {
            $ocupacion->$key = strtoupper($value);
        }
        $u = Auth::user();
        $ocupacion->user_change = $u->identificacion;
        $result = $ocupacion->save();
        if ($result) {
            $aud = new Auditoriaadmision();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "INSERTAR";
            $str = "CREACIÓN DE OCUPACION. DATOS: ";
            foreach ($ocupacion->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("La Ocupación <strong>" . $ocupacion->descripcion . "</strong> fue almacenada de forma exitosa!")->success();
            return redirect()->route('ocupacion.index');
        } else {
            flash("La Ocupación <strong>" . $ocupacion->descripcion . "</strong> no pudo ser almacenada. Error: " . $result)->error();
            return redirect()->route('ocupacion.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Ocupacion  $ocupacion
     * @return \Illuminate\Http\Response
     */
    public function show(Ocupacion $ocupacion) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Ocupacion  $ocupacion
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $ocupacion = Ocupacion::find($id);
        return view('admisiones.admision_matricula.ocupacion_laboral.edit')
                        ->with('location', 'admisiones')
                        ->with('ocupacion', $ocupacion);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Ocupacion  $ocupacion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $ocupacion = Ocupacion::find($id);
        $m = new Ocupacion($ocupacion->attributesToArray());
        foreach ($ocupacion->attributesToArray() as $key => $value) {
            if (isset($request->$key)) {
                $ocupacion->$key = strtoupper($request->$key);
            }
        }
        $u = Auth::user();
        $ocupacion->user_change = $u->identificacion;
        $result = $ocupacion->save();
        if ($result) {
            $aud = new Auditoriaadmision();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ACTUALIZAR DATOS";
            $str = "EDICION DE OCUPACIÓN. DATOS NUEVOS: ";
            $str2 = " DATOS ANTIGUOS: ";
            foreach ($m->attributesToArray() as $key => $value) {
                $str2 = $str2 . ", " . $key . ": " . $value;
            }
            foreach ($ocupacion->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str . " - " . $str2;
            $aud->save();
            flash("La Ocupación <strong>" . $ocupacion->descripcion . "</strong> fue modificada de forma exitosa!")->success();
            return redirect()->route('ocupacion.index');
        } else {
            flash("La Ocupación <strong>" . $ocupacion->descripcion . "</strong> no pudo ser modificada. Error: " . $result)->error();
            return redirect()->route('ocupacion.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Ocupacion  $ocupacion
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        // if (count($ocupacion->paginas) > 0 || count($grupo->modulos) > 0 || count($grupo->users) > 0) {
//            flash("El Grupo de usuario <strong>" . $grupo->nombre . "</strong> no pudo ser eliminado porque tiene permisos o usuarios asociados.")->warning();
//            return redirect()->route('grupousuario.index');
//        } else {
        $ocupacion = Ocupacion::find($id);
        $result = $ocupacion->delete();
        if ($result) {
            $aud = new Auditoriaadmision();
            $u = Auth::user();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ELIMINAR";
            $str = "ELIMINACIÓN DE OCUPACIÓN. DATOS ELIMINADOS: ";
            foreach ($ocupacion->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("La Ocupación <strong>" . $ocupacion->descripcion. "</strong> fue eliminada de forma exitosa!")->success();
            return redirect()->route('ocupacion.index');
        } else {
            flash("La Ocupación <strong>" . $ocupacion->descripcion . "</strong> no pudo ser eliminada. Error: " . $result)->error();
            return redirect()->route('ocupacion.index');
        }
//        }
    }

}
