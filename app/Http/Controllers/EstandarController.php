<?php

namespace App\Http\Controllers;

use App\Aprendizaje;
use App\Area;
use App\Auditoriaacademico;
use App\Color;
use App\Estandar;
use App\Estandarcomponente;
use App\Grupo;
use App\Jornada;
use App\Periodoacademico;
use App\Persona;
use App\Unidad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EstandarController extends Controller
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
                        return redirect()->route('menu.documental');
                    }
                    $unds = Unidad::all();
                    if (count($unds) > 0) {
                        foreach ($unds as $u) {
                            $unidades[$u->id] = $u->nombre . " - " . $u->descripcion . " - " . $u->ciudad->nombre;
                        }
                    } else {
                        flash("No hay unidades o sedes definidas")->error();
                        return redirect()->route('menu.documental');
                    }
                    $jnds = Jornada::all();
                    if (count($jnds) > 0) {
                        foreach ($jnds as $j) {
                            $jornadas[$j->id] = $j->descripcion . " - " . $j->jornadasnies;
                        }
                    } else {
                        flash("No hay jornadas académicas definidas")->error();
                        return redirect()->route('menu.documental');
                    }
                    return view('documental.estandar.list')
                        ->with('location', 'documental')
                        ->with('periodos', $periodos)
                        ->with('jornadas', $jornadas)
                        ->with('unidades', $unidades);
                } else {
                    flash('Usted no es un docente de la institución')->error();
                    return redirect()->route('menu.documental');
                }
            } else {
                flash('Usted no se encuentra registrado como persona natural en la base de datos')->error();
                return redirect()->route('menu.documental');
            }
        } else {
            flash('Usted no se encuentra registrado como persona en la base de datos')->error();
            return redirect()->route('menu.documental');
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
    public function store(Request $request)
    {
        return CrudController::storeWithParams($request, 'App\Estandar', 'estandar.listar', [$request->area_id, $request->grupo_id], ['titulo', 'descripcion'], 'App\Auditoriaacademico');
    }

    /**
     * Updated resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function actualizar(Request $request)
    {
        return CrudController::updateWithParams($request, $request->id, 'App\Estandar', 'estandar.listar', [$request->area_id, $request->grupo_id], ['titulo', 'descripcion'], 'App\Auditoriaacademico');
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
    public function destroy($id, $area, $grupo)
    {
        return CrudController::destroyWithParams($id, 'App\Estandar', 'estandar.listar', [$area, $grupo], ['estandarcomponentes'], 'App\Auditoriaacademico');
    }

    //lista los estándar de un área
    public function listar($id, $gr)
    {
        $area = Area::find($id);
        $estandares = $area->estandars;
        $grupo = Grupo::find($gr);
        return view('documental.estandar.listado')
            ->with('location', 'documental')
            ->with('area', $area)
            ->with('grupo', $grupo)
            ->with('estandares', $estandares);
    }

    //configurar estandar
    public function configurar($e, $g)
    {
        $grupo = Grupo::find($g);
        $estandar = Estandar::find($e);
        $area = $estandar->area;
        $componentes = $area->componentes;
        $componentesestantar = $estandar->estandarcomponentes;
        $componentesya = null;
        if (count($componentesestantar) > 0) {
            foreach ($componentesestantar as $ce) {
                $compcompetencias = null;
                $compcompetencias = $ce->componente->componentecompetencias;
                if (count($compcompetencias) > 0) {
                    foreach ($compcompetencias as $ccomp) {
                        $ccomp->logros = Aprendizaje::where([['componentecompetencia_id', $ccomp->id], ['estandarcomponente_id', $ce->id]])->get();
                    }
                }
                $componentesya[] = [
                    'ce' => $ce,
                    'competencias' => $compcompetencias
                ];
            }
        }
        return view('documental.estandar.configurar')
            ->with('location', 'documental')
            ->with('area', $area)
            ->with('componentes', $componentes)
            ->with('componentesya', $componentesya)
            ->with('grupo', $grupo)
            ->with('estandar', $estandar);
    }

    //agrega un componente al estandar
    public function addComponente($e, $g, $c)
    {
        $old = Estandarcomponente::where([['estandar_id', $e], ['componente_id', $c]])->first();
        if ($old != null) {
            flash("El componente ya existe en el estándar")->warning();
            return redirect()->route('estandar.configurar', [$e, $g]);
        }
        $data = new Estandarcomponente();
        $data->estandar_id = $e;
        $data->componente_id = $c;
        if ($data->save()) {
            $u = Auth::user();
            $a = new Auditoriaacademico();
            $a->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $a->operacion = "INSERTAR";
            $str = "AGREGAR COMPONENTE A ESTÁNDAR. DATOS: ";
            foreach ($data->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $a->detalles = $str;
            $a->save();
            flash("El registro fue almacenado de forma exitosa!")->success();
            return redirect()->route('estandar.configurar', [$e, $g]);
        } else {
            flash("Error al guardar el registro")->error();
            return redirect()->route('estandar.configurar', [$e, $g]);
        }
    }

    //remueve un componente del estandar
    public function removeComponente($e, $g, $cc)
    {
        return CrudController::destroyWithParams($cc, 'App\Estandarcomponente', 'estandar.configurar', [$e, $g], ['aprendizajes'], 'App\Auditoriaacademico');
    }

    //adiciona un logro o aprendizaje a una competencia dentro de un componente y estandar
    public function addLogro(Request $request)
    {
        return CrudController::storeWithParams($request, 'App\Aprendizaje', 'estandar.configurar', [$request->estandar_id, $request->grupo_id], ['logro', 'logro_negativo'], 'App\Auditoriaacademico');
    }

    //retira un logro de la competencia, componente y estandar
    public function removeLogro($e, $g, $id)
    {
        return CrudController::destroyWithParams($id, 'App\Aprendizaje', 'estandar.configurar', [$e, $g], ['indicadors'], 'App\Auditoriaacademico');
    }

    //agrega un nuevo indicador al aprendizaje o logro
    public function addIndicador(Request $request)
    {
        return CrudController::storeWithParams($request, 'App\Indicador', 'estandar.configurar', [$request->estandar_id, $request->grupo_id], ['indicador'], 'App\Auditoriaacademico');
    }

    //retira un indicador de logro de un logro o aprendizaje
    public function removeIndicador($e, $g, $id)
    {
        return CrudController::destroyWithParams($id, 'App\Indicador', 'estandar.configurar', [$e, $g], null, 'App\Auditoriaacademico');
    }
}
