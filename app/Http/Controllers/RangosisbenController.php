<?php

namespace App\Http\Controllers;

use App\Rangosisben;
use App\Auditoriaadmision;
use Illuminate\Http\Request;
use App\Http\Requests\RangosisbenRequest;
use Illuminate\Support\Facades\Auth;

class RangosisbenController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $rangos = Rangosisben::all();
        return view('admisiones.admision_matricula.rango_sisben.list')
                        ->with('location', 'admisiones')
                        ->with('rangos', $rangos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('admisiones.admision_matricula.rango_sisben.create')
                        ->with('location', 'admisiones');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RangosisbenRequest $request) {
        $rango = new Rangosisben($request->all());
        foreach ($rango->attributesToArray() as $key => $value) {
            $rango->$key = strtoupper($value);
        }
        $u = Auth::user();
        $rango->user_change = $u->identificacion;
        $result = $rango->save();
        if ($result) {
            $aud = new Auditoriaadmision();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "INSERTAR";
            $str = "CREACIÓN DE RANGO DE SISBEN. DATOS: ";
            foreach ($rango->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("El rango del sisben <strong>" . $rango->etiqueta . "</strong> fue almacenado de forma exitosa!")->success();
            return redirect()->route('rangosisben.index');
        } else {
            flash("El rango del sisben <strong>" . $rango->etiqueta . "</strong> no pudo ser almacenado. Error: " . $result)->error();
            return redirect()->route('rangosisben.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Rangosisben  $rangosisben
     * @return \Illuminate\Http\Response
     */
    public function show(Rangosisben $rangosisben) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Rangosisben  $rangosisben
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $rango = Rangosisben::find($id);
        return view('admisiones.admision_matricula.rango_sisben.edit')
                        ->with('location', 'admisiones')
                        ->with('rango', $rango);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Rangosisben  $rangosisben
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $rango = Rangosisben::find($id);
        $m = new Rangosisben($rango->attributesToArray());
        foreach ($rango->attributesToArray() as $key => $value) {
            if (isset($request->$key)) {
                $rango->$key = strtoupper($request->$key);
            }
        }
        $u = Auth::user();
        $rango->user_change = $u->identificacion;
        $result = $rango->save();
        if ($result) {
            $aud = new Auditoriaadmision();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ACTUALIZAR DATOS";
            $str = "EDICION DE RANGO DE SISBEN. DATOS NUEVOS: ";
            $str2 = " DATOS ANTIGUOS: ";
            foreach ($m->attributesToArray() as $key => $value) {
                $str2 = $str2 . ", " . $key . ": " . $value;
            }
            foreach ($rango->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str . " - " . $str2;
            $aud->save();
            flash("El rango del sisben <strong>" . $rango->etiqueta . "</strong> fue modificado de forma exitosa!")->success();
            return redirect()->route('rangosisben.index');
        } else {
            flash("El rango del sisben <strong>" . $rango->etiqueta . "</strong> no pudo ser modificado. Error: " . $result)->error();
            return redirect()->route('rangosisben.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Rangosisben  $rangosisben
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        // if (count($rango->paginas) > 0 || count($grupo->modulos) > 0 || count($grupo->users) > 0) {
//            flash("El Grupo de usuario <strong>" . $grupo->nombre . "</strong> no pudo ser eliminado porque tiene permisos o usuarios asociados.")->warning();
//            return redirect()->route('grupousuario.index');
//        } else {
        $rango = Rangosisben::find($id);
        $result = $rango->delete();
        if ($result) {
            $aud = new Auditoriaadmision();
            $u = Auth::user();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ELIMINAR";
            $str = "ELIMINACIÓN DE RANGO DE SISBEN. DATOS ELIMINADOS: ";
            foreach ($rango->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("EL rango de sisben <strong>" . $rango->etiqueta . "</strong> fue eliminado de forma exitosa!")->success();
            return redirect()->route('rangosisben.index');
        } else {
            flash("EL rango de sisben <strong>" . $rango->etiqueta . "</strong> no pudo ser eliminado. Error: " . $result)->error();
            return redirect()->route('rangosisben.index');
        }
//        }
    }

}
