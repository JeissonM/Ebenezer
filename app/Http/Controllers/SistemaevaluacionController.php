<?php

namespace App\Http\Controllers;

use App\Auditoriaacademico;
use App\Sistemaevaluacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SistemaevaluacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sistemas = Sistemaevaluacion::all();
        return view('academico.registro_academico.sistema_evaluacion.list')
            ->with('location', 'academico')
            ->with('sistemas', $sistemas);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('academico.registro_academico.sistema_evaluacion.create')
            ->with('location', 'academico');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->estado == 'ACTUAL') {
            $existe = Sistemaevaluacion::where('estado', 'ACTUAL')->first();
            if ($existe != null) {
                flash("El Sistema de evaluación <strong>" . $existe->nombre . "</strong> es el ACTUAL, cambie su estado pera poder agregar otro sistema como el ACTUAL.!")->warning();
                return redirect()->route('sistemaevaluacion.index');
            }
        }
        $sistema = new Sistemaevaluacion($request->all());
        foreach ($sistema->attributesToArray() as $key => $value) {
            $sistema->$key = strtoupper($value);
        }
        $u = Auth::user();
        $sistema->user_change = $u->identificacion;
        $result = $sistema->save();
        if ($result) {
            $aud = new Auditoriaacademico();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "INSERTAR";
            $str = "CREACIÓN DE SISTEMA DE EVALUACIÓN. DATOS: ";
            foreach ($sistema->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("El Sistema de evaluación <strong>" . $sistema->nombre . "</strong> fue almacenado de forma exitosa!")->success();
            return redirect()->route('sistemaevaluacion.index');
        } else {
            flash("El Sistema de evaluación <strong>" . $sistema->nombre . "</strong> no pudo ser almacenado. Error: " . $result)->error();
            return redirect()->route('sistemaevaluacion.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $sistema = Sistemaevaluacion::find($id);
        return view('academico.registro_academico.sistema_evaluacion.edit')
            ->with('location', 'academico')
            ->with('sistema', $sistema);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if ($request->estado == 'ACTUAL') {
            $existe = Sistemaevaluacion::where('estado', 'ACTUAL')->first();
            if ($existe != null) {
                flash("El Sistema de evaluación <strong>" . $existe->nombre . "</strong> es el ACTUAL, cambie su estado pera poder agregar otro sistema como el ACTUAL.!")->warning();
                return redirect()->route('sistemaevaluacion.index');
            }
        }
        $sistema = Sistemaevaluacion::find($id);
        $m = new Sistemaevaluacion($sistema->attributesToArray());
        foreach ($sistema->attributesToArray() as $key => $value) {
            if (isset($request->$key)) {
                $sistema->$key = strtoupper($request->$key);
            }
        }
        $u = Auth::user();
        $sistema->user_change = $u->identificacion;
        $result = $sistema->save();
        if ($result) {
            $aud = new Auditoriaacademico();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ACTUALIZAR DATOS";
            $str = "EDICION DE SISTEMAS DE EVALUACIÓN. DATOS NUEVOS: ";
            $str2 = " DATOS ANTIGUOS: ";
            foreach ($m->attributesToArray() as $key => $value) {
                $str2 = $str2 . ", " . $key . ": " . $value;
            }
            foreach ($sistema->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str . " - " . $str2;
            $aud->save();
            flash("El Sistema de evaluación <strong>" . $sistema->nombre . "</strong> fue modificado de forma exitosa!")->success();
            return redirect()->route('sistemaevaluacion.index');
        } else {
            flash("El Sistema de evaluación <strong>" . $sistema->nombre . "</strong> no pudo ser modificado. Error: " . $result)->error();
            return redirect()->route('sistemaevaluacion.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sistema = Sistemaevaluacion::find($id);
        if (count($sistema->evaluacionacademicas) > 0) {
            flash("El Sistema de evaluación <strong>" . $sistema->nombre . "</strong> no pudo ser eliminado porque tiene Evaluación Académica asociadas.")->warning();
            return redirect()->route('sistemaevaluacion.index');
        } else {
            $result = $sistema->delete();
            if ($result) {
                $aud = new Auditoriaacademico();
                $u = Auth::user();
                $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
                $aud->operacion = "ELIMINAR";
                $str = "ELIMINACIÓN DE SISTEMA DE EVALUACIÓN. DATOS ELIMINADOS: ";
                foreach ($sistema->attributesToArray() as $key => $value) {
                    $str = $str . ", " . $key . ": " . $value;
                }
                $aud->detalles = $str;
                $aud->save();
                flash("El Sistema de evauación <strong>" . $sistema->nombre . "</strong> fue eliminado de forma exitosa!")->success();
                return redirect()->route('sistemaevaluacion.index');
            } else {
                flash("El Sistema de evauación <strong>" . $sistema->nombre . "</strong> no pudo ser eliminado. Error: " . $result)->error();
                return redirect()->route('sistemaevaluacion.index');
            }
        }
    }
}
