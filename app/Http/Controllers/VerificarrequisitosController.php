<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jornada;
use App\Grado;
use App\Unidad;
use App\Periodoacademico;
use App\Aspirante;
use App\Parametrizardocumentoanexo;
use App\Requisitoverificado;
use Illuminate\Support\Facades\Auth;
use App\Auditoriaadmision;
use App\Matriculaauditoria;

class VerificarrequisitosController extends Controller
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
        return view('admisiones.agenda_entrevista.verificar_requisitos.list')
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
            return view('admisiones.agenda_entrevista.verificar_requisitos.aspirantes')
                ->with('location', 'admisiones')
                ->with('periodo', Periodoacademico::find($p))
                ->with('jornada', Jornada::find($j))
                ->with('unidad', Unidad::find($u))
                ->with('grado', Grado::find($g))
                ->with('aspirantes', $aspirantes);
        } else {
            flash("No hay aspirantes para los parámetros indicados")->error();
            return redirect()->route('verificarrequisitos.index');
        }
    }

    //verifica y lista los requisitos de admision
    public function listarrequisitos($id)
    {
        $a = Aspirante::find($id);
        $requisitos = Parametrizardocumentoanexo::where([['procesosacademico_id', 1], ['grado_id', $a->grado_id], ['jornada_id', $a->jornada_id], ['unidad_id', $a->unidad_id]])->get();
        $verificados = $a->requisitoverificados;
        if (count($requisitos) > 0) {
            foreach ($requisitos as $r) {
                $esta = "NO";
                $req = "";
                if (count($verificados) > 0) {
                    foreach ($verificados as $v) {
                        if ($v->documentoanexo_id == $r->documentoanexo_id && $v->procesosacademico_id == 1) {
                            $esta = "SI";
                            $req = $v->id;
                        }
                    }
                }
                $r->requisito = $req;
                $r->esta = $esta;
            }
            return view('admisiones.agenda_entrevista.verificar_requisitos.verificar')
                ->with('location', 'admisiones')
                ->with('a', $a)
                ->with('requisitos', $requisitos);
        } else {
            flash("No hay requisitos establecidos para el aspirante seleccionado")->error();
            return redirect()->route('verificarrequisitos.listaraspirantes', [$a->unidad_id, $a->periodoacademico_id, $a->jornada_id, $a->grado_id]);
        }
    }

    //Check requisito
    public function check($aspirante, $requisito, $proceso)
    {
        $v = new Requisitoverificado();
        $v->aspirante_id = $aspirante;
        $v->documentoanexo_id = $requisito;
        $v->procesosacademico_id = $proceso;
        $u = Auth::user();
        $v->user_change = $u->identificacion;
        $result = $v->save();
        if ($result) {
            $aud = new Auditoriaadmision();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "INSERTAR";
            $str = "CREACIÓN DE CHECK DE REQUISITOS DE INSCRIPCIÓN. DATOS: ";
            foreach ($v->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("El requisito fue verificado de forma exitosa!")->success();
            return redirect()->route('verificarrequisitos.listarrequisitos', $aspirante);
        } else {
            flash("El requisito no pudo ser verificado. Error: " . $result)->error();
            return redirect()->route('verificarrequisitos.listarrequisitos', $aspirante);
        }
    }

    //remueve el requisito cumplido
    public function removeRequisito($id)
    {
        $v = Requisitoverificado::find($id);
        $result = $v->delete();
        if ($result) {
            $aud = new Auditoriaadmision();
            $u = Auth::user();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ELIMINAR";
            $str = "ELIMINACIÓN DE REQUISITO VERIFICADO. DATOS ELIMINADOS: ";
            foreach ($v->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("El requisito fue retirado de forma exitosa!")->success();
            return redirect()->route('verificarrequisitos.listarrequisitos', $v->aspirante_id);
        } else {
            flash("El requisito no pudo ser retirado. Error: " . $result)->error();
            return redirect()->route('verificarrequisitos.listarrequisitos', $v->aspirante_id);
        }
    }

    //index
    public function indexmatricula()
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
        return view('matricula.matricula.verificar_requisitos.list')
            ->with('location', 'matricula')
            ->with('periodos', $periodos)
            ->with('jornadas', $jornadas)
            ->with('unidades', $unidades)
            ->with('grados', $grados);
    }

    //Lista los aspirantes por unidad, periodo, jornada, grado
    public function listaraspirantesmatricula($u, $p, $j, $g)
    {
        $aspirantes = Aspirante::where([['unidad_id', $u], ['periodoacademico_id', $p], ['jornada_id', $j], ['grado_id', $g]])->get();
        if (count($aspirantes) > 0) {
            return view('matricula.matricula.verificar_requisitos.aspirantes')
                ->with('location', 'matricula')
                ->with('periodo', Periodoacademico::find($p))
                ->with('jornada', Jornada::find($j))
                ->with('unidad', Unidad::find($u))
                ->with('grado', Grado::find($g))
                ->with('aspirantes', $aspirantes);
        } else {
            flash("No hay aspirantes para los parámetros indicados")->error();
            return redirect()->route('verificarrequisitos.indexmatricula');
        }
    }

    //verifica y lista los requisitos de matricula
    public function listarrequisitosmatricula($id)
    {
        $a = Aspirante::find($id);
        $requisitos = Parametrizardocumentoanexo::where([['procesosacademico_id', 2], ['grado_id', $a->grado_id], ['jornada_id', $a->jornada_id], ['unidad_id', $a->unidad_id]])->get();
        $verificados = $a->requisitoverificados;
        if (count($requisitos) > 0) {
            foreach ($requisitos as $r) {
                $esta = "NO";
                $req = "";
                if (count($verificados) > 0) {
                    foreach ($verificados as $v) {
                        if ($v->documentoanexo_id == $r->documentoanexo_id && $v->procesosacademico_id == 2) {
                            $esta = "SI";
                            $req = $v->id;
                        }
                    }
                }
                $r->requisito = $req;
                $r->esta = $esta;
            }
            return view('matricula.matricula.verificar_requisitos.verificar')
                ->with('location', 'matricula')
                ->with('a', $a)
                ->with('requisitos', $requisitos);
        } else {
            flash("No hay requisitos establecidos para el aspirante seleccionado")->error();
            return redirect()->route('verificarrequisitos.listaraspirantesmatricula', [$a->unidad_id, $a->periodoacademico_id, $a->jornada_id, $a->grado_id]);
        }
    }

    //Check requisito matricula
    public function checkmatricula($aspirante, $requisito, $proceso)
    {
        $v = new Requisitoverificado();
        $v->aspirante_id = $aspirante;
        $v->documentoanexo_id = $requisito;
        $v->procesosacademico_id = $proceso;
        $u = Auth::user();
        $v->user_change = $u->identificacion;
        $result = $v->save();
        if ($result) {
            $aud = new Matriculaauditoria();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "INSERTAR";
            $str = "CREACIÓN DE CHECK DE REQUISITOS DE MATRICULA. DATOS: ";
            foreach ($v->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("El requisito fue verificado de forma exitosa!")->success();
            return redirect()->route('verificarrequisitos.listarrequisitosmatricula', $aspirante);
        } else {
            flash("El requisito no pudo ser verificado. Error: " . $result)->error();
            return redirect()->route('verificarrequisitos.listarrequisitosmatricula', $aspirante);
        }
    }

    //remueve el requisito cumplido de matricula
    public function removeRequisitomatricula($id)
    {
        $v = Requisitoverificado::find($id);
        $result = $v->delete();
        if ($result) {
            $aud = new Matriculaauditoria();
            $u = Auth::user();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ELIMINAR";
            $str = "ELIMINACIÓN DE REQUISITO DE MATRÍCULA VERIFICADO. DATOS ELIMINADOS: ";
            foreach ($v->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("El requisito fue retirado de forma exitosa!")->success();
            return redirect()->route('verificarrequisitos.listarrequisitosmatricula', $v->aspirante_id);
        } else {
            flash("El requisito no pudo ser retirado. Error: " . $result)->error();
            return redirect()->route('verificarrequisitos.listarrequisitosmatricula', $v->aspirante_id);
        }
    }

    //realiza el pago de la matricula
    public function pagar($id)
    {
        $a = Aspirante::find($id);
        $a->pago = "PAGADO";
        $result = $a->save();
        if ($result) {
            $aud = new Matriculaauditoria();
            $u = Auth::user();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ELIMINAR";
            $str = "PAGO DE MATRICULA FINANCIERA. DATOS NUEVOS: ";
            foreach ($a->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("El pago fue realizado de forma exitosa!")->success();
            return redirect()->route('verificarrequisitos.listarrequisitosmatricula', $a->id);
        } else {
            flash("El pago no pudo ser realizado. Error: " . $result)->error();
            return redirect()->route('verificarrequisitos.listarrequisitosmatricula', $a->id);
        }
    }
}
