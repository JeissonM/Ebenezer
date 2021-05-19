<?php

namespace App\Http\Controllers;

use App\Asignarrequisitogrado;
use App\Auditoriaacademico;
use App\Grado;
use App\Jornada;
use App\Requisitogrado;
use App\Unidad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AsignarrequisitogradoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $unidades = $jornadas = null;
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
        $requisitos = Requisitogrado::all();
        return view('academico.registro_academico.grados.asignar_requisito.list')
            ->with('location', 'academico')
            ->with('jornadas', $jornadas)
            ->with('unidades', $unidades)
            ->with('requisitos', $requisitos)
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
     * @param \App\Asignarrequisitogrado $asignarrequisitogrado
     * @return \Illuminate\Http\Response
     */
    public function show(Asignarrequisitogrado $asignarrequisitogrado)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Asignarrequisitogrado $asignarrequisitogrado
     * @return \Illuminate\Http\Response
     */
    public function edit(Asignarrequisitogrado $asignarrequisitogrado)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Asignarrequisitogrado $asignarrequisitogrado
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Asignarrequisitogrado $asignarrequisitogrado)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Asignarrequisitogrado $asignarrequisitogrado
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $asig = Asignarrequisitogrado::find($id);
        $result = $asig->delete();
        if ($result) {
            $aud = new Auditoriaacademico();
            $u = Auth::user();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ELIMINAR";
            $str = "ELIMINACIÓN DE REQUISITO A GRADO. DATOS ELIMINADOS: ";
            foreach ($asig->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            return "SI";
        } else {
            return "NO";
        }
    }

    /**
     * Obtiene los requisitos para un grado, unidad y jornada
     *
     * @param $unidad_id ,$jornada_id,$grado_id
     * @return \Illuminate\Http\Response
     */
    public function getRequisito($und, $jor, $gra)
    {
        $requisitos = Asignarrequisitogrado::where([['unidad_id', $und], ['jornada_id', $jor], ['grado_id', $gra]])->get();
        if ($requisitos != null) {
            if (count($requisitos) > 0) {
                $response = null;
                foreach ($requisitos as $item) {
                    $obj['id'] = $item->id;
                    $obj['unidad'] = $item->unidad->nombre . "-" . $item->unidad->descripcion . "-" . $item->unidad->ciudad->nombre;
                    $obj['jornada'] = $item->jornada->descripcion . "-" . $item->jornada->jornadasnies;
                    $obj['requisito'] = $item->requisitogrado->descripcion;
                    $obj['grado'] = $item->grado->etiqueta;
                    $response[] = $obj;
                }
                return json_encode($response);
            } else {
                return "null";
            }
        } else {
            return "null";
        }
    }

    /**
     * Agregar un requisito para un grado, unidad y jornada
     *
     * @param $unidad_id ,$jornada_id,$grado_id,$requisitogrado_id
     * @return \Illuminate\Http\Response
     */
    public function agregar($und, $jor, $gra, $req)
    {
        $existe = Asignarrequisitogrado::where([['unidad_id', $und], ['jornada_id', $jor], ['grado_id', $gra], ['requisitogrado_id', $req]])->first();
        if ($existe != null) {
            return "EXISTE";
        } else {
            $asig = new Asignarrequisitogrado();
            $asig->unidad_id = $und;
            $asig->jornada_id = $jor;
            $asig->grado_id = $gra;
            $asig->requisitogrado_id = $req;
            $u = Auth::user();
            $asig->user_change = $u->identificacion;
            $result = $asig->save();
            if ($result) {
                $aud = new Auditoriaacademico();
                $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
                $aud->operacion = "INSERTAR";
                $str = "ASIGNAR REQUISIRO A GRADO. DATOS: ";
                foreach ($asig->attributesToArray() as $key => $value) {
                    $str = $str . ", " . $key . ": " . $value;
                }
                $aud->detalles = $str;
                $aud->save();
                return "SI";
            } else {
                return "NO";
            }
        }
    }
}
