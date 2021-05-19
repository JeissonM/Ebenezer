<?php

namespace App\Http\Controllers;

use App\Area;
use App\Ciclo;
use App\Cicloarea;
use App\Ciclogrado;
use App\Grado;
use App\Http\Requests\CicloRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CicloController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return CrudController::index('App\Ciclo', 'matricula.datos_basicos.ciclos.list', 'matricula');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return CrudController::create('matricula.datos_basicos.ciclos.create', 'matricula', null);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CicloRequest $request)
    {
        return CrudController::store($request, 'App\Ciclo', 'ciclo.index', ['ciclo', 'descripcion'], 'App\Matriculaauditoria');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $areas = Area::pluck('nombre', 'id');
        $ciclo = Ciclo::find($id);
        $ciclo->cicloareas;
        return view('matricula.datos_basicos.ciclos.areas')
            ->with('location', 'matricula')
            ->with('ciclo', $ciclo)
            ->with('areas', $areas);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return CrudController::edit($id, 'App\Ciclo', 'matricula.datos_basicos.ciclos.edit', 'matricula', null);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        return CrudController::update($request, $id, 'App\Ciclo', 'ciclo.index', ['ciclo', 'descripcion'], 'App\Matriculaauditoria');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return CrudController::destroy($id, 'App\Rhconvocatoria', 'rhconvocatorias.index', ['rhconvocatoriadocumentos', 'rhconvocatoriainstrumentos'], 'App\Auditoriarecursoshumano');
    }

    /**
     * Agrega un área al ciclo
     * @param int $id_ciclo, int $id_area
     * @return \Illuminate\Http\Response
     */
    public function agregarArea($id_area, $id_ciclo)
    {
        $ca = new Cicloarea();
        $ca->area_id = $id_area;
        $ca->ciclo_id = $id_ciclo;
        if ($ca->save()) {
            $u = Auth::user();
            $a['usuario'] = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $a['operacion'] = "INSERTAR";
            $str = "CREACIÓN DE ÁREA SOBRE CICLO. DATOS: ";
            foreach ($ca->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $a['detalles'] = $str;
            app('App\Matriculaauditoria')->create($a);
            flash("El registro fue almacenado de forma exitosa!")->success();
            return redirect()->route('ciclo.show', $id_ciclo);
        } else {
            flash("Error al guardar el registro")->error();
            return redirect()->route('ciclo.show', $id_ciclo);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyArea($id)
    {
        $cicloarea = Cicloarea::find($id);
        if ($cicloarea->delete()) {
            $u = Auth::user();
            $a['usuario'] = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $a['operacion'] = "ELIMINAR";
            $str = "ELIMINACIÓN DE ÁREA DE UN CICLO. DATOS ELIMINADOS: ";
            foreach ($cicloarea->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $a['detalles'] = $str;
            app('App\Matriculaauditoria')->create($a);
            flash("El registro fue eliminado de forma exitosa!")->success();
            return redirect()->route('ciclo.show', $cicloarea->ciclo_id);
        } else {
            flash("Error al eliminar el registro")->error();
            return redirect()->route('ciclo.show', $cicloarea->ciclo_id);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function grados($id)
    {
        $grados = Grado::pluck('etiqueta', 'id');
        $ciclo = Ciclo::find($id);
        $ciclo->ciclogrados;
        return view('matricula.datos_basicos.ciclos.grados')
            ->with('location', 'matricula')
            ->with('ciclo', $ciclo)
            ->with('grados', $grados);
    }

    /**
     * Agrega un grado al ciclo
     * @param int $id_ciclo, int $id_grado
     * @return \Illuminate\Http\Response
     */
    public function agregarGrado($id_grado, $id_ciclo)
    {
        $ca = new Ciclogrado();
        $ca->grado_id = $id_grado;
        $ca->ciclo_id = $id_ciclo;
        if ($ca->save()) {
            $u = Auth::user();
            $a['usuario'] = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $a['operacion'] = "INSERTAR";
            $str = "CREACIÓN DE GRADO SOBRE CICLO. DATOS: ";
            foreach ($ca->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $a['detalles'] = $str;
            app('App\Matriculaauditoria')->create($a);
            flash("El registro fue almacenado de forma exitosa!")->success();
            return redirect()->route('ciclo.grados', $id_ciclo);
        } else {
            flash("Error al guardar el registro")->error();
            return redirect()->route('ciclo.grados', $id_ciclo);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyGrado($id)
    {
        $ciclogrado = Ciclogrado::find($id);
        if ($ciclogrado->delete()) {
            $u = Auth::user();
            $a['usuario'] = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $a['operacion'] = "ELIMINAR";
            $str = "ELIMINACIÓN DE GRADO DE UN CICLO. DATOS ELIMINADOS: ";
            foreach ($ciclogrado->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $a['detalles'] = $str;
            app('App\Matriculaauditoria')->create($a);
            flash("El registro fue eliminado de forma exitosa!")->success();
            return redirect()->route('ciclo.grados', $ciclogrado->ciclo_id);
        } else {
            flash("Error al eliminar el registro")->error();
            return redirect()->route('ciclo.grados', $ciclogrado->ciclo_id);
        }
    }
}
