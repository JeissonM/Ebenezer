<?php

namespace App\Http\Controllers;

use App\Asignarlogrogrupomateria;
use App\Auditoriaacademico;
use App\Estudiante;
use App\Gradomateria;
use App\Grupomateriadocente;
use App\Jornada;
use App\Logro;
use App\Periodoacademico;
use App\Persona;
use App\Personalizarlogro;
use App\Unidad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class LogroController extends Controller
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
                $d = $pn->docente;
                if ($d != null) {
                    $periodos = $unidades = $jornadas = null;
                    $perds = Periodoacademico::all()->sortByDesc('anio');
                    if (count($perds) > 0) {
                        foreach ($perds as $p) {
                            $periodos[$p->id] = $p->etiqueta . " - " . $p->anio;
                        }
                    } else {
                        flash("No hay períodos académicos")->error();
                        return redirect()->route('menu.documental');
                    }
                    $unds = Unidad::all();
                    if (count($unds) > 0) {
                        foreach ($unds as $u) {
                            $unidades[$u->id] = $u->nombre . " - " . $u->descripcion . " - " . $u->ciudad->nombre;
                        }
                    } else {
                        flash("No hay unidades o sedes definidas")->error();
                        return redirect()->route('menu.documental');
                    }
                    $jnds = Jornada::all();
                    if (count($jnds) > 0) {
                        foreach ($jnds as $j) {
                            $jornadas[$j->id] = $j->descripcion . " - " . $j->jornadasnies;
                        }
                    } else {
                        flash("No hay jornadas académicas definidas")->error();
                        return redirect()->route('menu.documental');
                    }
                    return view('documental.logro.index')
                        ->with('location', 'documental')
                        ->with('periodos', $periodos)
                        ->with('jornadas', $jornadas)
                        ->with('unidades', $unidades);
                } else {
                    flash('Usted no es un docente de la institución')->error();
                    return redirect()->route('menu.documental');
                }
            } else {
                flash('Usted no se encuentra registrado como persona natural en la base de datos')->error();
                return redirect()->route('menu.documental');
            }
        } else {
            flash('Usted no se encuentra registrado como persona en la base de datos')->error();
            return redirect()->route('menu.documental');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param $id App\Gradomateria
     * @return \Illuminate\Http\Response
     */
    public function create($gm, $gmd)
    {
        $gm = Gradomateria::find($gm);
        return view('documental.logro.create')
            ->with('location', 'documental')
            ->with('gm', $gm)
            ->with('gmd', $gmd);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $logro = new Logro($request->all());
        $u = Auth::user();
        $logro->user_id = $u->id;
        $result = $logro->save();
        if ($result) {
            $aud = new Auditoriaacademico();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "INSERTAR";
            $str = "CREACIÓN DE LOGRO. DATOS: ";
            foreach ($logro->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("El Logro <strong>" . $logro->descripcion . "</strong> fue almacenado de forma exitosa!")->success();
            return redirect()->route('logro.listar', $request->gmd);
        } else {
            flash("El Logro <strong>" . $logro->descripcion . "</strong> no fue almacenado. Error:" . $result)->error();
            return redirect()->route('logro.listar', $request->gmd);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Logro $logro
     * @return \Illuminate\Http\Response
     */
    public function show(Logro $logro)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Logro $logro
     * @return \Illuminate\Http\Response
     */
    public function edit($id, $gmd)
    {
        $logro = Logro::find($id);
        $g = Grupomateriadocente::find($gmd);
        $gm = $g->gradomateria;
        return view('documental.logro.edit')
            ->with('location', 'documental')
            ->with('logro', $logro)
            ->with('gm', $gm)
            ->with('gmd', $gmd);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Logro $logro
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $logro = Logro::find($id);
        $m = new Logro($logro->attributesToArray());
        $logro->descripcion = $request->descripcion;
        $result = $logro->save();
        if ($result) {
            $u = Auth::user();
            $aud = new Auditoriaacademico();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ACTUALIZAR DATOS";
            $str = "EDICION DE LOGRO. DATOS NUEVOS: ";
            $str2 = " DATOS ANTIGUOS: ";
            foreach ($m->attributesToArray() as $key => $value) {
                $str2 = $str2 . ", " . $key . ": " . $value;
            }
            foreach ($logro->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str . " - " . $str2;
            $aud->save();
            flash("El Logro <strong>" . $logro->descripcion . "</strong> fue modificado de forma exitosa!")->success();
            return redirect()->route('logro.listar', $request->gmd);
        } else {
            flash("El Logro <strong>" . $logro->descripcion . "</strong> no fue modificado. Error:" . $result)->error();
            return redirect()->route('logro.listar', $request->gmd);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Logro $logro
     * @return \Illuminate\Http\Response
     */
    public function destroy(Logro $logro)
    {
        //
    }

    public function listar($gmd)
    {
        $gmd = Grupomateriadocente::find($gmd);
        $gm = $gmd->gradomateria;
        $logros = Logro::where([
            ['unidad_id', $gm->unidad_id],
            ['jornada_id', $gm->jornada_id],
            ['grado_id', $gm->grado_id],
            ['materia_id', $gm->materia_id]
        ])->get();
        $asignados = Asignarlogrogrupomateria::where([
            ['unidad_id', $gm->unidad_id],
            ['periodoacademico_id', $gm->periodoacademico_id],
            ['jornada_id', $gm->jornada_id],
            ['grado_id', $gm->grado_id],
            ['materia_id', $gm->materia_id],
            ['grupo_id', $gmd->grupo_id]
        ])->get();
        $u = Auth::user();
        return view('documental.logro.list')
            ->with('location', 'documental')
            ->with('logros', $logros)
            ->with('asignados', $asignados)
            ->with('gm', $gm)
            ->with('gmd', $gmd)
            ->with('user', $u);
    }

    public function asignar($log, $gmd, $per)
    {
        $logro = Logro::find($log);
        $existe = Asignarlogrogrupomateria::where([
            ['unidad_id', $logro->unidad_id],
            ['jornada_id', $logro->jornada_id],
            ['grado_id', $logro->grado_id],
            ['periodoacademico_id', $per],
            ['materia_id', $logro->materia_id],
            ['logro_id', $log]
        ])->first();
        if ($existe != null) {
            flash("El Logro <strong>" . $logro->descripcion . "</strong> ya esta asignado!")->warning();
            return redirect()->route('logro.listar', $gmd);
        }
        $g = Grupomateriadocente::find($gmd);
        $asig = new Asignarlogrogrupomateria();
        $asig->unidad_id = $logro->unidad_id;
        $asig->jornada_id = $logro->jornada_id;
        $asig->grado_id = $logro->grado_id;
        $asig->materia_id = $logro->materia_id;
        $asig->periodoacademico_id = $per;
        $asig->logro_id = $logro->id;
        $asig->grupo_id = $g->grupo_id;
        $result = $asig->save();
        if ($result) {
            $u = Auth::user();
            $aud = new Auditoriaacademico();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "INSERTAR";
            $str = "ASIGNACIÓN DE LOGROS A GRADOS. DATOS: ";
            foreach ($asig->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("El Logro <strong>" . $logro->descripcion . "</strong> fue asignado de forma exitosa!")->success();
            return redirect()->route('logro.listar', $gmd);
        } else {
            flash("El Logro <strong>" . $logro->descripcion . "</strong> no asignado. Error:" . $result)->error();
            return redirect()->route('logro.listar', $gmd);
        }
    }

    public function retirar($algm, $gmd)
    {
        $asig = Asignarlogrogrupomateria::find($algm);
        $result = $asig->delete();
        if ($result) {
            $aud = new Auditoriaacademico();
            $u = Auth::user();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ELIMINAR";
            $str = "ELIMINACIÓN DE LOGRO A GRADO. DATOS ELIMINADOS: ";
            foreach ($asig->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("El Logro <strong>" . $asig->logro->descripcion . "</strong> fue retirado de forma exitosa!")->success();
            return redirect()->route('logro.listar', $gmd);
        } else {
            flash("El Logro <strong>" . $asig->logro->descripcion . "</strong> no fue retirado. Error:" . $result)->error();
            return redirect()->route('logro.listar', $gmd);
        }
    }

    //Personalizar logro inicio
    public function personalizar_inicio()
    {
        $u = Auth::user();
        $p = Persona::where('numero_documento', $u->identificacion)->first();
        if ($p != null) {
            $pn = $p->personanatural;
            if ($pn != null) {
                $d = $pn->docente;
                if ($d != null) {
                    $periodos = $unidades = $jornadas = null;
                    $perds = Periodoacademico::all()->sortByDesc('anio');
                    if (count($perds) > 0) {
                        foreach ($perds as $p) {
                            $periodos[$p->id] = $p->etiqueta . " - " . $p->anio;
                        }
                    } else {
                        flash("No hay períodos académicos")->error();
                        return redirect()->route('menu.documental');
                    }
                    $unds = Unidad::all();
                    if (count($unds) > 0) {
                        foreach ($unds as $u) {
                            $unidades[$u->id] = $u->nombre . " - " . $u->descripcion . " - " . $u->ciudad->nombre;
                        }
                    } else {
                        flash("No hay unidades o sedes definidas")->error();
                        return redirect()->route('menu.documental');
                    }
                    $jnds = Jornada::all();
                    if (count($jnds) > 0) {
                        foreach ($jnds as $j) {
                            $jornadas[$j->id] = $j->descripcion . " - " . $j->jornadasnies;
                        }
                    } else {
                        flash("No hay jornadas académicas definidas")->error();
                        return redirect()->route('menu.documental');
                    }
                    return view('documental.personalizarlogro.index')
                        ->with('location', 'documental')
                        ->with('periodos', $periodos)
                        ->with('jornadas', $jornadas)
                        ->with('unidades', $unidades);
                } else {
                    flash('Usted no es un docente de la institución')->error();
                    return redirect()->route('menu.documental');
                }
            } else {
                flash('Usted no se encuentra registrado como persona natural en la base de datos')->error();
                return redirect()->route('menu.documental');
            }
        } else {
            flash('Usted no se encuentra registrado como persona en la base de datos')->error();
            return redirect()->route('menu.documental');
        }
    }

    //vista para personalizar logros
    public function revisarlogros($id, $est)
    {
        $gmd = Grupomateriadocente::find($id);
        $est = Estudiante::find($est);
        $asignados = Asignarlogrogrupomateria::where([['grupo_id', $gmd->grupo_id], ['grado_id', $gmd->gradomateria->grado_id], ['unidad_id', $est->unidad_id], ['periodoacademico_id', $est->periodoacademico_id], ['jornada_id', $est->jornada_id], ['materia_id', $gmd->gradomateria->materia_id]])->get();
        if (count($asignados) > 0) {
            foreach ($asignados as $a) {
                $a->personalizado = Personalizarlogro::where([['estudiante_id', $est->id], ['asignarlogrogrupomateria_id', $a->id]])->first();
            }
            return view('documental.personalizarlogro.personalizar')
                ->with('location', 'documental')
                ->with('est', $est)
                ->with('gmd', $gmd)
                ->with('asignados', $asignados);
        } else {
            flash('El grupo del estudiante no tiene logros asignados')->error();
            return redirect()->route('logro.personalizar_inicio');
        }
    }

    //Guardar logro personalizado
    public function guardarlp(Request $request)
    {
        $lp = new Personalizarlogro($request->all());
        if ($lp->descripcion == null) {
            flash('Debe indicar el logro personalizado')->warning();
            return redirect()->route('logro.revisarlogros', [$request->gmd, $request->estudiante_id]);
        }
        if ($lp->save()) {
            flash('Logro personalizado con exito')->success();
            return redirect()->route('logro.revisarlogros', [$request->gmd, $request->estudiante_id]);
        } else {
            flash('El logro no pudo ser personalizado')->error();
            return redirect()->route('logro.revisarlogros', [$request->gmd, $request->estudiante_id]);
        }
    }

    //Retirar logro personalizado
    public function retirarlp($id, $est, $logro)
    {
        $lp = Personalizarlogro::find($logro);
        if ($lp->delete()) {
            flash('Logro personalizado retirado con exito')->success();
            return redirect()->route('logro.revisarlogros', [$id, $est]);
        } else {
            flash('El logro no pudo ser retirado')->error();
            return redirect()->route('logro.revisarlogros', [$id, $est]);
        }
    }
}
