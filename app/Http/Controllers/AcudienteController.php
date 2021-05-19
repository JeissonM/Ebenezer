<?php

namespace App\Http\Controllers;

use App\Acudiente;
use App\Acudienteestudiante;
use App\Auditoriaacademico;
use App\Estudiante;
use App\Personanatural;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AcudienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($estudiante_id)
    {
        $a = Estudiante::find($estudiante_id);
        $pn = $a->personanatural;
        $acudientes = Acudienteestudiante::where('estudiante_id', $estudiante_id)->get();
        return view('academico.registro_academico.hoja_de_vida_estudiante.acudientes.list')
            ->with('location', 'academico')
            ->with('a', $a)
            ->with('pn', $pn)
            ->with('acudientes', $acudientes);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($estudiante_id)
    {
        $a = Estudiante::find($estudiante_id);
        $pn = $a->personanatural;
        $personas = Personanatural::all();
        $acudientes = $a->acudienteestudiantes;
        return view('academico.registro_academico.hoja_de_vida_estudiante.acudientes.create')
            ->with('location', 'academico')
            ->with('a', $a)
            ->with('pn', $pn)
            ->with('personas', $personas)
            ->with('acudientes', $acudientes);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Acudiente $acudiente
     * @return \Illuminate\Http\Response
     */
    public function show(Acudiente $acudiente)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Acudiente $acudiente
     * @return \Illuminate\Http\Response
     */
    public function edit(Acudiente $acudiente)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Acudiente $acudiente
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Acudiente $acudiente)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Acudiente $acudiente
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $acudiente = Acudienteestudiante::find($id);
        $result = $acudiente->delete();
        if ($result) {
            $aud = new Auditoriaacademico();
            $u = Auth::user();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ELIMINAR";
            $str = "ELIMINACIÓN DE ACUDIENTE ESTUDIANTE. DATOS: ";
            foreach ($acudiente->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("El Acudiente fue eliminado de forma exitosa!")->success();
            return redirect()->route('acudientes.inicio', $acudiente->estudiante_id);
        } else {
            flash("El Acudiente no pudo ser eliminado. Error:" . $result)->error();
            return redirect()->route('acudientes.inicio', $acudiente->estudiante_id);
        }
    }

    public function agregar($personanatural_id, $estudiante_id)
    {
        $existe = Acudienteestudiante::where([['estudiante_id', $estudiante_id], ['personanatural_id', $personanatural_id]])->first();
        if ($existe != null) {
            flash("La persona seleccionada ya es acudiente del estudiante seleccionado.")->warning();
            return redirect()->route('acudientes.crear', $estudiante_id);
        }
        $acudiente = new Acudienteestudiante();
        $acudiente->estudiante_id = $estudiante_id;
        $acudiente->personanatural_id = $personanatural_id;
        $u = Auth::user();
        $acudiente->user_change = $u->identificacion;
        $result = $acudiente->save();
        if ($result) {
            $aud = new Auditoriaacademico();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "INSERTAR";
            $str = "CREACIÓN DE ACUDIENTE ESTUDIANTE. DATOS: ";
            foreach ($acudiente->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("El Acudiente fue almacenado de forma exitosa!")->success();
            return redirect()->route('acudientes.crear', $estudiante_id);
        } else {
            flash("El Acudiente no pudo ser almacenado. Error: " . $result)->error();
            return redirect()->route('acudientes.crear', $estudiante_id);
        }
    }
}
