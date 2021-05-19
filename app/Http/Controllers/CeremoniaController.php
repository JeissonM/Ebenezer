<?php

namespace App\Http\Controllers;

use App\Auditoriaacademico;
use App\Ceremonia;
use App\Grado;
use App\Jornada;
use App\Periodoacademico;
use App\Unidad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CeremoniaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ceremonias = Ceremonia::all();
        return view('academico.registro_academico.grados.ceremonia.list')
            ->with('location', 'academico')
            ->with('ceremonias', $ceremonias);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $periodos = $unidades = $jornadas = null;
        $unds = Unidad::all();
        $perds = Periodoacademico::all()->sortByDesc('anio');
        if (count($perds) > 0) {
            foreach ($perds as $p) {
                $periodos[$p->id] = $p->etiqueta . " - " . $p->anio;
            }
        } else {
            flash("No hay períodos académicos")->error();
            return redirect()->route('menu.academico');
        }
        if (count($unds) > 0) {
            foreach ($unds as $u) {
                $unidades[$u->id] = $u->nombre . " - " . $u->descripcion . " - " . $u->ciudad->nombre;
            }
        } else {
            flash("No hay unidades o sedes definidas")->error();
            return redirect()->route('menu.academico');
        }
        $grados = Grado::all()->pluck('etiqueta', 'id');
        $jnds = Jornada::all();
        if (count($jnds) > 0) {
            foreach ($jnds as $j) {
                $jornadas[$j->id] = $j->descripcion . " - " . $j->jornadasnies;
            }
        } else {
            flash("No hay jornadas académicas definidas")->error();
            return redirect()->route('menu.academico');
        }
        if (count($grados) <= 0) {
            flash("No hay grados académicos definidos")->error();
            return redirect()->route('menu.academico');
        }
        return view('academico.registro_academico.grados.ceremonia.create')
            ->with('location', 'academico')
            ->with('jornadas', $jornadas)
            ->with('periodos', $periodos)
            ->with('unidades', $unidades)
            ->with('grados', $grados);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $ceremonia = new Ceremonia($request->all());
        foreach ($ceremonia->attributesToArray() as $key => $value) {
            $ceremonia->$key = strtoupper($value);
        }
        $u = Auth::user();
        $ceremonia->user_change = $u->identificacion;
        $result = $ceremonia->save();
        if ($result) {
            $aud = new Auditoriaacademico();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "INSERTAR";
            $str = "CREACIÓN DE CEREMONIA. DATOS: ";
            foreach ($ceremonia->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("La ceremonia <strong>" . $ceremonia->titulo . "</strong> fue almacenada de forma exitosa!")->success();
            return redirect()->route('ceremonia.index');
        } else {
            flash("El ceremonia <strong>" . $ceremonia->titulo . "</strong> no pudo ser almacenada. Error: " . $result)->error();
            return redirect()->route('ceremonia.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Ceremonia $ceremonia
     * @return \Illuminate\Http\Response
     */
    public function show(Ceremonia $ceremonia)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Ceremonia $ceremonia
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $periodos = $unidades = $jornadas = null;
        $perds = Periodoacademico::all()->sortByDesc('anio');
        if (count($perds) > 0) {
            foreach ($perds as $p) {
                $periodos[$p->id] = $p->etiqueta . " - " . $p->anio;
            }
        } else {
            flash("No hay períodos académicos")->error();
            return redirect()->route('menu.academico');
        }
        $unds = Unidad::all();
        if (count($unds) > 0) {
            foreach ($unds as $u) {
                $unidades[$u->id] = $u->nombre . " - " . $u->descripcion . " - " . $u->ciudad->nombre;
            }
        } else {
            flash("No hay unidades o sedes definidas")->error();
            return redirect()->route('menu.academico');
        }
        $grados = Grado::all()->pluck('etiqueta', 'id');
        $jnds = Jornada::all();
        if (count($jnds) > 0) {
            foreach ($jnds as $j) {
                $jornadas[$j->id] = $j->descripcion . " - " . $j->jornadasnies;
            }
        } else {
            flash("No hay jornadas académicas definidas")->error();
            return redirect()->route('menu.academico');
        }
        if (count($grados) <= 0) {
            flash("No hay grados académicos definidos")->error();
            return redirect()->route('menu.academico');
        }
        $ceremonia = Ceremonia::find($id);
        return view('academico.registro_academico.grados.ceremonia.edit')
            ->with('location', 'academico')
            ->with('periodos', $periodos)
            ->with('ceremonia', $ceremonia)
            ->with('jornadas', $jornadas)
            ->with('unidades', $unidades)
            ->with('grados', $grados);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Ceremonia $ceremonia
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $ceremonia = Ceremonia::find($id);
        $m = new Ceremonia($ceremonia->attributesToArray());
        foreach ($ceremonia->attributesToArray() as $key => $value) {
            if (isset($request->$key)) {
                $ceremonia->$key = strtoupper($request->$key);
            }
        }
        $u = Auth::user();
        $ceremonia->user_change = $u->identificacion;
        $result = $ceremonia->save();
        if ($result) {
            $aud = new Auditoriaacademico();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ACTUALIZAR DATOS";
            $str = "EDICION DE CEREMONIA. DATOS NUEVOS: ";
            $str2 = " DATOS ANTIGUOS: ";
            foreach ($m->attributesToArray() as $key => $value) {
                $str2 = $str2 . ", " . $key . ": " . $value;
            }
            foreach ($ceremonia->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str . " - " . $str2;
            $aud->save();
            flash("La ceremonia <strong>" . $ceremonia->titulo . "</strong> fue modificada de forma exitosa!")->success();
            return redirect()->route('ceremonia.index');
        } else {
            flash("La ceremonia <strong>" . $ceremonia->titulo . "</strong> no pudo ser modificada. Error: " . $result)->error();
            return redirect()->route('ceremonia.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Ceremonia $ceremonia
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ceremonia = Ceremonia::find($id);
//        if (count($ceremonia->evaluacionacademicas) > 0) {
//            flash("El Sistema de evaluación <strong>" . $ceremonia->nombre . "</strong> no pudo ser eliminado porque tiene Evaluación Académica asociadas.")->warning();
//            return redirect()->route('sistemaevaluacion.index');
//        } else {
        $result = $ceremonia->delete();
        if ($result) {
            $aud = new Auditoriaacademico();
            $u = Auth::user();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ELIMINAR";
            $str = "ELIMINACIÓN DE CEREMONIA DE GRADO. DATOS ELIMINADOS: ";
            foreach ($ceremonia->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("La ceremonia <strong>" . $ceremonia->titulo . "</strong> fue eliminado de forma exitosa!")->success();
            return redirect()->route('ceremonia.index');
        } else {
            flash("La ceremonia <strong>" . $ceremonia->titulo . "</strong> no pudo ser eliminado. Error: " . $result)->error();
            return redirect()->route('ceremonia.index');
        }
        //}
    }
}
