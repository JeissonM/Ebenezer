<?php

namespace App\Http\Controllers;

use App\Acudienteestudiante;
use Illuminate\Http\Request;
use App\Matriculaauditoria;
use Illuminate\Support\Facades\Auth;
use App\Unidad;
use App\Periodoacademico;
use App\Jornada;
use App\Grado;
use App\Aspirante;
use App\Categoria;
use App\Grupousuario;
use App\Persona;
use App\Personanatural;
use App\Estudiante;
use App\Datoscompestudiante;
use App\Padresestudiante;
use App\Resposablefestudiante;
use App\Situacionestudiante;
use App\User;
use Illuminate\Support\Facades\Hash;

class ConvertiraspirantesController extends Controller
{
    //index
    public function index()
    {
        $periodos = $unidades = $jornadas = null;
        $perds = Periodoacademico::all()->sortByDesc('anio');
        if (count($perds) > 0) {
            foreach ($perds as $p) {
                $periodos[$p->id] = $p->etiqueta . " - " . $p->anio;
            }
        } else {
            flash("No hay períodos académicos")->error();
            return redirect()->route('menu.matricula');
        }
        $unds = Unidad::all();
        if (count($unds) > 0) {
            foreach ($unds as $u) {
                $unidades[$u->id] = $u->nombre . " - " . $u->descripcion . " - " . $u->ciudad->nombre;
            }
        } else {
            flash("No hay unidades o sedes definidas")->error();
            return redirect()->route('menu.matricula');
        }
        $grados = Grado::all()->pluck('etiqueta', 'id');
        $jnds = Jornada::all();
        if (count($jnds) > 0) {
            foreach ($jnds as $j) {
                $jornadas[$j->id] = $j->descripcion . " - " . $j->jornadasnies;
            }
        } else {
            flash("No hay jornadas académicas definidas")->error();
            return redirect()->route('menu.matricula');
        }
        if (count($grados) <= 0) {
            flash("No hay grados académicos definidos")->error();
            return redirect()->route('menu.matricula');
        }
        $grupos = Grupousuario::all()->sortByDesc('nombre');
        $cats = Categoria::all();
        $sit = Situacionestudiante::all();
        return view('matricula.matricula.convertir_aspirantes.list')
            ->with('location', 'matricula')
            ->with('periodos', $periodos)
            ->with('jornadas', $jornadas)
            ->with('unidades', $unidades)
            ->with('grados', $grados)
            ->with('grupos', $grupos)
            ->with('situaciones', $sit)
            ->with('categorias', $cats);
    }

