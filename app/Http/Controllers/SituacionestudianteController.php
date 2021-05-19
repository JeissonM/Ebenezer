<?php

namespace App\Http\Controllers;

use App\Situacionestudiante;
use Illuminate\Http\Request;
use App\Http\Requests\SituacionestudianteRequest;
use Illuminate\Support\Facades\Auth;
use App\Matriculaauditoria;

class SituacionestudianteController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $situacionestudiante = Situacionestudiante::all();
        return view('matricula.datos_basicos.situacionestudiante.list')
                        ->with('location', 'matricula')
                        ->with('situacionestudiantes', $situacionestudiante);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('matricula.datos_basicos.situacionestudiante.create')
                        ->with('location', 'matricula');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SituacionestudianteRequest $request) {
        $situacionestudiante = new Situacionestudiante($request->all());
        foreach ($situacionestudiante->attributesToArray() as $key => $value) {
            $situacionestudiante->$key = strtoupper($value);
        }
        $u = Auth::user();
        $situacionestudiante->user_change = $u->identificacion;
        $result = $situacionestudiante->save();
        if ($result) {
            $aud = new Matriculaauditoria();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "INSERTAR";
            $str = "CREACIÓN DE LA SITUACIÓN DEL ESTUDIANTE, DATOS:  ";
            foreach ($situacionestudiante->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("La Situación Estudiante <strong>" . $situacionestudiante->nombre . "</strong> fue almacenada de forma exitosa!")->success();
            return redirect()->route('situacionestudiante.index');
        } else {
            flash("La Situación del Estudiante <strong>" . $situacionestudiante->nombre . "</strong> no pudo ser almacenada. Error: " . $result)->error();
            return redirect()->route('situacionestudiante.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Situacionestudiante  $situacionestudiante
     * @return \Illuminate\Http\Response
     */
    public function show(Situacionestudiante $situacionestudiante) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Situacionestudiante  $situacionestudiante
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $situacionestudiante = Situacionestudiante::find($id);
        return view('matricula.datos_basicos.situacionestudiante.edit')
                        ->with('location', 'matricula')
                        ->with('se', $situacionestudiante);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Situacionestudiante  $situacionestudiante
     * @return \Illuminate\Http\Response
     */
    public function update(SituacionestudianteRequest $request, Situacionestudiante $situacionestudiante) {
        $m = new Situacionestudiante($situacionestudiante->attributesToArray());
        foreach ($situacionestudiante->attributesToArray() as $key => $value) {
            if (isset($request->$key)) {
                $situacionestudiante->$key = strtoupper($request->$key);
            }
        }
        $u = Auth::user();
        $situacionestudiante->user_change = $u->identificacion;
        $result = $situacionestudiante->save();
        if ($result) {
            $aud = new Matriculaauditoria();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ACTUALIZAR DATOS";
            $str = "EDICION DE LA SITUACIÓN ESTUDIANTE. DATOS NUEVOS: ";
            $str2 = " DATOS ANTIGUOS: ";
            foreach ($m->attributesToArray() as $key => $value) {
                $str2 = $str2 . ", " . $key . ": " . $value;
            }
            foreach ($situacionestudiante->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str . " - " . $str2;
            $aud->save();
            flash("La Situación del Estudiante <strong>" . $situacionestudiante->nombre . "</strong> fue modificada de forma exitosa!")->success();
            return redirect()->route('situacionestudiante.index');
        } else {
            flash("La Situación del Estudiante <strong>" . $situacionestudiante->nombre . "</strong> no pudo ser modificada. Error: " . $result)->error();
            return redirect()->route('situacionestudiante.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Situacionestudiante  $situacionestudiante
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //        if (count($tipodoc->paginas) > 0 || count($grupo->modulos) > 0 || count($grupo->users) > 0) {
//            flash("El Grupo de usuario <strong>" . $grupo->nombre . "</strong> no pudo ser eliminado porque tiene permisos o usuarios asociados.")->warning();
//            return redirect()->route('grupousuario.index');
//        } else {
        $situacionestudiante = Situacionestudiante::find($id);
        $result = $situacionestudiante->delete();
        if ($result) {
            $aud = new Matriculaauditoria();
            $u = Auth::user();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ELIMINAR";
            $str = "ELIMINACIÓN DE LA SITUACIÓN DEL ESTUDIANTE. DATOS ELIMINADOS: ";
            foreach ($situacionestudiante->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("La Situación del Estudiante <strong>" . $situacionestudiante->nombre . "</strong> fue eliminada de forma exitosa!")->success();
            return redirect()->route('situacionestudiante.index');
        } else {
            flash("La Situación del Estudiante <strong>" . $situacionestudiante->nombre . "</strong> no pudo ser eliminada. Error: " . $result)->error();
            return redirect()->route('situacionestudiante.index');
        }
//        }
    }

}
