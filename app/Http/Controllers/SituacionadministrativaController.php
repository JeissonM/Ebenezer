<?php

namespace App\Http\Controllers;

use App\Situacionadministrativa;
use Illuminate\Http\Request;
use App\Auditoriaacademico;
use App\Http\Requests\SituacionadministrativaRequest;
use App\Situacionestudiante;
use Illuminate\Support\Facades\Auth;

class SituacionadministrativaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sa = Situacionadministrativa::all();
        return view('academico.carga_administrativa.situacionadministrativa.list')
            ->with('location', 'academico')
            ->with('sa', $sa);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('academico.carga_administrativa.situacionadministrativa.create')
            ->with('location', 'academico');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SituacionadministrativaRequest $request)
    {
        $sa = new Situacionadministrativa($request->all());
        foreach ($sa->attributesToArray() as $key => $value) {
            $sa->$key = strtoupper($value);
        }
        $u = Auth::user();
        $sa->user_change = $u->identificacion;
        $result = $sa->save();
        if ($result) {
            $this->setAuditoria('INSERTAR', 'CREACIÓN DE SITUACIÓN ADMINISTRATIVA. DATOS: ', $sa);
            flash("La Situación administrativa <strong>" . $sa->nombre . "</strong> fue almacenada de forma exitosa!")->success();
            return redirect()->route('situacionadministrativa.index');
        } else {
            flash("La Situación administrativa <strong>" . $sa->nombre . "</strong> no pudo ser almacenada. Error: " . $result)->error();
            return redirect()->route('situacionadministrativa.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\sa  $sa
     * @return \Illuminate\Http\Response
     */
    public function show($sa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\sa  $sa
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $sa = Situacionadministrativa::find($id);
        return view('academico.carga_administrativa.situacionadministrativa.edit')
            ->with('location', 'academico')
            ->with('sa', $sa);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\sa  $sa
     * @return \Illuminate\Http\Response
     */
    public function update($request, Situacionadministrativa $sa)
    {
        //
    }

    //Actualiza
    public function actualizar(Request $request)
    {
        $sa = Situacionadministrativa::find($request->id);
        $m = new Situacionadministrativa($sa->attributesToArray());
        foreach ($sa->attributesToArray() as $key => $value) {
            if (isset($request->$key)) {
                if ($key != 'id') {
                    $sa->$key = strtoupper($request->$key);
                }
            }
        }
        $u = Auth::user();
        $sa->user_change = $u->identificacion;
        $result = $sa->save();
        if ($result) {
            $aud = new Auditoriaacademico();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ACTUALIZAR DATOS";
            $str = "EDICION DE LA SITUACIÓN ESTUDIANTE. DATOS NUEVOS: ";
            $str2 = " DATOS ANTIGUOS: ";
            foreach ($m->attributesToArray() as $key => $value) {
                $str2 = $str2 . ", " . $key . ": " . $value;
            }
            foreach ($sa->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str . " - " . $str2;
            $aud->save();
            flash("La Situación administrativa <strong>" . $sa->nombre . "</strong> fue modificada de forma exitosa!")->success();
            return redirect()->route('situacionadministrativa.index');
        } else {
            flash("La Situación administrativa <strong>" . $sa->nombre . "</strong> no pudo ser modificada. Error: " . $result)->error();
            return redirect()->route('situacionadministrativa.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\sa  $sa
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sa = Situacionadministrativa::find($id);
        $result = $sa->delete();
        if ($result) {
            $this->setAuditoria('ELIMINAR', 'ELIMINACIÓN DE LA SITUACIÓN ADMINISTRATIVA. DATOS ELIMINADOS: ', $sa);
            flash("La Situación administrativa <strong>" . $sa->nombre . "</strong> fue eliminada de forma exitosa!")->success();
            return redirect()->route('situacionadministrativa.index');
        } else {
            flash("La Situación administrativa <strong>" . $sa->nombre . "</strong> no pudo ser eliminada. Error: " . $result)->error();
            return redirect()->route('situacionadministrativa.index');
        }
        //        }
    }

    //set auditoria
    public function setAuditoria($operacion, $titulo, $data)
    {
        $u = Auth::user();
        $aud = new Auditoriaacademico();
        $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
        $aud->operacion = $operacion;
        $str = $titulo;
        foreach ($data->attributesToArray() as $key => $value) {
            $str = $str . ", " . $key . ": " . $value;
        }
        $aud->detalles = $str;
        $aud->save();
    }
}
