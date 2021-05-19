<?php

namespace App\Http\Controllers;

use App\Aprendizaje;
use App\Color;
use App\Componentecompetencia;
use App\Ctunidad;
use App\Ctunidadestandar;
use App\Ctunidadestandaraprendizaje;
use App\Ctunidadevaluacion;
use App\Ctunidadtema;
use App\Estandar;
use App\Evaluacionacademica;
use App\Grado;
use App\Grupomateriadocente;
use App\Http\Requests\CtunidadRequest;
use App\Http\Requests\CtunidadtemaRequest;
use App\Jornada;
use App\Materia;
use App\Periodoacademico;
use App\Persona;
use App\Sistemaevaluacion;
use App\Unidad;
use CreateCtunidadsTable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContenidotematicoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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
                        return redirect()->route('menu.academicodocente');
                    }
                    $unds = Unidad::all();
                    if (count($unds) > 0) {
                        foreach ($unds as $u) {
                            $unidades[$u->id] = $u->nombre . " - " . $u->descripcion . " - " . $u->ciudad->nombre;
                        }
                    } else {
                        flash("No hay unidades o sedes definidas")->error();
                        return redirect()->route('menu.academicodocente');
                    }
                    $jnds = Jornada::all();
                    if (count($jnds) > 0) {
                        foreach ($jnds as $j) {
                            $jornadas[$j->id] = $j->descripcion . " - " . $j->jornadasnies;
                        }
                    } else {
                        flash("No hay jornadas académicas definidas")->error();
                        return redirect()->route('menu.academicodocente');
                    }
                    return view('docente.contenido.index')
                        ->with('location', 'academicodocente')
                        ->with('periodos', $periodos)
                        ->with('jornadas', $jornadas)
                        ->with('unidades', $unidades);
                } else {
                    flash('Usted no es un docente de la institución')->error();
                    return redirect()->route('menu.academicodocente');
                }
            } else {
                flash('Usted no se encuentra registrado como persona natural en la base de datos')->error();
                return redirect()->route('menu.academicodocente');
            }
        } else {
            flash('Usted no se encuentra registrado como persona en la base de datos')->error();
            return redirect()->route('menu.academicodocente');
        }
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
    public function store(CtunidadRequest $request)
    {
        return CrudController::storeWithParams($request, 'App\Ctunidad', 'cargaacademica.gestionar_contenido', [$request->grado_id, $request->materia_id], ['nombre', 'resumen', 'como_desarrollar', 'cuando_desarrollar', 'donde_desarrollar'], 'App\Auditoriaacademico');
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
    public function update(Request $request)
    {
        $u = Ctunidad::find($request->unidad_id);
        return CrudController::updateWithParams($request, $request->unidad_id, 'App\Ctunidad', 'contenido.configurar', [$u->grado_id, $u->materia_id, $u->id], ['nombre', 'resumen', 'como_desarrollar', 'cuando_desarrollar', 'donde_desarrollar'], 'App\Auditoriaacademico');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    //permite gestionar el contenido tematico de una materia y un grado
    public function gestionar_contenido($grado, $materia)
    {
        $unidades = Ctunidad::where([['grado_id', $grado], ['materia_id', $materia]])->get();
        $grado = Grado::find($grado);
        $materia = Materia::find($materia);
        if (count($unidades) > 0) {
            $color = new Color();
            foreach ($unidades as $u) {
                $u->color = $color->color(rand(0, $color->maximo()));
            }
        }
        return view('docente.contenido.gestionar')
            ->with('location', 'academicodocente')
            ->with('unidades', $unidades)
            ->with('grado', $grado)
            ->with('materia', $materia);
    }

    //configurar unidad
    public function configurar($g, $m, $u)
    {
        $grado = Grado::find($g);
        $materia = Materia::find($m);
        $unidad = Ctunidad::find($u);
        $estandaresTodos = Estandar::where([['area_id', $materia->area_id], ['grado_id', $grado->id]])->get();
        $estandaresUnidad = $unidad->ctunidadestandars;
        $aprendizajesFinal = null;
        if (count($estandaresUnidad) > 0) {
            foreach ($estandaresUnidad as $eund) {
                $componentTemp = null;
                $componentesTodos = $eund->estandar->estandarcomponentes;
                if (count($componentesTodos) > 0) {
                    foreach ($componentesTodos as $c) {
                        $o = null;
                        $o['componente'] = $c->componente->componente;
                        $o['descripcion'] = $c->componente->descripcion;
                        //competencias del componente
                        $comp = null;
                        $competencias = Componentecompetencia::where('componente_id', $c->componente_id)->get();
                        if (count($competencias) > 0) {
                            foreach ($competencias as $cm) {
                                $data = null;
                                $data['competencia'] = $cm->competencia->competencia;
                                //aprendizajes
                                $aprendTemp = null;
                                $aprend = Aprendizaje::where([['componentecompetencia_id', $cm->id], ['estandarcomponente_id', $c->id]])->get();
                                if (count($aprend) > 0) {
                                    foreach ($aprend as $apr) {
                                        $old = null;
                                        $old = Ctunidadestandaraprendizaje::where([['ctunidadestandar_id', $eund->id], ['aprendizaje_id', $apr->id]])->first();
                                        if ($old != null) {
                                            $aprendTemp[] = "<b>" . $apr->logro . "</b> - (NEGATIVO: " . $apr->logro_negativo . ")";
                                        }
                                    }
                                }
                                if ($aprendTemp != null) {
                                    $data['aprendizajes'] = $aprendTemp;
                                    $comp[] = $data;
                                }
                            }
                        }
                        if ($comp != null) {
                            $o['competencias'] = $comp;
                            $componentTemp[] = $o;
                        }
                    }
                }
                $aprendizajesFinal[] = [
                    'ctunidadestandar_id' => $eund->id,
                    'estandar_id' => $eund->estandar_id,
                    'estandar' => $eund->estandar->titulo,
                    'componentes' => $componentTemp
                ];
            }
        }
        $temas = $unidad->ctunidadtemas;
        return view('docente.contenido.unidad')
            ->with('location', 'academicodocente')
            ->with('unidad', $unidad)
            ->with('grado', $grado)
            ->with('materia', $materia)
            ->with('aprendizajes', $aprendizajesFinal)
            ->with('estandaresTodos', $estandaresTodos)
            ->with('temas', $temas);
    }

    //agrega estandar a la unidad
    public function addEstandar($u, $e)
    {
        $unidad = Ctunidad::find($u);
        $old = Ctunidadestandar::where([['ctunidad_id', $u], ['estandar_id', $e]])->first();
        if ($old != null) {
            flash('El estándar ya fue agregado a la unidad')->warning();
            return redirect()->route('contenido.configurar', [$unidad->grado_id, $unidad->materia_id, $unidad->id]);
        }
        $data = [
            'estandar_id' => $e,
            'ctunidad_id' => $u
        ];
        $request = new Request($data);
        //$request->request->add($data);
        return CrudController::storeWithParams($request, 'App\Ctunidadestandar', 'contenido.configurar', [$unidad->grado_id, $unidad->materia_id, $unidad->id], [], 'App\Auditoriaacademico');
    }

    //retira un estandar de la unidad
    public function deleteEstandar($g, $m, $u, $e)
    {
        return CrudController::destroyWithParams($e, 'App\Ctunidadestandar', 'contenido.configurar', [$g, $m, $u], ['ctunidadestandaraprendizajes'], 'App\Auditoriaacademico');
    }

    //gestiona los componentes de un estandar dentro de una unidad
    public function componentesEstandar($g, $m, $u, $e)
    {
        //$e=ctunidadestandar
        $grado = Grado::find($g);
        $materia = Materia::find($m);
        $unidad = Ctunidad::find($u);
        $ctunidadestandar = Ctunidadestandar::find($e);
        $componentesTodos = $ctunidadestandar->estandar->estandarcomponentes;
        $aprendizajesFinal = null;
        if (count($componentesTodos) > 0) {
            foreach ($componentesTodos as $c) {
                $o = null;
                $o['componente'] = $c->componente->componente;
                $o['descripcion'] = $c->componente->descripcion;
                //competencias del componente
                $comp = null;
                $competencias = Componentecompetencia::where('componente_id', $c->componente_id)->get();
                if (count($competencias) > 0) {
                    foreach ($competencias as $cm) {
                        $data = null;
                        $data['competencia'] = $cm->competencia->competencia;
                        //aprendizajes
                        $aprendTemp = null;
                        $aprend = Aprendizaje::where([['componentecompetencia_id', $cm->id], ['estandarcomponente_id', $c->id]])->get();
                        if (count($aprend) > 0) {
                            foreach ($aprend as $apr) {
                                $old = null;
                                $logro = null;
                                $logro['aprendizaje_id'] = $apr->id;
                                $logro['logro'] = $apr->logro;
                                $logro['logro_negativo'] = $apr->logro_negativo;
                                $logro['esta'] = 'NO';
                                $logro['ctunidadestandaraprendizaje_id'] = 0;
                                $old = Ctunidadestandaraprendizaje::where([['ctunidadestandar_id', $e], ['aprendizaje_id', $apr->id]])->first();
                                if ($old != null) {
                                    $logro['esta'] = 'SI';
                                    $logro['ctunidadestandaraprendizaje_id'] = $old->id;
                                }
                                $aprendTemp[] = $logro;
                            }
                        }
                        $data['aprendizajes'] = $aprendTemp;
                        $comp[] = $data;
                    }
                }
                $o['competencias'] = $comp;
                $aprendizajesFinal[] = $o;
            }
        }
        return view('docente.contenido.componentes')
            ->with('location', 'academicodocente')
            ->with('unidad', $unidad)
            ->with('grado', $grado)
            ->with('materia', $materia)
            ->with('estandar', $ctunidadestandar)
            ->with('aprendizajes', $aprendizajesFinal);
    }

    //esta el componente en el estandar y unidad
    public function estaComponente($comp, $componentesEstandarUnidad)
    {
        $esta = 0;
        foreach ($componentesEstandarUnidad as $ceu) {
            if ($ceu->estandarcomponente->componente_id == $comp->componente_id) {
                $esta = $ceu->id;
            }
        }
        return $esta;
    }

    //agrega un aprendizaje a un estandar y unidad
    public function addAprendizajeEstandar($g, $m, $u, $e, $a)
    {
        $data = [
            'aprendizaje_id' => $a,
            'ctunidadestandar_id' => $e
        ];
        $request = new Request($data);
        return CrudController::storeWithParams($request, 'App\Ctunidadestandaraprendizaje', 'contenido.componentesEstandar', [$g, $m, $u, $e], [], 'App\Auditoriaacademico');
    }

    //retira un aprendizaje de un estandar y unidad
    public function deleteAprendizajeEstandar($g, $m, $u, $e, $id)
    {
        return CrudController::destroyWithParams($id, 'App\Ctunidadestandaraprendizaje', 'contenido.componentesEstandar', [$g, $m, $u, $e], null, 'App\Auditoriaacademico');
    }

    //crea un nuevo tema dentro de una unidad
    public function temaStore(CtunidadtemaRequest $request)
    {
        $u = Ctunidad::find($request->ctunidad_id);
        return CrudController::storeWithParams($request, 'App\Ctunidadtema', 'contenido.configurar', [$u->grado_id, $u->materia_id, $u->id], ['titulo', 'duracion'], 'App\Auditoriaacademico');
    }

    //configurar un tema dentro de una unidad
    public function temaConfigurar($g, $m, $u, $t)
    {
        //$t=>Ctunidadtema
        $grado = Grado::find($g);
        $materia = Materia::find($m);
        $unidad = Ctunidad::find($u);
        $tema = Ctunidadtema::find($t);
        return view('docente.contenido.tema_configurar')
            ->with('location', 'academicodocente')
            ->with('unidad', $unidad)
            ->with('grado', $grado)
            ->with('materia', $materia)
            ->with('tema', $tema);
    }

    //actualiza un tema dentro de una unidad
    public function temaActualizar(Request $request)
    {
        $t = Ctunidadtema::find($request->ctunidadtema_id);
        return CrudController::updateWithParams($request, $request->ctunidadtema_id, 'App\Ctunidadtema', 'contenido.temaConfigurar', [$t->ctunidad->grado_id, $t->ctunidad->materia_id, $t->ctunidad_id, $t->id], ['titulo', 'duracion'], 'App\Auditoriaacademico');
    }

    //crea un subtema
    public function subtema_crear(Request $request)
    {
        $t = Ctunidadtema::find($request->ctunidadtema_id);
        if ($request->desarrollo != null) {
            return CrudController::storeWithParams($request, 'App\Ctunidadtemasubtema', 'contenido.temaConfigurar', [$t->ctunidad->grado_id, $t->ctunidad->materia_id, $t->ctunidad_id, $t->id], ['titulo'], 'App\Auditoriaacademico');
        } else {
            flash('Debe indicar el contenido del tema para crearlo')->warning();
            return redirect()->route('contenido.temaConfigurar', [$t->ctunidad->grado_id, $t->ctunidad->materia_id, $t->ctunidad_id, $t->id]);
        }
    }

    //actualizar subtema
    public function subtema_actualizar(Request $request)
    {
        $t = Ctunidadtema::find($request->ctunidadtema_id);
        if ($request->desarrollo != null) {
            return CrudController::updateWithParams($request, $request->ctunidadtemasubtema_id, 'App\Ctunidadtemasubtema', 'contenido.temaConfigurar', [$t->ctunidad->grado_id, $t->ctunidad->materia_id, $t->ctunidad_id, $t->id], ['titulo'], 'App\Auditoriaacademico');
        } else {
            flash('Debe indicar el contenido del tema para crearlo')->warning();
            return redirect()->route('contenido.temaConfigurar', [$t->ctunidad->grado_id, $t->ctunidad->materia_id, $t->ctunidad_id, $t->id]);
        }
    }

    //eliminar subtema
    public function subtema_eliminar($tema, $subtema)
    {
        $t = Ctunidadtema::find($tema);
        return CrudController::destroyWithParams($subtema, 'App\Ctunidadtemasubtema', 'contenido.temaConfigurar', [$t->ctunidad->grado_id, $t->ctunidad->materia_id, $t->ctunidad_id, $t->id], null, 'App\Auditoriaacademico');
    }

    //permite asignar el contenido tematico de una materia y un grado a un período en particular (MALLA CURRICULAR) 
    public function malla_curricular($grado, $materia)
    {
        $unidades = Ctunidad::where([['grado_id', $grado], ['materia_id', $materia]])->get();
        $grado = Grado::find($grado);
        $materia = Materia::find($materia);
        $evaluaciones = Evaluacionacademica::all();
        $unidadesya = null;
        if (count($evaluaciones)) {
            foreach ($evaluaciones as $ev) {
                $unds = null;
                if (count($unidades) > 0) {
                    foreach ($unidades as $und) {
                        $temp = Ctunidadevaluacion::where([['evaluacionacademica_id', $ev->id], ['ctunidad_id', $und->id]])->get();
                        if (count($temp) > 0) {
                            foreach ($temp as $t) {
                                $unds[] = $t;
                            }
                        }
                    }
                }
                $unidadesya[$ev->nombre . " (" . $ev->peso . "%)"] = $unds;
            }
        }
        return view('docente.contenido.malla_curricular')
            ->with('location', 'academicodocente')
            ->with('unidades', $unidades)
            ->with('grado', $grado)
            ->with('materia', $materia)
            ->with('evaluaciones', $evaluaciones)
            ->with('unidadesya', $unidadesya);
    }

    //asocia una unidad a un periodo
    public function malla_asignarunidad(Request $request)
    {
        $old = Ctunidadevaluacion::where([['ctunidad_id', $request->ctunidad_id], ['evaluacionacademica_id', $request->evaluacionacademica_id]])->first();
        if ($old != null) {
            flash('La unidad ya fue asociada al período')->warning();
            return redirect()->route('cargaacademica.malla_curricular', [$request->grado_id, $request->materia_id]);
        }
        return CrudController::storeWithParams($request, 'App\Ctunidadevaluacion', 'cargaacademica.malla_curricular', [$request->grado_id, $request->materia_id], [], 'App\Auditoriaacademico');
    }

    //elimina asociación de una unidad a un periodo
    public function malla_eliminarunidad($grado, $materia, $id)
    {
        return CrudController::destroyWithParams($id, 'App\Ctunidadevaluacion', 'cargaacademica.malla_curricular', [$grado, $materia], null, 'App\Auditoriaacademico');
    }

    //muestra el contenido tematico para un estudiante a partir de una materia, grado y grupo
    public function contenido_estudiante($id)
    {
        $gmd = Grupomateriadocente::find($id);
        $se = Sistemaevaluacion::where('estado', 'ACTUAL')->first();
        $evaluaciones = $se->evaluacionacademicas;
        if (count($evaluaciones) > 0) {
            $color = new Color();
            foreach ($evaluaciones as $e) {
                $unidadesEv = null;
                $unidades = Ctunidadevaluacion::where('evaluacionacademica_id', $e->id)->get();
                if (count($unidades) > 0) {
                    foreach ($unidades as $u) {
                        if ($u->ctunidad->grado_id == $gmd->gradomateria->grado_id && $u->ctunidad->materia_id == $gmd->gradomateria->materia_id) {
                            $und = $u->ctunidad;
                            $und->color = $color->color(rand(0, $color->maximo()));
                            $unidadesEv[] = $und;
                        }
                    }
                }
                $e->unidades = $unidadesEv;
            }
        }
        return view('aula_virtual.estudiante.contenido_tematico')
            ->with('location', 'aulavirtual')
            ->with('gmd', $gmd)
            ->with('se', $se)
            ->with('evaluaciones', $evaluaciones);
    }

    //muestra el contenido tematico para un estudiante a partir de una materia, grado, grupo y unidad
    public function contenido_estudianteTemas($id, $u)
    {
        $gmd = Grupomateriadocente::find($id);
        $unidad = Ctunidad::find($u);
        $estandaresUnidad = $unidad->ctunidadestandars;
        $aprendizajesFinal = null;
        if (count($estandaresUnidad) > 0) {
            foreach ($estandaresUnidad as $eund) {
                $componentTemp = null;
                $componentesTodos = $eund->estandar->estandarcomponentes;
                if (count($componentesTodos) > 0) {
                    foreach ($componentesTodos as $c) {
                        $o = null;
                        $o['componente'] = $c->componente->componente;
                        $o['descripcion'] = $c->componente->descripcion;
                        //competencias del componente
                        $comp = null;
                        $competencias = Componentecompetencia::where('componente_id', $c->componente_id)->get();
                        if (count($competencias) > 0) {
                            foreach ($competencias as $cm) {
                                $data = null;
                                $data['competencia'] = $cm->competencia->competencia;
                                //aprendizajes
                                $aprendTemp = null;
                                $aprend = Aprendizaje::where([['componentecompetencia_id', $cm->id], ['estandarcomponente_id', $c->id]])->get();
                                if (count($aprend) > 0) {
                                    foreach ($aprend as $apr) {
                                        $old = null;
                                        $old = Ctunidadestandaraprendizaje::where([['ctunidadestandar_id', $eund->id], ['aprendizaje_id', $apr->id]])->first();
                                        if ($old != null) {
                                            $aprendTemp[] = "<b>" . $apr->logro . "</b> - (NEGATIVO: " . $apr->logro_negativo . ")";
                                        }
                                    }
                                }
                                if ($aprendTemp != null) {
                                    $data['aprendizajes'] = $aprendTemp;
                                    $comp[] = $data;
                                }
                            }
                        }
                        if ($comp != null) {
                            $o['competencias'] = $comp;
                            $componentTemp[] = $o;
                        }
                    }
                }
                $aprendizajesFinal[] = [
                    'ctunidadestandar_id' => $eund->id,
                    'estandar_id' => $eund->estandar_id,
                    'estandar' => $eund->estandar->titulo,
                    'componentes' => $componentTemp
                ];
            }
        }
        $temasTemp = $unidad->ctunidadtemas;
        $temas = null;
        if (count($temasTemp) > 0) {
            foreach ($temasTemp as $t) {
                $sbtemas = null;
                $subtemas = $t->ctunidadtemasubtemas;
                if (count($subtemas) > 0) {
                    foreach ($subtemas as $st) {
                        $st->user;
                        $sbtemas[] = $st;
                    }
                }
                $temas[$t->id] = ['tema' => $t, 'datos' => $sbtemas];
            }
        }
        return view('aula_virtual.estudiante.contenido_tematico_temas')
            ->with('location', 'aulavirtual')
            ->with('gmd', $gmd)
            ->with('unidad', $unidad)
            ->with('aprendizajes', $aprendizajesFinal)
            ->with('temas', $temas);
    }
}
