<?php

namespace App\Http\Controllers;

use App\Auditoriaacademico;
use App\Ocupacion;
use App\Pais;
use App\Persona;
use App\Personanatural;
use App\Sexo;
use App\Tipodoc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PersonanaturalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('academico.carga_administrativa.personas_naturales.list')
            ->with('location', 'academico');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tipodoc = Tipodoc::all()->pluck('descripcion', 'id');
        $paises = Pais::all()->pluck('nombre', 'id');
        $sexos = Sexo::all()->pluck('nombre', 'id');
        $profesions = Ocupacion::all()->pluck('descripcion', 'id');
        return view('academico.carga_administrativa.personas_naturales.create')
            ->with('location', 'academico')
            ->with('tipodoc', $tipodoc)
            ->with('paises', $paises)
            ->with('sexos', $sexos)
            ->with('profesions', $profesions);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $p = $this->setPersona('NATURAL', $request->mail, $request->direccion, $request->celular, $request->telefono, $request->numero_documento, $request->lugar_expedicion, $request->fecha_expedicion, null, null, $request->tipodoc_id, $request->pais_id, $request->estado_id, $request->ciudad_id);
        if ($p->save()) {
            $this->setAuditoria('INSERTAR', 'CREACIÓN DE PERSONA GENERAL. DATOS: ', $p);
            $pn = $this->setPersonanatural($request->primer_nombre, $request->segundo_nombre, $request->fecha_nacimiento, $request->libreta_militar, $request->edad, $request->rh, $request->primer_apellido, $request->segundo_apellido, $request->distrito_militar, $request->numero_pasaporte, $request->otra_nacionalidad, $request->clase_libreta, null, $request->profesion, $request->profesion, $request->nivel_estudio, $request->ciudadpn_id, $request->estadopn_id, $request->paispn_id, $p->id, $request->sexo_id);
            if ($pn->save()) {
                $this->setAuditoria('INSERTAR', 'CREACIÓN DE PERSONA NATURAL. DATOS: ', $pn);
                flash("Datos guardados con éxito.")->success();
                return redirect()->route('personanatural.index');
            } else {
                $p->delete();
                flash("Los datos no fueron guardados, no se pudo establecer la persona natural.")->error();
                return redirect()->route('personanatural.index');
            }
        } else {
            flash("Los datos no fueron guardados, no se pudo establecer la persona.")->error();
            return redirect()->route('personanatural.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Personanatural  $personanatural
     * @return \Illuminate\Http\Response
     */
    public function show(Personanatural $personanatural)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Personanatural  $personanatural
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pn = Personanatural::find($id);
        $p = $pn->persona;
        $tipodoc = Tipodoc::all()->pluck('descripcion', 'id');
        $paises = Pais::all()->pluck('nombre', 'id');
        $sexos = Sexo::all()->pluck('nombre', 'id');
        $profesions = Ocupacion::all()->pluck('descripcion', 'id');
        $rhs = [
            "A+" => "A+",
            "A-" => "A-",
            "B+" => "B+",
            "B-" => "B-",
            "AB+" => "AB+",
            "AB-" => "AB-",
            "O+" => "O+",
            "O-" => "O-"
        ];
        return view('academico.carga_administrativa.personas_naturales.edit')
            ->with('location', 'academico')
            ->with('p', $p)
            ->with('pn', $pn)
            ->with('tipodoc', $tipodoc)
            ->with('paises', $paises)
            ->with('sexos', $sexos)
            ->with('profesions', $profesions)
            ->with('rhs', $rhs);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Personanatural  $personanatural
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Personanatural $p)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Personanatural  $personanatural
     * @return \Illuminate\Http\Response
     */
    public function destroy(Personanatural $personanatural)
    {
        //
    }

    //atualizar
    public function actualizar(Request $request)
    {
        $pn = Personanatural::find($request->pn_id);
        $p = $pn->persona;
        //dd($pn);
        foreach ($pn->attributesToArray() as $key => $value) {
            if (isset($request->$key)) {
                $pn->$key = strtoupper($request->$key);
            }
        }
        $pn->pais_id = $request->paispn_id;
        $pn->estado_id = $request->estadopn_id;
        $pn->ciudad_id = $request->ciudadpn_id;
        $pn->ocupacion = strtoupper($request->profesion);
        $pn->profesion = strtoupper($request->profesion);
        foreach ($p->attributesToArray() as $key => $value) {
            if (isset($request->$key)) {
                $p->$key = strtoupper($request->$key);
            }
        }
        if ($p->save()) {
            $this->setAuditoria('ACTUALIZAR', 'ACTUALIZAR DATOS PERSONA GENERAL. DATOS CAMBIADOS: ', $p);
            if ($pn->save()) {
                $this->setAuditoria('ACTUALIZAR', 'ACTUALIZAR DATOS PERSONA NATURAL. DATOS CAMBIADOS: ', $pn);
                flash('Datos actualizados con exito')->success();
                return redirect()->route('personanatural.index');
            } else {
                flash('Solo fue posible actualizar los datos generales de la persona, los datos personales y de procedencia no fueron actualizados')->error();
                return redirect()->route('personanatural.index');
            }
        } else {
            flash('No fue posible realizar la actualización de los datos.')->error();
            return redirect()->route('personanatural.index');
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

    /*
     * Crea una Persona
     */

    public function setPersona($tipopersona = 'NATURAL', $mail = null, $direccion = null, $celular = null, $telefono = null, $numero_documento, $lugar_exp = null, $fecha_exp = null, $nombre_com = null, $regimen = null, $tipodoc = 0, $pais = null, $estado = null, $ciudad = null)
    {
        $p = new Persona();
        $p->tipopersona = $tipopersona;
        $p->direccion = strtoupper($direccion);
        $p->mail = $mail;
        $p->celular = $celular;
        $p->telefono = $telefono;
        $p->numero_documento = $numero_documento;
        $p->lugar_expedicion = strtoupper($lugar_exp);
        $p->fecha_expedicion = $fecha_exp;
        if ($nombre_com != null) {
            $p->nombrecomercial = strtoupper($nombre_com);
        } else {
            $p->nombrecomercial = $nombre_com;
        }
        if ($nombre_com != null) {
            $p->regimen = strtoupper($regimen);
        } else {
            $p->regimen = $regimen;
        }
        $p->tipodoc_id = $tipodoc;
        $p->pais_id = $pais;
        $p->estado_id = $estado;
        $p->ciudad_id = $ciudad;
        $u = Auth::user();
        $p->user_change = $u->identificacion;
        return $p;
    }

    /*
     * Crea una Persona Natural
     */

    public function setPersonanatural($primer_nombre, $segundo_nombre = null, $fecha_nacimiento = null, $libreta_militar = null, $edad = null, $rh = null, $primer_apellido, $segundo_apellido = null, $distrito_militar = null, $numero_pasaporte = null, $otra_nacionalidad = null, $clase_libreta = null, $fax = null, $ocupacion = null, $profesion = null, $nivel_estudio = null, $ciudad_id = null, $estado_id = null, $pais_id = null, $persona_id, $sexo_id = null)
    {
        $pn = new Personanatural();
        $pn->primer_nombre = strtoupper($primer_nombre);
        $pn->segundo_nombre = strtoupper($segundo_nombre);
        $pn->fecha_nacimiento = $fecha_nacimiento;
        $pn->libreta_militar = $libreta_militar;
        $pn->edad = $edad;
        $pn->rh = $rh;
        $pn->primer_apellido = strtoupper($primer_apellido);
        $pn->segundo_apellido = strtoupper($segundo_apellido);
        $pn->distrito_militar = strtoupper($distrito_militar);
        $pn->numero_pasaporte = $numero_pasaporte;
        $pn->otra_nacionalidad = strtoupper($otra_nacionalidad);
        $pn->clase_libreta = strtoupper($clase_libreta);
        $pn->fax = $fax;
        $pn->ocupacion = strtoupper($ocupacion);
        $pn->profesion = strtoupper($profesion);
        $pn->nivel_estudio = strtoupper($nivel_estudio);
        $pn->sexo_id = $sexo_id;
        $pn->pais_id = $pais_id;
        $pn->estado_id = $estado_id;
        $pn->ciudad_id = $ciudad_id;
        $pn->persona_id = $persona_id;
        $u = Auth::user();
        $pn->user_change = $u->identificacion;
        return $pn;
    }

    /**
     * get a persona natural to user
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function personaNatural2($id) {
        $p = Persona::where('numero_documento', $id)->get();
        $response = null;
        $response["error"] = "SI";
        $p1 = $p2 = null;
        if (count($p) > 0) {
            foreach ($p as $value) {
                $pn = $value->personanatural;
                if ($p != null) {
                        $o['id'] = $pn->id;
                        $o["identificacion"] = $id;
                        $o["nombres"] = $pn->primer_nombre . " " . $pn->segundo_nombre;
                        $o["apellidos"] = $pn->primer_apellido . " " . $pn->segundo_apellido;
                        $o["mail"] = $value->mail;
                        $p1[] = $o;
                        $p2[$pn->id] = $pn->primer_nombre . " " . $pn->segundo_nombre . " " . $pn->primer_apellido . " " . $pn->segundo_apellido . " - FECHA REGISTRO:" . $pn->created_at;
                     }
            }
            if (count($p1) > 0) {
                $response["error"] = "NO";
                $response["data1"] = $p1;
                $response["data2"] = $p2;
            } else {
                $response["msg"] = "La persona con Identificación " . $id . " no es una persona natural.";
            }
        } else {
            $response["msg"] = "Ninguna coincidencia encontrada para Identificación: " . $id;
        }
        return json_encode($response);
    }
}
