<?php

namespace App\Http\Controllers;

use App\Actividad;
use App\Actividadpregunta;
use App\Auditoriaacademico;
use App\Evaluacionacademica;
use App\Grupomateriadocente;
use App\Pregunta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EbeducController extends Controller
{
    // indice
    public function index($id)
    {
        $gmd = Grupomateriadocente::find($id);
        $actividades = Actividad::where([['grado_id', $gmd->gradomateria->grado_id], ['materia_id', $gmd->gradomateria->materia_id], ['ebeduc', 'SI']])->get();
        return view('aula_virtual.docente.bancoebeduc')
            ->with('location', 'aulavirtual')
            ->with('gmd', $gmd)
            ->with('actividades', $actividades);
    }

    //crear ebeduc
    public function crear($id)
    {
        $gmd = Grupomateriadocente::find($id);
        $evs = Evaluacionacademica::all();
        $evaluaciones = null;
        if (count($evs) > 0) {
            foreach ($evs as $e) {
                $evaluaciones[$e->id] = $e->nombre . " (" . $e->peso . "%) - SISTEMA DE EVALUACIÓN: " . $e->sistemaevaluacion->nombre;
            }
        }
        if ($evaluaciones == null) {
            flash('No hay evaluaciones académicas para crear pruebas')->error();
            return redirect()->route('ebeduc.index', $id);
        }
        return view('aula_virtual.docente.bancoebeduccrear')
            ->with('location', 'aulavirtual')
            ->with('gmd', $gmd)
            ->with('evaluaciones', $evaluaciones);
    }

    //guardar ebeduc 
    public function store(Request $request)
    {
        $a = new Actividad();
        $a->nombre = strtoupper($request->nombre);
        $a->descripcion = strtoupper($request->descripcion);
        $a->recurso = "NO";
        $a->tipo = "EXAMEN";
        $a->ebeduc = "SI";
        $u = Auth::user();
        $a->user_change = $u->identificacion;
        $a->user_id = $u->id;
        $a->evaluacionacademica_id = $request->evaluacionacademica_id;
        $gmd = Grupomateriadocente::find($request->gmd_id);
        $a->grado_id = $gmd->gradomateria->grado_id;
        $a->materia_id = $gmd->gradomateria->materia_id;
        if ($a->save()) {
            $this->setAuditoria('INSERTAR', 'CREAR PRUEBA EBEDUC. DATOS CREADOS: ', $a);
            flash('Ebeduc creada con exito')->success();
            return redirect()->route('ebeduc.index', $request->gmd_id);
        } else {
            flash('La prueba ebeduc no pudo ser creada')->error();
            return redirect()->route('ebeduc.index', $request->gmd_id);
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
        $a = Actividad::find($id);
        return view('aula_virtual.docente.bancoebeducver')
            ->with('location', 'aulavirtual')
            ->with('gmd', $gmd)
            ->with('a', $a);
    }

    //edit
    public function edit($gmd_id, $id)
    {
        $gmd = Grupomateriadocente::find($gmd_id);
        $a = Actividad::find($id);
        $evs = Evaluacionacademica::all();
        $evaluaciones = null;
        if (count($evs) > 0) {
            foreach ($evs as $e) {
                $evaluaciones[$e->id] = $e->nombre . " (" . $e->peso . "%) - SISTEMA DE EVALUACIÓN: " . $e->sistemaevaluacion->nombre;
            }
        }
        return view('aula_virtual.docente.bancoebeducedit')
            ->with('location', 'aulavirtual')
            ->with('gmd', $gmd)
            ->with('a', $a)
            ->with('evaluaciones', $evaluaciones);
    }

    //update
    public function update(Request $request)
    {
        $a = Actividad::find($request->a_id);
        $a->nombre = strtoupper($request->nombre);
        $a->descripcion = strtoupper($request->descripcion);
        $u = Auth::user();
        $a->user_change = $u->identificacion;
        $a->evaluacionacademica_id = $request->evaluacionacademica_id;
        if ($a->save()) {
            $this->setAuditoria('ACTUALIZAR', 'ACTUALIZAR PRUEBA EBEDUC. DATOS ACTUALIZADOS: ', $a);
            flash('Prueba actualizada con exito')->success();
            return redirect()->route('ebeduc.index', $request->gmd_id);
        } else {
            flash('La prueba no pudo ser actualizada')->error();
            return redirect()->route('ebeduc.index', $request->gmd_id);
        }
    }

    //continuar
    public function continuar($gmd_id, $id)
    {
        $gmd = Grupomateriadocente::find($gmd_id);
        $a = Actividad::find($id);
        $preguntas = Pregunta::where([['grado_id', $a->grado_id], ['materia_id', $a->materia_id], ['tipo', 'SELECCION MULTIPLE']])->get();
        $preguntasya = $a->actividadpreguntas;
        return view('aula_virtual.docente.bancoebeduccontinuar')
            ->with('location', 'aulavirtual')
            ->with('gmd', $gmd)
            ->with('a', $a)
            ->with('preguntas', $preguntas)
            ->with('preguntasya', $preguntasya);
    }

    //add pregunta
    public function addpregunta($gmd, $a, $p)
    {
        $ap = new Actividadpregunta();
        $ap->actividad_id = $a;
        $ap->pregunta_id = $p;
        $old = Actividadpregunta::where([['actividad_id', $a], ['pregunta_id', $p]])->get();
        if (count($old) > 0) {
            flash('La pregunta ya ha sido añadida antes')->warning();
            return redirect()->route('ebeduc.continuar', [$gmd, $a]);
        }
        if ($ap->save()) {
            $this->setAuditoria('CREAR', 'ASOCIAR PREGUNTA A LA PRUEBA EBEDUC. DATOS INSERTADOS: ', $ap);
            flash('Pregunta asociada a la prueba con exito')->success();
            return redirect()->route('ebeduc.continuar', [$gmd, $a]);
        } else {
            flash('La pregunta no pudo ser asociada a la prueba')->error();
            return redirect()->route('ebeduc.continuar', [$gmd, $a]);
        }
    }

    //delete pregunta
    public function deletepregunta($gmd, $py)
    {
        $ap = Actividadpregunta::find($py);
        if ($ap->delete()) {
            $this->setAuditoria('ELIMINAR', 'QUITAR PREGUNTA DE PRUEBA EBEDUC. DATOS RETIRADOS: ', $ap);
            flash('Pregunta retirada de la prueba con exito')->success();
            return redirect()->route('ebeduc.continuar', [$gmd, $ap->actividad_id]);
        } else {
            flash('La pregunta no pudo ser retirada la prueba')->error();
            return redirect()->route('ebeduc.continuar', [$gmd, $ap->actividad_id]);
        }
    }
}
