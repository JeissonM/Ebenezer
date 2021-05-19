<?php

namespace App\Http\Controllers;

use App\Auditoriaacademico;
use App\Estudiante;
use App\Sancion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SancionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $estudiantes = Estudiante::all();
        return view('academico.registro_academico.sanciones.list')
            ->with('location', 'academico')
            ->with('estudiantes', $estudiantes);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($estudiante_id)
    {
        $a = Estudiante::find($estudiante_id);
        $pn = $a->personanatural;
        return view('academico.registro_academico.sanciones.create')
            ->with('location', 'academico')
            ->with('a', $a)
            ->with('pn', $pn);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $sancion = new Sancion($request->all());
        foreach ($sancion->attributesToArray() as $key => $value) {
            $sancion->$key = strtoupper($value);
        }
        $u = Auth::user();
        $sancion->user_change = $u->identificacion;
        $result = $sancion->save();
        if ($result) {
            $aud = new Auditoriaacademico();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "INSERTAR";
            $str = "CREACIÓN DE SANCION. DATOS: ";
            foreach ($sancion->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("La sanción fue almacenada de forma exitosa!")->success();
            return redirect()->route('sancion.show', $request->estudiante_id);
        } else {
            flash("La sanción no pudo ser almacenada de forma exitosa!. Erro:" . $result)->error();
            return redirect()->route('sancion.show', $request->estudiante_id);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Sancion $sancion
     * @return \Illuminate\Http\Response
     */
    public function show($estudiante_id)
    {
        $a = Estudiante::find($estudiante_id);
        $pn = $a->personanatural;
        $sanciones = $a->sancions;
        return view('academico.registro_academico.sanciones.show')
            ->with('location', 'academico')
            ->with('a', $a)
            ->with('pn', $pn)
            ->with('sanciones', $sanciones);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Sancion $sancion
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $sancion = Sancion::find($id);
        $a = Estudiante::find($sancion->estudiante_id);
        $pn = $a->personanatural;
        return view('academico.registro_academico.sanciones.edit')
            ->with('location', 'academcio')
            ->with('sancion', $sancion)
            ->with('a', $a)
            ->with('pn', $pn);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Sancion $sancion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $sancion = Sancion::find($id);
        $m = new Sancion($sancion->attributesToArray());
        foreach ($sancion->attributesToArray() as $key => $value) {
            if (isset($request->$key)) {
                $sancion->$key = strtoupper($request->$key);
            }
        }
        $u = Auth::user();
        $sancion->user_change = $u->identificacion;
        $result = $sancion->save();
        if ($result) {
            $aud = new Auditoriaacademico();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ACTUALIZAR DATOS";
            $str = "EDICION DE SANCIÓN. DATOS NUEVOS: ";
            $str2 = " DATOS ANTIGUOS: ";
            foreach ($m->attributesToArray() as $key => $value) {
                $str2 = $str2 . ", " . $key . ": " . $value;
            }
            foreach ($sancion->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str . " - " . $str2;
            $aud->save();
            flash("La sanción fue modificada de forma exitosa!")->success();
            return redirect()->route('sancion.show', $sancion->estudiante_id);
        } else {
            flash("La sanción no pudo ser modificada. Error: " . $result)->error();
            return redirect()->route('sancion.show', $request->estudiante_id);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Sancion $sancion
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sancion = Sancion::find($id);
        $result = $sancion->delete();
        if ($result) {
            $aud = new Auditoriaacademico();
            $u = Auth::user();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ELIMINAR";
            $str = "ELIMINACIÓN DE SANCIÓN. DATOS ELIMINADOS: ";
            foreach ($sancion->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("La sación fue eliminada de forma exitosa!")->success();
            return redirect()->route('sancion.show', $sancion->estudiante_id);
        } else {
            flash("La sanción no pudo ser eliminada. Error: " . $result)->error();
            return redirect()->route('sancion.show', $sancion->estudiante_id);
        }
    }
}
