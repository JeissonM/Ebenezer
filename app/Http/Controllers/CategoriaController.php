<?php

namespace App\Http\Controllers;

use App\Categoria;
use Illuminate\Http\Request;
use App\Http\Requests\CategoriaRequest;
use Illuminate\Support\Facades\Auth;
use App\Matriculaauditoria;

class CategoriaController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $categorias = Categoria::all();
        return view('matricula.datos_basicos.categoria.list')
                        ->with('location', 'matricula')
                        ->with('categorias', $categorias);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('matricula.datos_basicos.categoria.create')
                        ->with('location', 'matricula');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoriaRequest $request) {
        $categoria = new Categoria($request->all());
        foreach ($categoria->attributesToArray() as $key => $value) {
            $categoria->$key = strtoupper($value);
        }
        $u = Auth::user();
        $categoria->user_change = $u->identificacion;
        $result = $categoria->save();
        if ($result) {
            $aud = new Matriculaauditoria();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "INSERTAR";
            $str = "CREACIÓN DE CATEGORÍA, DATOS:  ";
            foreach ($categoria->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("La Categoría <strong>" . $categoria->nombre . "</strong> fue almacenada de forma exitosa!")->success();
            return redirect()->route('categoria.index');
        } else {
            flash("La Categoría <strong>" . $categoria->nombre . "</strong> no pudo ser almacenada. Error: " . $result)->error();
            return redirect()->route('categoria.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function show(Categoria $categoria) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $categoria = Categoria::find($id);
        return view('matricula.datos_basicos.categoria.edit')
                        ->with('location', 'matricula')
                        ->with('c', $categoria);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function update(CategoriaRequest $request, $id) {
        $categoria= Categoria::find($id);
        $m = new Categoria($categoria->attributesToArray());
        foreach ($categoria->attributesToArray() as $key => $value) {
            if (isset($request->$key)) {
                $categoria->$key = strtoupper($request->$key);
            }
        }
        $u = Auth::user();
        $categoria->user_change = $u->identificacion;
        $result = $categoria->save();
        if ($result) {
            $aud = new Matriculaauditoria();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ACTUALIZAR DATOS";
            $str = "EDICION DE CATEGORÍA. DATOS NUEVOS: ";
            $str2 = " DATOS ANTIGUOS: ";
            foreach ($m->attributesToArray() as $key => $value) {
                $str2 = $str2 . ", " . $key . ": " . $value;
            }
            foreach ($categoria->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str . " - " . $str2;
            $aud->save();
            flash("La Categoría <strong>" . $categoria->nombre . "</strong> fue modificada de forma exitosa!")->success();
            return redirect()->route('categoria.index');
        } else {
            flash("La Categoría <strong>" . $categoria->nombre . "</strong> no pudo ser modificada. Error: " . $result)->error();
            return redirect()->route('categoria.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //        if (count($tipodoc->paginas) > 0 || count($grupo->modulos) > 0 || count($grupo->users) > 0) {
//            flash("El Grupo de usuario <strong>" . $grupo->nombre . "</strong> no pudo ser eliminado porque tiene permisos o usuarios asociados.")->warning();
//            return redirect()->route('grupousuario.index');
//        } else {
        $categoria = Categoria::find($id);
        $result = $categoria->delete();
        if ($result) {
            $aud = new Matriculaauditoria();
            $u = Auth::user();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ELIMINAR";
            $str = "ELIMINACIÓN DE LA CATEGORÍA. DATOS ELIMINADOS: ";
            foreach ($categoria->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("La Categoría <strong>" . $categoria->nombre . "</strong> fue eliminada de forma exitosa!")->success();
            return redirect()->route('categoria.index');
        } else {
            flash("La Categoría <strong>" . $categoria->nombre . "</strong> no pudo ser eliminada. Error: " . $result)->error();
            return redirect()->route('categoria.index');
        }
//        }
    }

}
