<?php

namespace App\Http\Controllers;

use App\Inscripcion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Persona;
use App\Tipodoc;
use App\Pais;
use App\Sexo;
use App\Ocupacion;
use App\Http\Requests\PersonaRequest;
use App\Personanatural;
use App\Auditoriaadmision;
use App\Periodoacademico;
use App\Unidad;
use App\Jornada;
use App\Grado;
use App\Fechasprocesosacademico;
use App\Aspirante;
use App\Convocatoria;
use App\Estrato;
use App\Circunscripcion;
use App\Conquienvive;
use App\Entidadsalud;
use App\Etnia;
use App\Rangosisben;
use App\Situacionestudiante;
use App\Situacionanioanterior;
use App\Http\Requests\AspiranteRequest;
use App\Datoscomplementariosaspirante;
use App\Acudiente;
use App\Documentoanexo;
use App\Parametrizardocumentoanexo;
use App\Contratoinscripcion;
use PDF;

class InscripcionController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $u = Auth::user();
        $p = $pn = $ac = null;
        $p = Persona::where('numero_documento', $u->identificacion)->first();
        if ($p != null) {
            $pn = $p->personanatural;
            if ($pn != null) {
                $ac = $pn->acudientes;
            }
        }
        $tipodoc = Tipodoc::all()->pluck('descripcion', 'id');
        $paises = Pais::all()->pluck('nombre', 'id');
        $sexos = Sexo::all()->pluck('nombre', 'id');
        $profesions = Ocupacion::all()->pluck('descripcion', 'id');
        return view('acudiente.datos_acudiente.list')
            ->with('location', 'inscripcion')
            ->with('p', $p)
            ->with('pn', $pn)
            ->with('ac', $ac)
            ->with('tipodoc', $tipodoc)
            ->with('paises', $paises)
            ->with('sexos', $sexos)
            ->with('profesions', $profesions);
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
    public function store(PersonaRequest $request)
    {
        $p = $this->setPersona('NATURAL', $request->mail, $request->direccion, $request->celular, $request->telefono, $request->numero_documento, $request->lugar_expedicion, $request->fecha_expedicion, null, null, $request->tipodoc_id, $request->pais_id, $request->estado_id, $request->ciudad_id);
        if ($p->save()) {
            $this->setAuditoriaadmision('INSERTAR', 'CREACIÓN DE PERSONA GENERAL. DATOS: ', $p);
            $pn = $this->setPersonanatural($request->primer_nombre, $request->segundo_nombre, $request->fecha_nacimiento, $request->libreta_militar, $request->edad, $request->rh, $request->primer_apellido, $request->segundo_apellido, $request->distrito_militar, $request->numero_pasaporte, $request->otra_nacionalidad, $request->clase_libreta, null, $request->profesion, $request->profesion, $request->nivel_estudio, $request->ciudadpn_id, $request->estadopn_id, $request->paispn_id, $p->id, $request->sexo_id);
            if ($pn->save()) {
                $this->setAuditoriaadmision('INSERTAR', 'CREACIÓN DE PERSONA NATURAL. DATOS: ', $pn);
                flash("Datos guardados con éxito.")->success();
                return redirect()->route('inscripcion.index');
            } else {
                $p->delete();
                flash("Los datos no fueron guardados, no se pudo establecer la persona natural.")->error();
                return redirect()->route('inscripcion.index');
            }
        } else {
            flash("Los datos no fueron guardados, no se pudo establecer la persona.")->error();
            return redirect()->route('inscripcion.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Inscripcion  $inscripcion
     * @return \Illuminate\Http\Response
     */
    public function show(Inscripcion $inscripcion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Inscripcion  $inscripcion
     * @return \Illuminate\Http\Response
     */
    public function edit(Inscripcion $inscripcion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Inscripcion  $inscripcion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Inscripcion $inscripcion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Inscripcion  $inscripcion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Inscripcion $inscripcion)
    {
        //
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

    /*
     * muestra formulario para inscribir un aspirante
     */

    public function aspirante()
    {
        $periodos = $unidades = $jornadas = null;
        $perds = Periodoacademico::all()->sortByDesc('anio');
        if (count($perds) > 0) {
            foreach ($perds as $p) {
                $periodos[$p->id] = $p->etiqueta . " - " . $p->anio;
            }
        } else {
            flash("No hay períodos académicos definidos para inscribir aspirantes")->error();
            return redirect()->route('menu.inscripcion');
        }
        $unds = Unidad::all();
        if (count($unds) > 0) {
            foreach ($unds as $u) {
                $unidades[$u->id] = $u->nombre . " - " . $u->descripcion . " - " . $u->ciudad->nombre;
            }
        } else {
            flash("No hay unidades o sedes definidas para inscribir aspirantes")->error();
            return redirect()->route('menu.inscripcion');
        }
        $grados = Grado::all()->pluck('etiqueta', 'id');
        $jnds = Jornada::all();
        if (count($jnds) > 0) {
            foreach ($jnds as $j) {
                $jornadas[$j->id] = $j->descripcion . " - " . $j->jornadasnies;
            }
        } else {
            flash("No hay jornadas académicas definidas para inscribir aspirantes")->error();
            return redirect()->route('menu.inscripcion');
        }
        if (count($grados) <= 0) {
            flash("No hay grados académicos definidos para inscribir aspirantes")->error();
            return redirect()->route('menu.inscripcion');
        }
        $tipodoc = Tipodoc::all()->pluck('descripcion', 'id');
        $u = Auth::user();
        $pe = Persona::where('numero_documento', $u->identificacion)->get();
        if (count($pe) > 0) {
            $contrato = null;
            $contrato = Contratoinscripcion::where('estado', 'SI')->first();
            return view('acudiente.inscribir.list')
                ->with('location', 'inscripcion')
                ->with('periodos', $periodos)
                ->with('jornadas', $jornadas)
                ->with('unidades', $unidades)
                ->with('grados', $grados)
                ->with('tipodoc', $tipodoc)
                ->with('contrato', $contrato);
        } else {
            flash("Usted no ha realizado su registro de ACUDIENTE, vaya a Inscripción> Datos Acudiente y luego regrese a esta opción")->error();
            return redirect()->route('menu.inscripcion');
        }
    }

    /*
     * muestra el formulario de inscripcion
     */

    public function aspiranteform($und, $grd, $per, $jnda, $td, $num)
    {
        $unidad = Unidad::find($und);
        $grado = Grado::find($grd);
        $periodo = Periodoacademico::find($per);
        $jornada = Jornada::find($jnda);
        $tipodoc = Tipodoc::find($td);
        //verificamos las fechas
        $fechas = Fechasprocesosacademico::where([['procesosacademico_id', 1], ['periodoacademico_id', $per], ['jornada_id', $jnda], ['unidad_id', $und]])->get();
        $total = count($fechas);
        if ($total > 0) {
            $hoy = getdate();
            $fecha = $hoy["year"] . "/" . $hoy["mon"] . "/" . $hoy["mday"];
            if ($this->check_in_range($fechas[0]->fecha_inicio, $fechas[$total - 1]->fecha_fin, $fecha)) {
                if (count(Aspirante::where('numero_documento', $num)->get()) > 0) {
                    flash("La identificación ya está registrada en el sistema.")->error();
                    return redirect()->route('inscripcion.aspirante');
                } else {
                    $c = Convocatoria::where([['grado_id', $grd], ['periodoacademico_id', $per], ['jornada_id', $jnda], ['unidad_id', $und], ['estado', 'ABIERTA']])->first();
                    if ($c != null) {
                        $paises = Pais::all()->pluck('nombre', 'id');
                        $sexos = Sexo::all()->pluck('nombre', 'id');
                        $estratos = Estrato::all()->pluck('etiqueta', 'id');
                        $circunscripciones = null;
                        $cir = Circunscripcion::all();
                        if (count($cir) > 0) {
                            foreach ($cir as $ci) {
                                $circunscripciones[$ci->id] = $ci->nombre . " - " . $ci->descripcion;
                            }
                        }
                        $etnias = Etnia::all()->pluck('nombre', 'id');
                        $sis = Rangosisben::all();
                        $sisben = $entidades = $situaciones = null;
                        if (count($sis) > 0) {
                            foreach ($sis as $s) {
                                $sisben[$s->id] = $s->etiqueta . " - " . $s->descripcion;
                            }
                        }
                        $conquienvives = Conquienvive::all()->pluck('descripcion', 'id');
                        $enti = Entidadsalud::all();
                        if (count($enti) > 0) {
                            foreach ($enti as $e) {
                                $entidades[$e->id] = $e->codigo . " - " . $e->nombre . " - " . $e->tipoentidad . " - " . $e->sector;
                            }
                        }
                        $situ = Situacionanioanterior::all();
                        if (count($situ) > 0) {
                            foreach ($situ as $e) {
                                $situaciones[$e->id] = $e->etiqueta . " - " . $e->descripcion;
                            }
                        }
                        return view('acudiente.inscribir.aspirante')
                            ->with('location', 'inscripcion')
                            ->with('periodo', $periodo)
                            ->with('jornada', $jornada)
                            ->with('unidad', $unidad)
                            ->with('grado', $grado)
                            ->with('tipodoc', $tipodoc)
                            ->with('paises', $paises)
                            ->with('sexos', $sexos)
                            ->with('conv', $c)
                            ->with('num', $num)
                            ->with('etnias', $etnias)
                            ->with('sisben', $sisben)
                            ->with('entidades', $entidades)
                            ->with('situaciones', $situaciones)
                            ->with('conquienvives', $conquienvives)
                            ->with('estratos', $estratos)
                            ->with('circunscripciones', $circunscripciones);
                    } else {
                        flash("El grado al que aspira no tiene convocatorias para inscripción o las convocatorias están cerradas.")->error();
                        return redirect()->route('inscripcion.aspirante');
                    }
                }
            } else {
                flash("La fecha de hoy está fuera de las fechas establecidas para el proceso de inscripción.")->error();
                return redirect()->route('inscripcion.aspirante');
            }
        } else {
            flash("No hay fechas habilitadas para el proceso de inscripción.")->error();
            return redirect()->route('inscripcion.aspirante');
        }
    }

    //saber si una fecha esta en el rango
    function check_in_range($fecha_inicio, $fecha_fin, $fecha)
    {
        setlocale(LC_ALL, "es_ES");
        $fecha_inicio = strtotime($fecha_inicio);
        $fecha_fin = strtotime($fecha_fin);
        $fecha = strtotime($fecha);
        if (($fecha >= $fecha_inicio) && ($fecha <= $fecha_fin)) {
            return true;
        } else {
            return false;
        }
    }

    //guarda un aspirante
    public function aspirantestore(AspiranteRequest $request)
    {
        $old = Aspirante::where('numero_documento', $request->numero_documento)->get();
        if (count($old) > 0) {
            flash("El documento ingresado ya se encuentra inscrito")->error();
            return redirect()->route('inscripcion.aspirante');
        }
        $foto = "NO";
        if (isset($request->foto)) {
            $foto = $request->file('foto');
        }
        $asp = $this->setAspirante($foto, $request->numero_documento,  $request->lugar_expedicion,  $request->fecha_expedicion,  $request->rh,  $request->primer_nombre,  $request->segundo_nombre,  $request->primer_apellido,  $request->segundo_apellido,  $request->fecha_nacimiento,  $request->telefono,  $request->celular,  $request->correo,  $request->direccion_residencia,  $request->barrio_residencia,  null,  $request->tipodoc_id,  $request->sexo_id,  $request->ciudad_id,  $request->periodoacademico_id,  $request->grado_id,  $request->unidad_id,  $request->estrato_id,  $request->jornada_id,  $request->convocatoria_id,  $request->circunscripcion_id);
        if ($asp->save()) {
            $this->setAuditoriaadmision('INSERTAR', 'CREACIÓN DE ASPIRANTES. DATOS: ', $asp);
            $dc = $this->setDatoscomplementarios($request->padres_separados,  $request->iglesia_asiste,  $request->pastor,  $request->discapacidad,  $request->familias_en_accion,  $request->poblacion_victima_conflicto,  $request->desplazado,  $request->colegio_procedencia,  $request->compromiso_adquirido,  null,  $request->etnia_id,  $request->conquienvive_id,  $request->rangosisben_id,  $request->entidadsalud_id,  $request->situacionanioanterior_id,  $asp->id);
            if ($dc->save()) {
                $this->setAuditoriaadmision('INSERTAR', 'CREACIÓN DE DATOS COMPLEMENTARIOS ASPIRANTES. DATOS: ', $dc);
                $u = Auth::user();
                $p = Persona::where('numero_documento', $u->identificacion)->first();
                $ac = $this->setAcudiente($asp->id, $p->personanatural->id, null);
                if ($ac->save()) {
                    $this->setAuditoriaadmision('INSERTAR', 'CREACIÓN DE ACUDIENTE PARA EL ASPIRANTES. DATOS: ', $ac);
                    flash("El aspirante ha sido registrado con éxito.")->success();
                    return redirect()->route('inscripcion.aspirante');
                } else {
                    $dc->delete();
                    $asp->delete();
                    flash("No se pudo guardar la información del aspirante")->error();
                    return redirect()->route('inscripcion.aspirante');
                }
            } else {
                $asp->delete();
                flash("No se pudo guardar la información del aspirante")->error();
                return redirect()->route('inscripcion.aspirante');
            }
        } else {
            flash("No se pudo guardar la información del aspirante")->error();
            return redirect()->route('inscripcion.aspirante');
        }
        dd($request->all());
    }

    //crea aspirante
    public function setAspirante($foto = 'NO',  $numero_documento,  $lugar_expedicion = null,  $fecha_expedicion = null,  $rh = null,  $primer_nombre,  $segundo_nombre = null,  $primer_apellido,  $segundo_apellido = null,  $fecha_nacimiento = null,  $telefono = null,  $celular = null,  $correo = null,  $direccion_residencia = null,  $barrio_residencia = null,  $user_change = null,  $tipodoc_id,  $sexo_id = null,  $ciudad_id = null,  $periodoacademico_id,  $grado_id,  $unidad_id,  $estrato_id,  $jornada_id,  $convocatoria_id = null,  $circunscripcion_id)
    {
        $a = new Aspirante();
        if ($foto != 'NO') {
            $name = "Imagen_" . $foto->getClientOriginalName();
            $path = public_path() . "/images/fotos/";
            $foto->move($path, $name);
            $a->foto = $name;
        } else {
            $a->foto = $foto;
        }
        $a->numero_documento = $numero_documento;
        $a->lugar_expedicion = strtoupper($lugar_expedicion);
        $a->fecha_expedicion = $fecha_expedicion;
        $a->rh = $rh;
        $a->primer_nombre = strtoupper($primer_nombre);
        $a->segundo_nombre = strtoupper($segundo_nombre);
        $a->primer_apellido = strtoupper($primer_apellido);
        $a->segundo_apellido = strtoupper($segundo_apellido);
        $a->fecha_nacimiento = $fecha_nacimiento;
        $a->telefono = $telefono;
        $a->celular = $celular;
        $a->correo = $correo;
        $a->direccion_residencia = strtoupper($direccion_residencia);
        $a->barrio_residencia = strtoupper($barrio_residencia);
        $u = Auth::user();
        $a->user_change = $u->identificacion;
        $a->tipodoc_id = $tipodoc_id;
        $a->sexo_id = $sexo_id;
        $a->ciudad_id = $ciudad_id;
        $a->periodoacademico_id = $periodoacademico_id;
        $a->grado_id = $grado_id;
        $a->unidad_id = $unidad_id;
        $a->estrato_id = $estrato_id;
        $a->jornada_id = $jornada_id;
        $a->convocatoria_id = $convocatoria_id;
        $a->circunscripcion_id = $circunscripcion_id;
        return $a;
    }

    //Datos complementarios del aspirante
    public function setDatoscomplementarios($padres_separados = 'NO',  $iglesia_asiste = null,  $pastor = null,  $discapacidad = 'NO',  $familias_en_accion = 'NO',  $poblacion_victima_conflicto = 'NO',  $desplazado = 'NO',  $colegio_procedencia = null,  $compromiso_adquirido = 'NO',  $user_change = null,  $etnia_id = null,  $conquienvive_id = null,  $rangosisben_id = null,  $entidadsalud_id = null,  $situacionanioanterior_id,  $aspirante_id)
    {
        $d = new Datoscomplementariosaspirante();
        $d->padres_separados = $padres_separados;
        $d->iglesia_asiste = $iglesia_asiste;
        $d->pastor = $pastor;
        $d->discapacidad = $discapacidad;
        $d->familias_en_accion = $familias_en_accion;
        $d->poblacion_victima_conflicto = $poblacion_victima_conflicto;
        $d->desplazado = $desplazado;
        $d->colegio_procedencia = $colegio_procedencia;
        $d->compromiso_adquirido = $compromiso_adquirido;
        $u = Auth::user();
        $d->user_change = $u->identificacion;
        $d->etnia_id = $etnia_id;
        $d->conquienvive_id = $conquienvive_id;
        $d->rangosisben_id = $rangosisben_id;
        $d->entidadsalud_id = $entidadsalud_id;
        $d->situacionanioanterior_id = $situacionanioanterior_id;
        $d->aspirante_id = $aspirante_id;
        return $d;
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

    //Permite ver los documentos anexos al proceso de inscripcion
    public function documentosanexos()
    {
        $u = Auth::user();
        $p = Persona::where('numero_documento', $u->identificacion)->first();
        if ($p != null) {
            $pn = $p->personanatural;
            if ($pn != null) {
                $acs = $pn->acudientes;
                if (count($acs) > 0) {
                    $aspirantes = null;
                    foreach ($acs as $a) {
                        $aspirantes[] = $a->aspirante;
                    }
                    return view('acudiente.documentos_anexos.list')
                        ->with('location', 'inscripcion')
                        ->with('aspirantes', $aspirantes);
                } else {
                    flash("Usted no es un acudiente, no puede proceder")->error();
                    return redirect()->route('menu.inscripcion');
                }
            } else {
                flash("Usted no se encuentra registrado en el sistema, no puede proceder")->error();
                return redirect()->route('menu.inscripcion');
            }
        } else {
            flash("Usted no se encuentra registrado en el sistema, no puede proceder")->error();
            return redirect()->route('menu.inscripcion');
        }
    }

    //permite ver los documentos anexos
    public function documentosanexosver($unidad, $grado, $jornada)
    {
        $docs = Parametrizardocumentoanexo::where([['unidad_id', $unidad], ['jornada_id', $jornada], ['grado_id', $grado]])->get();
        return view('acudiente.documentos_anexos.verdocs')
            ->with('location', 'inscripcion')
            ->with('docs', $docs);
    }

    //Permite visualizar para imprimir los formularios de inscripcion
    public function formimprimir()
    {
        $u = Auth::user();
        $p = Persona::where('numero_documento', $u->identificacion)->first();
        if ($p != null) {
            $pn = $p->personanatural;
            if ($pn != null) {
                $acs = $pn->acudientes;
                if (count($acs) > 0) {
                    $aspirantes = null;
                    foreach ($acs as $a) {
                        $aspirantes[] = $a->aspirante;
                    }
                    return view('acudiente.inscribir.imprimir')
                        ->with('location', 'inscripcion')
                        ->with('aspirantes', $aspirantes);
                } else {
                    flash("Usted no es un acudiente, no puede proceder")->error();
                    return redirect()->route('menu.inscripcion');
                }
            } else {
                flash("Usted no se encuentra registrado en el sistema, no puede proceder")->error();
                return redirect()->route('menu.inscripcion');
            }
        } else {
            flash("Usted no se encuentra registrado en el sistema, no puede proceder")->error();
            return redirect()->route('menu.inscripcion');
        }
    }

    //permite imprimir el formulario de inscripcion
    public function formimprimirpdf($id)
    {
        $a = Aspirante::find($id);
        $a->unidad;
        $a->periodoacademico;
        $a->grado;
        $a->jornada;
        $a->tipodoc;
        $a->sexo;
        $ciudad = $estado = $pais = $acudientes = $padres = $respfinan = null;
        $ciudad = $a->ciudad;
        if ($ciudad != null) {
            $estado = $ciudad->estado;
        }
        if ($estado != null) {
            $pais = $estado->pais;
        }
        $a->ciudada = $ciudad;
        $a->estadoa = $estado;
        $a->paisa = $pais;
        $a->estrato;
        $a->etnia;
        $a->conquienvive;
        $a->circunscripcion;
        $a->situacionanioanterior;
        $a->rangosisben;
        $a->entidadsalud;
        $d = null;
        $d = $a->datoscomplementariosaspirante;
        $a->d = $d;
        $acu = $a->acudientes;
        if ($acu != null) {
            foreach ($acu as $ac) {
                $acudientes[] = [
                    "tipodoc" => $ac->personanatural->persona->tipodoc->descripcion,
                    "numero_documento" => $ac->personanatural->persona->numero_documento,
                    "acudiente" => $ac->personanatural->primer_nombre . " " . $ac->personanatural->segundo_nombre . " " . $ac->personanatural->primer_apellido . " " . $ac->personanatural->segundo_apellido
                ];
            }
        }
        $padres = $a->padresaspirantes;
        $respfinan = $a->responsablefinancieroaspirante;
        $a->acudientesm = $acudientes;
        $a->padres = $padres;
        $a->rf = $respfinan;
        $hoy = getdate();
        $fecha = $hoy["year"] . "/" . $hoy["mon"] . "/" . $hoy["mday"] . "  Hora: " . $hoy["hours"] . ":" . $hoy["minutes"] . ":" . $hoy["seconds"];
        $a->hoy = $fecha;
        $pdf = PDF::loadView('acudiente.inscribir.print', $a);
        return $pdf->stream('formulario.pdf');
    }
}
