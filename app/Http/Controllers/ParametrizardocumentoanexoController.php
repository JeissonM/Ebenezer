<?php

namespace App\Http\Controllers;

use App\Parametrizardocumentoanexo;
use Illuminate\Http\Request;
use App\Http\Requests\ParametrizardocanexoRequest;
use App\Documentoanexo;
use App\Unidad;
use App\Jornada;
use App\Grado;
use App\Auditoriaadmision;
use Illuminate\Support\Facades\Auth;
use App\Procesosacademicos;

class ParametrizardocumentoanexoController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $unidades = Unidad::all()->pluck('nombre', 'id');
        $jornadas = Jornada::all()->pluck('descripcion', 'id');
        $grados = $this->pluck(Grado::all());
        $docs = Documentoanexo::all()->pluck('nombre', 'id');
        $proc = Procesosacademicos::all();
        $procesos = null;
        if (count($proc) > 0) {
            foreach ($proc as $p) {
                $procesos[$p->id] = $p->nombre . " - " . $p->descripcion;
            }
        } else {
            flash("No hay procesos académicos en el sistema, no puede continuar")->error();
            return redirect()->route('menu.admisiones');
        }
        return view('admisiones.admision_matricula.parametrizar_documentos_anexos.list')
            ->with('location', 'admisiones')
            ->with('unidades', $unidades)
            ->with('jornadas', $jornadas)
            ->with('grados', $grados)
            ->with('procesos', $procesos)
            ->with('docs', $docs);
    }

    function pluck($array)
    {
        $grados = null;
        if (count($array) > 0) {
            foreach ($array as $g) {
                $grados[$g->id] = "ETIQUETA: " . $g->etiqueta . " - DESCRIPCIÓN: " . $g->descripcion;
            }
        }
        return $grados;
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
     * @param  \App\Parametrizardocumentoanexo  $parametrizardocumentoanexo
     * @return \Illuminate\Http\Response
     */
    public function show(Parametrizardocumentoanexo $parametrizardocumentoanexo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Parametrizardocumentoanexo  $parametrizardocumentoanexo
     * @return \Illuminate\Http\Response
     */
    public function edit(Parametrizardocumentoanexo $parametrizardocumentoanexo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Parametrizardocumentoanexo  $parametrizardocumentoanexo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Parametrizardocumentoanexo $parametrizardocumentoanexo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Parametrizardocumentoanexo  $parametrizardocumentoanexo
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pda = Parametrizardocumentoanexo::find($id);
        $result = $pda->delete();
        if ($result) {
            $aud = new Auditoriaadmision();
            $u = Auth::user();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ELIMINAR";
            $str = "ELIMINACIÓN DE LA PARAMETRIZACIÓN DEL DOCUMENTO ANEXO. DATOS ELIMINADOS: ";
            foreach ($pda->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("El documento anexo <strong>" . $pda->documentoanexo->nombre . "</strong> fue eliminado de forma exitosa!")->success();
            return redirect()->route('parametrizardocumentosanexos.index');
        } else {
            flash("El documento anexo <strong>" . $pda->documentoanexo->nombre . "</strong> no pudo ser eliminado. Error: " . $result)->error();
            return redirect()->route('parametrizardocumentosanexos.index');
        }
    }

    /*
     * @param $unidad, $jornada, $grado
     * @return $response
     */

    public function getParametrizados($unidad, $jornada, $grado, $proceso)
    {
        $docs = Parametrizardocumentoanexo::where([['grado_id', $grado], ['unidad_id', $unidad], ['jornada_id', $jornada], ['procesosacademico_id', $proceso]])->get();
        $response = null;
        $response['error'] = "NO";
        if (count($docs) > 0) {
            $docs2 = null;
            foreach ($docs as $d) {
                $docs2[] = [
                    'id' => $d->id,
                    'nombre' => $d->documentoanexo->nombre
                ];
            }
            if (count($docs2) > 0) {
                $response['data'] = $docs2;
            } else {
                $response['error'] = "SI";
                $response['mensaje'] = "No hay documentos anexos asociados a los parámetros dados.";
            }
        } else {
            $response['error'] = "SI";
            $response['mensaje'] = "No hay documentos anexos asociados a los parámetros dados.";
        }
        return json_encode($response);
    }

    /*
     * @param $unidad, $jornada, $grado, $id
     * @return $response
     */

    public function storeParametrizados($unidad, $jornada, $grado, $proceso, $id)
    {
        $response = null;
        $response['error'] = "NO";
        $doca = Parametrizardocumentoanexo::where([['grado_id', $grado], ['unidad_id', $unidad], ['jornada_id', $jornada], ['procesosacademico_id', $proceso], ['documentoanexo_id', $id]])->get();
        if (count($doca) > 0) {
            $response['error'] = "SI";
            $response['mensaje'] = "El documento anexo no pudo ser almacenado porque ya existe en la base de datos para los parámetros dados.";
        } else {
            $pda = new Parametrizardocumentoanexo();
            $pda->documentoanexo_id = $id;
            $pda->unidad_id = $unidad;
            $pda->jornada_id = $jornada;
            $pda->grado_id = $grado;
            $pda->procesosacademico_id = $proceso;
            $u = Auth::user();
            $pda->user_change = $u->identificacion;
            $result = $pda->save();
            if ($result) {
                $aud = new Auditoriaadmision();
                $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
                $aud->operacion = "INSERTAR";
                $str = "PARAMETRIZACIÓN DE DOCUMENTOS ANEXOS. DATOS: ";
                foreach ($pda->attributesToArray() as $key => $value) {
                    $str = $str . ", " . $key . ": " . $value;
                }
                $aud->detalles = $str;
                $aud->save();
                $response['mensaje'] = "El documento anexo fue almacenado con éxito.";
            } else {
                $response['error'] = "SI";
                $response['mensaje'] = "El documento anexo no pudo ser almacenado.";
            }
        }
        return json_encode($response);
    }
}
