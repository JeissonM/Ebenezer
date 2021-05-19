<?php

namespace App\Http\Controllers;

use App\Areaexamenadmisiongrado;
use App\Examenadmision;
use Illuminate\Http\Request;
use App\Periodoacademico;
use App\Jornada;
use App\Unidad;
use App\Grado;
use Illuminate\Support\Facades\Auth;
use App\Auditoriaadmision;
use App\Aspirante;
use App\Examenadmisionarea;
use App\Rangonota;

class ExamenadmisionController extends Controller
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
        return view('admisiones.agenda_entrevista.examen_admision.list')
            ->with('location', 'admisiones')
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
        $e = Examenadmision::find($request->examenadmision_id);
        $e->anotaciones = $request->anotaciones;
        $e->estado = $request->estado;
        $soporte = null;
        if (isset($request->soporte)) {
            $soporte = $request->file('soporte');
            $name = "Soporte_" . $soporte->getClientOriginalName();
            $path = public_path() . "/documentos/";
            $soporte->move($path, $name);
            $e->soporte = $name;
        }
        $calificacion = 0;
        foreach ($request->areas_id as $key => $value) {
            $area = null;
            $area = Examenadmisionarea::find($value);
            $area->calificacion = $request->areas_val[$key];
            $calificacion = $calificacion + ($request->areas_val[$key] * ($area->areaexamenadmisiongrado->peso / 100));
            $area->save();
            $this->setAuditoriaadmision('ACTUALIZAR', 'CALIFICAR AREA EXAMEN DE ADMISION. DATOS: ', $area);
        }
        $e->calificacion = $calificacion;
        if ($e->save()) {
            flash("Calificado con éxito!")->success();
            return redirect()->route('examenadmision.examen', $request->aspirante_id);
        } else {
            flash("Todos los datos del examen no pudieron ser guardados, verifique.")->error();
            return redirect()->route('examenadmision.examen', $request->aspirante_id);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Examenadmision  $examenadmision
     * @return \Illuminate\Http\Response
     */
    public function show(Examenadmision $examenadmision)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Examenadmision  $examenadmision
     * @return \Illuminate\Http\Response
     */
    public function edit(Examenadmision $examenadmision)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Examenadmision  $examenadmision
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Examenadmision $examenadmision)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Examenadmision  $examenadmision
     * @return \Illuminate\Http\Response
     */
    public function destroy(Examenadmision $examenadmision)
    {
        //
    }

    //Lista los aspirantes por unidad, periodo, jornada, grado
    public function listaraspirantes($u, $p, $j, $g)
    {
        $aspirantes = Aspirante::where([['unidad_id', $u], ['periodoacademico_id', $p], ['jornada_id', $j], ['grado_id', $g]])->get();
        if (count($aspirantes) > 0) {
            return view('admisiones.agenda_entrevista.examen_admision.aspirantes')
                ->with('location', 'admisiones')
                ->with('periodo', Periodoacademico::find($p))
                ->with('jornada', Jornada::find($j))
                ->with('unidad', Unidad::find($u))
                ->with('grado', Grado::find($g))
                ->with('aspirantes', $aspirantes);
        } else {
            flash("No hay aspirantes para los parámetros indicados")->error();
            return redirect()->route('examenadmision.index');
        }
    }

    //auditoria admision
    public function setAuditoriaadmision($operacion, $string1, $r)
    {
        $u = Auth::user();
        $aud = new Auditoriaadmision();
        $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
        $aud->operacion = $operacion;
        $str = $string1;
        foreach ($r->attributesToArray() as $key => $value) {
            $str = $str . ", " . $key . ": " . $value;
        }
        $aud->detalles = $str;
        $aud->save();
    }

    //muestra el formulario para el examen de admision
    public function examen($id)
    {
        $a = Aspirante::find($id);
        $e = null;
        $e = $a->examenadmision;
        $u = Auth::user();
        if ($e == null) {
            $e = new Examenadmision();
            $e->calificacion = 0.0;
            $e->estado = "PENDIENTE";
            $e->aspirante_id = $id;
            $e->user_change = $u->identificacion;
            if ($e->save()) {
                $this->setAuditoriaadmision('INSERTAR', 'CREACIÓN DE EXAMEN DE ADMISION. DATOS: ', $e);
            } else {
                flash("No se pudo establecer el examen del aspirante")->error();
                return redirect()->route('examenadmision.index');
            }
        }
        $areas = $e->examenadmisionareas;
        if (count($areas) <= 0) {
            $ar = Areaexamenadmisiongrado::where('grado_id', $a->grado_id)->get();
            if (count($ar) > 0) {
                foreach ($ar as $i) {
                    $j = new Examenadmisionarea();
                    $j->calificacion = 0.0;
                    $j->areaexamenadmisiongrado_id = $i->id;
                    $j->examenadmision_id = $e->id;
                    $j->user_change = $u->identificacion;
                    if ($j->save()) {
                        $this->setAuditoriaadmision('INSERTAR', 'CREACIÓN DE AREA PARA CALIFICAR EXAMEN DE ADMISION. DATOS: ', $j);
                        $areas[] = $j;
                    }
                }
            }
        }
        if (count($areas) <= 0) {
            flash("No hay áreas a evaluar definidas para el aspirante.")->error();
            return redirect()->route('examenadmision.index');
        }
        $estados = [
            'APROBADO' => 'APROBADO',
            'REPROBADO' => 'REPROBADO',
            'PENDIENTE' => 'PENDIENTE'
        ];
        $e->valor_cualitativo = $this->cualitativo($e->calificacion);
        return view('admisiones.agenda_entrevista.examen_admision.examen')
            ->with('location', 'admisiones')
            ->with('a', $a)
            ->with('e', $e)
            ->with('areas', $areas)
            ->with('estados', $estados);
    }

    //determina el valor cualitativo para una calificacion
    public function cualitativo($valor)
    {
        $notas = Rangonota::all();
        $valor_c = "";
        if (count($notas) > 0) {
            foreach ($notas as $n) {
                if ($valor >= $n->valor_inicial && $valor <= $n->valor_final) {
                    $valor_c = $n->valor_cualitativo;
                }
            }
        }
        return $valor_c;
    }
}
