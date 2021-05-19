<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Docente;
use Illuminate\Support\Facades\Auth;
use App\Auditoriaacademico;
use App\Personanatural;
use App\Situacionadministrativa;

class DocenteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $docentes = Docente::all();
        $sit = Situacionadministrativa::all();
        $situaciones = null;
        if (count($sit) > 0) {
            foreach ($sit as $s) {
                $situaciones[$s->id] = $s->nombre . " - " . $s->descripcion;
            }
        }
        return view('academico.registro_academico.docentes.list')
            ->with('location', 'academico')
            ->with('docentes', $docentes)
            ->with('situaciones', $situaciones);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sit = Situacionadministrativa::all();
        $situaciones = null;
        if (count($sit) > 0) {
            foreach ($sit as $s) {
                $situaciones[$s->id] = $s->nombre . " - " . $s->descripcion;
            }
        }
        return view('academico.registro_academico.docentes.create')
            ->with('location', 'academico')
            ->with('situaciones', $situaciones);
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
        //
    }

    /*
     * consulta de personas
     */

    public function busqueda($tp, $clave, $valor)
    {
        switch ($tp) {
            case 'NATURAL':
                return $this->buscarNatural($clave, $valor);
                break;
            case 'JURIDICA':
                //return $this->buscarJuridica($clave, $valor);
                break;
            case 'ESTUDIANTE':
                //return $this->buscarEstudiante($clave, $valor);
                break;
        }
    }

    /*
     * busca persona natural
     */

    public function buscarNatural($clave, $valor)
    {
        switch ($clave) {
            case 'IDENTIFICACION':
                $personas = Personanatural::all();
                if (count($personas) > 0) {
                    $pens = null;
                    foreach ($personas as $pn) {
                        if (stripos($pn->persona->numero_documento, $valor) !== false) {
                            $n = null;
                            $n['tipo'] = "N";
                            $n['id'] = $pn->id;
                            $n['ident'] = $pn->persona->numero_documento;
                            $n['persona'] = $pn->primer_nombre . " " . $pn->segundo_nombre . " " . $pn->primer_apellido . " " . $pn->segundo_apellido;
                            $n['situacion'] = "";
                            $pens[] = $n;
                        }
                    }
                    if ($pens !== null) {
                        return json_encode($pens);
                    } else {
                        return "null";
                    }
                } else {
                    return "null";
                }
                break;
            case 'NOMBRES':
                $personas = Personanatural::all();
                if (count($personas) > 0) {
                    $pens = null;
                    foreach ($personas as $pn) {
                        $texto = $pn->primer_nombre . " " . $pn->segundo_nombre . " " . $pn->primer_apellido . " " . $pn->segundo_apellido;
                        if (stripos($texto, $valor) !== false) {
                            $n = null;
                            $n['tipo'] = "N";
                            $n['id'] = $pn->id;
                            $n['ident'] = $pn->persona->numero_documento;
                            $n['persona'] = $texto;
                            $n['situacion'] = "";
                            $pens[] = $n;
                        }
                    }
                    if ($pens !== null) {
                        return json_encode($pens);
                    } else {
                        return "null";
                    }
                } else {
                    return "null";
                }
                break;
            default:
                return "null";
                break;
        }
    }

    //almacenar
    public function docente($pn, $s)
    {
        $d = new Docente();
        $d->personanatural_id = $pn;
        $d->situacionadministrativa_id = $s;
        $u = Auth::user();
        $d->user_change = $u->identificacion;
        if ($d->save()) {
            $this->setAuditoria('INSERTAR', 'CREAR DOCENTE. DATOS NUEVOS: ', $d);
            flash('La persona fue asignada como docente')->success();
            return redirect()->route('docente.index');
        } else {
            flash('La persona no pudo ser asignada como docente')->error();
            return redirect()->route('docente.index');
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

    //cambiar situacion
    public function cambiarSituacion($d, $s)
    {
        $doc = Docente::find($d);
        $doc->situacionadministrativa_id = $s;
        $u = Auth::user();
        $doc->user_change = $u->identificacion;
        if ($doc->save()) {
            $this->setAuditoria('ACTUALIZAR', 'CTUALOZAR SITUACIÓN DOCENTE. DATOS NUEVOS: ', $doc);
            flash('La situación fue cambiada con exito')->success();
            return redirect()->route('docente.index');
        } else {
            flash('La situación no pudo ser cambiada')->error();
            return redirect()->route('docente.index');
        }
    }
}
