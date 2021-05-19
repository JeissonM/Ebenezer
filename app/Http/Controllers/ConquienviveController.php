<?php

namespace App\Http\Controllers;

use App\Conquienvive;
use App\Auditoriaadmision;
use Illuminate\Http\Request;
use App\Http\Requests\ConquienviveRequest;
use Illuminate\Support\Facades\Auth;

class ConquienviveController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $vives = Conquienvive::all();
        return view('admisiones.admision_matricula.con_quien_vive.list')
                        ->with('location', 'admisiones')
                        ->with('vives', $vives);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('admisiones.admision_matricula.con_quien_vive.create')
                        ->with('location', 'admisiones');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ConquienviveRequest $request) {
        $vive = new Conquienvive($request->all());
        foreach ($vive->attributesToArray() as $key => $value) {
            $vive->$key = strtoupper($value);
        }
        $u = Auth::user();
        $vive->user_change = $u->identificacion;
        $result = $vive->save();
        if ($result) {
            $aud = new Auditoriaadmision();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "INSERTAR";
            $str = "CREACIÓN DE CON QUIEN VIVE. DATOS: ";
            foreach ($vive->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("La opción ¿con quien vive? <strong>" . $vive->descripcion . "</strong> fue almacenada de forma exitosa!")->success();
            return redirect()->route('conquienvive.index');
        } else {
            flash("La opción ¿con quien vive? <strong>" . $vive->descripcion . "</strong> no pudo ser almacenada. Error: " . $result)->error();
            return redirect()->route('conquienvive.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Conquienvive  $conquienvive
     * @return \Illuminate\Http\Response
     */
    public function show(Conquienvive $conquienvive) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Conquienvive  $conquienvive
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $vive = Conquienvive::find($id);
        return view('admisiones.admision_matricula.con_quien_vive.edit')
                        ->with('location', 'admisiones')
                        ->with('vive', $vive);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Conquienvive  $conquienvive
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $vive = Conquienvive::find($id);
        $m = new Conquienvive($vive->attributesToArray());
        foreach ($vive->attributesToArray() as $key => $value) {
            if (isset($request->$key)) {
                $vive->$key = strtoupper($request->$key);
            }
        }
        $u = Auth::user();
        $vive->user_change = $u->identificacion;
        $result = $vive->save();
        if ($result) {
            $aud = new Auditoriaadmision();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ACTUALIZAR DATOS";
            $str = "EDICION DE CON QUIEN VIVE. DATOS NUEVOS: ";
            $str2 = " DATOS ANTIGUOS: ";
            foreach ($m->attributesToArray() as $key => $value) {
                $str2 = $str2 . ", " . $key . ": " . $value;
            }
            foreach ($vive->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str . " - " . $str2;
            $aud->save();
            flash("La opción ¿con quien vive? <strong>" . $vive->descripcion. "</strong> fue modificada de forma exitosa!")->success();
            return redirect()->route('conquienvive.index');
        } else {
            flash("La opción ¿con quien vive? <strong>" . $vive->descripcion . "</strong> no pudo ser modificada. Error: " . $result)->error();
            return redirect()->route('conquienvive.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Conquienvive  $conquienvive
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        // if (count($vive->paginas) > 0 || count($grupo->modulos) > 0 || count($grupo->users) > 0) {
//            flash("El Grupo de usuario <strong>" . $grupo->nombre . "</strong> no pudo ser eliminado porque tiene permisos o usuarios asociados.")->warning();
//            return redirect()->route('grupousuario.index');
//        } else {
        $vive = Conquienvive::find($id);
        $result = $vive->delete();
        if ($result) {
            $aud = new Auditoriaadmision();
            $u = Auth::user();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ELIMINAR";
            $str = "ELIMINACIÓN DE CON QUIEN VIVE. DATOS ELIMINADOS: ";
            foreach ($vive->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("La opción ¿con quien vive? <strong>" . $vive->descripcion. "</strong> fue eliminada de forma exitosa!")->success();
            return redirect()->route('conquienvive.index');
        } else {
            flash("La opción ¿con quien vive? <strong>" . $vive->descripcion . "</strong> no pudo ser eliminada. Error: " . $result)->error();
            return redirect()->route('conquienvive.index');
        }
//        }
    }

}
