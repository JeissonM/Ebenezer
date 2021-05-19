<?php

namespace App\Http\Controllers;

use App\Sexo;
use App\Auditoriaadmision;
use App\Http\Requests\SexoRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class SexoController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $sexos = Sexo::all();
        return view('admisiones.datos_generales.sexo.list')
                        ->with('location', 'admisiones')
                        ->with('sexos', $sexos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('admisiones.datos_generales.sexo.create')
                        ->with('location', 'admisiones');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SexoRequest $request) {
        $sexo = new Sexo($request->all());
        foreach ($sexo->attributesToArray() as $key => $value) {
            $sexo->$key = strtoupper($value);
        }
        $u = Auth::user();
        $sexo->user_change = $u->identificacion;
        $result = $sexo->save();
        if ($result) {
            $aud = new Auditoriaadmision();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "INSERTAR";
            $str = "CREACIÓN DE SEXO. DATOS: ";
            foreach ($sexo->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("El Sexo <strong>" . $sexo->descripcion . "</strong> fue almacenado de forma exitosa!")->success();
            return redirect()->route('sexo.index');
        } else {
            flash("El Sexo <strong>" . $sexo->descripcion . "</strong> no pudo ser almacenado. Error: " . $result)->error();
            return redirect()->route('sexo.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Sexo  $sexo
     * @return \Illuminate\Http\Response
     */
    public function show(Sexo $sexo) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Sexo  $sexo
     * @return \Illuminate\Http\Response
     */
    public function edit(Sexo $sexo) {
        return view('admisiones.datos_generales.sexo.edit')
                        ->with('location', 'admisiones')
                        ->with('sexo', $sexo);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Sexo  $sexo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sexo $sexo) {
        $m = new Sexo($sexo->attributesToArray());
        foreach ($sexo->attributesToArray() as $key => $value) {
            if (isset($request->$key)) {
                $sexo->$key = strtoupper($request->$key);
            }
        }
        $u = Auth::user();
        $sexo->user_change = $u->identificacion;
        $result = $sexo->save();
        if ($result) {
            $aud = new Auditoriaadmision();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ACTUALIZAR DATOS";
            $str = "EDICION DE SEXO. DATOS NUEVOS: ";
            $str2 = " DATOS ANTIGUOS: ";
            foreach ($m->attributesToArray() as $key => $value) {
                $str2 = $str2 . ", " . $key . ": " . $value;
            }
            foreach ($sexo->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str . " - " . $str2;
            $aud->save();
            flash("El Sexo <strong>" . $sexo->nombre . "</strong> fue modificado de forma exitosa!")->success();
            return redirect()->route('sexo.index');
        } else {
            flash("El Sexo <strong>" . $sexo->nombre . "</strong> no pudo ser modificado. Error: " . $result)->error();
            return redirect()->route('sexo.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Sexo  $sexo
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //        if (count($tipodoc->paginas) > 0 || count($grupo->modulos) > 0 || count($grupo->users) > 0) {
//            flash("El Grupo de usuario <strong>" . $grupo->nombre . "</strong> no pudo ser eliminado porque tiene permisos o usuarios asociados.")->warning();
//            return redirect()->route('grupousuario.index');
//        } else {
        $sexo = Sexo::find($id);
        $result = $sexo->delete();
        if ($result) {
                $aud = new Auditoriaadmision();
                $u = Auth::user();
                $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
                $aud->operacion = "ELIMINAR";
                $str = "ELIMINACIÓN DE SEXO. DATOS ELIMINADOS: ";
                foreach ($sexo->attributesToArray() as $key => $value) {
                    $str = $str . ", " . $key . ": " . $value;
                }
                $aud->detalles = $str;
                $aud->save();
            flash("El Sexo <strong>" . $sexo->descripcion . "</strong> fue eliminado de forma exitosa!")->success();
            return redirect()->route('sexo.index');
        } else {
            flash("El Sexo <strong>" . $sexo->descripcion . "</strong> no pudo ser eliminado. Error: " . $result)->error();
            return redirect()->route('sexo.index');
        }
//        }
    }

}
