<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ModuloRequest;
use App\Auditoriausuario;
use Illuminate\Support\Facades\Auth;
use App\Modulo;

class ModuloController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $modulos = Modulo::all();
        return view('usuarios.modulos.list')
                        ->with('location', 'usuarios')
                        ->with('modulos', $modulos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('usuarios.modulos.create')
                        ->with('location', 'usuarios');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ModuloRequest $request) {
        $modulo = new Modulo($request->all());
        foreach ($modulo->attributesToArray() as $key => $value) {
            $modulo->$key = strtoupper($value);
        }
        if (mb_stristr($modulo->nombre, "MOD_") === false) {
            flash("El nombre del modulo <strong>" . $modulo->nombre . "</strong> es incorrecto, recuerde que debe tener la estructura MOD_ seguido del nombre que ud desee.")->warning();
            return redirect()->route('modulo.create');
        }
        $u = Auth::user();
        $modulo->user_change = $u->identificacion;
        $result = $modulo->save();
        if ($result) {
            $aud = new Auditoriausuario();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "INSERTAR";
            $str = "CREACIÓN DE MODULO. DATOS: ";
            foreach ($modulo->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("El modulo <strong>" . $modulo->nombre . "</strong> fue almacenado de forma exitosa!")->success();
            return redirect()->route('modulo.index');
        } else {
            flash("El modulo <strong>" . $modulo->nombre . "</strong> no pudo ser almacenado. Error: " . $result)->error();
            return redirect()->route('modulo.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $modulo = Modulo::find($id);
        return view('usuarios.modulos..edit')
                        ->with('location', 'usuarios')
                        ->with('modulo', $modulo);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $modulo = Modulo::find($id);
        $m = new Modulo($modulo->attributesToArray());
        foreach ($modulo->attributesToArray() as $key => $value) {
            if (isset($request->$key)) {
                $modulo->$key = strtoupper($request->$key);
            }
        }
        if (mb_stristr($modulo->nombre, "MOD_") === false) {
            flash("El nombre del modulo <strong>" . $modulo->nombre . "</strong> es incorrecto, recuerde que debe tener la estructura MOD_ seguido del nombre que ud desee.")->warning();
            return redirect()->route('modulo.edit', $modulo->id);
        }
        $u = Auth::user();
        $modulo->user_change = $u->identificacion;
        $result = $modulo->save();
        if ($result) {
            $aud = new Auditoriausuario();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ACTUALIZAR DATOS";
            $str = "EDICION DE MODULO. DATOS NUEVOS: ";
            $str2 = " DATOS ANTIGUOS: ";
            foreach ($m->attributesToArray() as $key => $value) {
                $str2 = $str2 . ", " . $key . ": " . $value;
            }
            foreach ($modulo->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            flash("El modulo <strong>" . $modulo->nombre . "</strong> fue modificado de forma exitosa!")->success();
            return redirect()->route('modulo.index');
        } else {
            flash("El modulo <strong>" . $modulo->nombre . "</strong> no pudo ser modificado. Error: " . $result)->error();
            return redirect()->route('modulo.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //
    }

}
