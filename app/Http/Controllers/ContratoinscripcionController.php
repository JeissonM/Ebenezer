<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contratoinscripcion;
use App\Http\Requests\ContratoinscripcionRequest;
use Illuminate\Support\Facades\Auth;
use App\Auditoriaadmision;

class ContratoinscripcionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contratos = Contratoinscripcion::all();
        return view('admisiones.agenda_entrevista.contrato_inscripcion.list')
            ->with('location', 'admisiones')
            ->with('contratos', $contratos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admisiones.agenda_entrevista.contrato_inscripcion.create')
            ->with('location', 'admisiones');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ContratoinscripcionRequest $request)
    {
        if ($this->verificar($request->estado)) {
            flash("El contrato no pudo ser almacenado porque ya existe otro contrato definido como ACTUAL.")->error();
            return redirect()->route('contratoinscripcion.index');
        }
        $contrato = new Contratoinscripcion($request->all());
        $u = Auth::user();
        $contrato->user_change = $u->identificacion;
        $result = $contrato->save();
        if ($result) {
            $aud = new Auditoriaadmision();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "INSERTAR";
            $str = "CREACIÓN DE CONTRATOS DE INSCRIPCIÓN. DATOS: ";
            foreach ($contrato->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("El contrato fue almacenado de forma exitosa!")->success();
            return redirect()->route('contratoinscripcion.index');
        } else {
            flash("El contrato no pudo ser almacenado. Error: " . $result)->error();
            return redirect()->route('contratoinscripcion.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Contratoinscripcion  contrato
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $contrato = Contratoinscripcion::find($id);
        return view('admisiones.agenda_entrevista.contrato_inscripcion.show')
            ->with('location', 'admisiones')
            ->with('contrato', $contrato);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Contratoinscripcion  contratos
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $contrato = Contratoinscripcion::find($id);
        return view('admisiones.agenda_entrevista.contrato_inscripcion.edit')
            ->with('location', 'admisiones')
            ->with('contrato', $contrato);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Contratoinscripcion  contrato
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if ($this->verificar($request->estado)) {
            flash("El contrato no pudo ser modificado porque ya existe otro contrato definido como ACTUAL.")->error();
            return redirect()->route('contratoinscripcion.index');
        }
        $contrato = Contratoinscripcion::find($id);
        $m = new Contratoinscripcion($contrato->attributesToArray());
        foreach ($contrato->attributesToArray() as $key => $value) {
            if (isset($request->$key)) {
                $contrato->$key = $request->$key;
            }
        }
        $u = Auth::user();
        $contrato->user_change = $u->identificacion;
        $result = $contrato->save();
        if ($result) {
            $aud = new Auditoriaadmision();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ACTUALIZAR DATOS";
            $str = "EDICION DE LOS CONTRATOS DE INSCRIPCIÓN. DATOS NUEVOS: ";
            $str2 = " DATOS ANTIGUOS: ";
            foreach ($m->attributesToArray() as $key => $value) {
                $str2 = $str2 . ", " . $key . ": " . $value;
            }
            foreach ($contrato->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str . " - " . $str2;
            $aud->save();
            flash("El contrato fue modificado de forma exitosa!")->success();
            return redirect()->route('contratoinscripcion.index');
        } else {
            flash("El contrato no pudo ser modificado. Error: " . $result)->error();
            return redirect()->route('contratoinscripcion.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Circunscripcion  contratos
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $contrato = Contratoinscripcion::find($id);
        $result = $contrato->delete();
        if ($result) {
            $aud = new Auditoriaadmision();
            $u = Auth::user();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ELIMINAR";
            $str = "ELIMINACIÓN DE LOS CONTRATOS DE INSCRIPCIÓN. DATOS ELIMINADOS: ";
            foreach ($contrato->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("El contrato fue eliminado de forma exitosa!")->success();
            return redirect()->route('contratoinscripcion.index');
        } else {
            flash("El contrato no pudo ser eliminado. Error: " . $result)->error();
            return redirect()->route('contratoinscripcion.index');
        }
    }

    //Verifica si hay al menos un contrato con estado SI
    public function verificar($estado)
    {
        if ($estado == 'SI') {
            $contratos = Contratoinscripcion::where('estado', 'SI')->get();
            if (count($contratos) > 0) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}
