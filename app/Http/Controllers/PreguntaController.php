<?php

namespace App\Http\Controllers;

use App\Auditoriaacademico;
use App\Grupomateriadocente;
use App\Pregunta;
use App\Respuesta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PreguntaController extends Controller
{
    //index
    public function index($id)
    {
        $gmd = Grupomateriadocente::find($id);
        $preguntas = Pregunta::where([['grado_id', $gmd->gradomateria->grado_id], ['materia_id', $gmd->gradomateria->materia_id]])->get();
        if (count($preguntas) > 0) {
            foreach ($preguntas as $p) {
                $r = "---";
                if ($p->respuesta_id != null) {
                    $r = Respuesta::find($p->respuesta_id)->letra;
                }
                $p->resp = $r;
            }
        }
        return view('aula_virtual.docente.bancopregunta')
            ->with('location', 'aulavirtual')
            ->with('gmd', $gmd)
            ->with('preguntas', $preguntas);
    }

    //crear pregunta
    public function crear($id)
    {
        $gmd = Grupomateriadocente::find($id);
        return view('aula_virtual.docente.bancopreguntacrear')
            ->with('location', 'aulavirtual')
            ->with('gmd', $gmd);
    }

    //guardar pregunta
    public function store(Request $request)
    {
        $a = new Pregunta();
        $a->pregunta = $request->pregunta;
        $a->puntos = $request->puntos;
        $a->tipo = $request->tipo;
        $u = Auth::user();
        $a->user_change = $u->identificacion;
        $a->user_id = $u->id;
        $gmd = Grupomateriadocente::find($request->gmd_id);
        $a->grado_id = $gmd->gradomateria->grado_id;
        $a->materia_id = $gmd->gradomateria->materia_id;
        if ($a->save()) {
            $this->setAuditoria('INSERTAR', 'CREAR PREGUNTA PARA ACTIVIDAD. DATOS CREADOS: ', $a);
            flash('Pregunta creada con exito')->success();
            return redirect()->route('preguntas.index', $request->gmd_id);
        } else {
            flash('La pregunta no pudo ser creada')->error();
            return redirect()->route('preguntas.index', $request->gmd_id);
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

    //show
    public function show($gmd_id, $id)
    {
        $gmd = Grupomateriadocente::find($gmd_id);
        $a = Pregunta::find($id);
        $resp = "---";
        if ($a != null) {
            if ($a->respuesta_id != null) {
                $resp = Respuesta::find($a->respuesta_id)->letra;
            }
        }
        $a->resp = $resp;
        return view('aula_virtual.docente.bancopreguntaver')
            ->with('location', 'aulavirtual')
            ->with('gmd', $gmd)
            ->with('a', $a);
    }

    //edit
    public function edit($gmd_id, $id)
    {
        $gmd = Grupomateriadocente::find($gmd_id);
        $a = Pregunta::find($id);
        return view('aula_virtual.docente.bancopreguntaedit')
            ->with('location', 'aulavirtual')
            ->with('gmd', $gmd)
            ->with('a', $a);
    }

    //update
    public function update(Request $request)
    {
        $a = Pregunta::find($request->a_id);
        $a->puntos = $request->puntos;
        $a->pregunta = $request->pregunta;
        $a->tipo = $request->tipo;
        $u = Auth::user();
        $a->user_change = $u->identificacion;
        if ($a->save()) {
            $this->setAuditoria('ACTUALIZAR', 'ACTUALIZAR PREGUNTA DE ACTIVIDAD. DATOS ACTUALIZADOS: ', $a);
            flash('Pregunta actualizada con exito')->success();
            return redirect()->route('preguntas.index', $request->gmd_id);
        } else {
            flash('La Pregunta no pudo ser actualizada')->error();
            return redirect()->route('preguntas.index', $request->gmd_id);
        }
    }

    //continuar
    public function continuar($gmd_id, $id)
    {
        $gmd = Grupomateriadocente::find($gmd_id);
        $a = Pregunta::find($id);
        $resp = "---";
        if ($a != null) {
            if ($a->respuesta_id != null) {
                $resp = Respuesta::find($a->respuesta_id)->letra;
            }
        }
        $a->resp = $resp;
        return view('aula_virtual.docente.bancopreguntacontinuar')
            ->with('location', 'aulavirtual')
            ->with('gmd', $gmd)
            ->with('a', $a);
    }

    //guardar respuesta
    public function storerespuesta(Request $request)
    {
        $a = new Respuesta($request->all());
        $a->letra = strtoupper($a->letra);
        if ($a->save()) {
            $this->setAuditoria('INSERTAR', 'CREAR RESPUESTA PARA PREGUNTA DE ACTIVIDAD. DATOS CREADOS: ', $a);
            flash('Respuesta creada con exito')->success();
            return redirect()->route('preguntas.continuar', [$request->gmd_id, $request->pregunta_id]);
        } else {
            flash('La respuesta no pudo ser creada')->error();
            return redirect()->route('preguntas.continuar', [$request->gmd_id, $request->pregunta_id]);
        }
    }

    //marca la respuesta como correcta
    public function correctarespuesta($gmd, $id)
    {
        $r = Respuesta::find($id);
        $p = $r->pregunta;
        $p->respuesta_id = $id;
        if ($p->save()) {
            flash('Respuesta marcada como correcta')->success();
            return redirect()->route('preguntas.continuar', [$gmd, $r->pregunta_id]);
        } else {
            flash('La respuesta no pudo ser marcada como correcta')->error();
            return redirect()->route('preguntas.continuar', [$gmd, $r->pregunta_id]);
        }
    }

    //update respuesta
    public function editrespuesta(Request $request)
    {
        $a = Respuesta::find($request->respuesta_id);
        $a->letra = $request->letra;
        $a->letra = strtoupper($a->letra);
        $a->respuesta = $request->respuesta;
        if ($a->save()) {
            $this->setAuditoria('ACTUALIZAR', 'ACTUALIZAR RESPUESTA DE PREGUNTA DE ACTIVIDAD. DATOS ACTUALIZADOS: ', $a);
            flash('Respuesta actualizada con exito')->success();
            return redirect()->route('preguntas.continuar', [$request->gmd_id, $a->pregunta_id]);
        } else {
            flash('La respuesta no pudo ser actualizada')->error();
            return redirect()->route('preguntas.continuar', [$request->gmd_id, $a->pregunta_id]);
        }
    }

    //delete respuesta
    public function deleterespuesta($gmd, $r)
    {
        $r = Respuesta::find($r);
        if ($r->delete()) {
            $this->setAuditoria('ELIMINAR', 'ELIMINAR RESPUESTA DE PREGUNTA DE ACTIVIDAD. DATOS ELIMINADOS: ', $r);
            flash('Respuesta eliminada con exito')->success();
            return redirect()->route('preguntas.continuar', [$gmd, $r->pregunta_id]);
        } else {
            flash('La respuesta no pudo ser eliminada')->error();
            return redirect()->route('preguntas.continuar', [$gmd, $r->pregunta_id]);
        }
    }
}
