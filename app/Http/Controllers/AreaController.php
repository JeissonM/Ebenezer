<?php

namespace App\Http\Controllers;

use App\Area;
use Illuminate\Http\Request;
use App\Http\Requests\AreaRequest;
use Illuminate\Support\Facades\Auth;
use App\Matriculaauditoria;

class AreaController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $areas = Area::all();
        return view('matricula.datos_basicos.areas.list')
            ->with('location', 'matricula')
            ->with('areas', $areas);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('matricula.datos_basicos.areas.create')
            ->with('location', 'matricula');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AreaRequest $request)
    {
        $area = new Area($request->all());
        foreach ($area->attributesToArray() as $key => $value) {
            $area->$key = strtoupper($value);
        }
        $u = Auth::user();
        $area->user_change = $u->identificacion;
        $result = $area->save();
        if ($result) {
            $aud = new Matriculaauditoria();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "INSERTAR";
            $str = "CREACIÓN DE ÁREA. DATOS: ";
            foreach ($area->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("El área <strong>" . $area->nombre . "</strong> fue almacenada de forma exitosa!")->success();
            return redirect()->route('area.index');
        } else {
            flash("El área <strong>" . $area->nombre . "</strong> no pudo ser almacenada. Error: " . $result)->error();
            return redirect()->route('area.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Area  $area
     * @return \Illuminate\Http\Response
     */
    public function show(Area $area)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Area  $area
     * @return \Illuminate\Http\Response
     */
    public function edit(Area $area)
    {
        return view('matricula.datos_basicos.areas.edit')
            ->with('location', 'matricula')
            ->with('a', $area);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Area  $area
     * @return \Illuminate\Http\Response
     */
    public function update(AreaRequest $request, Area $area)
    {
        $m = new Area($area->attributesToArray());
        foreach ($area->attributesToArray() as $key => $value) {
            if (isset($request->$key)) {
                $area->$key = strtoupper($request->$key);
            }
        }
        $u = Auth::user();
        $area->user_change = $u->identificacion;
        $result = $area->save();
        if ($result) {
            $aud = new Matriculaauditoria();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ACTUALIZAR DATOS";
            $str = "EDICION DE ÁREA. DATOS NUEVOS: ";
            $str2 = " DATOS ANTIGUOS: ";
            foreach ($m->attributesToArray() as $key => $value) {
                $str2 = $str2 . ", " . $key . ": " . $value;
            }
            foreach ($area->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str . " - " . $str2;
            $aud->save();
            flash("El área <strong>" . $area->nombre . "</strong> fue modificada de forma exitosa!")->success();
            return redirect()->route('area.index');
        } else {
            flash("El área <strong>" . $area->nombre . "</strong> no pudo ser modificada. Error: " . $result)->error();
            return redirect()->route('area.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Area  $area
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $area = Area::find($id);
        if (count($area->componentes) > 0 || count($area->materias) > 0 || count($area->cicloareas) > 0 || count($area->estandars) > 0) {
            flash("El área <strong>" . $area->nombre . "</strong> no pudo ser eliminada porque tiene datos asociados.")->warning();
            return redirect()->route('area.index');
        } else {
            $result = $area->delete();
            if ($result) {
                $aud = new Matriculaauditoria();
                $u = Auth::user();
                $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
                $aud->operacion = "ELIMINAR";
                $str = "ELIMINACIÓN DE ÁREA. DATOS ELIMINADOS: ";
                foreach ($area->attributesToArray() as $key => $value) {
                    $str = $str . ", " . $key . ": " . $value;
                }
                $aud->detalles = $str;
                $aud->save();
                flash("El área <strong>" . $area->nombre . "</strong> fue eliminada de forma exitosa!")->success();
                return redirect()->route('area.index');
            } else {
                flash("El área <strong>" . $area->nombre . "</strong> no pudo ser eliminada. Error: " . $result)->error();
                return redirect()->route('area.index');
            }
        }
    }
}
