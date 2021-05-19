<?php

namespace App\Http\Controllers;

use App\Convocatoria;
use App\Periodounidad;
use App\Auditoriaadmision;
use App\Grado;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ConvocatoriaController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $perund = Periodounidad::all();
        return view('admisiones.calendario_procesos_convocatoria.convocatoria.list')
                        ->with('location', 'admisiones')
                        ->with('perund', $perund);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $result = json_decode($request->pu);
        $array = null;
        $u = Auth::user();
        foreach ($request->grados as $g) {
            $existe = Convocatoria::where('grado_id', $g)->get();
            if (count($existe) > 0) {
                
            }
            $conv = new Convocatoria();
            $conv->unidad_id = $result->unidad_id;
            $conv->periodoacademico_id = $result->periodoacademico_id;
            $conv->jornada_id = $result->jornada_id;
            $conv->cupo = $request->cupo;
            $conv->estado = $request->estado;
            $conv->grado_id = $g;
            $conv->user_change = $u->identificacion;
            $array[] = $conv;
        }
        if ($array !== null) {
            $response = "<h4>Detalles del proceso</h4>";
            foreach ($array as $r) {
                $existe = Convocatoria::where([['grado_id', $r->grado_id], ['unidad_id', $r->unidad_id], ['periodoacademico_id', $r->periodoacademico_id], ['jornada_id', $r->jornada_id]])->get();
                if (count($existe) <= 0) {
                    if ($r->save()) {
                        $aud = new Auditoriaadmision();
                        $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
                        $aud->operacion = "INSERTAR";
                        $str = "CREACIÓN DE CONVOCATORIA. DATOS: ";
                        foreach ($r->attributesToArray() as $key => $value) {
                            $str = $str . ", " . $key . ": " . $value;
                        }
                        $aud->detalles = $str;
                        $aud->save();
                        $response = $response . "<p>[OK] La convocatoria para el grado " . $r->grado->etiqueta . " - " . $r->grado->descripcion . " se guardo con exito!.</p>";
                    } else {
                        $response = $response . "<p>[x] La convocatoria para el grado " . $r->grado->etiqueta . " - " . $r->grado->descripcion . " no pudo ser almacenda!.</p>";
                    }
                } else {
                    $response = $response . "<p>[x] La convocatoria para el grado " . $r->grado->etiqueta . " - " . $r->grado->descripcion . " ya tiene convocatoria creada!.</p>";
                }
            }
            flash($response)->success();
            return redirect()->route('convocatoria.show', $result->id);
        } else {
            flash('No hay convocatorias para guardar')->warning();
            return redirect()->route('convocatoria.show', $result->id);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Convocatoria  $convocatoria
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $perund = Periodounidad::find($id);
        $grado = Grado::all();
        $grados = null;
        if (count($grado) > 0) {
            foreach ($grado as $g) {
                $grados[$g->id] = $g->etiqueta . " - " . $g->descripcion;
            }
        }
        $conv = Convocatoria::where([['periodoacademico_id', $perund->periodoacademico_id], ['jornada_id', $perund->jornada_id], ['unidad_id', $perund->unidad_id]])->get();
        return view('admisiones.calendario_procesos_convocatoria.convocatoria.create')
                        ->with('location', 'admisiones')
                        ->with('conv', $conv)
                        ->with('grados', $grados)
                        ->with('perund', $perund);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Convocatoria  $convocatoria
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $convocatoria = Convocatoria::find($id);
        return view('admisiones.calendario_procesos_convocatoria.convocatoria.edit')
                        ->with('location', 'admisiones')
                        ->with('convocatoria', $convocatoria);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Convocatoria  $convocatoria
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $conv = Convocatoria::find($id);
        $m = new Convocatoria($conv->attributesToArray());
        foreach ($conv->attributesToArray() as $key => $value) {
            if (isset($request->$key)) {
                $conv->$key = strtoupper($request->$key);
            }
        }
        $u = Auth::user();
        $conv->user_change = $u->identificacion;
        $result = $conv->save();
        if ($result) {
            $aud = new Auditoriaadmision();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ACTUALIZAR DATOS";
            $str = "EDICION DE CONVOCATORIA. DATOS NUEVOS: ";
            $str2 = " DATOS ANTIGUOS: ";
            foreach ($m->attributesToArray() as $key => $value) {
                $str2 = $str2 . ", " . $key . ": " . $value;
            }
            foreach ($conv->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str . " - " . $str2;
            $aud->save();
            flash("La convocatoria <strong>" . $conv->grado->etiqueta . " - " . $conv->grado->descripcion . "</strong> fue modificada de forma exitosa!")->success();
            return redirect()->route('convocatoria.index');
        } else {
            flash("La convocatoria <strong>" . $conv->grado->etiqueta . " - " . $conv->grado->descripcion . "</strong> no pudo ser modificada. Error: " . $result)->error();
            return redirect()->route('convocatoria.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Convocatoria  $convocatoria
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        // if (count($unidad->paginas) > 0 || count($grupo->modulos) > 0 || count($grupo->users) > 0) {
//            flash("El Grupo de usuario <strong>" . $grupo->nombre . "</strong> no pudo ser eliminado porque tiene permisos o usuarios asociados.")->warning();
//            return redirect()->route('grupousuario.index');
//        } else {
        $conv = Convocatoria::find($id);
        $result = $conv->delete();
        if ($result) {
            $aud = new Auditoriaadmision();
            $u = Auth::user();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ELIMINAR";
            $str = "ELIMINACIÓN DE CONVOCATORIA. DATOS ELIMINADOS: ";
            foreach ($conv->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("La convocatoria fue eliminada de forma exitosa!")->success();
            return redirect()->route('convocatoria.index');
        } else {
            flash("La convocatoria no pudo ser eliminada. Error: " . $result)->error();
            return redirect()->route('convocatoria.index');
        }
//        }
    }

}
