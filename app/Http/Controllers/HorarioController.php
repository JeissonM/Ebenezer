<?php

namespace App\Http\Controllers;

use App\Auditoriaacademico;
use App\Estudiante;
use App\Grado;
use App\Grupo;
use App\Horario;
use App\Jornada;
use App\Periodoacademico;
use App\Persona;
use App\Unidad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HorarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
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
        return view('academico.registro_academico.horario.list')
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
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $hor = new Horario();
        $hor->grupo_id = $request->grupo_id;
        if (isset($request->horario)) {
            $horario = $request->file('horario');
            $name = "Horario_" . str_slug($horario->getClientOriginalName());
            $path = public_path() . "/horarios/";
            $horario->move($path, $name);
            $hor->horario = $name;
        }
        $u = Auth::user();
        $hor->user_change = $u->identificacion;
        $result = $hor->save();
        if ($result) {
            $aud = new Auditoriaacademico();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "INSERTAR";
            $str = "CREACIÓN DE HORARIO. DATOS: ";
            foreach ($hor->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("El Horario fue almacenado de forma exitosa!")->success();
            return redirect()->route('horario.edit', $request->grupo_id);
        } else {
            flash("El Horario no pudo ser almacenado. Error: " . $result)->error();
            return redirect()->route('horario.edit', $request->grupo_id);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Horario $horario
     * @return \Illuminate\Http\Response
     */
    public function show(Horario $horario) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Horario $horario
     * @return \Illuminate\Http\Response
     */
    public function edit($grupo_id) {
        $grupo = Grupo::find($grupo_id);
        $horario = Horario::where('grupo_id', $grupo_id)->first();
        return view('academico.registro_academico.horario.create')
            ->with('location', 'academico')
            ->with('horario', $horario)
            ->with('grupo', $grupo);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Horario $horario
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Horario $horario) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Horario $horario
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $horario = Horario::find($id);
        $result = $horario->delete();
        if ($result) {
            //unlink(asset('horarios/' . $horario->horario));
            $aud = new Auditoriaacademico();
            $u = Auth::user();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ELIMINAR";
            $str = "ELIMINACIÓN DE HORARIO. DATOS ELIMINADOS: ";
            foreach ($horario->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("El horario fue eliminado de forma exitosa!")->success();
            return redirect()->route('horario.edit', $horario->grupo_id);
        } else {
            flash("El horario no fue eliminado de forma exitosa. Error:" . $result)->error();
            return redirect()->route('horario.edit', $horario->grupo_id);
        }
    }

    //Horario estudiante
    public function horarioestudiante() {
        $u = Auth::user();
        $p = Persona::where('numero_documento', $u->identificacion)->first();
        if ($p != null) {
            $pn = $p->personanatural;
            if ($pn != null) {
                $est = $pn->estudiante;
                if ($est != null) {
                    $estg = $est->estudiantegrupos;
                    if (count($estg) > 0) {
                        $g = null;
                        foreach ($estg as $gr) {
                            if ($gr->grupo->periodoacademico_id == $est->periodoacademico_id && $gr->grupo->grado_id == $est->grado_id && $gr->grupo->unidad_id == $est->unidad_id && $gr->grupo->jornada_id == $est->jornada_id) {
                                $g = $gr->grupo;
                            }
                        }
                        if ($g != null) {
                            $h = Horario::where('grupo_id', $g->id)->first();
                            if ($h != null) {
                                return view('estudiante.horarios.horarios')
                                    ->with('location', 'academico_e_a')
                                    ->with('est', $est)
                                    ->with('horario', $h);
                            } else {
                                flash('El grupo del estudiante no tiene horario asignado.')->error();
                                return redirect()->route('menu.academicoestudiante');
                            }
                        } else {
                            flash('El estudiante no tiene matrícula académica.')->error();
                            return redirect()->route('menu.academicoestudiante');
                        }
                    } else {
                        flash('El estudiante no tiene matrícula académica.')->error();
                        return redirect()->route('menu.academicoestudiante');
                    }
                } else {
                    flash('Usted no es un estudiante de la institución')->error();
                    return redirect()->route('menu.academicoestudiante');
                }
            } else {
                flash('Usted no se encuentra registrado como persona natural en la base de datos')->error();
                return redirect()->route('menu.academicoestudiante');
            }
        } else {
            flash('Usted no se encuentra registrado como persona en la base de datos')->error();
            return redirect()->route('menu.academicoestudiante');
        }
    }

    //Horario estudiante por parte de acudiente
    public function horarioacudiente($id) {
        $est = Estudiante::find($id);
        if ($est != null) {
            $estg = $est->estudiantegrupos;
            if (count($estg) > 0) {
                $g = null;
                foreach ($estg as $gr) {
                    if ($gr->grupo->periodoacademico_id == $est->periodoacademico_id && $gr->grupo->grado_id == $est->grado_id && $gr->grupo->unidad_id == $est->unidad_id && $gr->grupo->jornada_id == $est->jornada_id) {
                        $g = $gr->grupo;
                    }
                }
                if ($g != null) {
                    $h = Horario::where('grupo_id', $g->id)->first();
                    if ($h != null) {
                        return view('acudiente.academico.horarios')
                            ->with('location', 'academicoacudiente')
                            ->with('est', $est)
                            ->with('horario', $h);
                    } else {
                        flash('El grupo del estudiante no tiene horario asignado.')->error();
                        return redirect()->route('menu.academicomenuacudiente', $id);
                    }
                } else {
                    flash('El estudiante no tiene matrícula académica.')->error();
                    return redirect()->route('menu.academicomenuacudiente', $id);
                }
            } else {
                flash('El estudiante no tiene matrícula académica.')->error();
                return redirect()->route('menu.academicomenuacudiente', $id);
            }
        } else {
            flash('Usted no es un estudiante de la institución')->error();
            return redirect()->route('menu.academicomenuacudiente', $id);
        }
    }


    public function horarioGrupoConsultar($unidad, $periodo, $grado, $grupo) {
        $gr = Grupo::findOrFail($grupo);
        if ($gr == null) {
            return 'null';
        }
        $horario = $gr->horarios()->first();
        if ($horario == null) {
            return 'null';
        }
        $data['grupo'] = $gr->nombre;
        $data['horario'] = $horario->horario;
        $data['html'] = "<tr><td>" . $gr->nombre . "</td><td><a target='_blank' href='" . asset('horarios/' . $horario->horario) . "'>" . $horario->horario . "</a></td></tr>";
        return json_encode($data);
    }
}
