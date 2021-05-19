<?php

namespace App\Http\Controllers;

use App\Areaexamenadmision;
use Illuminate\Http\Request;
use App\Grado;
use App\Auditoriaadmision;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AreaexamenadmisionRequest;

class AreaexamenadmisionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $areas = Areaexamenadmision::all();
        return view('admisiones.agenda_entrevista.area_examen_admision.list')
            ->with('location', 'admisiones')
            ->with('areas', $areas);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admisiones.agenda_entrevista.area_examen_admision.create')
            ->with('location', 'admisiones');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AreaexamenadmisionRequest $request)
    {
        $area = new Areaexamenadmision($request->all());
        $u = Auth::user();
        foreach ($area->attributesToArray() as $key => $value) {
            $area->$key = strtoupper($value);
        }
        $area->user_change = $u->identificacion;
        $result = $area->save();
        if ($result) {
            $aud = new Auditoriaadmision();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "INSERTAR";
            $str = "CREACIÓN DE ÁREAS DE EXÁMEN DE ADMISIÓN. DATOS: ";
            foreach ($area->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("El área fue almacenada de forma exitosa!")->success();
            return redirect()->route('areaexamenadmision.index');
        } else {
            flash("El área no pudo ser almacenada. Error: " . $result)->error();
            return redirect()->route('areaexamenadmision.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Areaexamenadmision  contrato
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Areaexamenadmision  areas
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $area = Areaexamenadmision::find($id);
        return view('admisiones.agenda_entrevista.area_examen_admision.edit')
            ->with('location', 'admisiones')
            ->with('area', $area);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Areaexamenadmision  contrato
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $area = Areaexamenadmision::find($id);
        $m = new Areaexamenadmision($area->attributesToArray());
        foreach ($area->attributesToArray() as $key => $value) {
            if (isset($request->$key)) {
                $area->$key =strtoupper($request->$key);
            }
        }
        $u = Auth::user();
        $area->user_change = $u->identificacion;
        $result = $area->save();
        if ($result) {
            $aud = new Auditoriaadmision();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ACTUALIZAR DATOS";
            $str = "EDICION DE LAS ÁREAS DE EXAMEN DE ADMISIÓN. DATOS NUEVOS: ";
            $str2 = " DATOS ANTIGUOS: ";
            foreach ($m->attributesToArray() as $key => $value) {
                $str2 = $str2 . ", " . $key . ": " . $value;
            }
            foreach ($area->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str . " - " . $str2;
            $aud->save();
            flash("El área fue modificada de forma exitosa!")->success();
            return redirect()->route('areaexamenadmision.index');
        } else {
            flash("El área no pudo ser modificada. Error: " . $result)->error();
            return redirect()->route('areaexamenadmision.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Circunscripcion  areas
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $area = Areaexamenadmision::find($id);
        if (count($area->areaexamenadmisiongrados) > 0) {
            flash("El área no puede ser eliminada porque tiene parametrización de grado y peso asociados")->warning();
            return redirect()->route('areaexamenadmision.index');
        }
        $result = $area->delete();
        if ($result) {
            $aud = new Auditoriaadmision();
            $u = Auth::user();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ELIMINAR";
            $str = "ELIMINACIÓN DE LAS ÁREAS DEL EXAMEN DE ADMISIÓN. DATOS ELIMINADOS: ";
            foreach ($area->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("El área fue eliminada de forma exitosa!")->success();
            return redirect()->route('areaexamenadmision.index');
        } else {
            flash("El área no pudo ser eliminada. Error: " . $result)->error();
            return redirect()->route('areaexamenadmision.index');
        }
    }
}
