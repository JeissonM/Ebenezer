<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Itemcontenidomateria;
use App\Http\Requests\ItemcontenidomateriaRequest;
use Illuminate\Support\Facades\Auth;
use App\Matriculaauditoria;

class ItemcontenidomateriaController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $itemcontenidomateria = Itemcontenidomateria::all();
        return view('matricula.datos_basicos.itemcontenidomateria.list')
                        ->with('location', 'matricula')
                        ->with('itemcontenidomateria', $itemcontenidomateria);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('matricula.datos_basicos.itemcontenidomateria.create')
                        ->with('location', 'matricula');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ItemcontenidomateriaRequest $request) {
        $itemcm = new Itemcontenidomateria($request->all());
        foreach ($itemcm->attributesToArray() as $key => $value) {
            $itemcm->$key = strtoupper($value);
        }
        $u = Auth::user();
        $itemcm->user_change = $u->identificacion;
        $result = $itemcm->save();
        if ($result) {
            $aud = new Matriculaauditoria();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "INSERTAR";
            $str = "CREACIÓN DE ITEM CONTENIDO DE MATERIA. DATOS: ";
            foreach ($itemcm->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("El item contenido de materia <strong>" . $itemcm->nombre . "</strong> fue almacenado de forma exitosa!")->success();
            return redirect()->route('itemcontenidomateria.index');
        } else {
            flash("El item contenido de materia <strong>" . $itemcm->nombre . "</strong> no pudo ser almacenado. Error: " . $result)->error();
            return redirect()->route('itemcontenidomateria.index');
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
        $itemcm = Itemcontenidomateria::find($id);
        return view('matricula.datos_basicos.itemcontenidomateria.edit')
                        ->with('location', 'matricula')
                        ->with('Itemcontenidomateria', $itemcm);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $itemcm = Itemcontenidomateria::find($id);
        $m = new Itemcontenidomateria($itemcm->attributesToArray());
        foreach ($itemcm->attributesToArray() as $key => $value) {
            if (isset($request->$key)) {
                $itemcm->$key = strtoupper($request->$key);
            }
        }
        $u = Auth::user();
        $itemcm->user_change = $u->identificacion;
        $result = $itemcm->save();
        if ($result) {
            $aud = new Matriculaauditoria();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ACTUALIZAR DATOS";
            $str = "EDICION DEL ITEM CONTENIDO DE MATERIA. DATOS NUEVOS: ";
            $str2 = " DATOS ANTIGUOS: ";
            foreach ($m->attributesToArray() as $key => $value) {
                $str2 = $str2 . ", " . $key . ": " . $value;
            }
            foreach ($itemcm->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str . " - " . $str2;
            $aud->save();
            flash("El Item Contenido de Materia <strong>" . $itemcm->nombre . "</strong> fué modificado de forma exitosa!")->success();
            return redirect()->route('itemcontenidomateria.index');
        } else {
            flash("El Item Contenido de Materia <strong>" . $itemcm->nombre . "</strong> no pudo ser modificado. Error: " . $result)->error();
            return redirect()->route('itemcontenidomateria.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $itemcm = Itemcontenidomateria::find($id);
        $result = $itemcm->delete();
        if ($result) {
            $aud = new Matriculaauditoria();
            $u = Auth::user();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ELIMINAR";
            $str = "ELIMINACIÓN DEL ITEM CONTENIDO DE MATERIA. DATOS ELIMINADOS: ";
            foreach ($itemcm->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("El Item Contenido de Materia <strong>" . $itemcm->nombre . "</strong> fue eliminadO de forma exitosa!")->success();
            return redirect()->route('itemcontenidomateria.index');
        } else {
            flash("El Item Contenido de Materia <strong>" . $itemcm->nombre . "</strong> no pudo ser eliminado. Error: " . $result)->error();
            return redirect()->route('itemcontenidomateria.index');
        }
    }

}
