<?php

namespace App\Http\Controllers;

use App\Responsablefinancieroaspirante;
use Illuminate\Http\Request;
use App\Tipodoc;
use App\Ocupacion;
use App\Sexo;
use App\Pais;
use Illuminate\Support\Facades\Auth;
use App\Persona;
use App\Personanatural;
use App\Acudiente;
use App\Aspirante;
use App\Http\Requests\ResponsablefaspiranteRequest;
use App\Auditoriaadmision;

class ResponsablefinancieroaspiranteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $u = Auth::user();
        $p = Persona::where('numero_documento', $u->identificacion)->first();
        if ($p != null) {
            $aspirantes = null;
            $pn = $p->personanatural;
            if ($pn != null) {
                $acudientes = $pn->acudientes;
                if (count($acudientes) > 0) {
                    foreach ($acudientes as $ac) {
                        $aspirantes[$ac->aspirante_id] = $ac->aspirante;
                    }
                }
            }
            if ($aspirantes != null) {
                return view('acudiente.responsable_financiero.list')
                    ->with('location',  'inscripcion')
                    ->with('aspirantes', $aspirantes);
            } else {
                flash("Usted no posee aspirantes asociados, no puede continuar")->error();
                return redirect()->route('menu.inscripcion');
            }
        } else {
            flash("Usted no posee aspirantes asociados, no puede continuar")->error();
            return redirect()->route('menu.inscripcion');
        }
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
    public function store(ResponsablefaspiranteRequest $request)
    {
        $p = $this->setPersona('NATURAL', $request->mail, $request->direccion, $request->celular, $request->telefono, $request->numero_documento, $request->lugar_expedicion, $request->fecha_expedicion, null, null, $request->tipodoc_id, $request->pais_id, $request->estado_id, $request->ciudad_id);
        if ($p->save()) {
            $this->setAuditoriaadmision('INSERTAR', 'CREACIÓN DE PERSONA GENERAL. DATOS: ', $p);
            $pn = $this->setPersonanatural($request->primer_nombre, $request->segundo_nombre, $request->fecha_nacimiento, $request->libreta_militar, $request->edad, $request->rh, $request->primer_apellido, $request->segundo_apellido, $request->distrito_militar, $request->numero_pasaporte, $request->otra_nacionalidad, $request->clase_libreta, null, $request->profesion, $request->profesion, $request->nivel_estudio, $request->ciudadpn_id, $request->estadopn_id, $request->paispn_id, $p->id, $request->sexo_id);
            if ($pn->save()) {
                $this->setAuditoriaadmision('INSERTAR', 'CREACIÓN DE PERSONA NATURAL. DATOS: ', $pn);
                $r = $this->setResponsableFinanciero($request->direccion_trabajo, $request->telefono_trabajo, $request->puesto_trabajo, $request->empresa_labora, $request->jefe_inmediato, $request->telefono_jefe, $request->descripcion_trabajador_independiente, $request->ocupacion_id, $pn->id, $request->aspirante_id, null);
                if ($r->save()) {
                    flash("Datos guardados con éxito.")->success();
                    return redirect()->route('responsablefaspirante.index');
                } else {
                    $p->delete();
                    $pn->delete();
                    flash("Los datos no fueron guardados, no se pudo establecer el responsable financiero.")->error();
                    return redirect()->route('responsablefaspirante.index');
                }
            } else {
                $p->delete();
                flash("Los datos no fueron guardados, no se pudo establecer la persona natural.")->error();
                return redirect()->route('responsablefaspirante.index');
            }
        } else {
            flash("Los datos no fueron guardados, no se pudo establecer la persona.")->error();
            return redirect()->route('responsablefaspirante.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Responsablefinancieroaspirante  $responsablefinancieroaspirante
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $a = Aspirante::find($id);
        $tipodoc = Tipodoc::all()->pluck('descripcion', 'id');
        $paises = Pais::all()->pluck('nombre', 'id');
        $sexos = Sexo::all()->pluck('nombre', 'id');
        $profesions = Ocupacion::all()->pluck('descripcion', 'id');
        $p = null;
        $p = $a->responsablefinancieroaspirante;
        return view('acudiente.responsable_financiero.data')
            ->with('location',  'inscripcion')
            ->with('tipodoc', $tipodoc)
            ->with('paises', $paises)
            ->with('sexos', $sexos)
            ->with('a', $a)
            ->with('p', $p)
            ->with('rh', [
                "A+" => "A+",
                "A-" => "A-",
                "B+" => "B+",
                "B-" => "B-",
                "AB+" => "AB+",
                "AB-" => "AB-",
                "O+" => "O+",
                "O-" => "O-"
            ])
            ->with('profesions', $profesions);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Responsablefinancieroaspirante  $responsablefinancieroaspirante
     * @return \Illuminate\Http\Response
     */
    public function edit(Responsablefinancieroaspirante $responsablefinancieroaspirante)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Responsablefinancieroaspirante  $responsablefinancieroaspirante
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $p = Responsablefinancieroaspirante::find($id);
        $m = new Responsablefinancieroaspirante($p->attributesToArray());
        foreach ($p->attributesToArray() as $key => $value) {
            if (isset($request->$key)) {
                $p->$key = strtoupper($request->$key);
            }
        }
        $u = Auth::user();
        $p->user_change = $u->identificacion;
        $result = $p->save();
        if ($result) {
            $aud = new Auditoriaadmision();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ACTUALIZAR DATOS";
            $str = "EDICION DE RESPONSABLE FINANCIERO DEL ASPIRANTE. DATOS NUEVOS: ";
            $str2 = " DATOS ANTIGUOS: ";
            foreach ($m->attributesToArray() as $key => $value) {
                $str2 = $str2 . ", " . $key . ": " . $value;
            }
            foreach ($p->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str . " - " . $str2;
            $aud->save();
            flash("Los datos fueron modificados de forma exitosa!")->success();
            return redirect()->route('responsablefaspirante.index');
        } else {
            flash("Los datos no pudieron ser modificados. Error: " . $result)->error();
            return redirect()->route('responsablefaspirante.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Responsablefinancieroaspirante  $responsablefinancieroaspirante
     * @return \Illuminate\Http\Response
     */
    public function destroy(Responsablefinancieroaspirante $responsablefinancieroaspirante)
    {
        //
    }

    /*
     * Crea una Persona
     */

    public function setPersona($tipopersona = 'NATURAL', $mail = null, $direccion = null, $celular = null, $telefono = null, $numero_documento, $lugar_exp = null, $fecha_exp = null, $nombre_com = null, $regimen = null, $tipodoc = 0, $pais = null, $estado = null, $ciudad = null)
    {
        $p = new Persona;
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
        $pn = new Personanatural;
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

    /*
     * set Auditoria Admision
     */

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

    //set responsable financiero
    public function setResponsableFinanciero($direccion_trabajo, $telefono_trabajo, $puesto_trabajo = null, $empresa_labora = null, $jefe_inmediato = null, $telefono_jefe = null, $descripcion_trabajador_independiente = null, $ocupacion_id = null, $personanatural_id, $aspirante_id, $user_change = null)
    {
        $r = new Responsablefinancieroaspirante();
        $r->direccion_trabajo = strtoupper($direccion_trabajo);
        $r->telefono_trabajo = $telefono_trabajo;
        $r->puesto_trabajo = strtoupper($puesto_trabajo);
        $r->empresa_labora = strtoupper($empresa_labora);
        $r->jefe_inmediato = strtoupper($jefe_inmediato);
        $r->telefono_jefe = $telefono_jefe;
        $r->descripcion_trabajador_independiente = strtoupper($descripcion_trabajador_independiente);
        $r->ocupacion_id = $ocupacion_id;
        $r->personanatural_id = $personanatural_id;
        $r->aspirante_id = $aspirante_id;
        $u = Auth::user();
        $r->user_change = $u->identificacion;
        return $r;
    }

}
