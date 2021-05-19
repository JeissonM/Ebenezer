<?php

namespace App\Http\Controllers;

use App\Entidadsalud;
use App\Auditoriaadmision;
use App\Http\Requests\EntidadsaludRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class EntidadsaludController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $salud = Entidadsalud::all();
        return view('admisiones.datos_generales.entidad_salud.list')
                        ->with('location', 'admisiones')
                        ->with('salud', $salud);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('admisiones.datos_generales.entidad_salud.create')
                        ->with('location', 'admisiones');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EntidadsaludRequest $request) {
        $entidad = new Entidadsalud($request->all());
        foreach ($entidad->attributesToArray() as $key => $value) {
            $entidad->$key = strtoupper($value);
        }
        $u = Auth::user();
        $entidad->user_change = $u->identificacion;
        $result = $entidad->save();
        if ($result) {
            $aud = new Auditoriaadmision();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "INSERTAR";
            $str = "CREACIÓN DE ENTIDAD DE SALUD. DATOS: ";
            foreach ($entidad->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("La Entidad de Salud <strong>" . $entidad->nombre . "</strong> fue almacenada de forma exitosa!")->success();
            return redirect()->route('entidadsalud.index');
        } else {
            flash("La Entidad de Salud <strong>" . $entidad->nombre . "</strong> no pudo ser almacenada. Error: " . $result)->error();
            return redirect()->route('entidadsalud.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Entidadsalud  $entidadsalud
     * @return \Illuminate\Http\Response
     */
    public function show(Entidadsalud $entidadsalud) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Entidadsalud  $entidadsalud
     * @return \Illuminate\Http\Response
     */
    public function edit(Entidadsalud $entidadsalud) {
        return view('admisiones.datos_generales.entidad_salud.edit')
                        ->with('location', 'admisiones')
                        ->with('salud', $entidadsalud);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Entidadsalud  $entidadsalud
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Entidadsalud $entidadsalud) {
        $m = new Entidadsalud($entidadsalud->attributesToArray());
        foreach ($entidadsalud->attributesToArray() as $key => $value) {
            if (isset($request->$key)) {
                $entidadsalud->$key = strtoupper($request->$key);
            }
        }
        $u = Auth::user();
        $entidadsalud->user_change = $u->identificacion;
        $result = $entidadsalud->save();
        if ($result) {
            $aud = new Auditoriaadmision();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ACTUALIZAR DATOS";
            $str = "EDICION DE ENTIDAD DE SALUD. DATOS NUEVOS: ";
            $str2 = " DATOS ANTIGUOS: ";
            foreach ($m->attributesToArray() as $key => $value) {
                $str2 = $str2 . ", " . $key . ": " . $value;
            }
            foreach ($entidadsalud->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str . " - " . $str2;
            $aud->save();
            flash("La Entidad de Salud <strong>" . $entidadsalud->nombre. "</strong> fue modificada de forma exitosa!")->success();
            return redirect()->route('entidadsalud.index');
        } else {
            flash("La Entidad de Salud <strong>" . $entidadsalud->nombre. "</strong> no pudo ser modificada. Error: " . $result)->error();
            return redirect()->route('entidadsalud.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Entidadsalud  $entidadsalud
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        // if (count($entidadsalud->paginas) > 0 || count($grupo->modulos) > 0 || count($grupo->users) > 0) {
//            flash("El Grupo de usuario <strong>" . $grupo->nombre . "</strong> no pudo ser eliminado porque tiene permisos o usuarios asociados.")->warning();
//            return redirect()->route('grupousuario.index');
//        } else {
        $entidadsalud = Entidadsalud::find($id);
        $result = $entidadsalud->delete();
        if ($result) {
            $aud = new Auditoriaadmision();
            $u = Auth::user();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ELIMINAR";
            $str = "ELIMINACIÓN DE ENTIDAD DE SALUD. DATOS ELIMINADOS: ";
            foreach ($entidadsalud->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("La Entidad de Salud <strong>" . $entidadsalud->nombre. "</strong> fue eliminada de forma exitosa!")->success();
            return redirect()->route('entidadsalud.index');
        } else {
            flash("La Entidad de Salud <strong>" . $entidadsalud->nombre. "</strong> no pudo ser eliminada. Error: " . $result)->error();
            return redirect()->route('entidadsalud.index');
        }
//        }
    }

}
