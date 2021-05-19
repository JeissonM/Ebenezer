<?php

namespace App\Http\Controllers;

use App\Auditoriaacademico;
use App\Requisitogrado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RequisitogradoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $requisitos = Requisitogrado::all();
        return view('academico.registro_academico.grados.requisitos.list')
            ->with('location', 'academico')
            ->with('requisitos', $requisitos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('academico.registro_academico.grados.requisitos.create')
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
        $requisito = new Requisitogrado($request->all());
        foreach ($requisito->attributesToArray() as $key => $value) {
            $requisito->$key = strtoupper($value);
        }
        $u = Auth::user();
            $requisito->user_change = $u->identificacion;
            $result = $requisito->save();
            if ($result) {
                $aud = new Auditoriaacademico();
                $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
                $aud->operacion = "INSERTAR";
                $str = "CREACIÓN DE REQUISITO DE GRADO. DATOS: ";
                foreach ($requisito->attributesToArray() as $key => $value) {
                    $str = $str . ", " . $key . ": " . $value;
                }
                $aud->detalles = $str;
                $aud->save();
                flash("El Requisito <strong>" . $requisito->descripcion . "</strong> fue almacenado de forma exitosa!")->success();
                return redirect()->route('requisitogrado.index');
            } else {
            flash("El Requisito <strong>" . $requisito->descripcion . "</strong> no pudo ser almacenado. Error: " . $result)->error();
            return redirect()->route('requisitogrado.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Requisitogrado $requisitogrado
     * @return \Illuminate\Http\Response
     */
    public function show(Requisitogrado $requisitogrado)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Requisitogrado $requisitogrado
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $requisito = Requisitogrado::find($id);
        return view('academico.registro_academico.grados.requisitos.edit')
            ->with('location', 'academico')
            ->with('requisito', $requisito);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Requisitogrado $requisitogrado
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $requisito = Requisitogrado::find($id);
        $m = new Requisitogrado($requisito->attributesToArray());
        foreach ($requisito->attributesToArray() as $key => $value) {
            if (isset($request->$key)) {
                $requisito->$key = strtoupper($request->$key);
            }
        }
        $u = Auth::user();
        $requisito->user_change = $u->identificacion;
        $result = $requisito->save();
        if ($result) {
            $aud = new Auditoriaacademico();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ACTUALIZAR DATOS";
            $str = "EDICION DE REQUISITO DE GRADO. DATOS NUEVOS: ";
            $str2 = " DATOS ANTIGUOS: ";
            foreach ($m->attributesToArray() as $key => $value) {
                $str2 = $str2 . ", " . $key . ": " . $value;
            }
            foreach ($requisito->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str . " - " . $str2;
            $aud->save();
            flash("El Requisito <strong>" . $requisito->descripcion . "</strong> fue modificado de forma exitosa!")->success();
            return redirect()->route('requisitogrado.index');
        } else {
            flash("El Requisito <strong>" . $requisito->descripcion . "</strong> no pudo ser modificado. Error: " . $result)->error();
            return redirect()->route('requisitogrado.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Requisitogrado $requisitogrado
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $requisito = Requisitogrado::find($id);
        if (count($requisito->requisitogrados) > 0) {
            flash("El Requsito <strong>" . $requisito->descripcion . "</strong> no pudo ser eliminado porque tiene grados asociados.")->warning();
            return redirect()->route('sistemaevaluacion.index');
        } else {
            $result = $requisito->delete();
            if ($result) {
                $aud = new Auditoriaacademico();
                $u = Auth::user();
                $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
                $aud->operacion = "ELIMINAR";
                $str = "ELIMINACIÓN DE REQUISITO DE GRADO. DATOS ELIMINADOS: ";
                foreach ($requisito->attributesToArray() as $key => $value) {
                    $str = $str . ", " . $key . ": " . $value;
                }
                $aud->detalles = $str;
                $aud->save();
                flash("El Requisito <strong>" . $requisito->descripcion . "</strong> fue eliminado de forma exitosa!")->success();
                return redirect()->route('requisitogrado.index');
            } else {
                flash("El Requisito <strong>" . $requisito->descripcion . "</strong> no pudo ser eliminado. Error: " . $result)->error();
                return redirect()->route('requisitogrado.index');
            }
        }
    }
}
