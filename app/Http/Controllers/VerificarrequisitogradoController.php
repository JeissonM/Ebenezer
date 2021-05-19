<?php

namespace App\Http\Controllers;

use App\Asignarrequisitogrado;
use App\Auditoriaacademico;
use App\Estudiante;
use App\Grado;
use App\Jornada;
use App\Periodoacademico;
use App\Unidad;
use App\Verificarrequisitogrado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerificarrequisitogradoController extends Controller
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
        return view('academico.registro_academico.grados.verificar_requisitos.list')
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
     * @param \App\Verificarrequisitogrado $verificarrequisitogrado
     * @return \Illuminate\Http\Response
     */
    public function show(Verificarrequisitogrado $verificarrequisitogrado)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Verificarrequisitogrado $verificarrequisitogrado
     * @return \Illuminate\Http\Response
     */
    public function edit(Verificarrequisitogrado $verificarrequisitogrado)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Verificarrequisitogrado $verificarrequisitogrado
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Verificarrequisitogrado $verificarrequisitogrado)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Verificarrequisitogrado $verificarrequisitogrado
     * @return \Illuminate\Http\Response
     */
    public function destroy(Verificarrequisitogrado $verificarrequisitogrado)
    {
        //
    }

    /**
     * Lista todos los estudiantes para un grado,perido,unidad y jornadd
     */
    public function listarEstudiantes($und, $per, $jor, $gra)
    {
        $estudiantes = Estudiante::where([['unidad_id', $und], ['periodoacademico_id', $per], ['jornada_id', $jor], ['grado_id', $gra]])->get();
        if (count($estudiantes) > 0) {
            return view('academico.registro_academico.grados.verificar_requisitos.estudiantes')
                ->with('location', 'academico')
                ->with('periodo', Periodoacademico::find($per))
                ->with('jornada', Jornada::find($jor))
                ->with('unidad', Unidad::find($und))
                ->with('grado', Grado::find($gra))
                ->with('estudiantes', $estudiantes);
        } else {
            flash("No hay estudiantes para los parámetros indicados")->error();
            return redirect()->route('verificarrequisitogrado.index');
        }
    }

    public function listarRequisitos($est, $per, $jor, $und, $gra)
    {
        $a = Estudiante::find($est);
        $requisitos = Asignarrequisitogrado::where([['grado_id', $gra], ['unidad_id', $und],
            ['jornada_id', $jor]])->get();
        $verificados = $a->verificarrequisitogrados;
        if (count($requisitos) > 0) {
            foreach ($requisitos as $r) {
                $esta = 'NO';
                $req = "";
                if (count($verificados) > 0) {
                    foreach ($verificados as $v) {
                        if ($v->asignarrequisitogrado->requisitogrado_id == $r->requisitogrado_id) {
                            $esta = "SI";
                            $req = $v->id;
                        }
                    }
                }
                $r->requisito = $req;
                $r->esta = $esta;
            }
            return view('academico.registro_academico.grados.verificar_requisitos.verificar')
                ->with('location', 'academico')
                ->with('a', $a)
                ->with('periodo', Periodoacademico::find($per))
                ->with('jornada', Jornada::find($jor))
                ->with('unidad', Unidad::find($und))
                ->with('grado', Grado::find($gra))
                ->with('requisitos', $requisitos);
        } else {
            flash("No hay requisitos establecidos para el estudiante seleccionado")->error();
            return redirect()->route('verificarrequisitogrado.listar', [$a->unidad_id, $a->periodoacademico_id, $a->jornada_id, $a->grado_id]);
        }
    }

    public function check($estudiante, $asignarrequ, $per, $jor, $und, $gra)
    {
        $est = Estudiante::find($estudiante);
        $verificar = new Verificarrequisitogrado();
        $verificar->estudiante_id = $estudiante;
        $verificar->asignarrequisitogrado_id = $asignarrequ;
        $verificar->periodoacademico_id = $per;
        $u = Auth::user();
        $verificar->user_change = $u->identificacion;
        $result = $verificar->save();
        if ($result) {
            $aud = new Auditoriaacademico();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "INSERTAR";
            $str = "CREACIÓN DE CHECK DE REQUISITOS DE GRADO. DATOS: ";
            foreach ($verificar->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("El requisito fue verificado de forma exitosa!")->success();
            return redirect()->route('verificarrequisitogrado.listarrequisitos', [$est, $per, $jor, $und, $gra]);
        } else {
            flash("El requisito no pudo ser verificado. Error: " . $result)->error();
            return redirect()->route('verificarrequisitogrado.listarrequisitos', [$est, $per, $jor, $und, $gra]);
        }
    }

    //remueve el requisito cumplido
    public function removeRequisito($id, $per, $jor, $und, $gra)
    {
        $v = Verificarrequisitogrado::find($id);
        $result = $v->delete();
        if ($result) {
            $aud = new Auditoriaacademico();
            $u = Auth::user();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ELIMINAR";
            $str = "ELIMINACIÓN DE REQUISITO DE GRADO VERIFICADO. DATOS ELIMINADOS: ";
            foreach ($v->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("El requisito fue retirado de forma exitosa!")->success();
            return redirect()->route('verificarrequisitogrado.listarrequisitos', [$v->estudiante_id, $per, $jor, $und, $gra]);
        } else {
            flash("El requisito no pudo ser retirado. Error: " . $result)->error();
            return redirect()->route('verificarrequisitogrado.listarrequisitos', [$v->estudiante_id, $per, $jor, $und, $gra]);
        }
    }
}
