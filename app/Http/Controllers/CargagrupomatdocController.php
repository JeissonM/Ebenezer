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
use App\Docente;
use App\Grupo;
use App\Grupomateriadocente;
use Illuminate\Support\Facades\Auth;

class CargagrupomatdocController extends Controller
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
        return view('academico.cargaacademica.carga_grupomatdoc.list')
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
        $gmd = Grupomateriadocente::find($id);
        if ($gmd->delete()) {
            $this->setAuditoria('ELIMINAR', 'ELIMINA CARGA ACADÉMICA DE MATERIA A DOCENTE Y GRUPO. DATOS ELIMINADOS: ', $gmd);
            flash('Materia retirada con exito')->success();
            return redirect()->route('cargagrupomatdoc.continuar', [$gmd->gradomateria->unidad_id, $gmd->gradomateria->periodoacademico_id, $gmd->gradomateria->jornada_id, $gmd->gradomateria->grado_id, $gmd->grupo_id]);
        } else {
            flash('La materia no pudo ser retirada')->error();
            return redirect()->route('cargagrupomatdoc.continuar', [$gmd->gradomateria->unidad_id, $gmd->gradomateria->periodoacademico_id, $gmd->gradomateria->jornada_id, $gmd->gradomateria->grado_id, $gmd->grupo_id]);
        }
    }

    //grupos para un grado
    public function grupos($u, $p, $j, $g)
    {
        $grupos = Grupo::where([['unidad_id', $u], ['periodoacademico_id', $p], ['jornada_id', $j], ['grado_id', $g]])->get();
        if (count($grupos) > 0) {
            $grs = null;
            foreach ($grupos as $gr) {
                $grs[] = [
                    'id' => $gr->id,
                    'value' => $gr->nombre . " - CUPO: " . $gr->cupo . " - CUPO USADO: " . $gr->cupousado
                ];
            }
            return json_encode($grs);
        } else {
            return "null";
        }
    }

    //continua hacia la gestion de carga
    public function continuar($u, $p, $j, $g, $grupo)
    {
        $materias = Gradomateria::where([['unidad_id', $u], ['periodoacademico_id', $p], ['jornada_id', $j], ['grado_id', $g]])->get();
        $gr = Grupo::find($grupo);
        $materiassi = null;
        if ($gr != null) {
            $materiassi = $gr->grupomateriadocentes;
        }
        $doc = Docente::all();
        $docentes = null;
        if (count($doc) > 0) {
            foreach ($doc as $d) {
                $docentes[$d->id] = $d->personanatural->primer_nombre . " " . $d->personanatural->segundo_nombre . " " . $d->personanatural->primer_apellido . " " . $d->personanatural->segundo_apellido;
            }
        }
        return view('academico.cargaacademica.carga_grupomatdoc.gestion')
            ->with('location', 'academico')
            ->with('periodo', Periodoacademico::find($p))
            ->with('jornada', Jornada::find($j))
            ->with('unidad', Unidad::find($u))
            ->with('grado', Grado::find($g))
            ->with('grupo', $gr)
            ->with('materiassi', $materiassi)
            ->with('materias', $materias)
            ->with('docentes', $docentes);
    }

    //agrega una materia a un grupo
    public function agregar($gm_id, $g)
    {
        $old = Grupomateriadocente::where([['gradomateria_id', $gm_id], ['grupo_id', $g]])->get();
        $grupo = Grupo::find($g);
        if (count($old) > 0) {
            flash('La materia ya está asociada al grado.')->warning();
            return redirect()->route('cargagrupomatdoc.continuar', [$grupo->unidad_id, $grupo->periodoacademico_id, $grupo->jornada_id, $grupo->grado_id, $grupo->id]);
        }
        $gm = new Grupomateriadocente();
        $gm->gradomateria_id = $gm_id;
        $gm->docente_id = null;
        $gm->grupo_id = $g;
        $user = Auth::user();
        $gm->user_change = $user->identificacion;
        if ($gm->save()) {
            $this->setAuditoria('INSERTAR', 'AGREGAR CARGA ACADÉMICA, MATERIA A GRUPO Y DOCENTE. DATOS NUEVOS: ', $gm);
            flash('Materia asociada con exito')->success();
            return redirect()->route('cargagrupomatdoc.continuar', [$grupo->unidad_id, $grupo->periodoacademico_id, $grupo->jornada_id, $grupo->grado_id, $grupo->id]);
        } else {
            flash('La materia no pudo ser asociada')->error();
            return redirect()->route('cargagrupomatdoc.continuar', [$grupo->unidad_id, $grupo->periodoacademico_id, $grupo->jornada_id, $grupo->grado_id, $grupo->id]);
        }
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

    //docente
    public function docente($gmdoc, $docente)
    {
        $gmd = Grupomateriadocente::find($gmdoc);
        $gmd->docente_id = $docente;
        $user = Auth::user();
        $gmd->user_change = $user->identificacion;
        if ($gmd->save()) {
            $this->setAuditoria('INSERTAR', 'AGREGAR CARGA ACADÉMICA, MATERIA A GRUPO Y DOCENTE. DATOS NUEVOS: ', $gmd);
            flash('El docente ha sido asociado con exito')->success();
            return redirect()->route('cargagrupomatdoc.continuar', [$gmd->gradomateria->unidad_id, $gmd->gradomateria->periodoacademico_id, $gmd->gradomateria->jornada_id, $gmd->gradomateria->grado_id, $gmd->grupo_id]);
        } else {
            flash('El docente no pudo ser asociado a la materia y curso')->error();
            return redirect()->route('cargagrupomatdoc.continuar', [$gmd->gradomateria->unidad_id, $gmd->gradomateria->periodoacademico_id, $gmd->gradomateria->jornada_id, $gmd->gradomateria->grado_id, $gmd->grupo_id]);
        }
    }
}
