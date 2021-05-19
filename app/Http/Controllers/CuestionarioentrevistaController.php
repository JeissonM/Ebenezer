<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cuestionarioentrevista;
use Illuminate\Support\Facades\Auth;
use App\Circunscripcion;
use App\Http\Requests\CuestionarioentrevistaRequest;
use App\Auditoriaadmision;
use App\Cuestionariopregunta;
use App\Cuestionarioprespuesta;
use App\Http\Requests\CuestionariopreguntaRequest;

class CuestionarioentrevistaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cuestionarios = Cuestionarioentrevista::all();
        return view('admisiones.agenda_entrevista.cuestionarioentrevista.list')
            ->with('location', 'admisiones')
            ->with('cuestionarios', $cuestionarios);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cir = Circunscripcion::all();
        if (count($cir) > 0) {
            $circunscripciones = null;
            foreach ($cir as $c) {
                $circunscripciones[$c->id] = $c->nombre . " - " . $c->descripcion;
            }
            return view('admisiones.agenda_entrevista.cuestionarioentrevista.create')
                ->with('location', 'admisiones')
                ->with('circunscripciones', $circunscripciones);
        } else {
            flash("No hay circunscripciones para crear cuestionarios")->error();
            return redirect()->route('cuestionarioentrevista.index');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CuestionarioentrevistaRequest $request)
    {
        $c = new Cuestionarioentrevista($request->all());
        foreach ($c->attributesToArray() as $key => $value) {
            $c->$key = strtoupper($value);
        }
        $u = Auth::user();
        $c->user_change = $u->identificacion;
        $result = $c->save();
        if ($result) {
            $aud = new Auditoriaadmision();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "INSERTAR";
            $str = "CREACIÓN DE CUESTIONARIOS. DATOS: ";
            foreach ($c->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("El cuestionario <strong>" . $c->nombre . "</strong> fue almacenado de forma exitosa!")->success();
            return redirect()->route('cuestionarioentrevista.index');
        } else {
            flash("El cuestionario <strong>" . $c->nombre . "</strong> no pudo ser almacenado. Error: " . $result)->error();
            return redirect()->route('cuestionarioentrevista.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $c = Cuestionarioentrevista::find($id);
        return view('admisiones.agenda_entrevista.cuestionarioentrevista.show')
            ->with('location', 'admisiones')
            ->with('c', $c);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cu = Cuestionarioentrevista::find($id);
        $cir = Circunscripcion::all();
        $circunscripciones = null;
        foreach ($cir as $c) {
            $circunscripciones[$c->id] = $c->nombre . " - " . $c->descripcion;
        }
        return view('admisiones.agenda_entrevista.cuestionarioentrevista.edit')
            ->with('location', 'admisiones')
            ->with('c', $cu)
            ->with('circunscripciones', $circunscripciones);
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
        $c = Cuestionarioentrevista::find($id);
        $m = new Cuestionarioentrevista($c->attributesToArray());
        foreach ($c->attributesToArray() as $key => $value) {
            if (isset($request->$key)) {
                $c->$key = strtoupper($request->$key);
            }
        }
        $u = Auth::user();
        $c->user_change = $u->identificacion;
        $result = $c->save();
        if ($result) {
            $aud = new Auditoriaadmision();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ACTUALIZAR DATOS";
            $str = "EDICION DE CUESTIONARIO DE ENTREVISTA. DATOS NUEVOS: ";
            $str2 = " DATOS ANTIGUOS: ";
            foreach ($m->attributesToArray() as $key => $value) {
                $str2 = $str2 . ", " . $key . ": " . $value;
            }
            foreach ($c->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str . " - " . $str2;
            $aud->save();
            flash("El cuestionario <strong>" . $c->nombre . "</strong> fue modificado de forma exitosa!")->success();
            return redirect()->route('cuestionarioentrevista.index');
        } else {
            flash("El cuestionario <strong>" . $c->nombre . "</strong> no pudo ser modificado. Error: " . $result)->error();
            return redirect()->route('cuestionarioentrevista.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $c = Cuestionarioentrevista::find($id);
        if (count($c->cuestionariopreguntas) > 0) {
            flash("El cuestionario <strong>" . $c->nombre . "</strong> no pudo ser eliminado porque tiene preguntas asociadas.")->warning();
            return redirect()->route('cuestionarioentrevista.index');
        } else {
            $result = $c->delete();
            if ($result) {
                $aud = new Auditoriaadmision();
                $u = Auth::user();
                $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
                $aud->operacion = "ELIMINAR";
                $str = "ELIMINACIÓN DE CUESTIONARIO DE ENTREVISTA. DATOS ELIMINADOS: ";
                foreach ($c->attributesToArray() as $key => $value) {
                    $str = $str . ", " . $key . ": " . $value;
                }
                $aud->detalles = $str;
                $aud->save();
                flash("El cuestionario <strong>" . $c->nombre . "</strong> fue eliminado de forma exitosa!")->success();
                return redirect()->route('cuestionarioentrevista.index');
            } else {
                flash("El cuestionario <strong>" . $c->nombre . "</strong> no pudo ser eliminado. Error: " . $result)->error();
                return redirect()->route('cuestionarioentrevista.index');
            }
        }
    }

    //Continua a mostrar la gestion de cuestionario
    public function continuar($id)
    {
        $c = Cuestionarioentrevista::find($id);
        $c->cuestionariopreguntas;
        return view('admisiones.agenda_entrevista.cuestionarioentrevista.preguntaslist')
            ->with('location', 'admisiones')
            ->with('c', $c);
    }

    //form para crear pregunta
    public function preguntacreate($id)
    {
        $c = Cuestionarioentrevista::find($id);
        return view('admisiones.agenda_entrevista.cuestionarioentrevista.preguntascreate')
            ->with('location', 'admisiones')
            ->with('c', $c);
    }

    //guarda una pregunta
    public function preguntastore(CuestionariopreguntaRequest $request)
    {
        $c = new Cuestionariopregunta($request->all());
        foreach ($c->attributesToArray() as $key => $value) {
            $c->$key = strtoupper($value);
        }
        $u = Auth::user();
        $c->user_change = $u->identificacion;
        $result = $c->save();
        if ($result) {
            $aud = new Auditoriaadmision();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "INSERTAR";
            $str = "CREACIÓN DE PREGUNTA PARA CUESTIONARIOS. DATOS: ";
            foreach ($c->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("La pregunta fue almacenada de forma exitosa!")->success();
            return redirect()->route('cuestionarioentrevista.continuar', $request->cuestionarioentrevista_id);
        } else {
            flash("La pregunta no pudo ser almacenada. Error: " . $result)->error();
            return redirect()->route('cuestionarioentrevista.continuar', $request->cuestionarioentrevista_id);
        }
    }

    //elimina una pregunta
    public function preguntadelete($id)
    {
        $p = Cuestionariopregunta::find($id);
        $p->estado = "ELIMINADA";
        $result = $p->save();
        if ($result) {
            $aud = new Auditoriaadmision();
            $u = Auth::user();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ELIMINAR";
            $str = "ELIMINACIÓN DE PREGUNTA. DATOS ELIMINADOS: ";
            foreach ($p->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("La pregunta fue eliminada de forma exitosa!")->success();
            return redirect()->route('cuestionarioentrevista.continuar', $p->cuestionarioentrevista_id);
        } else {
            flash("La pregunta no pudo ser eliminada. Error: " . $result)->error();
            return redirect()->route('cuestionarioentrevista.continuar', $p->cuestionarioentrevista_id);
        }
    }

    //continua para gestionar respuestas
    public function preguntacontinuar($id)
    {
        $p = Cuestionariopregunta::find($id);
        $p->cuestionarioprespuestas;
        return view('admisiones.agenda_entrevista.cuestionarioentrevista.respuestaslist')
            ->with('location', 'admisiones')
            ->with('p', $p);
    }

    //form para crear respuesta
    public function respuestacreate($id)
    {
        $p = Cuestionariopregunta::find($id);
        return view('admisiones.agenda_entrevista.cuestionarioentrevista.respuestascreate')
            ->with('location', 'admisiones')
            ->with('p', $p);
    }

    //guarda una respuesta
    public function respuestastore(Request $request)
    {
        $r = new Cuestionarioprespuesta($request->all());
        foreach ($r->attributesToArray() as $key => $value) {
            $r->$key = strtoupper($value);
        }
        $u = Auth::user();
        $r->user_change = $u->identificacion;
        $result = $r->save();
        if ($result) {
            $aud = new Auditoriaadmision();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "INSERTAR";
            $str = "CREACIÓN DE RESPUESTA DE PREGUNTA PARA CUESTIONARIOS. DATOS: ";
            foreach ($r->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("La respuesta fue almacenada de forma exitosa!")->success();
            return redirect()->route('cuestionarioentrevista.preguntacontinuar', $request->cuestionariopregunta_id);
        } else {
            flash("La respuesta no pudo ser almacenada. Error: " . $result)->error();
            return redirect()->route('cuestionarioentrevista.preguntacontinuar', $request->cuestionariopregunta_id);
        }
    }

    //elimina una respuesta
    public function respuestadelete($id)
    {
        $r = Cuestionarioprespuesta::find($id);
        $result = $r->delete();
        if ($result) {
            $aud = new Auditoriaadmision();
            $u = Auth::user();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ELIMINAR";
            $str = "ELIMINACIÓN DE RESPUESTA. DATOS ELIMINADOS: ";
            foreach ($r->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("La respuesta fue eliminada de forma exitosa!")->success();
            return redirect()->route('cuestionarioentrevista.preguntacontinuar', $r->cuestionariopregunta_id);
        } else {
            flash("La respuesta no pudo ser eliminada. Error: " . $result)->error();
            return redirect()->route('cuestionarioentrevista.preguntacontinuar', $r->cuestionariopregunta_id);
        }
    }
}



//sociales
//español
//ingles
//matematica
//naturales
