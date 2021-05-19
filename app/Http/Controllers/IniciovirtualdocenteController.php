<?php

namespace App\Http\Controllers;

use App\Grado;
use App\Gradomateria;
use App\Grupo;
use App\Grupomateriadocente;
use App\Jornada;
use App\Periodoacademico;
use App\Persona;
use App\Unidad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use PDF;
use Illuminate\Support\Facades\Auth;

class IniciovirtualdocenteController extends Controller
{
    //inicio docente
    public function iniciodocente()
    {
        $u = Auth::user();
        $p = Persona::where('numero_documento', $u->identificacion)->first();
        if ($p != null) {
            $pn = $p->personanatural;
            if ($pn != null) {
                $d = $pn->docente;
                if ($d != null) {
                    $periodos = $unidades = $jornadas = null;
                    $perds = Periodoacademico::all()->sortByDesc('anio');
                    if (count($perds) > 0) {
                        foreach ($perds as $p) {
                            $periodos[$p->id] = $p->etiqueta . " - " . $p->anio;
                        }
                    } else {
                        flash("No hay períodos académicos")->error();
                        return redirect()->route('menu.aulavirtual');
                    }
                    $unds = Unidad::all();
                    if (count($unds) > 0) {
                        foreach ($unds as $u) {
                            $unidades[$u->id] = $u->nombre . " - " . $u->descripcion . " - " . $u->ciudad->nombre;
                        }
                    } else {
                        flash("No hay unidades o sedes definidas")->error();
                        return redirect()->route('menu.aulavirtual');
                    }
                    $jnds = Jornada::all();
                    if (count($jnds) > 0) {
                        foreach ($jnds as $j) {
                            $jornadas[$j->id] = $j->descripcion . " - " . $j->jornadasnies;
                        }
                    } else {
                        flash("No hay jornadas académicas definidas")->error();
                        return redirect()->route('menu.aulavirtual');
                    }
                    return view('aula_virtual.docente.index')
                        ->with('location', 'aulavirtual')
                        ->with('periodos', $periodos)
                        ->with('jornadas', $jornadas)
                        ->with('unidades', $unidades);
                } else {
                    flash('Usted no es un docente de la institución')->error();
                    return redirect()->route('menu.aulavirtual');
                }
            } else {
                flash('Usted no se encuentra registrado como persona natural en la base de datos')->error();
                return redirect()->route('menu.aulavirtual');
            }
        } else {
            flash('Usted no se encuentra registrado como persona en la base de datos')->error();
            return redirect()->route('menu.aulavirtual');
        }
    }

    //get grados de docente
    public function gradosdocente($unidad, $periodo, $jornada)
    {
        $gradomaterias = Gradomateria::where([['unidad_id', $unidad], ['periodoacademico_id', $periodo], ['jornada_id', $jornada]])->get();
        if (count($gradomaterias) > 0) {
            $grados = null;
            foreach ($gradomaterias as $g) {
                $grados[$g->grado_id] = $g->grado->etiqueta;
            }
            if ($grados != null) {
                return json_encode($grados);
            } else {
                return "null";
            }
        } else {
            return "null";
        }
    }


    //get materias de docente
    public function materiasdocente($unidad, $periodo, $jornada, $grado)
    {
        $gradomaterias = Gradomateria::where([['unidad_id', $unidad], ['periodoacademico_id', $periodo], ['jornada_id', $jornada], ['grado_id', $grado]])->get();
        if (count($gradomaterias) > 0) {
            $materias = null;
            $u = Auth::user();
            $p = Persona::where('numero_documento', $u->identificacion)->first();
            $d = $p->personanatural->docente;
            foreach ($gradomaterias as $g) {
                $gmds = Grupomateriadocente::where([['gradomateria_id', $g->id], ['docente_id', $d->id]])->get();
                if (count($gmds) > 0) {
                    foreach ($gmds as $gmd) {
                        $materias[] = [
                            'materia_id' => $g->materia_id,
                            'codigo' => $g->materia->codigomateria,
                            'materia' => $g->materia->nombre,
                            'grupo' => $gmd->grupo->nombre,
                            'gmd_id' => $gmd->id
                        ];
                    }
                }
            }
            if ($materias != null) {
                return json_encode($materias);
            } else {
                return "null";
            }
        } else {
            return "null";
        }
    }

    //menu aula docente
    public function menuauladocente($id)
    {
        $gmd = Grupomateriadocente::find($id);
        $contactos = $gmd->grupo->estudiantegrupos;
        $docente = $gmd->docente;
        return view('aula_virtual.docente.panel')
            ->with('location', 'aulavirtual')
            ->with('gmd', $gmd)
            ->with('contactos', $contactos)
            ->with('docente', $docente);
    }

