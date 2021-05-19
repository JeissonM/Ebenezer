<?php

namespace App\Http\Controllers;

use App\Materia;
use Illuminate\Http\Request;
use App\Http\Requests\MateriaRequest;
use Illuminate\Support\Facades\Auth;
use App\Matriculaauditoria;
use App\Area;
use App\Naturaleza;

class MateriaController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $materias = Materia::all();
        return view('matricula.datos_basicos.materia.list')
            ->with('location', 'matricula')
            ->with('materias', $materias);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $naturalezas = Naturaleza::all()->pluck('nombre', 'id');
        $areas = Area::all()->pluck('nombre', 'id');
        return view('matricula.datos_basicos.materia.create')
            ->with('location', 'matricula')
            ->with('naturalezas', $naturalezas)
            ->with('areas', $areas);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MateriaRequest $request)
    {
        $materia = new Materia($request->all());
        foreach ($materia->attributesToArray() as $key => $value) {
            if ($key == 'naturaleza_id') {
                if ($value != '0') {
                    $materia->$key = $value;
                } else {
                    $materia->$key = null;
                }
            } else {
                $materia->$key = strtoupper($value);
            }
        }
        $u = Auth::user();
        $materia->user_change = $u->identificacion;
        $result = $materia->save();
        if ($result) {
            $aud = new Matriculaauditoria();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "INSERTAR";
            $str = "CREACIÓN DE LA MATERIA, DATOS:  ";
            foreach ($materia->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("La Materia <strong>" . $materia->nombre . "</strong> fue almacenada de forma exitosa!")->success();
            return redirect()->route('materia.index');
        } else {
            flash("La Materia <strong>" . $materia->nombre . "</strong> no pudo ser almacenada. Error: " . $result)->error();
            return redirect()->route('materia.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Materia  $materia
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $naturalezas = Naturaleza::all()->pluck('nombre', 'id');
        $areas = Area::all()->pluck('nombre', 'id');
        $materia = Materia::find($id);
        return view('matricula.datos_basicos.materia.show')
            ->with('location', 'matricula')
            ->with('materia', $materia)
            ->with('naturalezas', $naturalezas)
            ->with('areas', $areas);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Materia  $materia
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $naturalezas = Naturaleza::all()->pluck('nombre', 'id');
        $areas = Area::all()->pluck('nombre', 'id');
        $materia = Materia::find($id);
        return view('matricula.datos_basicos.materia.edit')
            ->with('location', 'matricula')
            ->with('materia', $materia)
            ->with('naturalezas', $naturalezas)
            ->with('areas', $areas);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Materia  $materia
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $materia = Materia::find($id);
        $m = new Materia($materia->attributesToArray());
        foreach ($materia->attributesToArray() as $key => $value) {
            if (isset($request->$key)) {
                if ($key == 'naturaleza_id') {
                    if ($request->$key != '0') {
                        $materia->$key = $request->$key;
                    } else {
                        $materia->$key = null;
                    }
                } else {
                    $materia->$key = strtoupper($request->$key);
                }
            }
        }
        $u = Auth::user();
        $materia->user_change = $u->identificacion;
        $result = $materia->save();
        if ($result) {
            $aud = new Matriculaauditoria();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ACTUALIZAR DATOS";
            $str = "EDICION DE LA MATERIA. DATOS NUEVOS: ";
            $str2 = " DATOS ANTIGUOS: ";
            foreach ($m->attributesToArray() as $key => $value) {
                $str2 = $str2 . ", " . $key . ": " . $value;
            }
            foreach ($materia->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str . " - " . $str2;
            $aud->save();
            flash("La Materia <strong>" . $materia->nombre . "</strong> fue modificada de forma exitosa!")->success();
            return redirect()->route('materia.index');
        } else {
            flash("La Materia <strong>" . $materia->nombre . "</strong> no pudo ser modificada. Error: " . $result)->error();
            return redirect()->route('materia.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Materia  $materia
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // if (count($tipodoc->paginas) > 0 || count($grupo->modulos) > 0 || count($grupo->users) > 0) {
        //            flash("El Grupo de usuario <strong>" . $grupo->nombre . "</strong> no pudo ser eliminado porque tiene permisos o usuarios asociados.")->warning();
        //            return redirect()->route('grupousuario.index');
        //        } else {
        $materia = Materia::find($id);
        $result = $materia->delete();
        if ($result) {
            $aud = new Matriculaauditoria();
            $u = Auth::user();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ELIMINAR";
            $str = "ELIMINACIÓN DE LA MATERIA. DATOS ELIMINADOS: ";
            foreach ($materia->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("La Materia <strong>" . $materia->nombre . "</strong> fue eliminada de forma exitosa!")->success();
            return redirect()->route('materia.index');
        } else {
            flash("La Materia <strong>" . $materia->nombre . "</strong> no pudo ser eliminada. Error: " . $result)->error();
            return redirect()->route('materia.index');
        }
        //        }
    }

    /**
     * Retorna el nombre de naturaleza
     *
     * @param  \App\Materia  $id
     * @return naturaleza -> nombre
     */
    /*   public function naturaleza($id) {
      $naturaleza = Naturaleza::find($id);

      $materias = $naturaleza->naturalezas;
      if (count($materias) > 0) {
      foreach ($naturaleza as $value) {
      if ($id == $value->id)
      return $value->nombre;
      }
      } else {
      return "null";
      }
      } */

    /**
     * Retorna el nombre del area
     *
     * @param  \App\Materia  $id
     * @return area->nombre
     */
    //    public function area($id) {
    //        $area = Area::find($id);
    //
    //        $materias = $area->areas;
    //        if (count($materias) > 0) {
    //            foreach ($area as $value) {
    //                if ($id == $value->id)
    //                    return $value->nombre;
    //            }
    //        } else {
    //            return "null";
    //        }
    //    }
    //
    //    public function naturalezas() {
    ////        $naturaleza = Naturaleza::find($id);
    //        $nat = $naturaleza->naturalezas;
    //        if (count($nat) > 0) {
    //            $naturalezas = null;
    //            foreach ($nat as $value) {
    //                $obj["id"] = $value->id;
    //                $obj["value"] = $value->nombre;
    //                $naturalezas[] = $obj;
    //            }
    //            return json_encode($naturalezas);
    //        } else {
    //            return "null";
    //        }
    //    }
}
