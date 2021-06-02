<?php

namespace App\Http\Controllers;

use App\Actividad;
use App\Actividadpregunta;
use App\Auditoriaacademico;
use App\Ctundestapracts;
use App\Ctunidad;
use App\Evaluacionacademica;
use App\Grupomateriadocente;
use App\Pregunta;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ActividadController extends Controller
{
    // indice
    public function index($id) {
        $gmd = Grupomateriadocente::find($id);
        $actividades = Actividad::where([['grado_id', $gmd->gradomateria->grado_id], ['materia_id', $gmd->gradomateria->materia_id]])->get();
        return view('aula_virtual.docente.bancoactividad')
            ->with('location', 'aulavirtual')
            ->with('gmd', $gmd)
            ->with('actividades', $actividades);
    }

    //crear actividad
    public function crear($id) {
        $gmd = Grupomateriadocente::find($id);
        $evs = Evaluacionacademica::all();
        $mat = $gmd->gradomateria->materia_id;
        $grd = $gmd->gradomateria->grado_id;
        $unidades = Ctunidad::where([['materia_id', $mat], ['grado_id', $grd]])->get()->pluck('nombre', 'id');
        if (count($unidades) <= 0) {
            flash('No hay unidades para crear actividades')->error();
            return redirect()->route('actividad.index', $id);
        }
        $evaluaciones = null;
        if (count($evs) > 0) {
            foreach ($evs as $e) {
                $evaluaciones[$e->id] = $e->nombre . " (" . $e->peso . "%) - SISTEMA DE EVALUACIÓN: " . $e->sistemaevaluacion->nombre;
            }
        }
        if ($evaluaciones == null) {
            flash('No hay evaluaciones académicas para crear actividades')->error();
            return redirect()->route('actividad.index', $id);
        }
        return view('aula_virtual.docente.bancoactividadcrear')
            ->with('location', 'aulavirtual')
            ->with('gmd', $gmd)
            ->with('unidades', $unidades)
            ->with('evaluaciones', $evaluaciones);
    }

    //guardar actividad
    public function store(Request $request) {
        $validate = Validator::make($request->all(), [
            'ctunidadtema_id' => 'required',
            'nombre' => 'required',
            'logros' => 'required'
        ]);
        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate->errors());
        }
        $a = new Actividad();
        $a->nombre = strtoupper($request->nombre);
        $a->descripcion = strtoupper($request->descripcion);
        $a->recurso = "NO";
        $a->tipo = $request->tipo;
        $u = Auth::user();
        $a->user_change = $u->identificacion;
        $a->user_id = $u->id;
        $a->evaluacionacademica_id = $request->evaluacionacademica_id;
        $gmd = Grupomateriadocente::find($request->gmd_id);
        $a->grado_id = $gmd->gradomateria->grado_id;
        $a->materia_id = $gmd->gradomateria->materia_id;
        $a->ctunidadtema_id = $request->ctunidadtema_id;
        if (!isset($request->logros) || count($request->logros) <= 0) {
            flash('Debe seleccionar mínimo un logro para la actividad.')->warning();
            return redirect()->back()->withInput($request->all());
        }
        if ($request->tipo == 'ACTIVIDAD-RECURSO') {
            if (isset($request->recurso)) {
                $recurso = $request->file('recurso');
                $name = "Recurso_" . $recurso->getClientOriginalName();
                $path = public_path() . "/documentos/aulavirtual/";
                $recurso->move($path, $name);
                $a->recurso = $name;
            }
        }
        if ($request->tipo == 'ACTIVIDAD-ESCRITA') {
            $a->recurso = $request->recurso;
        }
        if ($a->save()) {
            $a->ctunidadestandaraprendizajes()->sync($request->logros);

//            foreach ($request->logros as $item) {
//                $ct = new Ctundestapracts();
//                $ct->actividad_id = $a->id;
//                $ct->ctunidadestandaraprendizaje_id = $item;
//                $ct->user_id = $a->user_id;
//                $ct->save();
//            }
            $this->setAuditoria('INSERTAR', 'CREAR ACTIVIDAD ACADEMICA. DATOS CREADOS: ', $a);
            flash('Actividad creada con exito')->success();
            return redirect()->route('actividad.index', $request->gmd_id);
        } else {
            flash('La actividad no pudo ser creada')->error();
            return redirect()->route('actividad.index', $request->gmd_id);
        }
    }

    //auditoria
    public function setAuditoria($operacion, $title, $obj) {
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
    public function show($gmd_id, $id) {
        $gmd = Grupomateriadocente::find($gmd_id);
        $a = Actividad::find($id);
        return view('aula_virtual.docente.bancoactividadver')
            ->with('location', 'aulavirtual')
            ->with('gmd', $gmd)
            ->with('a', $a);
    }

    //edit
    public function edit($gmd_id, $id) {
        $gmd = Grupomateriadocente::find($gmd_id);
        $a = Actividad::find($id);
        $evs = Evaluacionacademica::all();
        $unidades = Ctunidad::where([['materia_id', $gmd->gradomateria->materia_id], ['grado_id', $gmd->gradomateria->grado_id]])->get()->pluck('nombre', 'id');
        if (count($unidades) <= 0) {
            flash('No hay unidades para crear actividades')->error();
            return redirect()->route('actividad.index', $id);
        }
        $evaluaciones = null;
        if (count($evs) > 0) {
            foreach ($evs as $e) {
                $evaluaciones[$e->id] = $e->nombre . " (" . $e->peso . "%) - SISTEMA DE EVALUACIÓN: " . $e->sistemaevaluacion->nombre;
            }
        }
        $logros = json_decode($this->getAprendizajes($a->ctunidadtema->ctunidad_id));
//        dd(json_decode($logros));
        return view('aula_virtual.docente.bancoactividadedit')
            ->with('location', 'aulavirtual')
            ->with('gmd', $gmd)
            ->with('a', $a)
            ->with('unidades', $unidades)
            ->with('logros', $logros)
            ->with('evaluaciones', $evaluaciones);
    }

    //update
    public function update(Request $request) {
//        dd($request->all());
        $a = Actividad::find($request->a_id);
        if ($request->data == 'BASICO') {
            $a->nombre = strtoupper($request->nombre);
            $a->descripcion = strtoupper($request->descripcion);
            $u = Auth::user();
            $a->user_change = $u->identificacion;
            $a->evaluacionacademica_id = $request->evaluacionacademica_id;
        }
        if ($request->data == 'DOCUMENTO') {
            if (isset($request->recurso)) {
                $recurso = $request->file('recurso');
                $name = "Recurso_" . $recurso->getClientOriginalName();
                $path = public_path() . "/documentos/aulavirtual/";
                $recurso->move($path, $name);
                $a->recurso = $name;
            }
        }
        if ($request->data == 'ESCRITO') {
            $a->recurso = $request->recurso;
        }
        $a->ctunidadtema_id = $request->ctunidadtema_id;
        if ($a->save()) {
            $a->ctunidadestandaraprendizajes()->sync($request->logros);
            $this->setAuditoria('ACTUALIZAR', 'ACTUALIZAR ACTIVIDAD ACADEMICA. DATOS ACTUALIZADOS: ', $a);
            flash('Actividad actualizada con exito')->success();
            return redirect()->route('actividad.index', $request->gmd_id);
        } else {
            flash('La actividad no pudo ser actualizada')->error();
            return redirect()->route('actividad.index', $request->gmd_id);
        }
    }

    //continuar
    public function continuar($gmd_id, $id) {
        $gmd = Grupomateriadocente::find($gmd_id);
        $a = Actividad::find($id);
        $preguntas = Pregunta::where([['grado_id', $a->grado_id], ['materia_id', $a->materia_id]])->get();
        $preguntasya = $a->actividadpreguntas;
        return view('aula_virtual.docente.bancoactividadcontinuar')
            ->with('location', 'aulavirtual')
            ->with('gmd', $gmd)
            ->with('a', $a)
            ->with('preguntas', $preguntas)
            ->with('preguntasya', $preguntasya);
    }

    //add pregunta
    public function addpregunta($gmd, $a, $p) {
        $ap = new Actividadpregunta();
        $ap->actividad_id = $a;
        $ap->pregunta_id = $p;
        $old = Actividadpregunta::where([['actividad_id', $a], ['pregunta_id', $p]])->get();
        if (count($old) > 0) {
            flash('La pregunta ya ha sido añadida antes')->warning();
            return redirect()->route('actividad.continuar', [$gmd, $a]);
        }
        if ($ap->save()) {
            $this->setAuditoria('CREAR', 'ASOCIAR PREGUNTA A ACTIVIDAD ACADEMICA. DATOS INSERTADOS: ', $ap);
            flash('Pregunta asociada a la actividad con exito')->success();
            return redirect()->route('actividad.continuar', [$gmd, $a]);
        } else {
            flash('La pregunta no pudo ser asociada a la actividad')->error();
            return redirect()->route('actividad.continuar', [$gmd, $a]);
        }
    }

    //delete pregunta
    public function deletepregunta($gmd, $py) {
        $ap = Actividadpregunta::find($py);
        if ($ap->delete()) {
            $this->setAuditoria('ELIMINAR', 'QUITAR PREGUNTA DE ACTIVIDAD ACADEMICA. DATOS RETIRADOS: ', $ap);
            flash('Pregunta retirada de la actividad con exito')->success();
            return redirect()->route('actividad.continuar', [$gmd, $ap->actividad_id]);
        } else {
            flash('La pregunta no pudo ser retirada la actividad')->error();
            return redirect()->route('actividad.continuar', [$gmd, $ap->actividad_id]);
        }
    }

    //obtiene los temas de una ctunidad_id
    public function getTemas($ctunidad_id) {
        $ctunid = Ctunidad::findOrFail($ctunidad_id);
        if ($ctunid == null)
            return "null";

        $temas = $ctunid->ctunidadtemas()->pluck('titulo', 'id');
        if (count($temas) <= 0)
            return "null";

        return json_encode($temas);
    }

    /**
     * SELECT ctunidadestandaraprendizajes.id,
     * (SELECT aprendizajes.logro FROM aprendizajes WHERE aprendizajes.id = ctunidadestandaraprendizajes.aprendizaje_id) AS 'logro'
     * FROM ctunidadestandars
     * INNER JOIN ctunidadestandaraprendizajes ON ctunidadestandaraprendizajes.ctunidadestandar_id = ctunidadestandars.id
     * WHERE ctunidadestandars.ctunidad_id = 1
     * @param $ctunidad_id
     *
     */
    public function getAprendizajes($ctunidad_id) {
        $query = DB::table('ctunidadestandars')
            ->join('ctunidadestandaraprendizajes', 'ctunidadestandaraprendizajes.ctunidadestandar_id', '=', 'ctunidadestandars.id')
            ->select('ctunidadestandaraprendizajes.id',
                DB::raw("(SELECT aprendizajes.logro FROM aprendizajes WHERE aprendizajes.id = ctunidadestandaraprendizajes.aprendizaje_id) AS logro"))
            ->where('ctunidadestandars.ctunidad_id', $ctunidad_id)->orderBy('logro')->get();
        if (count($query) <= 0)
            return "null";

        return json_encode($query);
    }
}
