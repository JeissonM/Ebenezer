<?php

namespace App\Http\Controllers;

use App\Acudiente;
use App\Acudienteestudiante;
use App\Auditoriaacademico;
use App\Estudiante;
use App\Http\Requests\PadresaspiranteRequest;
use App\Http\Requests\PadresestudinateRequest;
use App\Ocupacion;
use App\Padresestudiante;
use App\Persona;
use App\Personanatural;
use App\Sexo;
use App\Tipodoc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PadresestudianteController extends Controller
{
    //lista los padres de un estudiante
    public function inicio($id)
    {
        $a = Estudiante::find($id);
        $pn = $a->personanatural;
        $padres = $a->padresestudiantes;
        return view('academico.registro_academico.hoja_de_vida_estudiante.padres.list')
            ->with('location', 'academico')
            ->with('a', $a)
            ->with('pn', $pn)
            ->with('padres', $padres);
    }

    //crear padre/madre del estudiante
    public function crear($id)
    {
        $a = Estudiante::find($id);
        $pn = $a->personanatural;
        $tipodoc = Tipodoc::all()->pluck('descripcion', 'id');
        $sexos = Sexo::all()->pluck('nombre', 'id');
        $profesions = Ocupacion::all()->pluck('descripcion', 'id');
        $ac = $a->acudienteestudiantes;
        $u = Auth::user();
        $acu = null;
        if (count($ac) > 0) {
            foreach ($ac as $m) {
                if ($m->personanatural->persona->numero_documento == $u->identificacion) {
                    $acu = $m;
                }
            }
        }
        return view('academico.registro_academico.hoja_de_vida_estudiante.padres.create')
            ->with('location', 'academico')
            ->with('a', $a)
            ->with('pn', $pn)
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
    public function store(PadresestudinateRequest $request)
    {
        if (isset($request->automatico)) {
            //Es acudiente, copia de persona natural a padre
            $acu = Acudiente::find($request->automatico);
            $pn = $acu->personanatural;
            $p = $this->setPadreestudinate($pn->persona->numero_documento, $pn->persona->lugar_expedicion, $pn->persona->fecha_expedicion, $pn->primer_nombre, $pn->segundo_nombre, $pn->primer_apellido, $pn->segundo_apellido, null, 'NO', $pn->persona->direccion, null, $pn->persona->telefono, $pn->persona->celular, $pn->persona->mail, $request->padre_madre, $pn->sexo_id, $pn->persona->tipodoc_id, null, $request->estudiante_id, null);
            if ($p->save()) {
                $this->setAuditoriaacademico('INSERTAR', 'CREACIÓN DE PADRE DE ESTUDIANTE. DATOS: ', $p);
                flash("El/La " . $request->padre_madre . " fue almacenado(a) de forma exitosa")->success();
                return redirect()->route('padresestudiante.inicio', $request->estudiante_id);
            } else {
                flash("El/La " . $request->padre_madre . " no pudo ser almacenado(a)")->error();
                return redirect()->route('padresestudiante.inicio', $request->estudiante_id);
            }
        }
        if (isset($request->acudiente)) {
            if ($request->acudiente == 'SI') {
                //verificar que no esté
                $oldp = Persona::where('numero_documento', $request->numero_documento)->get();
                if (count($oldp) > 0) {
                    //ya está, hacemos padre
                    $pad = $this->setPadreestudinate($request->numero_documento, $request->lugar_expedicion, $request->fecha_expedicion, $request->primer_nombre, $request->segundo_nombre, $request->primer_apellido, $request->segundo_apellido, $request->vive, $request->acudiente, $request->direccion_residencia, $request->barrio_residencia, $request->telefono, $request->celular, $request->correo, $request->padre_madre, $request->sexo_id, $request->tipodoc_id, $request->ocupacion_id, $request->estudiante_id, null);
                    if ($pad->save()) {
                        $this->setAuditoriaacademico('INSERTAR', 'CREACIÓN DE PADRE DE ESTUDIANTE. DATOS: ', $pad);
                        flash("El/La " . $request->padre_madre . " fue almacenado(a) de forma exitosa")->success();
                        return redirect()->route('padresestudiante.inicio', $request->estudiante_id);
                    } else {
                        flash("El/La " . $request->padre_madre . " no pudo ser almacenado(a)")->error();
                        return redirect()->route('padresestudiante.inicio', $request->estudiante_id);
                    }
                }
                //Hacer Acudiente, persona natural, persona y padre
                $p = $this->setPersona('NATURAL', $request->correo, $request->direccion_residencia, $request->celular, $request->telefono, $request->numero_documento, $request->lugar_expedicion, $request->fecha_expedicion, null, null, $request->tipodoc_id, null, null, null);
                if ($p->save()) {
                    $this->setAuditoriaacademico('INSERTAR', 'CREACIÓN DE PERSONA GENERAL. DATOS: ', $p);
                    $pn = $this->setPersonanatural($request->primer_nombre, $request->segundo_nombre, null, null, null, null, $request->primer_apellido, $request->segundo_apellido, null, null, null, null, null, null, null, null, null, null, null, $p->id, $request->sexo_id);
                    if ($pn->save()) {
                        $this->setAuditoriaacademico('INSERTAR', 'CREACIÓN DE PERSONA NATURAL. DATOS: ', $pn);
                        $a = $this->setAcudiente($request->estudiante_id, $pn->id, null);
                        if ($a->save()) {
                            $this->setAuditoriaacademico('INSERTAR', 'CREACIÓN DE ESTUDIANTE. DATOS: ', $a);
                            $padre = $this->setPadreestudinate($request->numero_documento, $request->lugar_expedicion, $request->fecha_expedicion, $request->primer_nombre, $request->segundo_nombre, $request->primer_apellido, $request->segundo_apellido, $request->vive, $request->acudiente, $request->direccion_residencia, $request->barrio_residencia, $request->telefono, $request->celular, $request->correo, $request->padre_madre, $request->sexo_id, $request->tipodoc_id, $request->ocupacion_id, $request->estudiante_id, null);
                            if ($padre->save()) {
                                $this->setAuditoriaacademico('INSERTAR', 'CREACIÓN DE PADRE DE ESTUDIANTE. DATOS: ', $padre);
                                flash("El/La " . $request->padre_madre . " fue almacenado(a) de forma exitosa")->success();
                                return redirect()->route('padresestudiante.inicio', $request->estudiante_id);
                            } else {
                                $p->delete();
                                $pn->delete();
                                $a->delete();
                                flash("El/La " . $request->padre_madre . " no pudo ser almacenado(a)")->error();
                                return redirect()->route('padresestudiante.inicio', $request->estudiante_id);
                            }
                        } else {
                            $p->delete();
                            $pn->delete();
                            flash("El/La " . $request->padre_madre . " no pudo ser almacenado(a)")->error();
                            return redirect()->route('padresestudiante.inicio', $request->estudiante_id);
                        }
                    } else {
                        $p->delete();
                        flash("El/La " . $request->padre_madre . " no pudo ser almacenado(a)")->error();
                        return redirect()->route('padresestudiante.inicio', $request->estudiante_id);
                    }
                } else {
                    flash("El/La " . $request->padre_madre . " no pudo ser almacenado(a)")->error();
                    return redirect()->route('padresestudiante.inicio', $request->estudiante_id);
                }
            }
        }
        //metodo convencional: crea padre
        $p = $this->setPadreaspirante($request->numero_documento, $request->lugar_expedicion, $request->fecha_expedicion, $request->primer_nombre, $request->segundo_nombre, $request->primer_apellido, $request->segundo_apellido, $request->vive, $request->acudiente, $request->direccion_residencia, $request->barrio_residencia, $request->telefono, $request->celular, $request->correo, $request->padre_madre, $request->sexo_id, $request->tipodoc_id, $request->ocupacion_id, $request->estudiante_id, null);
        if ($p->save()) {
            $this->setAuditoriaadmision('INSERTAR', 'CREACIÓN DE PADRE DE ASPIRANTE. DATOS: ', $p);
            flash("El/La " . $request->padre_madre . " fue almacenado(a) de forma exitosa")->success();
            return redirect()->route('padresestudiante.inicio', $request->estudiante_id);
        } else {
            flash("El/La " . $request->padre_madre . " no pudo ser almacenado(a)")->error();
            return redirect()->route('padresestudiantes.inicio', $request->estudiante_id);
        }
    }

    public function destroy($id){
        $p = Padresestudiante::find($id);
        if ($p->delete()) {
            flash("El/La " . $p->padre_madre . " fue eliminado(a) de forma exitosa")->success();
            return redirect()->route('padresestudiante.inicio', $p->estudiante_id);
        } else {
            flash("El/La " . $p->padre_madre . " no pudo ser eliminado(a)")->error();
            return redirect()->route('padresestudiante.inicio', $p->estudiante_id);
        }
    }

    /*
    * set Auditoria Admision
    */

    public function setAuditoriaacademico($operacion, $string1, $r)
    {
        $u = Auth::user();
        $aud = new Auditoriaacademico();
        $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
        $aud->operacion = $operacion;
        $str = $string1;
        foreach ($r->attributesToArray() as $key => $value) {
            $str = $str . ", " . $key . ": " . $value;
        }
        $aud->detalles = $str;
        $aud->save();
    }
    //crea un padre de estudiante
    public function setPadreestudinate($numero_documento, $lugar_expedicion = null, $fecha_expedicion = null, $primer_nombre, $segundo_nombre = null, $primer_apellido, $segundo_apellido = null, $vive = null, $acudiente = null, $direccion_residencia = null, $barrio_residencia = null, $telefono = null, $celular = null, $correo = null, $padre_madre, $sexo_id = null, $tipodoc_id, $ocupacion_id = null, $estudiante_id, $user_change)
    {
        $p = new Padresestudiante();
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
        $p->estudiante_id = $estudiante_id;
        $u = Auth::user();
        $p->user_change = $u->identificacion;
        return $p;
    }

    //Crea acudiente con relación al aspirante
    public function setAcudiente($estudiante, $personanatural, $user_change = null)
    {
        $a = new Acudienteestudiante();
        $a->estudiante_id = $estudiante;
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
