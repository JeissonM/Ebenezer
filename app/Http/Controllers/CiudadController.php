<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ciudad;
use App\Http\Requests\CiudadRequest;
use App\Pais;
use App\Estado;

class CiudadController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $ciudades = Ciudad::all();
        $ciudades->each(function ($ciudad) {
            $ciudad->estado;
        });
        return view('admisiones.datos_generales.ciudades.list')
                        ->with('location', 'admisiones')
                        ->with('ciudades', $ciudades);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $estados = Estado::all()->pluck('nombre', 'id');
        return view('admisiones.datos_generales.ciudades.create')
                        ->with('location', 'admisiones')
                        ->with('estados', $estados);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $ciudad = new Ciudad($request->all());
        foreach ($ciudad->attributesToArray() as $key => $value) {
            if ($key === 'poblacion') {
                if (strlen($value) === 0) {
                    $ciudad->$key = 0;
                } else {
                    $ciudad->$key = $value;
                }
            } else {
                $ciudad->$key = strtoupper($value);
            }
        }
        $result = $ciudad->save();
        if ($result) {
            flash("La Ciudad <strong>" . $ciudad->nombre . "</strong> fue almacenada de forma exitosa!")->success();
            return redirect()->route('ciudad.index');
        } else {
            flash("La Ciudad <strong>" . $ciudad->nombre . "</strong> no pudo ser almacenada. Error: " . $result)->error();
            return redirect()->route('ciudad.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $ciudad = Ciudad::find($id);
        $ciudad->estado->pais;
        return view('admisiones.datos_generales.ciudades.show')
                        ->with('location', 'admisiones')
                        ->with('ciudad', $ciudad);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $ciudad = Ciudad::find($id);
        $estados = Estado::all()->pluck('nombre', 'id');
        return view('matricula.datos_basicos.materia.edit')
                        ->with('location', 'matricula')
                        ->with('ciudad', $ciudad)
                        ->with('estados', $estados);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $ciudad = Ciudad::find($id);
        foreach ($ciudad->attributesToArray() as $key => $value) {
            if (isset($request->$key)) {
                if ($key === 'poblacion') {
                    if (strlen($request->$key) === 0) {
                        $ciudad->$key = 0;
                    } else {
                        $ciudad->$key = $request->$key;
                    }
                } else {
                    $ciudad->$key = strtoupper($request->$key);
                }
            }
        }
        $result = $ciudad->save();
        if ($result) {
            flash("La Ciudad <strong>" . $ciudad->nombre . "</strong> fue modificada de forma exitosa!")->success();
            return redirect()->route('ciudad.index');
        } else {
            flash("La Ciudad <strong>" . $ciudad->nombre . "</strong> no pudo ser modificada. Error: " . $result)->error();
            return redirect()->route('ciudad.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $ciudad = Ciudad::find($id);
        $result = $ciudad->delete();
        if ($result) {
            flash("La Ciudad <strong>" . $ciudad->nombre . "</strong> fue eliminada de forma exitosa!")->success();
            return redirect()->route('ciudad.index');
        } else {
            flash("La Ciudad <strong>" . $ciudad->nombre . "</strong> no pudo ser eliminada. Error: " . $result)->error();
            return redirect()->route('ciudad.index');
        }
    }

    /**
     * show all resource from a estado.
     *
     * @param  int  $id codigo del dpto
     * @return \Illuminate\Http\Response
     */
    public function sectores($id) {
        $ciudad = Ciudad::find($id);
        $sect = $ciudad->sectorciudads;
        if (count($sect) > 0) {
            $sectores = null;
            foreach ($sect as $value) {
                $obj["id"] = $value->id;
                $obj["value"] = $value->nombre;
                $sectores[] = $obj;
            }
            return json_encode($sectores);
        } else {
            return "null";
        }
    }

}
