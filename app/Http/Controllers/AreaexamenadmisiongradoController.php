<?php

namespace App\Http\Controllers;

use App\Areaexamenadmisiongrado;
use Illuminate\Http\Request;
use App\Areaexamenadmision;
use App\Grado;
use Illuminate\Support\Facades\Auth;
use App\Auditoriaadmision;
use App\Http\Requests\AreaexamenadmisiongradoRequest;

class AreaexamenadmisiongradoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $areasg = Areaexamenadmisiongrado::all();
        return view('admisiones.agenda_entrevista.area_examen_admision_grado.list')
            ->with('location', 'admisiones')
            ->with('areasg', $areasg);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $grados = Grado::all()->pluck('etiqueta', 'id');
        $areas = Areaexamenadmision::all()->pluck('nombre', 'id');
        return view('admisiones.agenda_entrevista.area_examen_admision_grado.create')
            ->with('location', 'admisiones')
            ->with('grados', $grados)
            ->with('areas', $areas);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AreaexamenadmisiongradoRequest $request)
    {
        if ($this->verificar($request->grado_id) >= 100) {
            flash("El grado ya tiene el total de los pesos permitidos, no se guardó el nuevo peso")->error();
            return redirect()->route('areaexamenadmisiongrado.index');
        }
        if ($this->verificar($request->grado_id) + $request->peso > 100) {
            flash("El peso que desea guardar sobrepasa los 100, no se pudo guardar.")->error();
            return redirect()->route('areaexamenadmisiongrado.index');
        }
        $area = new Areaexamenadmisiongrado($request->all());
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
            $str = "CREACIÓN DE PESOS DE ÁREAS DE EXÁMEN DE ADMISIÓN. DATOS: ";
            foreach ($area->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("El peso para el área fue almacenado de forma exitosa!")->success();
            return redirect()->route('areaexamenadmisiongrado.index');
        } else {
            flash("El peso para el área no pudo ser almacenado. Error: " . $result)->error();
            return redirect()->route('areaexamenadmisiongrado.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Areaexamenadmisiongrado  $areaexamenadmisiongrado
     * @return \Illuminate\Http\Response
     */
    public function show(Areaexamenadmisiongrado $areaexamenadmisiongrado)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Areaexamenadmisiongrado  $areaexamenadmisiongrado
     * @return \Illuminate\Http\Response
     */
    public function edit(Areaexamenadmisiongrado $areaexamenadmisiongrado)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Areaexamenadmisiongrado  $areaexamenadmisiongrado
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Areaexamenadmisiongrado $areaexamenadmisiongrado)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Areaexamenadmisiongrado  $areaexamenadmisiongrado
     * @return \Illuminate\Http\Response
     */
    public function destroy(Areaexamenadmisiongrado $areaexamenadmisiongrado)
    {
        //
    }

    //verifica si los pesos de un grado suman 100
    public function pesos($id)
    {
        $g = Grado::find($id);
        $hay = 0;
        $pesos = $g->areaexamenadmisiongrados;
        if (count($pesos) > 0) {
            foreach ($pesos as $p) {
                $hay = $hay + $p->peso;
            }
        }
        return json_encode($hay);
    }

    //verifica si se pasa de los 100
    public function verificar($id)
    {
        $g = Grado::find($id);
        $hay = 0;
        $pesos = $g->areaexamenadmisiongrados;
        if (count($pesos) > 0) {
            foreach ($pesos as $p) {
                $hay = $hay + $p->peso;
            }
        }
        return $hay;
    }
}
