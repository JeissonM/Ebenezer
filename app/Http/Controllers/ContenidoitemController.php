<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contenidoitem;
use App\Http\Requests\ContenidoitemRequest;
use Illuminate\Support\Facades\Auth;
use App\Matriculaauditoria;
use App\Itemcontenidomateria;
use App\Materia;

class ContenidoitemController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $materias = Materia::all();
        return view('matricula.datos_basicos.contenidoitem.list')
                        ->with('location', 'matricula')
                        ->with('materias', $materias);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('matricula.datos_basicos.contenidoitem.create')
                        ->with('location', 'matricula');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ContenidoitemRequest $request) {
        $contenidoitem = new Contenidoitem($request->all());
        foreach ($contenidoitem->attributesToArray() as $key => $value) {
            $contenidoitem->$key = strtoupper($value);
        }
        $u = Auth::user();
        $contenidoitem->user_change = $u->identificacion;
        $result = $contenidoitem->save();
        if ($result) {
            $aud = new Auditoriaadmision();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "INSERTAR";
            $str = "CREACIÓN DE CONTENIDO DE ITEM DE MATERIA. DATOS: ";
            foreach ($contenidoitem->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("El Contedido de Item de Materia <strong>" . $contenidoitem->nombre . "</strong> fue almacenado de forma exitosa!")->success();
            return redirect()->route('contenidoitem.index');
        } else {
            flash("El Contedido de Item de Materia <strong>" . $contenidoitem->nombre . "</strong> no pudo ser almacenada. Error: " . $result)->error();
            return redirect()->route('contenidoitem.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $materia = Materia::find($id);
        $materia->contenidoitems;
        return view('matricula.datos_basicos.contenidoitem.listcontenido')
                        ->with('location', 'matricula')
                        ->with('materia', $materia);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        //
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
