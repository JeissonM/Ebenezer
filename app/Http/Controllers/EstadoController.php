<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Estado;
use App\Http\Requests\EstadoRequest;
use App\Pais;

class EstadoController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $estados = Estado::all();
        $estados->each(function ($estados) {
            $estados->pais;
        });
        return view('admisiones.datos_generales.estados.list')
                        ->with('location', 'admisiones')
                        ->with('estados', $estados);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $paises = Pais::all()->pluck('nombre', 'id');
        return view('admisiones.datos_generales.estados.create')
                        ->with('location', 'admisiones')
                        ->with('paises', $paises);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $estado = new Estado($request->all());
        foreach ($estado->attributesToArray() as $key => $value) {
            $estado->$key = strtoupper($value);
        }
        $result = $estado->save();
        if ($result) {
            flash("El Estado <strong>" . $estado->nombre . "</strong> fue almacenado de forma exitosa!")->success();
            return redirect()->route('estado.index');
        } else {
            flash("El Estado <strong>" . $estado->nombre . "</strong> no pudo ser almacenado. Error: " . $result)->error();
            return redirect()->route('estado.index');
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
        $estado = Estado::find($id);
        $paises = Pais::all()->pluck('nombre', 'id');
        return view('admisiones.datos_generales.estados.edit')
                        ->with('location', 'admisiones')
                        ->with('estado', $estado)
                        ->with('paises', $paises);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $estado = Estado::find($id);
        foreach ($estado->attributesToArray() as $key => $value) {
            if (isset($request->$key)) {
                $estado->$key = strtoupper($request->$key);
            }
        }
        $result = $estado->save();
        if ($result) {
            flash("El Estado <strong>" . $estado->nombre . "</strong> fue modificado de forma exitosa!")->success();
            return redirect()->route('estado.index');
        } else {
            flash("El Estado <strong>" . $estado->nombre . "</strong> no pudo ser modificado. Error: " . $result)->error();
            return redirect()->route('estado.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $estado = Estado::find($id);
        if (count($estado->ciudades) > 0) {
            flash("El Estado <strong>" . $estado->nombre . "</strong> no pudo ser eliminado porque tiene ciudades/municipios asociados.")->warning();
            return redirect()->route('estado.index');
        } else {
            $result = $estado->delete();
            if ($result) {
                flash("El Estado <strong>" . $estado->nombre . "</strong> fue eliminado de forma exitosa!")->success();
                return redirect()->route('estado.index');
            } else {
                flash("El Estado <strong>" . $estado->nombre . "</strong> no pudo ser eliminado. Error: " . $result)->error();
                return redirect()->route('estado.index');
            }
        }
    }

    /**
     * show all resource from a estado.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function ciudades($id) {
        $estado = Estado::find($id);
        $ciudades = $estado->ciudades;
        if (count($ciudades) > 0) {
            $ciudadesf = null;
            foreach ($ciudades as $value) {
                $obj["id"] = $value->id;
                $obj["value"] = $value->nombre;
                $ciudadesf[] = $obj;
            }
            return json_encode($ciudadesf);
        } else {
            return "null";
        }
    }

}
