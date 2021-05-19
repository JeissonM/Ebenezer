<?php

namespace App\Http\Controllers;

use App\Padresaspirante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Persona;
use App\Auditoriaadmision;
use App\Aspirante;
use App\Sexo;
use App\Ocupacion;
use App\Http\Requests\PadresaspiranteRequest;
use App\Tipodoc;
use App\Personanatural;
use App\Acudiente;

class PadresaspiranteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $u = Auth::user();
        $aspirantes = null;
        $asps = Padresaspirante::where('numero_documento', $u->identificacion)->get();
        if (count($asps) > 0) {
            $p = null;
            foreach ($asps as $a) {
                $aspirantes[$a->aspirante_id] = $a->aspirante;
            }
        }
        $p = Persona::where('numero_documento', $u->identificacion)->first();
        if ($p != null) {
            $pn = $p->personanatural;
            if ($pn != null) {
                $acudientes = $pn->acudientes;
                if (count($acudientes) > 0) {
                    foreach ($acudientes as $ac) {
                        $aspirantes[$ac->aspirante_id] = $ac->aspirante;
                    }
                }
            }
        }
        if ($aspirantes != null) {
            return view('acudiente.padres_aspirante.list')
                ->with('location',  'inscripcion')
                ->with('aspirantes', $aspirantes);
        } else {
            flash("Usted no posee aspirantes asociados como hijos, no puede continuar")->error();
            return redirect()->route('menu.inscripcion');
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function lista($id)
    {
        $a = Aspirante::find($id);
        $padres = null;
        $padres = $a->padresaspirantes;
        return view('acudiente.padres_aspirante.padres')
            ->with('location',  'inscripcion')
            ->with('padres', $padres)
            ->with('a', $a);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $a = Aspirante::find($id);
        $tipodoc = Tipodoc::all()->pluck('descripcion',  'id');
        $sexos = Sexo::all()->pluck('nombre',  'id');
        $profesions = Ocupacion::all()->pluck('descripcion',  'id');
        $ac = $a->acudientes;
        $u = Auth::user();
        $acu = null;
        if (count($ac) > 0) {
            foreach ($ac as $m) {
                if ($m->personanatural->persona->numero_documento == $u->identificacion) {
                    $acu = $m;
                }
            }
        }
        return view('acudiente.padres_aspirante.create')
            ->with('location',  'inscripcion')
            ->with('a', $a)
            ->with('acu', $acu)
            ->with('tipodoc', $tipodoc)
            ->with('sexos', $sexos)
            ->with('profesions', $profesions);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PadresaspiranteRequest $request)
    {
        if (isset($request->automatico)) {
            //Es acudiente, copia de persona natural a padre
            $acu = Acudiente::find($request->automatico);
            $pn = $acu->personanatural;
            $p = $this->setPadreaspirante($pn->persona->numero_documento, $pn->persona->lugar_expedicion, $pn->persona->fecha_expedicion, $pn->primer_nombre, $pn->segundo_nombre, $pn->primer_apellido, $pn->segundo_apellido, null, 'NO', $pn->persona->direccion, null, $pn->persona->telefono, $pn->persona->celular, $pn->persona->mail, $request->padre_madre, $pn->sexo_id, $pn->persona->tipodoc_id, null, $request->aspirante_id, null);
            if ($p->save()) {
                $this->setAuditoriaadmision('INSERTAR', 'CREACIÓN DE PADRE DE ASPIRANTE. DATOS: ', $p);
                flash("El/La " . $request->padre_madre . " fue almacenado(a) de forma exitosa")->success();
                return redirect()->route('padresaspirantes.lista', $request->aspirante_id);
            } else {
                flash("El/La " . $request->padre_madre . " no pudo ser almacenado(a)")->error();
                return redirect()->route('padresaspirantes.lista', $request->aspirante_id);
            }
        }
        if (isset($request->acudiente)) {
            if ($request->acudiente == 'SI') {
                //verificar que no esté
                $oldp = Persona::where('numero_documento', $request->numero_documento)->get();
                if (count($oldp) > 0) {
                    //ya está, hacemos padre
                    $pad = $this->setPadreaspirante($request->numero_documento, $request->lugar_expedicion, $request->fecha_expedicion, $request->primer_nombre, $request->segundo_nombre, $request->primer_apellido, $request->segundo_apellido, $request->vive, $request->acudiente, $request->direccion_residencia, $request->barrio_residencia, $request->telefono, $request->celular, $request->correo, $request->padre_madre, $request->sexo_id, $request->tipodoc_id, $request->ocupacion_id, $request->aspirante_id, null);
                    if ($pad->save()) {
                        $this->setAuditoriaadmision('INSERTAR', 'CREACIÓN DE PADRE DE ASPIRANTE. DATOS: ', $pad);
                        flash("El/La " . $request->padre_madre . " fue almacenado(a) de forma exitosa")->success();
                        return redirect()->route('padresaspirantes.lista', $request->aspirante_id);
                    } else {
                        flash("El/La " . $request->padre_madre . " no pudo ser almacenado(a)")->error();
                        return redirect()->route('padresaspirantes.lista', $request->aspirante_id);
                    }
                }
                //Hacer Acudiente, persona natural, persona y padre
                $p = $this->setPersona('NATURAL', $request->correo, $request->direccion_residencia, $request->celular, $request->telefono, $request->numero_documento, $request->lugar_expedicion, $request->fecha_expedicion, null, null, $request->tipodoc_id, null, null, null);
                if ($p->save()) {
                    $this->setAuditoriaadmision('INSERTAR', 'CREACIÓN DE PERSONA GENERAL. DATOS: ', $p);
                    $pn = $this->setPersonanatural($request->primer_nombre, $request->segundo_nombre, null, null, null, null, $request->primer_apellido, $request->segundo_apellido, null, null, null, null, null, null, null, null, null, null, null, $p->id, $request->sexo_id);
                    if ($pn->save()) {
                        $this->setAuditoriaadmision('INSERTAR', 'CREACIÓN DE PERSONA NATURAL. DATOS: ', $pn);
                        $a = $this->setAcudiente($request->aspirante_id, $pn->id, null);
                        if ($a->save()) {
                            $this->setAuditoriaadmision('INSERTAR', 'CREACIÓN DE ACUDIENTE. DATOS: ', $a);
                            $padre = $this->setPadreaspirante($request->numero_documento, $request->lugar_expedicion, $request->fecha_expedicion, $request->primer_nombre, $request->segundo_nombre, $request->primer_apellido, $request->segundo_apellido, $request->vive, $request->acudiente, $request->direccion_residencia, $request->barrio_residencia, $request->telefono, $request->celular, $request->correo, $request->padre_madre, $request->sexo_id, $request->tipodoc_id, $request->ocupacion_id, $request->aspirante_id, null);
                            if ($padre->save()) {
                                $this->setAuditoriaadmision('INSERTAR', 'CREACIÓN DE PADRE DE ASPIRANTE. DATOS: ', $padre);
                                flash("El/La " . $request->padre_madre . " fue almacenado(a) de forma exitosa")->success();
                                return redirect()->route('padresaspirantes.lista', $request->aspirante_id);
                            } else {
                                $p->delete();
                                $pn->delete();
                                $a->delete();
                                flash("El/La " . $request->padre_madre . " no pudo ser almacenado(a)")->error();
                                return redirect()->route('padresaspirantes.lista', $request->aspirante_id);
                            }
                        } else {
                            $p->delete();
                            $pn->delete();
                            flash("El/La " . $request->padre_madre . " no pudo ser almacenado(a)")->error();
                            return redirect()->route('padresaspirantes.lista', $request->aspirante_id);
                        }
                    } else {
                        $p->delete();
                        flash("El/La " . $request->padre_madre . " no pudo ser almacenado(a)")->error();
                        return redirect()->route('padresaspirantes.lista', $request->aspirante_id);
                    }
                } else {
                    flash("El/La " . $request->padre_madre . " no pudo ser almacenado(a)")->error();
                    return redirect()->route('padresaspirantes.lista', $request->aspirante_id);
                }
            }
        }
        //metodo convencional: crea padre
        $p = $this->setPadreaspirante($request->numero_documento, $request->lugar_expedicion, $request->fecha_expedicion, $request->primer_nombre, $request->segundo_nombre, $request->primer_apellido, $request->segundo_apellido, $request->vive, $request->acudiente, $request->direccion_residencia, $request->barrio_residencia, $request->telefono, $request->celular, $request->correo, $request->padre_madre, $request->sexo_id, $request->tipodoc_id, $request->ocupacion_id, $request->aspirante_id, null);
        if ($p->save()) {
            $this->setAuditoriaadmision('INSERTAR', 'CREACIÓN DE PADRE DE ASPIRANTE. DATOS: ', $p);
            flash("El/La " . $request->padre_madre . " fue almacenado(a) de forma exitosa")->success();
            return redirect()->route('padresaspirantes.lista', $request->aspirante_id);
        } else {
            flash("El/La " . $request->padre_madre . " no pudo ser almacenado(a)")->error();
            return redirect()->route('padresaspirantes.lista', $request->aspirante_id);
        }
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


    /**
     * Display the specified resource.
     *
     * @param  \App\Padresaspirante  $padresaspirante
     * @return \Illuminate\Http\Response
     */
    public function show(Padresaspirante $padresaspirante)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Padresaspirante  $padresaspirante
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $p = Padresaspirante::find($id);
        $tipodoc = Tipodoc::all()->pluck('descripcion',  'id');
        $sexos = Sexo::all()->pluck('nombre',  'id');
        $profesions = Ocupacion::all()->pluck('descripcion',  'id');
        return view('acudiente.padres_aspirante.edit')
            ->with('location',  'inscripcion')
            ->with('p', $p)
            ->with('tipodoc', $tipodoc)
            ->with('sexos', $sexos)
            ->with('profesions', $profesions);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Padresaspirante  $padresaspirante
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $p = Padresaspirante::find($id);
        $m = new Padresaspirante($p->attributesToArray());
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
            $str = "EDICION DE PADRE/MADRE DE ASPIRANTE. DATOS NUEVOS: ";
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
            return redirect()->route('padresaspirantes.lista', $p->aspirante_id);
        } else {
            flash("Los datos no pudieron ser modificados. Error: " . $result)->error();
            return redirect()->route('padresaspirantes.lista', $p->aspirante_id);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Padresaspirante  $padresaspirante
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $p = Padresaspirante::find($id);
        if ($p->delete()) {
            flash("El/La " . $p->padre_madre . " fue eliminado(a) de forma exitosa")->success();
            return redirect()->route('padresaspirantes.lista', $p->aspirante_id);
        } else {
            flash("El/La " . $p->padre_madre . " no pudo ser eliminado(a)")->error();
            return redirect()->route('padresaspirantes.lista', $p->aspirante_id);
        }
    }

    //crea un padre de aspirante
    public function setPadreaspirante($numero_documento, $lugar_expedicion = null, $fecha_expedicion = null, $primer_nombre, $segundo_nombre = null, $primer_apellido, $segundo_apellido = null, $vive = null, $acudiente = null, $direccion_residencia = null, $barrio_residencia = null, $telefono = null, $celular = null, $correo = null, $padre_madre, $sexo_id = null, $tipodoc_id, $ocupacion_id = null, $aspirante_id, $user_change)
    {
        $p = new Padresaspirante();
        $p->numero_documento = $numero_documento;
        $p->lugar_expedicion = strtoupper($lugar_expedicion);
        $p->fecha_expedicion = $fecha_expedicion;
        $p->primer_nombre = strtoupper($primer_nombre);
        $p->segundo_nombre = strtoupper($segundo_nombre);
        $p->primer_apellido = strtoupper($primer_apellido);
        $p->segundo_apellido = strtoupper($segundo_apellido);
        $p->vive = $vive;
        $p->acudiente = $acudiente;
        $p->direccion_residencia = strtoupper($direccion_residencia);
        $p->barrio_residencia = strtoupper($barrio_residencia);
        $p->telefono = $telefono;
        $p->celular = $celular;
        $p->correo = $correo;
        $p->padre_madre = $padre_madre;
        $p->sexo_id = $sexo_id;
        $p->tipodoc_id = $tipodoc_id;
        $p->ocupacion_id = $ocupacion_id;
        $p->aspirante_id = $aspirante_id;
        $u = Auth::user();
        $p->user_change = $u->identificacion;
        return $p;
    }

    //Crea acudiente con relación al aspirante
    public function setAcudiente($aspirante, $personanatural, $user_change = null)
    {
        $a = new Acudiente();
        $a->aspirante_id = $aspirante;
        $a->personanatural_id = $personanatural;
        $u = Auth::user();
        $a->user_change = $u->identificacion;
        return $a;
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
}
