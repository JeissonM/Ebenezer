<?php

namespace App\Http\Controllers;

use App\Agendacitas;
use App\Aspirante;
use App\Auditoriaadmision;
use App\Entrevista;
use App\Periodounidad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Persona;
use App\Unidad;
use App\Periodoacademico;
use App\Jornada;
use App\Grado;
use Illuminate\Support\Facades\Mail;
use App\Mail\Notificarcita;

class EntrevistaController extends Controller
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
            $pn = $p->personanatural;
            if ($pn != null) {
                $acs = $pn->acudientes;
                if (count($acs) > 0) {
                    $aspirantes = null;
                    foreach ($acs as $a) {
                        $aspirantes[] = $a->aspirante;
                    }
                    return view('acudiente.entrevista.list')
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $periodos = $unidades = $jornadas = null;
        $perds = Periodoacademico::all()->sortByDesc('anio');
        if (count($perds) > 0) {
            foreach ($perds as $p) {
                $periodos[$p->id] = $p->etiqueta . " - " . $p->anio;
            }
        } else {
            flash("No hay períodos académicos")->error();
            return redirect()->route('menu.admisiones');
        }
        $unds = Unidad::all();
        if (count($unds) > 0) {
            foreach ($unds as $u) {
                $unidades[$u->id] = $u->nombre . " - " . $u->descripcion . " - " . $u->ciudad->nombre;
            }
        } else {
            flash("No hay unidades o sedes definidas")->error();
            return redirect()->route('menu.admisiones');
        }
        $grados = Grado::all()->pluck('etiqueta', 'id');
        $jnds = Jornada::all();
        if (count($jnds) > 0) {
            foreach ($jnds as $j) {
                $jornadas[$j->id] = $j->descripcion . " - " . $j->jornadasnies;
            }
        } else {
            flash("No hay jornadas académicas definidas")->error();
            return redirect()->route('menu.admisiones');
        }
        if (count($grados) <= 0) {
            flash("No hay grados académicos definidos")->error();
            return redirect()->route('menu.admisiones');
        }
        return view('admisiones.agenda_entrevista.agendarentrevista.list')
            ->with('location', 'admisiones')
            ->with('periodos', $periodos)
            ->with('jornadas', $jornadas)
            ->with('unidades', $unidades)
            ->with('grados', $grados);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pu = null;
        $asp = Aspirante::find($id);
        $pu = Periodounidad::where([['periodoacademico_id', $asp->periodoacademico_id], ['unidad_id', $asp->unidad_id], ['jornada_id', $asp->jornada_id]])->first();
        if ($pu != null) {
            $citas = Agendacitas::where([['periodounidad_id', $pu->id], ['estado', 'DISPONIBLE']])->get();
            if (count($citas) > 0) {
                foreach ($citas as $a) {
                    $hi = (string) $a->horainicio;
                    $hf = (string) $a->horafin;
                    if (strlen($hi) < 4) {
                        $a->horainicio = "0" . $hi[0] . ":" . $hi[1] . $hi[2];
                    } else {
                        $a->horainicio = $hi[0] . $hi[1] . ":" . $hi[2] . $hi[3];
                    }
                    if (strlen($hf) < 4) {
                        $a->horafin = "0" . $hf[0] . ":" . $hf[1] . $hf[2];
                    } else {
                        $a->horafin = $hf[0] . $hf[1] . ":" . $hf[2] . $hf[3];
                    }
                }
                return view('acudiente.entrevista.entrevista')
                    ->with('location', 'inscripcion')
                    ->with('a', $asp)
                    ->with('citas', $citas);
            } else {
                flash("No hay fechas disponibles para el aspirante.")->error();
                return redirect()->route('entrevistaa.index');
            }
        } else {
            flash("No hay períodos programados para la UNIDAD, PERÍODO y JORNADA del aspirante, por favor ponerse en contacto al siguiente número de telefono xxx-xxx-xxxx o al correo: xxxxxx@example.com")->warning();
            return redirect()->route('entrevistaa.index');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    //permite agendar una cita
    public function agendar($id, $cita)
    {
        $a = Aspirante::find($id);
        $e = new Entrevista();
        $e->nombre = "ENTREVISTA ASPIRANTE " . $a->primer_nombre . " " . $a->segundo_nombre . " " . $a->primer_apellido . " " . $a->segundo_apellido;
        $e->descripcion = "ENTREVISTA PROCESO DE ADMISIÓN";
        $e->estado = "PENDIENTE";
        $u = Auth::user();
        $e->user_change = $u->identificacion;
        $e->agendacita_id = $cita;
        $e->aspirante_id = $id;
        $result = $e->save();
        if ($result) {
            $ac = Agendacitas::find($cita);
            $ac->estado = "USADO";
            $ac->save();
            $aud = new Auditoriaadmision();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "INSERTAR";
            $str = "CREACIÓN DE CITA PARA ENTREVISTA. DATOS: ";
            foreach ($e->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("La cita fue agendada de forma exitosa!")->success();
            return redirect()->route('entrevistaa.index');
        } else {
            flash("La cita no pudo ser agendada. Error: " . $result)->error();
            return redirect()->route('entrevistaa.index');
        }
    }

    //Lista los aspirantes por unidad, periodo, jornada, grado
    public function listaraspirantes($u, $p, $j, $g)
    {
        $aspirantes = Aspirante::where([['unidad_id', $u], ['periodoacademico_id', $p], ['jornada_id', $j], ['grado_id', $g]])->get();
        if (count($aspirantes) > 0) {
            return view('admisiones.agenda_entrevista.agendarentrevista.aspirantes')
                ->with('location', 'admisiones')
                ->with('periodo', Periodoacademico::find($p))
                ->with('jornada', Jornada::find($j))
                ->with('unidad', Unidad::find($u))
                ->with('grado', Grado::find($g))
                ->with('aspirantes', $aspirantes);
        } else {
            flash("No hay aspirantes para los parámetros indicados")->error();
            return redirect()->route('entrevista.create');
        }
    }

    //Horas para la entrevista
    public function horas($id)
    {
        $pu = null;
        $asp = Aspirante::find($id);
        $pu = Periodounidad::where([['periodoacademico_id', $asp->periodoacademico_id], ['unidad_id', $asp->unidad_id], ['jornada_id', $asp->jornada_id]])->first();
        if ($pu != null) {
            $citas = Agendacitas::where([['periodounidad_id', $pu->id], ['estado', 'DISPONIBLE']])->get();
            if (count($citas) > 0) {
                foreach ($citas as $a) {
                    $hi = (string) $a->horainicio;
                    $hf = (string) $a->horafin;
                    if (strlen($hi) < 4) {
                        $a->horainicio = "0" . $hi[0] . ":" . $hi[1] . $hi[2];
                    } else {
                        $a->horainicio = $hi[0] . $hi[1] . ":" . $hi[2] . $hi[3];
                    }
                    if (strlen($hf) < 4) {
                        $a->horafin = "0" . $hf[0] . ":" . $hf[1] . $hf[2];
                    } else {
                        $a->horafin = $hf[0] . $hf[1] . ":" . $hf[2] . $hf[3];
                    }
                }
                return view('admisiones.agenda_entrevista.agendarentrevista.entrevista')
                    ->with('location', 'admisiones')
                    ->with('a', $asp)
                    ->with('citas', $citas);
            } else {
                flash("No hay fechas disponibles para el aspirante.")->error();
                return redirect()->route('entrevista.create');
            }
        } else {
            flash("No hay períodos programados para la UNIDAD, PERÍODO y JORNADA del aspirante, reporte el error a la institución, no es normal que esto ocurra.")->warning();
            return redirect()->route('entrevista.create');
        }
    }

    //permite agendar una cita desde admision
    public function agendarcita($id, $cita)
    {
        $a = Aspirante::find($id);
        $e = new Entrevista();
        $e->nombre = "ENTREVISTA ASPIRANTE " . $a->primer_nombre . " " . $a->segundo_nombre . " " . $a->primer_apellido . " " . $a->segundo_apellido;
        $e->descripcion = "ENTREVISTA PROCESO DE ADMISIÓN";
        $e->estado = "PENDIENTE";
        $u = Auth::user();
        $e->user_change = $u->identificacion;
        $e->agendacita_id = $cita;
        $e->aspirante_id = $id;
        $result = $e->save();
        if ($result) {
            $aci = Agendacitas::find($cita);
            $aci->estado = "USADO";
            $aci->save();
            $aud = new Auditoriaadmision();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "INSERTAR";
            $str = "CREACIÓN DE CITA PARA ENTREVISTA. DATOS: ";
            foreach ($e->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            //Enviar correo notificando la cita
            $acudientes = $a->acudientes;
            if (count($acudientes) > 0) {
                $horai = $horaf = "";
                $hi = (string) $aci->horainicio;
                $hf = (string) $aci->horafin;
                if (strlen($hi) < 4) {
                    $horai = "0" . $hi[0] . ":" . $hi[1] . $hi[2];
                } else {
                    $horai = $hi[0] . $hi[1] . ":" . $hi[2] . $hi[3];
                }
                if (strlen($hf) < 4) {
                    $horaf = "0" . $hf[0] . ":" . $hf[1] . $hf[2];
                } else {
                    $horaf = $hf[0] . $hf[1] . ":" . $hf[2] . $hf[3];
                }
                foreach ($acudientes as $ac) {
                    $mail = $ac->personanatural->persona->mail;
                    if ($mail != null) {
                        //envio correo
                        $nombre = $ac->personanatural->primer_nombre . " " . $ac->personanatural->segundo_nombre . " " . $ac->personanatural->primer_apellido . " " . $ac->personanatural->segundo_apellido;
                        $msj = "Hola, señor(a)" . $nombre . " la siguiente notificación le es enviada para comunicarle que ha sido asignada la cita de la entrevista y exámen de admisión,"
                            . " ésto debido a que usted no agendó dicha cita. La entrevista se realizará en la fecha y hora: " . $aci->fecha . " " . $horai . " - " . $horaf . ". "
                            . "Agradecemos ser puntuales y llevar la documentación requerida que puede ser consultada dentro del aplicativo en la opción INSCRIPCIÓN> VER DOCUMENTOS ANEXOS AL PROCESO DE INSCRIPCIÓN";
                        $data = [
                            'asunto' => 'Notificación cita para entrevista y exámen de admisión',
                            'mensaje' => $msj,
                            'pie' => 'Ebenezer - Valledupar'
                        ];
                        Mail::to($mail)->send(new Notificarcita($data));
                    }
                }
            }
            flash("La cita fue agendada de forma exitosa!")->success();
            return redirect()->route('entrevista.listaraspirantes', [$a->unidad_id, $a->periodoacademico_id, $a->jornada_id, $a->grado_id]);
        } else {
            flash("La cita no pudo ser agendada. Error: " . $result)->error();
            return redirect()->route('entrevista.listaraspirantes', [$a->unidad_id, $a->periodoacademico_id, $a->jornada_id, $a->grado_id]);
        }
    }
}
