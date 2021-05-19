<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jornada;
use App\Periodoacademico;
use App\Unidad;
use App\Grado;
use App\Gradomateria;
use App\Materia;
use App\Auditoriaacademico;
use App\Grupo;
use App\Grupomateriadocente;
use Illuminate\Support\Facades\Auth;

class CargagradoController extends Controller
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
        return view('academico.cargaacademica.carga_grados.list')
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        $gm = Gradomateria::find($id);
        if ($gm->delete()) {
            $this->setAuditoria('ELIMINAR', 'ELIMINA CARGA ACADÉMICA, MATERIA DE GRADO. DATOS ELIMINADOS: ', $gm);
            flash('Materia retirada con exito')->success();
            return redirect()->route('cargagrados.continuar', [$gm->unidad_id, $gm->periodoacademico_id, $gm->jornada_id, $gm->grado_id]);
        } else {
            flash('La materia no pudo ser retirada')->error();
            return redirect()->route('cargagrados.continuar', [$gm->unidad_id, $gm->periodoacademico_id, $gm->jornada_id, $gm->grado_id]);
        }
    }

    //continua hacia la gestion de carga
    public function continuar($u, $p, $j, $g)
    {
        $materias = Materia::all();
        $materiassi = Gradomateria::where([['unidad_id', $u], ['periodoacademico_id', $p], ['jornada_id', $j], ['grado_id', $g]])->get();
        return view('academico.cargaacademica.carga_grados.gestion')
            ->with('location', 'academico')
            ->with('periodo', Periodoacademico::find($p))
            ->with('jornada', Jornada::find($j))
            ->with('unidad', Unidad::find($u))
            ->with('grado', Grado::find($g))
            ->with('materiassi', $materiassi)
            ->with('materias', $materias);
    }

    //auditoria
    public function setAuditoria($operacion, $title, $obj)
    {
        $u = Auth::user();
        $aud = new Auditoriaacademico();
        $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
        $aud->operacion = $operacion;
        $str = $title;
        foreach ($obj->attributesToArray() as $key => $value) {
            $str = $str . ", " . $key . ": " . $value;
        }
        $aud->detalles = $str;
        $aud->save();
    }

    //agrega una materia a un grado
    public function agregar($u, $p, $j, $g, $m, $peso)
    {
        $old = Gradomateria::where([['unidad_id', $u], ['periodoacademico_id', $p], ['jornada_id', $j], ['grado_id', $g], ['materia_id', $m]])->get();
        if (count($old) > 0) {
            flash('La materia ya está asociada al grado.')->warning();
            return redirect()->route('cargagrados.continuar', [$u, $p, $j, $g]);
        }
        $gm = new Gradomateria();
        $gm->unidad_id = $u;
        $gm->periodoacademico_id = $p;
        $gm->jornada_id = $j;
        $gm->grado_id = $g;
        $gm->materia_id = $m;
        $gm->peso = $peso;
        $user = Auth::user();
        $gm->user_change = $user->identificacion;
        if ($gm->save()) {
            $grupos = null;
            $grupos = Grupo::where([['unidad_id', $u], ['periodoacademico_id', $p], ['jornada_id', $j], ['grado_id', $g]])->get();
            if ($grupos != null) {
                foreach ($grupos as $gr) {
                    $gmd = new Grupomateriadocente();
                    $gmd->user_change = $user->identificacion;
                    $gmd->gradomateria_id = $gm->id;
                    $gmd->docente_id = null;
                    $gmd->grupo_id = $gr->id;
                    if ($gmd->save()) {
                        $this->setAuditoria('INSERTAR', 'AGREGAR CARGA ACADÉMICA, MATERIA A GRUPO Y DOCENTE. DATOS NUEVOS: ', $gmd);
                    }
                }
            }
            $this->setAuditoria('INSERTAR', 'AGREGAR CARGA ACADÉMICA, MATERIA A GRADO. DATOS NUEVOS: ', $gm);
            flash('Materia asociada con exito')->success();
            return redirect()->route('cargagrados.continuar', [$u, $p, $j, $g]);
        } else {
            flash('La materia no pudo ser asociada')->error();
            return redirect()->route('cargagrados.continuar', [$u, $p, $j, $g]);
        }
    }
}
