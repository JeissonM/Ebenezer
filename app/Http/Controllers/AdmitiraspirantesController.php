<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Auditoriaadmision;
use App\Unidad;
use App\Jornada;
use App\Grado;
use App\Periodoacademico;
use App\Aspirante;
use App\Parametrizardocumentoanexo;
use App\Rangonota;

class AdmitiraspirantesController extends Controller
{
    //formulario de inicio
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
        return view('admisiones.agenda_entrevista.admitir.list')
            ->with('location', 'admisiones')
            ->with('periodos', $periodos)
            ->with('jornadas', $jornadas)
            ->with('unidades', $unidades)
            ->with('grados', $grados);
    }

    //Lista los aspirantes por unidad, periodo, jornada, grado
    public function listaraspirantes($u, $p, $j, $g)
    {
        $aspirantes = Aspirante::where([['unidad_id', $u], ['periodoacademico_id', $p], ['jornada_id', $j], ['grado_id', $g]])->get();
        if (count($aspirantes) > 0) {
            return view('admisiones.agenda_entrevista.admitir.aspirantes')
                ->with('location', 'admisiones')
                ->with('periodo', Periodoacademico::find($p))
                ->with('jornada', Jornada::find($j))
                ->with('unidad', Unidad::find($u))
                ->with('grado', Grado::find($g))
                ->with('aspirantes', $aspirantes);
        } else {
            flash("No hay aspirantes para los parámetros indicados")->error();
            return redirect()->route('admitiraspirantes.index');
        }
    }

    //muestra el formulario de admision
    public function show($id)
    {
        $a = Aspirante::find($id);
        $requisitos = $entrevista = $examen = null;
        //verificar requisitos
        $requisitos = Parametrizardocumentoanexo::where([['procesosacademico_id', 1], ['grado_id', $a->grado_id], ['jornada_id', $a->jornada_id], ['unidad_id', $a->unidad_id]])->get();
        $verificados = $a->requisitoverificados;
        if (count($requisitos) > 0) {
            foreach ($requisitos as $r) {
                $esta = "NO";
                $req = "";
                if (count($verificados) > 0) {
                    foreach ($verificados as $v) {
                        if ($v->documentoanexo_id == $r->documentoanexo_id) {
                            $esta = "SI";
                            $req = $v->id;
                        }
                    }
                }
                $r->requisito = $req;
                $r->esta = $esta;
            }
        }
        //verificar entrevista
        $entrevista = $a->entrevista;
        $horai = $horaf = "";
        if ($entrevista != null) {
            $hi = (string) $entrevista->agendacita->horainicio;
            $hf = (string) $entrevista->agendacita->horafin;
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
        }
        //verificar examen de admision
        $examen = $a->examenadmision;
        if ($examen != null) {
            $examen->valor_c = $this->cualitativo($examen->calificacion);
            $examen->examenadmisionareas;
        }
        return view('admisiones.agenda_entrevista.admitir.admitir')
            ->with('location', 'admisiones')
            ->with('a', $a)
            ->with('horai', $horai)
            ->with('horaf', $horaf)
            ->with('requisitos', $requisitos)
            ->with('e', $entrevista)
            ->with('examen', $examen);
    }

    //determina el valor cualitativo para una calificacion
    public function cualitativo($valor)
    {
        $notas = Rangonota::all();
        $valor_c = "";
        if (count($notas) > 0) {
            foreach ($notas as $n) {
                if ($valor >= $n->valor_inicial && $valor <= $n->valor_final) {
                    $valor_c = $n->valor_cualitativo;
                }
            }
        }
        return $valor_c;
    }

    //procesa la admision de un estudiante
    public function admitir($id, $estado)
    {
        $a = Aspirante::find($id);
        $u = Auth::user();
        $a->user_change = $u->identificacion;
        $a->estado = $estado;
        $result = $a->save();
        if ($result) {
            $aud = new Auditoriaadmision();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "INSERTAR";
            $str = "ADMISIÓN DE ASPIRANTES. DATOS: ";
            foreach ($a->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("El estado del aspirante fue procesado con exito")->success();
            return redirect()->route('admitiraspirantes.show', $id);
        } else {
            flash("El estado del aspirante no pudo ser procesado. Error: " . $result)->error();
            return redirect()->route('admitiraspirantes.show', $id);
        }
    }
}
