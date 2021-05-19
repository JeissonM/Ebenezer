<?php

namespace App\Http\Controllers;

use App\Estrato;
use App\Auditoriaadmision;
use App\Http\Requests\EstratoRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class EstratoController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $estratos = Estrato::all();
        return view('admisiones.datos_generales.estrato.list')
                        ->with('location', 'admisiones')
                        ->with('estratos', $estratos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('admisiones.datos_generales.estrato.create')
                        ->with('location', 'admisiones');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EstratoRequest $request) {
        $estrato = new Estrato($request->all());
        foreach ($estrato->attributesToArray() as $key => $value) {
            $estrato->$key = strtoupper($value);
        }
        $u = Auth::user();
        $estrato->user_change = $u->identificacion;
        $result = $estrato->save();
        if ($result) {
            $aud = new Auditoriaadmision();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "INSERTAR";
            $str = "CREACIÓN DE NIVEL SOCIOECONOMICO. DATOS: ";
            foreach ($estrato->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("El Nivel Socieconomico <strong>" . $estrato->etiqueta . "</strong> fue almacenado de forma exitosa!")->success();
            return redirect()->route('estrato.index');
        } else {
            flash("El Nivel Socieconomico <strong>" . $estrato->etiqueta . "</strong> no pudo ser almacenado. Error: " . $result)->error();
            return redirect()->route('estrato.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Estrato  $estrato
     * @return \Illuminate\Http\Response
     */
    public function show(Estrato $estrato) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Estrato  $estrato
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $estrato = Estrato::find($id);
        return view('admisiones.datos_generales.estrato.edit')
                        ->with('location', 'admisiones')
                        ->with('estrato', $estrato);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Estrato  $estrato
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $estrato = Estrato::find($id);
        $m = new Estrato($estrato->attributesToArray());
        foreach ($estrato->attributesToArray() as $key => $value) {
            if (isset($request->$key)) {
                $estrato->$key = strtoupper($request->$key);
            }
        }
        $u = Auth::user();
        $estrato->user_change = $u->identificacion;
        $result = $estrato->save();
        if ($result) {
            $aud = new Auditoriaadmision();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ACTUALIZAR DATOS";
            $str = "EDICION DE NIVEL SOCIOECONOMICO. DATOS NUEVOS: ";
            $str2 = " DATOS ANTIGUOS: ";
            foreach ($m->attributesToArray() as $key => $value) {
                $str2 = $str2 . ", " . $key . ": " . $value;
            }
            foreach ($estrato->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str . " - " . $str2;
            $aud->save();
            flash("El Nivel Socioeconomico <strong>" . $estrato->etiqueta . "</strong> fue modificado de forma exitosa!")->success();
            return redirect()->route('estrato.index');
        } else {
            flash("El Nivel Socioeconomico <strong>" . $estrato->etiqueta . "</strong> no pudo ser modificado. Error: " . $result)->error();
            return redirect()->route('estrato.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Estrato  $estrato
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        // if (count($estrato->paginas) > 0 || count($grupo->modulos) > 0 || count($grupo->users) > 0) {
//            flash("El Grupo de usuario <strong>" . $grupo->nombre . "</strong> no pudo ser eliminado porque tiene permisos o usuarios asociados.")->warning();
//            return redirect()->route('grupousuario.index');
//        } else {
        $estrato = Estrato::find($id);
        $result = $estrato->delete();
        if ($result) {
            $aud = new Auditoriaadmision();
            $u = Auth::user();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ELIMINAR";
            $str = "ELIMINACIÓN DE NIVEL SOCIOECONOMICO. DATOS ELIMINADOS: ";
            foreach ($estrato->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("El Nivel Socioeconomico <strong>" . $estrato->etiqueta . "</strong> fue eliminado de forma exitosa!")->success();
            return redirect()->route('estrato.index');
        } else {
            flash("El Nivel Socieconomico <strong>" . $estrato->etiqueta . "</strong> no pudo ser eliminado. Error: " . $result)->error();
            return redirect()->route('estrato.index');
        }
//        }
    }

}
