<?php

namespace App\Http\Controllers;

use App\Auditoriaacademico;
use App\Categoria;
use App\Ceremonia;
use App\Estudiante;
use App\Grado;
use App\Graduarestudiante;
use App\Jornada;
use App\Periodoacademico;
use App\Situacionestudiante;
use App\Unidad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GraduarestudianteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $periodos = $unidades = $jornadas = null;
        $perds = Periodoacademico::all()->sortByDesc('anio');
        if (count($perds) > 0) {
            foreach ($perds as $p) {
                $periodos[$p->id] = $p->etiqueta . " - " . $p->anio;
            }
        } else {
            flash("No hay períodos académicos")->error();
            return redirect()->route('menu.admisiones');
        }
        $unds = Unidad::all();
        if (count($unds) > 0) {
            foreach ($unds as $u) {
                $unidades[$u->id] = $u->nombre . " - " . $u->descripcion . " - " . $u->ciudad->nombre;
            }
        } else {
            flash("No hay unidades o sedes definidas")->error();
            return redirect()->route('menu.admisiones');
        }
        $grados = Grado::all()->pluck('etiqueta', 'id');
        $jnds = Jornada::all();
        if (count($jnds) > 0) {
            foreach ($jnds as $j) {
                $jornadas[$j->id] = $j->descripcion . " - " . $j->jornadasnies;
            }
        } else {
            flash("No hay jornadas académicas definidas")->error();
            return redirect()->route('menu.admisiones');
        }
        if (count($grados) <= 0) {
            flash("No hay grados académicos definidos")->error();
            return redirect()->route('menu.admisiones');
        }
        return view('academico.registro_academico.grados.graduar_estudiante.list')
            ->with('location', 'academico')
            ->with('periodos', $periodos)
            ->with('jornadas', $jornadas)
            ->with('unidades', $unidades)
            ->with('grados', $grados);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (isset($request->estudiantes)) {
            $seleccionados = count($request->estudiantes);
            $procesados = $noprocesados = 0;
            $exitos = "<h3>Graduados Correctamente</h3>";
            $error = "<h3>No Graduados</h3>";
            $response = null;
            foreach ($request->estudiantes as $item) {
                $e = Estudiante::find($item);
                $m = new Estudiante($e->attributesToArray());
                $e->categoria_id = $request->categoria_id;
                $e->situacionestudiante_id = $request->situacionestudiante_id;
                $u = Auth::user();
                $e->user_change = $u->identificacion;
                $result = $e->save();
                if ($result) {
                    $procesados = $procesados + 1;
                    $aud = new Auditoriaacademico();
                    $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
                    $aud->operacion = "ACTUALIZAR DATOS";
                    $str = "EDICION DE ESTUDIANTE (GRADUAR). DATOS NUEVOS: ";
                    $str2 = " DATOS ANTIGUOS: ";
                    foreach ($m->attributesToArray() as $key => $value) {
                        $str2 = $str2 . ", " . $key . ": " . $value;
                    }
                    foreach ($e->attributesToArray() as $key => $value) {
                        $str = $str . ", " . $key . ": " . $value;
                    }
                    $aud->detalles = $str . " - " . $str2;
                    $aud->save();
                    $exitos = $exitos . "<br><strong>" . $procesados . ":</strong>" . $e->personanatural->persona->tipodoc->abreviatura . "-" . $e->personanatural->persona->numero_documento . " " . $e->personanatural->primer_nombre . " " . $e->personanatural->primer_apellido;
                } else {
                    $noprocesados = $noprocesados + 1;
                    $error = $error . "<br><strong>" . $noprocesados . ":</strong>" . $e->personanatural->persona->tipodoc->abreviatura . "-" . $e->personanatural->persona->numero_documento . " " . $e->personanatural->primer_nombre . " " . $e->personanatural->primer_apellido;
                }
            }
            $response = $exitos . "<br>" . $error . "<br><strong>Estudiantes graduados </strong>" . $procesados . "/" . $seleccionados;
            flash($response)->success();
            return redirect()->route('graduarestudiante.listar',$request->ceremonia_id);
        } else {
            flash("Atención!. Debe seleccionar estudiantes para porder realizar el proceso de grado.")->warning();
            return redirect()->route('graduarestudiante.listar',$request->ceremonia_id);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Graduarestudiante $graduarestudiante
     * @return \Illuminate\Http\Response
     */
    public function show($ceremonia_id)
    {
        $ceremonia = Ceremonia::find($ceremonia_id);
        $situaciones = Situacionestudiante::all()->pluck('nombre', 'id');
        $categorias = Categoria::all()->pluck('nombre', 'id');
        $est = $ceremonia->ceremoniaestudiantes;
        return view('academico.registro_academico.grados.graduar_estudiante.create')
            ->with('location', 'academico')
            ->with('ceremonia', $ceremonia)
            ->with('situaciones', $situaciones)
            ->with('categorias', $categorias)
            ->with('estudiantes', $est);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Graduarestudiante $graduarestudiante
     * @return \Illuminate\Http\Response
     */
    public function edit(Graduarestudiante $graduarestudiante)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Graduarestudiante $graduarestudiante
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Graduarestudiante $graduarestudiante)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Graduarestudiante $graduarestudiante
     * @return \Illuminate\Http\Response
     */
    public function destroy(Graduarestudiante $graduarestudiante)
    {
        //
    }
}
