<?php

namespace App\Http\Controllers;

use App\Grado;
use App\Auditoriaadmision;
use Illuminate\Http\Request;
use App\Http\Requests\GradoRequest;
use Illuminate\Support\Facades\Auth;

class GradoController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $grados = Grado::all();
        return view('admisiones.admision_matricula.grados.list')
                        ->with('location', 'admisiones')
                        ->with('grados', $grados);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('admisiones.admision_matricula.grados.create')
                        ->with('location', 'admisiones');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GradoRequest $request) {
        $grado = new Grado($request->all());
        foreach ($grado->attributesToArray() as $key => $value) {
            $grado->$key = strtoupper($value);
        }
        $u = Auth::user();
        $grado->user_change = $u->identificacion;
        $result = $grado->save();
        if ($result) {
            $aud = new Auditoriaadmision();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "INSERTAR";
            $str = "CREACIÓN DE GRADO ACADÉMICO. DATOS: ";
            foreach ($grado->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("El Grado <strong>" . $grado->etiqueta . "</strong> fue almacenado de forma exitosa!")->success();
            return redirect()->route('gradoacademico.index');
        } else {
            flash("El Grado <strong>" . $grado->etiqueta . "</strong> no pudo ser almacenado. Error: " . $result)->error();
            return redirect()->route('gradoacademico.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Grado  $grado
     * @return \Illuminate\Http\Response
     */
    public function show(Grado $grado) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Grado  $grado
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $grado = Grado::find($id);
        return view('admisiones.admision_matricula.grados.edit')
                        ->with('location', 'admisiones')
                        ->with('grado', $grado);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Grado  $grado
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $grado = Grado::find($id);
        $m = new Grado($grado->attributesToArray());
        foreach ($grado->attributesToArray() as $key => $value) {
            if (isset($request->$key)) {
                $grado->$key = strtoupper($request->$key);
            }
        }
        $u = Auth::user();
        $grado->user_change = $u->identificacion;
        $result = $grado->save();
        if ($result) {
            $aud = new Auditoriaadmision();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ACTUALIZAR DATOS";
            $str = "EDICION DE GRADO. DATOS NUEVOS: ";
            $str2 = " DATOS ANTIGUOS: ";
            foreach ($m->attributesToArray() as $key => $value) {
                $str2 = $str2 . ", " . $key . ": " . $value;
            }
            foreach ($grado->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str . " - " . $str2;
            $aud->save();
            flash("El Grado <strong>" . $grado->etiqueta . "</strong> fue modificado de forma exitosa!")->success();
            return redirect()->route('gradoacademico.index');
        } else {
            flash("El Grado <strong>" . $grado->etiqueta . "</strong> no pudo ser modificado. Error: " . $result)->error();
            return redirect()->route('gradoacademico.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Grado  $grado
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        // if (count($grado->paginas) > 0 || count($grupo->modulos) > 0 || count($grupo->users) > 0) {
//            flash("El Grupo de usuario <strong>" . $grupo->nombre . "</strong> no pudo ser eliminado porque tiene permisos o usuarios asociados.")->warning();
//            return redirect()->route('grupousuario.index');
//        } else {
        $grado = Grado::find($id);
        $result = $grado->delete();
        if ($result) {
            $aud = new Auditoriaadmision();
            $u = Auth::user();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ELIMINAR";
            $str = "ELIMINACIÓN DE GRADO. DATOS ELIMINADOS: ";
            foreach ($grado->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("El Grado <strong>" . $grado->etiqueta . "</strong> fue eliminado de forma exitosa!")->success();
            return redirect()->route('gradoacademico.index');
        } else {
            flash("El Grado <strong>" . $grado->etiqueta . "</strong> no pudo ser eliminado. Error: " . $result)->error();
            return redirect()->route('gradoacademico.index');
        }
//        }
    }

}
