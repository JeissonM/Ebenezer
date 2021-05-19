<?php

namespace App\Http\Controllers;

use App\Estudiante;
use App\Estudiantegrupo;
use Illuminate\Http\Request;
use App\Unidad;
use App\Grado;
use App\Grupo;
use App\Jornada;
use App\Periodoacademico;
use App\Situacionestudiante;
use Illuminate\Support\Facades\Auth;
use App\Matriculaauditoria;

class MatricularantiguosController extends Controller
{
    //index
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
        $situa = Situacionestudiante::all();
        $situaciones = null;
        if (count($situa) > 0) {
            foreach ($situa as $s) {
                $situaciones[$s->id] = $s->nombre;
            }
        }
        return view('matricula.matricula.matricula_antiguos.list')
            ->with('location', 'matricula')
            ->with('periodos', $periodos)
            ->with('jornadas', $jornadas)
            ->with('unidades', $unidades)
            ->with('grados', $grados)
            ->with('situaciones', $situaciones);
    }

    //devuelve los estudiantes matriculados en un grupo
    public function matriculados($id)
    {
        $grupo = Grupo::find($id);
        $estudiantes = null;
        if ($grupo != null) {
            $estudiantes = $grupo->estudiantegrupos;
            if ($estudiantes != null) {
                $eee = null;
                foreach ($estudiantes as $e) {
                    $eee[] = [
                        'identificacion' => $e->estudiante->personanatural->persona->numero_documento,
                        'estudiante' => $e->estudiante->personanatural->primer_nombre . " " . $e->estudiante->personanatural->segundo_nombre . " " . $e->estudiante->personanatural->primer_apellido . " " . $e->estudiante->personanatural->segundo_apellido,
                        'estudiantegrupo' => $e->id
                    ];
                }
                return json_encode($eee);
            } else {
                return "null";
            }
        } else {
            return "null";
        }
    }


    //devuelve los estudiantes no matriculados
    public function nomatriculados($unidad, $periodo, $jornada, $grado, $situacion, $estado)
    {
        $est = Estudiante::where([['estado', $estado], ['pago', 'PAGADO'], ['periodoacademico_id', $periodo], ['grado_id', $grado], ['unidad_id', $unidad], ['jornada_id', $jornada], ['situacionestudiante_id', $situacion]])->get();
        $estudiantes = null;
        if (count($est) > 0) {
            foreach ($est as $e) {
                $estudiantes[] = [
                    'identificacion' => $e->personanatural->persona->numero_documento,
                    'estudiante' => $e->personanatural->primer_nombre . " " . $e->personanatural->segundo_nombre . " " . $e->personanatural->primer_apellido . " " . $e->personanatural->segundo_apellido,
                    'id' => $e->id
                ];
            }
            return json_encode($estudiantes);
        } else {
            return "null";
        }
    }

    //matricular estudiante antiguo
    public function matriculara($grupo, $estudiante)
    {
        $gg = Grupo::find($grupo);
        if ($gg->cupo == $gg->cupousado) {
            return json_encode([
                'error' => 'SI',
                'mensaje' => 'No se pudo matricular el estudiante porque no hay cupo en el grupo seleccionado',
                'tipo' => 'error'
            ]);
        }
        $eg = new Estudiantegrupo();
        $u = Auth::user();
        $eg->user_change = $u->identificacion;
        $eg->estudiante_id = $estudiante;
        $eg->grupo_id = $grupo;
        if ($eg->save()) {
            $this->setAuditoriamatricula('INSERTAR', 'MATRICULAR ESTUDIANTE ANTIGUO. DATOS NUEVOS: ', $eg);
            $gg->cupousado = $gg->cupousado + 1;
            $gg->save();
            $est = Estudiante::find($estudiante);
            $est->grado_anterior = $est->grado_id;
            $est->grado_id = $gg->grado_id;
            $est->periodo_anterior = $est->periodoacademico_id;
            $est->periodoacademico_id = $gg->periodoacademico_id;
            $est->estado = "MATRICULADO";
            $est->save();
            return json_encode([
                'error' => 'NO',
                'mensaje' => 'Estudiante matriculado con exito',
                'tipo' => 'success'
            ]);
        } else {
            return json_encode([
                'error' => 'SI',
                'mensaje' => 'No se pudo matricular el estudiante',
                'tipo' => 'error'
            ]);
        }
    }

    //retirar matricula estudiante antiguo
    public function retirara($estudianteg)
    {
        $eg = Estudiantegrupo::find($estudianteg);
        $est = Estudiante::find($eg->estudiante_id);
        $grupo = Grupo::find($eg->grupo_id);
        if ($eg->delete()) {
            $this->setAuditoriamatricula('ELIMINAR', 'ELIMINAR MATRICULA ESTUDIANTE ANTIGUO. DATOS ELIMINADOS: ', $eg);
            $grupo->cupousado = $grupo->cupousado - 1;
            $grupo->save();
            $est->grado_id = $est->grado_anterior;
            $est->grado_anterior = null;
            $est->periodoacademico_id = $est->periodo_anterior;
            $est->periodo_anterior = null;
            $est->estado = "APROBADO";
            $est->pago = "PAGADO";
            $est->save();
            return json_encode([
                'error' => 'NO',
                'mensaje' => 'Estudiante retirado con exito',
                'tipo' => 'success'
            ]);
        } else {
            return json_encode([
                'error' => 'SI',
                'mensaje' => 'No se pudo retirar el estudiante',
                'tipo' => 'error'
            ]);
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


    //permite parametrizar el cambio de grupo
    public function create()
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
        return view('matricula.matricula.matricula_antiguos.cambiogrupo')
            ->with('location', 'matricula')
            ->with('periodos', $periodos)
            ->with('jornadas', $jornadas)
            ->with('unidades', $unidades)
            ->with('grados', $grados);
    }

    //estudiantes matriculados en un grado
    public function estmatriculados($u, $p, $j, $g)
    {
        $est = Estudiante::where([['periodoacademico_id', $p], ['grado_id', $g], ['unidad_id', $u], ['jornada_id', $j]])->get();
        $estudiantes = null;
        if (count($est) > 0) {
            foreach ($est as $e) {
                $estudiantes[] = [
                    'identificacion' => $e->personanatural->persona->numero_documento,
                    'estudiante' => $e->personanatural->primer_nombre . " " . $e->personanatural->segundo_nombre . " " . $e->personanatural->primer_apellido . " " . $e->personanatural->segundo_apellido,
                    'id' => $e->id
                ];
            }
            return json_encode($estudiantes);
        } else {
            return "null";
        }
    }

    //permite ver el estudiante para cambiar grupo
    public function show($id)
    {
        $e = Estudiante::find($id);
        $grupos = $grupo = null;
        $grupos = $e->estudiantegrupos;
        if (count($grupos) > 0) {
            foreach ($grupos as $eg) {
                $g = $eg->grupo;
                if ($g->unidad_id == $e->unidad_id && $g->jornada_id == $e->jornada_id && $g->periodoacademico_id == $e->periodoacademico_id && $g->grado_id == $e->grado_id) {
                    $grupo = $g;
                    $grupo->eg_id = $eg->id;
                }
            }
            if ($grupo != null) {
                $grps = Grupo::where([['unidad_id', $e->unidad_id], ['jornada_id', $e->jornada_id], ['grado_id', $e->grado_id], ['periodoacademico_id', $e->periodoacademico_id]])->get();
                $quedan = null;
                if (count($grps) > 0) {
                    foreach ($grps as $gp) {
                        if ($gp->cupo > $gp->cupousado) {
                            $quedan[] = $gp;
                        }
                    }
                    if ($quedan != null) {
                        return view('matricula.matricula.matricula_antiguos.cambiogrupocambiar')
                            ->with('location', 'matricula')
                            ->with('e', $e)
                            ->with('grupo', $grupo)
                            ->with('grupos', $quedan);
                    } else {
                        flash("No hay grupos disponibles en el grado y período actual del estudiante")->error();
                        return redirect()->route('matricularantiguos.create');
                    }
                } else {
                    flash("No hay grupos disponibles en el grado y período actual del estudiante")->error();
                    return redirect()->route('matricularantiguos.create');
                }
            } else {
                flash("El estudiante no tiene matrícula académica en el período actual")->error();
                return redirect()->route('matricularantiguos.create');
            }
        } else {
            flash("El estudiante no tiene matrícula académica")->error();
            return redirect()->route('matricularantiguos.create');
        }
    }


    //cambia un grupo
    public function cambiar($eg, $g)
    {
        $estg = Estudiantegrupo::find($eg);
        $grupoantes = Grupo::find($estg->grupo_id);
        $gruponuevo = Grupo::find($g);
        $estg->grupo_id = $g;
        $u = Auth::user();
        $estg->user_change = $u->identificacion;
        if ($estg->save()) {
            $grupoantes->cupousado = $grupoantes->cupousado - 1;
            $gruponuevo->cupousado = $gruponuevo->cupousado + 1;
            $grupoantes->save();
            $gruponuevo->save();
            $this->setAuditoriamatricula('ACTUALIZAR', 'AMBIO DE GRUPO MATRICULADO. DATOS NUEVOS: ', $estg);
            flash('Grupo cambiado con exito.')->success();
        } else {
            flash("El grupo no pudo ser cambiado")->error();
        }
        return redirect()->route('matricularantiguos.show', $estg->estudiante_id);
    }
}