    //Convierte en estudiantes a los aspirantes ubicandolos por unidad, periodo, jornada, grado, situacion y rol
    public function convertiraspirantes($u, $p, $j, $g, $s, $r, $c)
    {
        //$aspirantes = Aspirante::where([['unidad_id', $u], ['periodoacademico_id', $p], ['jornada_id', $j], ['grado_id', $g], ['estado', 'ADMITIDO'], ['pago', 'PAGADO']])->get();
        $aspirantes = Aspirante::where([['unidad_id', $u], ['periodoacademico_id', $p], ['jornada_id', $j], ['grado_id', $g], ['estado', 'ADMITIDO']])->get();
        $response = null;
        $hoy = getdate();
        $periodo = Periodoacademico::find($p);
        $jornada = Jornada::find($j);
        $unidad = Unidad::find($u);
        $grado = Grado::find($g);
        $fecha = $hoy["year"] . "/" . $hoy["mon"] . "/" . $hoy["mday"];
        if (count($aspirantes) > 0) {
            $response[] = "*********************************************************************************************************";
            $response[] = "PROCESO DE CONVERSIÓN MASIVO - CONVERSIÓN DE ASPIRANTES ADMITIDOS EN ESTUDIANTES. FECHA: " . $hoy["year"] . "/" . $hoy["mon"] . "/" . $hoy["mday"];
            $response[] = "UNIDAD: " . $unidad->nombre . " - JORNADA: " . $jornada->descripcion . " - PERÍODO: " . $periodo->etiqueta . " " . $periodo->anio . " - GRADO: " . $grado->etiqueta;
            $response[] = "*********************************************************************************************************";
            $response[] = "                                                                        ";
            $response[] = "                                                                        ";
            foreach ($aspirantes as $a) {
                //verificar que no esté en el sistema como estudiante
                $po = Persona::where('numero_documento', $a->numero_documento)->first();
                $si = false;
                if ($po != null) {
                    if ($po->personanatural != null) {
                        if ($po->personanatural->estudiante != null) {
                            $response[] = "--- [X] EL ASPIRANTE YA SE ENCUENTRA REGISTRADO COMO ESTUDIANTE EN EL SISTEMA, NO SE PUDO CONVERTIR.";
                            $si = true;
                        }
                    }
                }
                if ($si == false) {
                    //crear persona
                    $response[] = "----- CONVIRTIENDO AL ASPIRANTE " . $a->numero_documento . "  -  " . $a->primer_nombre . " " . $a->primer_apellido;
                    $p = $this->setPersona('NATURAL', $a->correo, $a->direccion_residencia, $a->celular, $a->telefono, $a->numero_documento, $a->lugar_expedicion, $a->fecha_expedicion, null, null, $a->tipodoc_id, null, null, $a->ciudad_id);
                    if ($p->save()) {
                        $this->setAuditoriamatricula('INSERTAR', 'CREACIÓN DE PERSONA GENERAL. DATOS: ', $p);
                        $response[] = "[OK] LA PERSONA GENERAL HA SIDO CREADA CON EXITO";
                        //crear persona natural
                        $pn = $this->setPersonanatural($a->primer_nombre, $a->segundo_nombre, $a->fecha_nacimiento, null, null, $a->rh, $a->primer_apellido, $a->segundo_apellido, null, null, null, null, null, null, null, null, $a->ciudad_id, null, null, $p->id, $a->sexo_id);
                        if ($pn->save()) {
                            $this->setAuditoriamatricula('INSERTAR', 'CREACIÓN DE PERSONA NATURAL. DATOS: ', $pn);
                            $response[] = "[OK] LA PERSONA NATURAL HA SIDO CREADA CON EXITO";
                            //crear estudiante
                            $e = $this->setEstudiante($a->created_at, 'NUEVO', $a->barrio_residencia, $a->periodoacademico_id, $a->grado_id, $a->unidad_id, $a->estrato_id, $a->jornada_id, $pn->id, $s, $c);
                            if ($e->save()) {
                                $this->setAuditoriamatricula('INSERTAR', 'CREACIÓN DE ESTUDIANTE. DATOS: ', $e);
                                $response[] = "[OK] EL ESTUDIANTE HA SIDO CREADO CON EXITO";
                                //crear datos complementarios
                                $da = $acu = $resp = $padres = null;
                                $da = $a->datoscomplementariosaspirante;
                                if ($da != null) {
                                    $d = $this->setInformacionComplementaria($da->padres_separados,  $da->iglesia_asiste,  $da->pastor,  $da->discapacidad,  $da->familias_en_accion,  $da->poblacion_victima_conflicto,  $da->desplazado,  $da->colegio_procedencia,  $da->compromiso_adquirido,  null,  $da->etnia_id,  $da->conquienvive_id,  $da->rangosisben_id,  $da->entidadsalud_id,  $da->situacionanioanterior_id,  $e->id);
                                    if ($d->save()) {
                                        $this->setAuditoriamatricula('INSERTAR', 'CREACIÓN DE DATOS COMPLEMENTARIOS DEL ESTUDIANTE. DATOS: ', $d);
                                        $response[] = "[OK] LOS DATOS COMPLEMENTARIOS DEL ESTUDIANTE HAN SIDO CREADOS CON EXITO";
                                    } else {
                                        $response[] = "[X] LA INFORMACIÓN COMPLEMENTARIA NO SE GUARDÓ PERO NO AFECTA EL PROCESO DE CONVERSIÓN DEL ASPIRANTE";
                                    }
                                } else {
                                    $response[] = "[--] EL ASPIRANTE NO TIENE INFORMACIÓN COMPLEMENTARIA";
                                }
                                //asignar acudientes
                                $acu = $a->acudientes;
                                $u = Auth::user();
                                if (count($acu) > 0) {
                                    foreach ($acu as $ac) {
                                        $mm = new Acudienteestudiante();
                                        $mm->estudiante_id = $e->id;
                                        $mm->personanatural_id = $ac->personanatural_id;
                                        $mm->user_change = $u->identificacion;
                                        if ($mm->save()) {
                                            $this->setAuditoriamatricula('INSERTAR', 'CREACIÓN DE ACUDIENTE DEL ESTUDIANTE. DATOS: ', $mm);
                                            $response[] = "[OK] LOS DATOS DEL ACUDIENTE " . $ac->personanatural->primer_nombre . " " . $ac->personanatural->primer_apellido . " DEL ESTUDIANTE HAN SIDO ALMACENADOS CON EXITO";
                                        } else {
                                            $response[] = "[X] EL ACUDIENTE NO SE GUARDÓ PERO NO AFECTA EL PROCESO DE CONVERSIÓN DEL ASPIRANTE";
                                        }
                                    }
                                } else {
                                    $response[] = "[--] EL ASPIRANTE NO TIENE INFORMACIÓN DE ACUDIENTES";
                                }
                                //crear padres estudiante
                                $padres = $a->padresaspirantes;
                                if (count($padres) > 0) {
                                    foreach ($padres as $pa) {
                                        $pp = $this->setPadre($pa->numero_documento, $pa->lugar_expedicion, $pa->fecha_expedicion, $pa->primer_nombre, $pa->segundo_nombre, $pa->primer_apellido, $pa->segundo_apellido, $pa->vive, $pa->acudiente, $pa->direccion_residencia, $pa->barrio_residencia, $pa->telefono, $pa->celular, $pa->correo, $pa->padre_madre, $pa->sexo_id, $pa->tipodoc_id, $pa->ocupacion_id, $e->id);
                                        if ($pp->save()) {
                                            $this->setAuditoriamatricula('INSERTAR', 'CREACIÓN DE PADRE DEL ESTUDIANTE. DATOS: ', $pp);
                                            $response[] = "[OK] LOS DATOS DEL PADRE " . $pp->primer_nombre . " " . $pp->primer_apellido . " DEL ESTUDIANTE HAN SIDO ALMACENADOS CON EXITO";
                                        } else {
                                            $response[] = "[X] EL PADRE NO SE GUARDÓ PERO NO AFECTA EL PROCESO DE CONVERSIÓN DEL ASPIRANTE";
                                        }
                                    }
                                } else {
                                    $response[] = "[--] EL ASPIRANTE NO TIENE INFORMACIÓN DE PADRES";
                                }
                                //asignar responsables financieros
                                $resp = $a->responsablefinancieroaspirante;
                                if ($resp != null) {
                                    $rr = $this->setResponsableFinanciero($resp->direccion_trabajo, $resp->telefono_trabajo, $resp->puesto_trabajo, $resp->empresa_labora, $resp->jefe_inmediato, $resp->telefono_jefe, $resp->descripcion_trabajador_independiente, $resp->ocupacion_id, $pn->id, $e->id, null);
                                    if ($rr->save()) {
                                        $this->setAuditoriamatricula('INSERTAR', 'CREACIÓN DE RESPONSABLE FINANCIERO DEL ESTUDIANTE. DATOS: ', $rr);
                                        $response[] = "[OK] LOS DATOS DEL RESPONSABLE FINANCIERO DEL ESTUDIANTE HAN SIDO ALMACENADOS CON EXITO";
                                    } else {
                                        $response[] = "[X] EL RESPONSABLE NO SE GUARDÓ PERO NO AFECTA EL PROCESO DE CONVERSIÓN DEL ASPIRANTE";
                                    }
                                } else {
                                    $response[] = "[--] EL ASPIRANTE NO TIENE INFORMACIÓN DE RESPONSABLE FINANCIERO";
                                }
                                //crear usuario
                                $user = new User();
                                $user->identificacion = $p->numero_documento;
                                $user->nombres = $pn->primer_nombre . " " . $pn->segundo_nombre;
                                $user->apellidos = $pn->primer_apellido . " " . $pn->segundo_apellido;
                                $user->email = $p->mail;
                                $user->password = Hash::make($a->numero_documento);
                                $user->user_change = $u->identificacion;
                                $user->estado = "ACTIVO";
                                if ($user->save()) {
                                    $this->setAuditoriamatricula('INSERTAR', 'CREACIÓN DE USUARIO DEL ESTUDIANTE. DATOS: ', $user);
                                    $response[] = "[OK] LOS DATOS DEL USUARIO PARA EL ESTUDIANTE HAN SIDO ALMACENADOS CON EXITO";
                                    $user->grupousuarios()->sync($r);
                                } else {
                                    $response[] = "[x] EL USUARIO DEL ESTUDIANTE NO PUDO SER CREADO, AÚN ASÍ, EL PROCESO DE CONVERSIÓN PARA EL ASPIRANTE NO SE VERÁ AFECTADO";
                                }
                            } else {
                                $pn->delete();
                                $p->delete();
                                $response[] = "[x] EL ESTUDIANTE NO PUDO SER CREADO, LA CONVERSIÓN PARA EL ASPIRANTE DE DESHACE, DEBERÁ REPETIR EL PROCESO PARA EL ASPIRANTE";
                            }
                        } else {
                            $p->delete();
                            $response[] = "[x] LA PERSONA NATURAL NO PUDO SER CREADA, LA CONVERSIÓN PARA EL ASPIRANTE DE DESHACE, DEBERÁ REPETIR EL PROCESO PARA EL ASPIRANTE";
                        }
                    } else {
                        $response[] = "[x] LA PERSONA GENERAL NO PUDO SER CREADA, DEBERÁ REPETIR EL PROCESO PARA EL ASPIRANTE";
                    }
                }
                $response[] = "*********************************************************************************************************";
                $response[] = "                                                                                          ";
            }
            //creo el archivo fisico
            $archivo = "CONVERSIÓN_AUTOMATICA_ASPIRANTES_" . $grado->etiqueta . "_" . $periodo->etiqueta . "-" . $periodo->anio . "_" . $hoy["year"] . $hoy["mon"] . $hoy["mday"] . $hoy["hours"] . $hoy["minutes"] . $hoy["seconds"] . ".txt";
            $file = fopen(public_path() . "/documentos/log/" . $archivo, 'w+');
            foreach ($response as $value) {
                fwrite($file, $value . PHP_EOL);
            }
            fclose($file);
            $response["archivo"] = $archivo;
            $response["resultado"] = $response;
            return view('matricula.matricula.convertir_aspirantes.aspirantes')
                ->with('location', 'matricula')
                ->with('response', $response);
        } else {
            flash("No hay aspirantes para los parámetros indicados")->error();
            return redirect()->route('convertiraspirantes.index');
        }
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
     * set Auditoria matricula
     */

    public function setAuditoriamatricula($operacion, $string1, $r)
    {
        $u = Auth::user();
        $aud = new Matriculaauditoria();
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
    *set Estudiante
    */
    public function setEstudiante($fecha_ingreso, $estado, $barrio_residencia, $periodoacademico_id, $grado_id, $unidad_id, $estrato_id, $jornada_id, $personanatural_id, $situacionestudiante_id, $categoria_id)
    {
        $e = new Estudiante();
        $e->fecha_ingreso = $fecha_ingreso;
        $e->estado = $estado;
        $e->barrio_residencia = $barrio_residencia;
        $e->periodoacademico_id = $periodoacademico_id;
        $e->grado_id = $grado_id;
        $e->unidad_id = $unidad_id;
        $e->estrato_id = $estrato_id;
        $e->jornada_id = $jornada_id;
        $e->personanatural_id = $personanatural_id;
        $e->situacionestudiante_id = $situacionestudiante_id;
        $e->categoria_id = $categoria_id;
        $u = Auth::user();
        $e->user_change = $u->identificacion;
        return $e;
    }

    // informacion complementaria del estudiante
    public function setInformacionComplementaria($padres_separados = 'NO',  $iglesia_asiste = null,  $pastor = null,  $discapacidad = 'NO',  $familias_en_accion = 'NO',  $poblacion_victima_conflicto = 'NO',  $desplazado = 'NO',  $colegio_procedencia = null,  $compromiso_adquirido = 'NO',  $user_change = null,  $etnia_id = null,  $conquienvive_id = null,  $rangosisben_id = null,  $entidadsalud_id = null,  $situacionanioanterior_id,  $estudiante_id)
    {
        $d = new Datoscompestudiante();
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
        $d->estudiante_id = $estudiante_id;
        return $d;
    }

    //guarda padres del estudiante
    public function setPadre($numero_documento, $lugar_expedicion, $fecha_expedicion, $primer_nombre, $segundo_nombre, $primer_apellido, $segundo_apellido, $vive, $acudiente, $direccion_residencia, $barrio_residencia, $telefono, $celular, $correo, $padre_madre, $sexo_id, $tipodoc_id, $ocupacion_id, $id)
    {
        $p = new Padresestudiante();
        $p->numero_documento = $numero_documento;
        $p->lugar_expedicion = $lugar_expedicion;
        $p->fecha_expedicion = $fecha_expedicion;
        $p->primer_nombre = $primer_nombre;
        $p->segundo_nombre = $segundo_nombre;
        $p->primer_apellido = $primer_apellido;
        $p->segundo_apellido = $segundo_apellido;
        $p->vive = $vive;
        $p->acudiente = $acudiente;
        $p->direccion_residencia = $direccion_residencia;
        $p->barrio_residencia = $barrio_residencia;
        $p->telefono = $telefono;
        $p->celular = $celular;
        $p->correo = $correo;
        $p->padre_madre = $padre_madre;
        $p->sexo_id = $sexo_id;
        $p->tipodoc_id = $tipodoc_id;
        $p->ocupacion_id = $ocupacion_id;
        $p->estudiante_id = $id;
        $u = Auth::user();
        $p->user_change = $u->identificacion;
        return $p;
    }

    // responsable financiero
    public function setResponsableFinanciero($direccion_trabajo, $telefono_trabajo, $puesto_trabajo = null, $empresa_labora = null, $jefe_inmediato = null, $telefono_jefe = null, $descripcion_trabajador_independiente = null, $ocupacion_id = null, $personanatural_id, $id, $user_change = null)
    {
        $r = new Resposablefestudiante();
        $r->direccion_trabajo = strtoupper($direccion_trabajo);
        $r->telefono_trabajo = $telefono_trabajo;
        $r->puesto_trabajo = strtoupper($puesto_trabajo);
        $r->empresa_labora = strtoupper($empresa_labora);
        $r->jefe_inmediato = strtoupper($jefe_inmediato);
        $r->telefono_jefe = $telefono_jefe;
        $r->descripcion_trabajador_independiente = strtoupper($descripcion_trabajador_independiente);
        $r->ocupacion_id = $ocupacion_id;
        $r->personanatural_id = $personanatural_id;
        $r->estudiante_id = $id;
        $u = Auth::user();
        $r->user_change = $u->identificacion;
        return $r;
    }
}
