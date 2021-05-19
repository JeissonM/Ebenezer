<?php

namespace App\Http\Controllers;

use App\Etnia;
use App\Auditoriaadmision;
use App\Http\Requests\EtniaRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class EtniaController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $etnias = Etnia::all();
        return view('admisiones.datos_generales.etnia.list')
                        ->with('location', 'admisiones')
                        ->with('etnias', $etnias);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('admisiones.datos_generales.etnia.create')
                        ->with('location', 'admisiones');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EtniaRequest $request) {
        $etnia = new Etnia($request->all());
        foreach ($etnia->attributesToArray() as $key => $value) {
            $etnia->$key = strtoupper($value);
        }
        $u = Auth::user();
        $etnia->user_change = $u->identificacion;
        $result = $etnia->save();
        if ($result) {
            $aud = new Auditoriaadmision();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "INSERTAR";
            $str = "CREACIÓN DE ETNIA. DATOS: ";
            foreach ($etnia->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("La Étnia <strong>" . $etnia->nombre . "</strong> fue almacenada de forma exitosa!")->success();
            return redirect()->route('etnia.index');
        } else {
            flash("La Étnia <strong>" . $etnia->nombre . "</strong> no pudo ser almacenada. Error: " . $result)->error();
            return redirect()->route('etnia.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Etnia  $etnia
     * @return \Illuminate\Http\Response
     */
    public function show(Etnia $etnia) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Etnia  $etnia
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $etnia = Etnia::find($id);
        return view('admisiones.datos_generales.etnia.edit')
                        ->with('location', 'admisiones')
                        ->with('etnia', $etnia);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Etnia  $etnia
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $etnia = Etnia::find($id);
        $m = new Etnia($etnia->attributesToArray());
        foreach ($etnia->attributesToArray() as $key => $value) {
            if (isset($request->$key)) {
                $etnia->$key = strtoupper($request->$key);
            }
        }
        $u = Auth::user();
        $etnia->user_change = $u->identificacion;
        $result = $etnia->save();
        if ($result) {
            $aud = new Auditoriaadmision();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ACTUALIZAR DATOS";
            $str = "EDICION DE ETNIA. DATOS NUEVOS: ";
            $str2 = " DATOS ANTIGUOS: ";
            foreach ($m->attributesToArray() as $key => $value) {
                $str2 = $str2 . ", " . $key . ": " . $value;
            }
            foreach ($etnia->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str . " - " . $str2;
            $aud->save();
            flash("La Étnia <strong>" . $etnia->nombre . "</strong> fue modificada de forma exitosa!")->success();
            return redirect()->route('etnia.index');
        } else {
            flash("La Étnia <strong>" . $etnia->nombre . "</strong> no pudo ser modificada. Error: " . $result)->error();
            return redirect()->route('etnia.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Etnia  $etnia
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        // if (count($etnia->paginas) > 0 || count($grupo->modulos) > 0 || count($grupo->users) > 0) {
//            flash("El Grupo de usuario <strong>" . $grupo->nombre . "</strong> no pudo ser eliminado porque tiene permisos o usuarios asociados.")->warning();
//            return redirect()->route('grupousuario.index');
//        } else {
        $etnia = Etnia::find($id);
        $result = $etnia->delete();
        if ($result) {
            $aud = new Auditoriaadmision();
            $u = Auth::user();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ELIMINAR";
            $str = "ELIMINACIÓN DE ETNIA. DATOS ELIMINADOS: ";
            foreach ($etnia->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("La Étnia <strong>" . $etnia->nombre . "</strong> fue eliminada de forma exitosa!")->success();
            return redirect()->route('etnia.index');
        } else {
            flash("La Étnia <strong>" . $etnia->nombre . "</strong> no pudo ser eliminada. Error: " . $result)->error();
            return redirect()->route('etnia.index');
        }
//        }
    }

}
