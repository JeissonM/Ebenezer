<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\GrupousuarioRequest;
use App\Grupousuario;
use App\Modulo;
use App\Auditoriausuario;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Pagina;

class GrupousuarioController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $grupos = Grupousuario::all()->sortBy('nombre');
        return view('usuarios.grupos_usuarios.list')
                        ->with('location', 'usuarios')
                        ->with('grupos', $grupos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $modulos = Modulo::all()->pluck('nombre', 'id');
        return view('usuarios.grupos_usuarios.create')
                        ->with('location', 'usuarios')
                        ->with('modulos', $modulos);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GrupousuarioRequest $request) {
        $grupo = new Grupousuario($request->all());
        foreach ($grupo->attributesToArray() as $key => $value) {
            $grupo->$key = strtoupper($value);
        }
        $u = Auth::user();
        $grupo->user_change = $u->identificacion;
        $result = $grupo->save();
        $grupo->modulos()->sync($request->modulos);
        if ($result) {
            $aud = new Auditoriausuario();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "INSERTAR";
            $str = "CREACIÓN DE GRUPO DE USUARIO. DATOS: ";
            foreach ($grupo->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("El Grupo de usuario <strong>" . $grupo->nombre . "</strong> fue almacenado de forma exitosa!")->success();
            return redirect()->route('grupousuario.index');
        } else {
            flash("El Grupo de usuario <strong>" . $grupo->nombre . "</strong> no pudo ser almacenado. Error: " . $result)->error();
            return redirect()->route('grupousuario.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $grupo = Grupousuario::find($id);
        $grupo->modulos;
        $total = count($grupo->users);
        return view('usuarios.grupos_usuarios.show')
                        ->with('location', 'usuarios')
                        ->with('grupo', $grupo)
                        ->with('total', $total);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $grupo = Grupousuario::find($id);
        $grupo->modulos;
        $modulos = Modulo::all()->pluck('nombre', 'id');
        return view('usuarios.grupos_usuarios.edit')
                        ->with('location', 'usuarios')
                        ->with('grupo', $grupo)
                        ->with('modulos', $modulos);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $grupo = Grupousuario::find($id);
        $m = new Grupousuario($grupo->attributesToArray());
        foreach ($grupo->attributesToArray() as $key => $value) {
            if (isset($request->$key)) {
                $grupo->$key = strtoupper($request->$key);
            }
        }
        $u = Auth::user();
        $grupo->user_change = $u->identificacion;
        $result = $grupo->save();
        $grupo->modulos()->sync($request->modulos);
        if ($result) {
            $aud = new Auditoriausuario();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ACTUALIZAR DATOS";
            $str = "EDICION DE GRUPO DE USUARIOS. DATOS NUEVOS: ";
            $str2 = " DATOS ANTIGUOS: ";
            foreach ($m->attributesToArray() as $key => $value) {
                $str2 = $str2 . ", " . $key . ": " . $value;
            }
            foreach ($grupo->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str . " - " . $str2;
            $aud->save();
            flash("El Grupo de usuario <strong>" . $grupo->nombre . "</strong> fue modificado de forma exitosa!")->success();
            return redirect()->route('grupousuario.index');
        } else {
            flash("El Grupo de usuario <strong>" . $grupo->nombre . "</strong> no pudo ser modificado. Error: " . $result)->error();
            return redirect()->route('grupousuario.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $grupo = Grupousuario::find($id);
        if (count($grupo->paginas) > 0 || count($grupo->modulos) > 0 || count($grupo->users) > 0) {
            flash("El Grupo de usuario <strong>" . $grupo->nombre . "</strong> no pudo ser eliminado porque tiene permisos o usuarios asociados.")->warning();
            return redirect()->route('grupousuario.index');
        } else {
            $result = $grupo->delete();
            if ($result) {
                $aud = new Auditoriausuario();
                $u = Auth::user();
                $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
                $aud->operacion = "ELIMINAR";
                $str = "ELIMINACIÓN DE GRUPOS DE USUARIOS. DATOS ELIMINADOS: ";
                foreach ($grupo->attributesToArray() as $key => $value) {
                    $str = $str . ", " . $key . ": " . $value;
                }
                $aud->detalles = $str;
                $aud->save();
                flash("El Grupo de usuario <strong>" . $grupo->nombre . "</strong> fue eliminado de forma exitosa!")->success();
                return redirect()->route('grupousuario.index');
            } else {
                flash("El Grupo de usuario <strong>" . $grupo->nombre . "</strong> no pudo ser eliminado. Error: " . $result)->error();
                return redirect()->route('grupousuario.index');
            }
        }
    }

    /**
     * Show the view privilegios.
     *
     * @return \Illuminate\Http\Response
     */
    public function privilegios() {
        $grupos = Grupousuario::all()->sortBy('nombre')->pluck('nombre', 'id');
        $paginas2 = Pagina::all()->sortBy('nombre');
        $paginas = null;
        foreach ($paginas2 as $p) {
            $paginas[$p->id] = $p->nombre . " ==> " . $p->descripcion;
        }
        return view('usuarios.privilegios.list')
                        ->with('location', 'usuarios')
                        ->with('grupos', $grupos)
                        ->with('paginas', $paginas);
    }

    /**
     * Show the view privilegios.
     *
     * @return \Illuminate\Http\Response
     */
    public function getPrivilegios($id) {
        $grupo = Grupousuario::find($id);
        $paginas = $grupo->paginas;
        $array = null;
        foreach ($paginas as $value) {
            $obj["id"] = $value->id;
            $obj["value"] = $value->nombre . " ==> " . $value->descripcion;
            $array[] = $obj;
        }
        return json_encode($array);
    }

    /**
     * Show the view privilegios.
     *
     * @return \Illuminate\Http\Response
     */
    public function setPrivilegios() {
        if (!isset($_POST["privilegios"])) {
            DB::table('grupousuario_pagina')->where('grupousuario_id', '=', $_POST["id"])->delete();
            flash("<strong>Privilegios </strong> eliminados de forma exitosa!")->success();
            return redirect()->route('grupousuario.privilegios');
        } else {
            $grupo = Grupousuario::find($_POST["id"]);
            $grupo->paginas()->sync($_POST["privilegios"]);
            $grupo->paginas;
            flash("<strong>Privilegios </strong> asignados de forma exitosa!")->success();
            return redirect()->route('grupousuario.privilegios');
        }
    }

}
