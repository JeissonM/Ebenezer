<?php

namespace App\Http\Controllers;

use App\Auditoriaacademico;
use App\Forodiscusion;
use App\Forodiscusionrespuesta;
use App\Grupomateriadocente;
use App\Http\Requests\ForodiscusionRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ForodiscusionController extends Controller
{
    //inicio docente foro
    public function iniciodocente($id)
    {
        $gmd = Grupomateriadocente::find($id);
        $foros = $gmd->forodiscusions;
        return view('aula_virtual.docente.foros')
            ->with('location', 'aulavirtual')
            ->with('gmd', $gmd)
            ->with('foros', $foros);
    }

    //inicio estudiante foro
    public function inicioestudiante($id)
    {
        $gmd = Grupomateriadocente::find($id);
        $foros = $gmd->forodiscusions;
        return view('aula_virtual.estudiante.foros')
            ->with('location', 'aulavirtual')
            ->with('gmd', $gmd)
            ->with('foros', $foros);
    }

    //create foro
    public function create($id)
    {
        $gmd = Grupomateriadocente::find($id);
        return view('aula_virtual.docente.foroscreate')
            ->with('location', 'aulavirtual')
            ->with('gmd', $gmd);
    }

    //create foro
    public function createe($id)
    {
        $gmd = Grupomateriadocente::find($id);
        return view('aula_virtual.estudiante.foroscreate')
            ->with('location', 'aulavirtual')
            ->with('gmd', $gmd);
    }

    //store foro
    public function store(ForodiscusionRequest $request)
    {
        $f = new Forodiscusion($request->all());
        $u = Auth::user();
        $f->user_change = $u->identificacion;
        $f->user_id = $u->id;
        if ($f->save()) {
            $this->setAuditoria('INSERTAR', 'CREACIÓN DE FORO DE DISCUSIÓN. DATOS NUEVOS: ', $f);
            flash('Tema creado con exito')->success();
            return redirect()->route('forodiscusion.docenteinicio', $request->grupomateriadocente_id);
        } else {
            flash('El tema no pudo ser creado, pruebe de nuevo')->error();
            return redirect()->route('forodiscusion.docenteinicio', $request->grupomateriadocente_id);
        }
    }

    //store foro
    public function storeforo(ForodiscusionRequest $request)
    {
        $f = new Forodiscusion($request->all());
        $u = Auth::user();
        $f->user_change = $u->identificacion;
        $f->user_id = $u->id;
        if ($f->save()) {
            $this->setAuditoria('INSERTAR', 'CREACIÓN DE FORO DE DISCUSIÓN. DATOS NUEVOS: ', $f);
            flash('Tema creado con exito')->success();
            return redirect()->route('forodiscusion.estudianteinicio', $request->grupomateriadocente_id);
        } else {
            flash('El tema no pudo ser creado, pruebe de nuevo')->error();
            return redirect()->route('forodiscusion.estudianteinicio', $request->grupomateriadocente_id);
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

    //leer foro
    public function leerforo($id)
    {
        $f = Forodiscusion::find($id);
        $f->forodiscusionrespuestas;
        $gmd = $f->grupomateriadocente;
        $contactos = $gmd->grupo->estudiantegrupos;
        $docente = $gmd->docente;
        return view('aula_virtual.docente.forosleer')
            ->with('location', 'aulavirtual')
            ->with('gmd', $gmd)
            ->with('foro', $f)
            ->with('contactos', $contactos)
            ->with('docente', $docente);
    }

    //leer foroe
    public function leerforoe($id)
    {
        $f = Forodiscusion::find($id);
        $f->forodiscusionrespuestas;
        $gmd = $f->grupomateriadocente;
        $contactos = $gmd->grupo->estudiantegrupos;
        $docente = $gmd->docente;
        return view('aula_virtual.estudiante.forosleer')
            ->with('location', 'aulavirtual')
            ->with('gmd', $gmd)
            ->with('foro', $f)
            ->with('contactos', $contactos)
            ->with('docente', $docente);
    }

    //guarda respuesta
    public function storerespuesta(Request $request)
    {
        $r = new Forodiscusionrespuesta($request->all());
        $u = Auth::user();
        $r->user_change = $u->identificacion;
        $r->user_id = $u->id;
        if ($r->save()) {
            $this->setAuditoria('INSERTAR', 'CREACIÓN DE RESPUESTA A FORO DE DISCUSIÓN. DATOS NUEVOS: ', $r);
            flash('Respuesta enviada con exito')->success();
            return redirect()->route('forodiscusion.leerforo', $request->forodiscusion_id);
        } else {
            flash('La respuesta no pudo ser creada, pruebe de nuevo')->error();
            return redirect()->route('forodiscusion.leerforo', $request->forodiscusion_id);
        }
    }

    //guarda respuesta
    public function storerespuestae(Request $request)
    {
        $r = new Forodiscusionrespuesta($request->all());
        $u = Auth::user();
        $r->user_change = $u->identificacion;
        $r->user_id = $u->id;
        if ($r->save()) {
            $this->setAuditoria('INSERTAR', 'CREACIÓN DE RESPUESTA A FORO DE DISCUSIÓN. DATOS NUEVOS: ', $r);
            flash('Respuesta enviada con exito')->success();
            return redirect()->route('forodiscusion.leerforoe', $request->forodiscusion_id);
        } else {
            flash('La respuesta no pudo ser creada, pruebe de nuevo')->error();
            return redirect()->route('forodiscusion.leerforoe', $request->forodiscusion_id);
        }
    }
}
