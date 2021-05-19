<?php

namespace App\Http\Controllers;

use App\Asignarrequisitogrado;
use App\Auditoriaacademico;
use App\Ceremonia;
use App\Ceremoniaestudiante;
use App\Estudiante;
use App\Grado;
use App\Jornada;
use App\Periodoacademico;
use App\Requisitogrado;
use App\Unidad;
use App\Verificarrequisitogrado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CeremoniaestudianteController extends Controller
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
        return view('academico.registro_academico.grados.ceremonia_estudiante.list')
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Ceremoniaestudiante $ceremoniaestudiante
     * @return \Illuminate\Http\Response
     */
    public function show(Ceremoniaestudiante $ceremoniaestudiante)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Ceremoniaestudiante $ceremoniaestudiante
     * @return \Illuminate\Http\Response
     */
    public function edit(Ceremoniaestudiante $ceremoniaestudiante)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Ceremoniaestudiante $ceremoniaestudiante
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ceremoniaestudiante $ceremoniaestudiante)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Ceremoniaestudiante $ceremoniaestudiante
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ceremoniaestudiante $ceremoniaestudiante)
    {
        //
    }

    public function getCeremonia($und, $per, $jor, $gra)
    {
        $ceremonia = Ceremonia::where([['unidad_id', $und], ['periodoacademico_id', $per], ['jornada_id', $jor], ['grado_id', $gra]])->get();
        if ($ceremonia != null) {
            if (count($ceremonia) > 0) {
                $response = null;
                foreach ($ceremonia as $value) {
                    $obj['id'] = $value->id;
                    $obj['value'] = $value->titulo . " - " . $value->lugar . " FECHA INICIO: " . $value->fechahorainicio . " FECHA FIN: " . $value->fechahorafin;
                    $response[] = $obj;
                }
                return json_encode($response);
            } else {
                return "null";
            }
        } else {
            return "null";
        }
    }

    public function listarestudiantes($und, $per, $jor, $gra, $cer)
    {
        $estud = Estudiante::where([['unidad_id', $und], ['periodoacademico_id', $per], ['jornada_id', $jor], ['grado_id', $gra]])->get();
        $ceremonia = Ceremonia::find($cer);
        if (count($estud) > 0) {
            foreach ($estud as $e) {
                $aux = $this->verificar($e, $ceremonia);
                $e->requisitos = $aux[0];
                $e->cumplidos = $aux[1];
                $e->cumplio = $aux[2];
            }
            $asinados = Ceremoniaestudiante::where('ceremonia_id', $cer)->get();
            return view('academico.registro_academico.grados.ceremonia_estudiante.asignar')
                ->with('location', 'academico')
                ->with('estudiantes', $estud)
                ->with('ceremonia', $ceremonia)
                ->with('asignados', $asinados);
        }
    }

    public function verificar($est, $cer)
    {
        $requisitos = Asignarrequisitogrado::where([
            ['unidad_id', $cer->unidad_id],
            ['grado_id', $cer->grado_id],
            ['jornada_id', $cer->jornada_id]
        ])->count();
        $req_cumplidos = Verificarrequisitogrado::where([
            ['estudiante_id', $est->id],
            ['periodoacademico_id', $cer->periodoacademico_id]
        ])->count();
        if ($requisitos == $req_cumplidos) {
            $array = [$requisitos, $req_cumplidos, "SI"];
            return $array;
        } else {
            $array = [$requisitos, $req_cumplidos, "NO"];
            return $array;
        }
    }

    public function agregar($est, $cer)
    {
        $c = Ceremonia::find($cer);
        $e = Estudiante::find($est);
        $existe = Ceremoniaestudiante::where([['estudiante_id', $est], ['ceremonia_id', $cer]])->first();
        if ($existe != null) {
            flash("El estudiante <strong>" . $e->personanatural->primer_nombre . " " . $e->personanatural->primer_apellido . "</strong> ya se encuentra registrado.")->warning();
            return redirect()->route('ceremoniaestudiante.listar', [$c->unidad_id, $c->periodo_id, $c->jornada_id, $c->grado_id, $cer]);
        }
        $cer_est = new Ceremoniaestudiante();
        $cer_est->estudiante_id = $est;
        $cer_est->ceremonia_id = $cer;
        $u = Auth::user();
        $cer_est->user_change = $u->identificacion;
        $result = $cer_est->save();
        if ($result) {
            $aud = new Auditoriaacademico();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "INSERTAR";
            $str = "ASIGNAR ESTUDIANTE A CEREMONIA. DATOS: ";
            foreach ($cer_est->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("El estudiante <strong>" . $e->personanatural->primer_nombre . " " . $e->personanatural->primer_apellido . "</strong> fue asignado de forma exitosa!")->success();
            return redirect()->route('ceremoniaestudiante.listar', [$c->unidad_id, $c->periodoacademico_id, $c->jornada_id, $c->grado_id, $cer]);
        } else {
            flash("El estudiante <strong>" . $e->personanatural->primer_nombre . " " . $e->personanatural->primer_apellido . "</strong> no pudo ser asignado correctamente. Error:" . $result)->error();
            return redirect()->route('ceremoniaestudiante.listar', [$c->unidad_id, $c->periodoacademico_id, $c->jornada_id, $c->grado_id, $cer]);
        }
    }

    public function retirar($id){
        $cer_est = Ceremoniaestudiante::find($id);
        $result = $cer_est->delete();
        if($result){
            $aud = new Auditoriaacademico();
            $u = Auth::user();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ELIMINAR";
            $str = "ELIMINACIÓN DE ESTUDIANTE A CEREMONIA. DATOS ELIMINADOS: ";
            foreach ($cer_est->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("El estudiante <strong>" . $cer_est->estudiante->personanatural->primer_nombre . " " . $cer_est->estudiante->personanatural->primer_apellido . "</strong> fue retirado de forma exitosa!")->success();
            return redirect()->route('ceremoniaestudiante.listar', [$cer_est->ceremonia->unidad_id, $cer_est->ceremonia->periodoacademico_id, $cer_est->ceremonia->jornada_id, $cer_est->ceremonia->grado_id, $cer_est->ceremonia_id]);
        }else{
            flash("El estudiante <strong>" . $cer_est->estudiante->personanatural->primer_nombre . " " . $cer_est->estudiante->personanatural->primer_apellido . "</strong> fue retirado de forma exitosa!")->success();
            return redirect()->route('ceremoniaestudiante.listar', [$cer_est->ceremonia->unidad_id, $cer_est->ceremonia->periodoacademico_id, $cer_est->ceremonia->jornada_id, $cer_est->ceremonia->grado_id, $cer_est->ceremonia_id]);
        }
    }
}
