<?php

namespace App\Http\Controllers;

use App\Periodoacademico;
use App\Auditoriaadmision;
use Illuminate\Http\Request;
use App\Http\Requests\PeriodoacademicoRequest;
use Illuminate\Support\Facades\Auth;

class PeriodoacademicoController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $periodos = Periodoacademico::all();
        return view('admisiones.admision_matricula.periodo_academico.list')
                        ->with('location', 'admisiones')
                        ->with('periodos', $periodos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('admisiones.admision_matricula.periodo_academico.create')
                        ->with('location', 'admisiones');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PeriodoacademicoRequest $request) {
        $periodo = new Periodoacademico($request->all());
        foreach ($periodo->attributesToArray() as $key => $value) {
            $periodo->$key = strtoupper($value);
        }
        if (!isset($request->fecha_inicio)) {
            $periodo->fecha_inicio = null;
        }
        if (!isset($request->fecha_fin)) {
            $periodo->fecha_fin = null;
        }
        $u = Auth::user();
        $periodo->user_change = $u->identificacion;
        $result = $periodo->save();
        if ($result) {
            $aud = new Auditoriaadmision();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "INSERTAR";
            $str = "CREACIÓN DE PERIODO ACADEMICO. DATOS: ";
            foreach ($periodo->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("El Período <strong>" . $periodo->etiqueta . " - " . $periodo->anio . "</strong> fue almacenado de forma exitosa!")->success();
            return redirect()->route('periodoacademico.index');
        } else {
            flash("El Período <strong>" . $periodo->etiqueta . " - " . $periodo->anio . "</strong> no pudo ser almacenado. Error: " . $result)->error();
            return redirect()->route('periodoacademico.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Periodoacademico  $periodoacademico
     * @return \Illuminate\Http\Response
     */
    public function show(Periodoacademico $periodoacademico) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Periodoacademico  $periodoacademico
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $periodo = Periodoacademico::find($id);
        return view('admisiones.admision_matricula.periodo_academico.edit')
                        ->with('location', 'admisiones')
                        ->with('periodo', $periodo);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Periodoacademico  $periodoacademico
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $periodo = Periodoacademico::find($id);
        $m = new Periodoacademico($periodo->attributesToArray());
        foreach ($periodo->attributesToArray() as $key => $value) {
            if (isset($request->$key)) {
                $periodo->$key = strtoupper($request->$key);
            }
        }
        if (!isset($request->fecha_inicio)) {
            $periodo->fecha_inicio = null;
        }
        if (!isset($request->fecha_fin)) {
            $periodo->fecha_fin = null;
        }
        $u = Auth::user();
        $periodo->user_change = $u->identificacion;
        $result = $periodo->save();
        if ($result) {
            $aud = new Auditoriaadmision();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ACTUALIZAR DATOS";
            $str = "EDICION DE PERÍODO. DATOS NUEVOS: ";
            $str2 = " DATOS ANTIGUOS: ";
            foreach ($m->attributesToArray() as $key => $value) {
                $str2 = $str2 . ", " . $key . ": " . $value;
            }
            foreach ($periodo->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str . " - " . $str2;
            $aud->save();
            flash("El Período <strong>" . $periodo->etiqueta . " - " . $periodo->anio . "</strong> fue modificado de forma exitosa!")->success();
            return redirect()->route('periodoacademico.index');
        } else {
            flash("El Período <strong>" . $periodo->etiqueta . " - " . $periodo->anio . "</strong> no pudo ser modificado. Error: " . $result)->error();
            return redirect()->route('periodoacademico.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Periodoacademico  $periodoacademico
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        // if (count($periodo->paginas) > 0 || count($grupo->modulos) > 0 || count($grupo->users) > 0) {
//            flash("El Grupo de usuario <strong>" . $grupo->nombre . "</strong> no pudo ser eliminado porque tiene permisos o usuarios asociados.")->warning();
//            return redirect()->route('grupousuario.index');
//        } else {
        $periodo = Periodoacademico::find($id);
        $result = $periodo->delete();
        if ($result) {
            $aud = new Auditoriaadmision();
            $u = Auth::user();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ELIMINAR";
            $str = "ELIMINACIÓN DE PERÍODO ACADEMICO. DATOS ELIMINADOS: ";
            foreach ($periodo->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("El Período <strong>" . $periodo->etiqueta . " - " . $periodo->anio . "</strong> fue eliminado de forma exitosa!")->success();
            return redirect()->route('periodoacademico.index');
        } else {
            flash("El Período <strong>" . $periodo->etiqueta . " - " . $periodo->anio . "</strong> no pudo ser eliminado. Error: " . $result)->error();
            return redirect()->route('periodoacademico.index');
        }
//        }
    }

}
