<?php

namespace App\Http\Controllers;

use App\Documentoanexo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Auditoriaadmision;
use App\Http\Requests\DocumentoanexoRequest;

class DocumentoanexoController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $documentosanexos = Documentoanexo::all();
        return view('admisiones.admision_matricula.documentos_anexos.list')
                        ->with('location', 'admisiones')
                        ->with('documentoanexo', $documentosanexos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('admisiones.admision_matricula.documentos_anexos.create')
                        ->with('location', 'admisiones');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $documentoanexo = new Documentoanexo($request->all());
        foreach ($documentoanexo->attributesToArray() as $key => $value) {
            $documentoanexo->$key = strtoupper($value);
        }
        $u = Auth::user();
        $documentoanexo->user_change = $u->identificacion;
        $result = $documentoanexo->save();
        if ($result) {
            $aud = new Auditoriaadmision();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "INSERTAR";
            $str = "CREACIÓN DE DOCUMENTOS ANEXOS. DATOS: ";
            foreach ($documentoanexo->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("El documento anexo <strong>" . $documentoanexo->nombre . "</strong> fue almacenado de forma exitosa!")->success();
            return redirect()->route('documentosanexos.index');
        } else {
            flash("El documento anexo <strong>" . $documentoanexo->nombre . "</strong> no pudo ser almacenado. Error: " . $result)->error();
            return redirect()->route('documentosanexos.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Documentoanexo  $documentoanexo
     * @return \Illuminate\Http\Response
     */
    public function show(Documentoanexo $documentoanexo) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Documentoanexo  $documentoanexo
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $documentoanexo = Documentoanexo::find($id);
        return view('admisiones.admision_matricula.documentos_anexos.edit')
                        ->with('location', 'admisiones')
                        ->with('documentoanexo', $documentoanexo);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Documentoanexo  $documentoanexo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $documentoanexo = Documentoanexo::find($id);
        $m = new Documentoanexo($documentoanexo->attributesToArray());
        foreach ($documentoanexo->attributesToArray() as $key => $value) {
            if (isset($request->$key)) {
                $documentoanexo->$key = strtoupper($request->$key);
            }
        }
        $u = Auth::user();
        $documentoanexo->user_change = $u->identificacion;
        $result = $documentoanexo->save();
        if ($result) {
            $aud = new Auditoriaadmision();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ACTUALIZAR DATOS";
            $str = "EDICION DE DOCUMENTOS ANEXOS. DATOS NUEVOS: ";
            $str2 = " DATOS ANTIGUOS: ";
            foreach ($m->attributesToArray() as $key => $value) {
                $str2 = $str2 . ", " . $key . ": " . $value;
            }
            foreach ($documentoanexo->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str . " - " . $str2;
            $aud->save();
            flash("El documento anexo <strong>" . $documentoanexo->nombre . "</strong> fue modificado de forma exitosa!")->success();
            return redirect()->route('documentosanexos.index');
        } else {
            flash("El documento anexo <strong>" . $documentoanexo->nombre . "</strong> no pudo ser modificado. Error: " . $result)->error();
            return redirect()->route('documentosanexos.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Documentoanexo  $documentoanexo
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
         // if (count($situacion->paginas) > 0 || count($grupo->modulos) > 0 || count($grupo->users) > 0) {
//            flash("El Grupo de usuario <strong>" . $grupo->nombre . "</strong> no pudo ser eliminado porque tiene permisos o usuarios asociados.")->warning();
//            return redirect()->route('grupousuario.index');
//        } else {
        $documentoanexo = Documentoanexo::find($id);
        $result = $documentoanexo->delete();
        if ($result) {
            $aud = new Auditoriaadmision();
            $u = Auth::user();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ELIMINAR";
            $str = "ELIMINACIÓN DEL DOCUMENTO ANEXO. DATOS ELIMINADOS: ";
            foreach ($documentoanexo->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("El documento anexo <strong>" . $documentoanexo->nombre . "</strong> fue eliminado de forma exitosa!")->success();
            return redirect()->route('documentosanexos.index');
        } else {
            flash("El documento anexo <strong>" . $documentoanexo->nombre . "</strong> no pudo ser eliminado. Error: " . $result)->error();
            return redirect()->route('documentosanexos.index');
        }
//        }
    }

}
