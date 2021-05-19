<?php

namespace App\Http\Controllers;

use App\Docente;
use Illuminate\Http\Request;
use App\Grupo;
use App\Matriculaauditoria;
use Illuminate\Support\Facades\Auth;
use App\Unidad;
use App\Periodoacademico;
use App\Jornada;
use App\Grado;
use App\Http\Requests\GrupoRequest;

class GrupoController extends Controller
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
            return redirect()->route('menu.matricula');
        }
        $unds = Unidad::all();
        if (count($unds) > 0) {
            foreach ($unds as $u) {
                $unidades[$u->id] = $u->nombre . " - " . $u->descripcion . " - " . $u->ciudad->nombre;
            }
        } else {
            flash("No hay unidades o sedes definidas")->error();
            return redirect()->route('menu.matricula');
        }
        $grados = Grado::all()->pluck('etiqueta', 'id');
        $jnds = Jornada::all();
        if (count($jnds) > 0) {
            foreach ($jnds as $j) {
                $jornadas[$j->id] = $j->descripcion . " - " . $j->jornadasnies;
            }
        } else {
            flash("No hay jornadas académicas definidas")->error();
            return redirect()->route('menu.matricula');
        }
        if (count($grados) <= 0) {
            flash("No hay grados académicos definidos")->error();
            return redirect()->route('menu.matricula');
        }
        return view('matricula.matricula.grupos.list')
            ->with('location', 'matricula')
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GrupoRequest $request)
    {
        $g = new Grupo($request->all());
        foreach ($g->attributesToArray() as $key => $value) {
            $g->$key = strtoupper($value);
        }
        $u = Auth::user();
        $g->user_change = $u->identificacion;
        $result = $g->save();
        if ($result) {
            $this->setAuditoriamatricula('INSERTAR', 'CREACIÓN DE GRUPO. DATOS: ', $g);
            flash("El grupo <strong>" . $g->nombre . "</strong> fue almacenado de forma exitosa!")->success();
            return redirect()->route('grupo.continuar', [$request->unidad_id, $request->periodoacademico_id, $request->jornada_id, $request->grado_id]);
        } else {
            flash("El grupo <strong>" . $g->nombre . "</strong> no pudo ser almacenado. Error: " . $result)->error();
            return redirect()->route('grupo.continuar', [$request->unidad_id, $request->periodoacademico_id, $request->jornada_id, $request->grado_id]);
        }
    }

    /*
     * set Auditoria matricula
     */

    public function setAuditoriamatricula($operacion, $string1, $r)
    {
        $u = Auth::user();
        $aud = new Matriculaauditoria();
        $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
        $aud->operacion = $operacion;
        $str = $string1;
        foreach ($r->attributesToArray() as $key => $value) {
            $str = $str . ", " . $key . ": " . $value;
        }
        $aud->detalles = $str;
        $aud->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $g = Grupo::find($id);
        $doc = Docente::all();
        $grupos = Grupo::where([['unidad_id', $g->unidad_id], ['periodoacademico_id', $g->periodoacademico_id], ['jornada_id', $g->jornada_id]])->get();
        $docentes = null;
        if (count($doc) > 0) {
            foreach ($doc as $d) {
                $puede = true;
                if (count($grupos) > 0) {
                    foreach ($grupos as $gr) {
                        if ($d->id == $gr->docente_id) {
                            $puede = false;
                        }
                    }
                }
                if ($puede) {
                    $docentes[] = $d;
                }
            }
        }
        return view('matricula.matricula.grupos.director')
            ->with('location', 'matricula')
            ->with('g', $g)
            ->with('docentes', $docentes);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $g = Grupo::find($id);
        $result = $g->delete();
        if ($result) {
            $this->setAuditoriamatricula('ELIMINAR', 'ELIMINACIÓN DE GRUPO. DATOS ELIMINADOS: ', $g);
            flash("El grupo <strong>" . $g->nombre . "</strong> fue eliminado de forma exitosa!")->success();
            return redirect()->route('grupo.continuar', [$g->unidad_id, $g->periodoacademico_id, $g->jornada_id, $g->grado_id]);
        } else {
            flash("El grupo <strong>" . $g->nombre . "</strong> no pudo ser eliminado. Error: " . $result)->error();
            return redirect()->route('grupo.continuar', [$g->unidad_id, $g->periodoacademico_id, $g->jornada_id, $g->grado_id]);
        }
    }

    //continua hacia la gestion de grupos
    public function continuar($u, $p, $j, $g)
    {
        $grupos = Grupo::where([['unidad_id', $u], ['periodoacademico_id', $p], ['jornada_id', $j], ['grado_id', $g]])->get();
        return view('matricula.matricula.grupos.gestion')
            ->with('location', 'matricula')
            ->with('periodo', Periodoacademico::find($p))
            ->with('jornada', Jornada::find($j))
            ->with('unidad', Unidad::find($u))
            ->with('grado', Grado::find($g))
            ->with('grupos', $grupos);
    }

    //Asigna docente como director de grupo
    public function asignardirector($g, $d)
    {
        $grupo = Grupo::find($g);
        $grupo->docente_id = $d;
        if ($grupo->save()) {
            $this->setAuditoriamatricula('ACTUALIZAR', 'ASIGNAR DIRECTOR A GRUPO. DATOS ACTUALIZADOS: ', $grupo);
            flash("El docente fue asignado como director al grupo <strong>" . $grupo->nombre . "</strong> de forma exitosa!")->success();
            return redirect()->route('grupo.show', $grupo->id);
        } else {
            flash("El docente no pudo ser asignado al grupo <strong>" . $grupo->nombre . "</strong>")->error();
            return redirect()->route('grupo.show', $grupo->id);
        }
    }
}
