<?php

namespace App\Http\Controllers;

use App\Jornada;
use App\Auditoriaadmision;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\JornadaRequest;
use Illuminate\Http\Request;

class JornadaController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $jornadas = Jornada::all();
        return view('admisiones.calendario_procesos_convocatoria.jornada.list')
                        ->with('location', 'admisiones')
                        ->with('jornadas', $jornadas);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('admisiones.calendario_procesos_convocatoria.jornada.create')
                        ->with('location', 'admisiones');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(JornadaRequest $request) {
        $jornada = new Jornada($request->all());
        foreach ($jornada->attributesToArray() as $key => $value) {
            $jornada->$key = strtoupper($value);
        }
        $u = Auth::user();
        $jornada->user_change = $u->identificacion;
        $result = $jornada->save();
        if ($result) {
            $aud = new Auditoriaadmision();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "INSERTAR";
            $str = "CREACIÓN DE JORNADA. DATOS: ";
            foreach ($jornada->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("La jornada <strong>" . $jornada->descripcion . "</strong> fue almacenada de forma exitosa!")->success();
            return redirect()->route('jornada.index');
        } else {
            flash("El jornada <strong>" . $jornada->descripcion . "</strong> no pudo ser almacenada. Error: " . $result)->error();
            return redirect()->route('jornada.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Jornada  $jornada
     * @return \Illuminate\Http\Response
     */
    public function show(Jornada $jornada) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Jornada  $jornada
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $jornada = Jornada::find($id);
        return view('admisiones.calendario_procesos_convocatoria.jornada.edit')
                        ->with('location', 'admisiones')
                        ->with('jornada', $jornada);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Jornada  $jornada
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $jornada = Jornada::find($id);
        $m = new Jornada($jornada->attributesToArray());
        foreach ($jornada->attributesToArray() as $key => $value) {
            if (isset($request->$key)) {
                $jornada->$key = strtoupper($request->$key);
            }
        }
        $u = Auth::user();
        $jornada->user_change = $u->identificacion;
        $result = $jornada->save();
        if ($result) {
            $aud = new Auditoriaadmision();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ACTUALIZAR DATOS";
            $str = "EDICION DE JORNADA. DATOS NUEVOS: ";
            $str2 = " DATOS ANTIGUOS: ";
            foreach ($m->attributesToArray() as $key => $value) {
                $str2 = $str2 . ", " . $key . ": " . $value;
            }
            foreach ($jornada->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str . " - " . $str2;
            $aud->save();
            flash("La jornada<strong>" . $jornada->descripcion . "</strong> fue modificada de forma exitosa!")->success();
            return redirect()->route('jornada.index');
        } else {
            flash("La jornada <strong>" . $jornada->descripcion . "</strong> no pudo ser modificada. Error: " . $result)->error();
            return redirect()->route('jornada.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Jornada  $jornada
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        // if (count($jornada->paginas) > 0 || count($grupo->modulos) > 0 || count($grupo->users) > 0) {
//            flash("El Grupo de usuario <strong>" . $grupo->nombre . "</strong> no pudo ser eliminado porque tiene permisos o usuarios asociados.")->warning();
//            return redirect()->route('grupousuario.index');
//        } else {
        $jornada = Jornada::find($id);
        $result = $jornada->delete();
        if ($result) {
            $aud = new Auditoriaadmision();
            $u = Auth::user();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ELIMINAR";
            $str = "ELIMINACIÓN DE JORNADA. DATOS ELIMINADOS: ";
            foreach ($jornada->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("La jornada <strong>" . $jornada->descripcion . "</strong> fue eliminada de forma exitosa!")->success();
            return redirect()->route('jornada.index');
        } else {
            flash("La jornada <strong>" . $jornada->descripcion . "</strong> no pudo ser eliminada. Error: " . $result)->error();
            return redirect()->route('jornada.index');
        }
//        }
    }

}