    /**
     * @param $id App\Grupomateriadocente
     * imprimir lista de estudiantes para calificaciones
     */
    public function imprimirlista($id)
    {
        $gmd = Grupomateriadocente::find($id);
        $contactos = $gmd->grupo->estudiantegrupos;
        $estudiantes = null;
        if (count($contactos) > 0) {
            foreach ($contactos as $c) {
                $estudiantes[] = $c->estudiante->personanatural->primer_apellido . " " . $c->estudiante->personanatural->segundo_apellido . " " . $c->estudiante->personanatural->primer_nombre . " " . $c->estudiante->personanatural->segundo_nombre;
            }
        }
        if ($estudiantes != null) {
            sort($estudiantes);
        }
        $docente = $gmd->docente;
        $periodo = $gmd->gradomateria->periodoacademico; //
        $unidad = $gmd->gradomateria->unidad; //
        $jornada = $gmd->gradomateria->jornada; //
        $grupo = $gmd->grupo;
        $grado = $gmd->gradomateria->grado; //
        $hoy = getdate();
        $fecha = $hoy["year"] . "/" . $hoy["mon"] . "/" . $hoy["mday"] . "  Hora: " . $hoy["hours"] . ":" . $hoy["minutes"] . ":" . $hoy["seconds"];
        $pdf = PDF::loadView('aula_virtual.docente.listacalificacion', compact('contactos', 'docente', 'periodo', 'unidad', 'jornada', 'grupo', 'grado', 'fecha', 'estudiantes'));
        return $pdf->stream('lista_de_calificacion.pdf');
    }

    //devuelve los estudiantes de un grupomateriadocente
    public function estudiantes($id)
    {
        $gmd = Grupomateriadocente::find($id);
        if ($gmd != null) {
            $contactos = $gmd->grupo->estudiantegrupos;
            $estudiantes = null;
            if (count($contactos) > 0) {
                foreach ($contactos as $c) {
                    $estudiantes[] = [
                        'id' => $c->estudiante_id,
                        'identificacion' => $c->estudiante->personanatural->persona->numero_documento,
                        'nombres' => $c->estudiante->personanatural->primer_apellido . " " . $c->estudiante->personanatural->segundo_apellido . " " . $c->estudiante->personanatural->primer_nombre . " " . $c->estudiante->personanatural->segundo_nombre
                    ];
                }
            }
            $ests = null;
            if ($estudiantes != null) {
                $ests = $this->orderMultiDimensionalArray($estudiantes, 'nombres');
            }
            return json_encode($ests);
        } else {
            return "null";
        }
    }


    //ordena arreglos multidimencionales
    public function orderMultiDimensionalArray($toOrderArray, $field, $inverse = false)
    {
        $position = array();
        $newRow = array();
        foreach ($toOrderArray as $key => $row) {
            $position[$key] = $row[$field];
            $newRow[$key] = $row;
        }
        if ($inverse) {
            arsort($position);
        } else {
            asort($position);
        }
        $returnArray = array();
        foreach ($position as $key => $pos) {
            $returnArray[] = $newRow[$key];
        }
        return $returnArray;
    }

    //get grupos de un grado
    public function gruposgrado($unidad, $periodo, $jornada, $grado)
    {
        $grupos = Grupo::where([['unidad_id', $unidad], ['periodoacademico_id', $periodo], ['jornada_id', $jornada], ['grado_id', $grado]])->get();
        if (count($grupos) > 0) {
            return json_encode($grupos);
        } else {
            return "null";
        }
    }

    //devuelve los estudiantes de un grupo
    public function estudiantesdelgrupo($id)
    {
        $gmd = Grupo::find($id);
        if ($gmd != null) {
            $contactos = $gmd->estudiantegrupos;
            $estudiantes = null;
            if (count($contactos) > 0) {
                foreach ($contactos as $c) {
                    $estudiantes[] = [
                        'id' => $c->estudiante_id,
                        'identificacion' => $c->estudiante->personanatural->persona->numero_documento,
                        'nombres' => $c->estudiante->personanatural->primer_apellido . " " . $c->estudiante->personanatural->segundo_apellido . " " . $c->estudiante->personanatural->primer_nombre . " " . $c->estudiante->personanatural->segundo_nombre
                    ];
                }
            }
            $ests = null;
            if ($estudiantes != null) {
                $ests = $this->orderMultiDimensionalArray($estudiantes, 'nombres');
            }
            return json_encode($ests);
        } else {
            return "null";
        }
    }
}
