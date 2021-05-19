<?php

namespace App\Http\Controllers;

use App\Tipodoc;
use App\Auditoriaadmision;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\TipodocRequest;
use Illuminate\Http\Request;

class TipodocController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $tipos = Tipodoc::all();
        return view('admisiones.datos_generales.tipodoc.list')
                        ->with('location', 'admisiones')
                        ->with('tipos', $tipos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('admisiones.datos_generales.tipodoc.create')
                        ->with('location', 'admisiones');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TipodocRequest $request) {
        $tipo = new Tipodoc($request->all());
        foreach ($tipo->attributesToArray() as $key => $value) {
            $tipo->$key = strtoupper($value);
        }
        $u = Auth::user();
        $tipo->user_change = $u->identificacion;
        $result = $tipo->save();
        if ($result) {
            $aud = new Auditoriaadmision();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "INSERTAR";
            $str = "CREACIÓN DE TIPO DE DOCUMENTO. DATOS: ";
            foreach ($tipo->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("El Tipo de Documento <strong>" . $tipo->descripcion . "</strong> fue almacenado de forma exitosa!")->success();
            return redirect()->route('tipodoc.index');
        } else {
            flash("El Tipo de Documento <strong>" . $tipo->descripcion . "</strong> no pudo ser almacenado. Error: " . $result)->error();
            return redirect()->route('tipodoc.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Tipodoc  $tipodoc
     * @return \Illuminate\Http\Response
     */
    public function show(Tipodoc $tipodoc) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Tipodoc  $tipodoc
     * @return \Illuminate\Http\Response
     */
    public function edit(Tipodoc $tipodoc) {
        return view('admisiones.datos_generales.tipodoc.edit')
                        ->with('location', 'admisiones')
                        ->with('tipo', $tipodoc);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tipodoc  $tipodoc
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tipodoc $tipodoc) {
        $m = new Tipodoc($tipodoc->attributesToArray());
        foreach ($tipodoc->attributesToArray() as $key => $value) {
            if (isset($request->$key)) {
                $tipodoc->$key = strtoupper($request->$key);
            }
        }
        $u = Auth::user();
        $tipodoc->user_change = $u->identificacion;
        $result = $tipodoc->save();
        if ($result) {
            $aud = new Auditoriaadmision();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ACTUALIZAR DATOS";
            $str = "EDICION DE TIPO DE DOCUMENTO. DATOS NUEVOS: ";
            $str2 = " DATOS ANTIGUOS: ";
            foreach ($m->attributesToArray() as $key => $value) {
                $str2 = $str2 . ", " . $key . ": " . $value;
            }
            foreach ($tipodoc->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str . " - " . $str2;
            $aud->save();
            flash("El Tipo de Documento <strong>" . $tipodoc->descripcion . "</strong> fue modificado de forma exitosa!")->success();
            return redirect()->route('tipodoc.index');
        } else {
            flash("El Tipo de Documento <strong>" . $tipodoc->descripcion . "</strong> no pudo ser modificado. Error: " . $result)->error();
            return redirect()->route('tipodoc.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tipodoc  $tipodoc
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
//        if (count($tipodoc->paginas) > 0 || count($grupo->modulos) > 0 || count($grupo->users) > 0) {
//            flash("El Grupo de usuario <strong>" . $grupo->nombre . "</strong> no pudo ser eliminado porque tiene permisos o usuarios asociados.")->warning();
//            return redirect()->route('grupousuario.index');
//        } else {
        $tipodoc = Tipodoc::find($id);
        $result = $tipodoc->delete();
        if ($result) {
            $aud = new Auditoriaadmision();
            $u = Auth::user();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ELIMINAR";
            $str = "ELIMINACIÓN DE TIPO DE DOCUMENTO. DATOS ELIMINADOS: ";
            foreach ($tipodoc->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("El Tipo de Documento <strong>" . $tipodoc->descripcion . "</strong> fue eliminado de forma exitosa!")->success();
            return redirect()->route('tipodoc.index');
        } else {
            flash("El Tipo de Documento <strong>" . $tipodoc->descripcion . "</strong> no pudo ser eliminado. Error: " . $result)->error();
            return redirect()->route('tipodoc.index');
        }
//        }
    }

}
