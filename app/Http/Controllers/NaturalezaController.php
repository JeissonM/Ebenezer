<?php

namespace App\Http\Controllers;

use App\Naturaleza;
use Illuminate\Http\Request;
use App\Http\Requests\NaturalezaRequest;
use Illuminate\Support\Facades\Auth;
use App\Matriculaauditoria;
use App\Materia;
class NaturalezaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $naturalezas = Naturaleza::all();
        return view('matricula.datos_basicos.naturaleza.list')
                        ->with('location', 'matricula')
                        ->with('naturalezas', $naturalezas);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('matricula.datos_basicos.naturaleza.create')
                        ->with('location', 'matricula');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NaturalezaRequest $request)
    {
        $naturaleza = new Naturaleza($request->all());
        foreach ($naturaleza->attributesToArray() as $key => $value) {
            $naturaleza->$key = strtoupper($value);
        }
        $u = Auth::user();
        $naturaleza->user_change = $u->identificacion;
        $result = $naturaleza->save();
        if ($result) {
            $aud = new Matriculaauditoria();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "INSERTAR";
            $str = "CREACIÓN DE LA NATURALEZA, DATOS:  ";
            foreach ($naturaleza->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("La Naturaleza <strong>" . $naturaleza->nombre . "</strong> fue almacenada de forma exitosa!")->success();
            return redirect()->route('naturaleza.index');
        } else {
            flash("La Naturaleza <strong>" . $naturaleza->nombre . "</strong> no pudo ser almacenada. Error: " . $result)->error();
            return redirect()->route('naturaleza.index');
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Naturaleza  $naturaleza
     * @return \Illuminate\Http\Response
     */
    public function show(Naturaleza $naturaleza)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Naturaleza  $naturaleza
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $naturaleza=Naturaleza::find($id);
        return view('matricula.datos_basicos.naturaleza.edit')
                        ->with('location', 'matricula')
                
                        ->with('n',$naturaleza);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Naturaleza  $naturaleza
     * @return \Illuminate\Http\Response
     */
    public function update(NaturalezaRequest $request, Naturaleza $naturaleza)
    {
        $m = new Naturaleza($naturaleza->attributesToArray());
        foreach ($naturaleza->attributesToArray() as $key => $value) {
            if (isset($request->$key)) {
                $naturaleza->$key = strtoupper($request->$key);
            }
        }
        $u = Auth::user();
        $naturaleza->user_change = $u->identificacion;
        $result = $naturaleza->save();
        if ($result) {
            $aud = new Matriculaauditoria();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ACTUALIZAR DATOS";
            $str = "EDICION DE NATURALEZA. DATOS NUEVOS: ";
            $str2 = " DATOS ANTIGUOS: ";
            foreach ($m->attributesToArray() as $key => $value) {
                $str2 = $str2 . ", " . $key . ": " . $value;
            }
            foreach ($naturaleza->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str . " - " . $str2;
            $aud->save();
            flash("La Naturaleza <strong>" . $naturaleza->nombre . "</strong> fue modificada de forma exitosa!")->success();
            return redirect()->route('naturaleza.index');
        } else {
            flash("La Naturaleza <strong>" . $naturaleza->nombre . "</strong> no pudo ser modificada. Error: " . $result)->error();
            return redirect()->route('naturaleza.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Naturaleza  $naturaleza
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
//                if (count($tipodoc->paginas) > 0 || count($grupo->modulos) > 0 || count($grupo->users) > 0) {
//            flash("El Grupo de usuario <strong>" . $grupo->nombre . "</strong> no pudo ser eliminado porque tiene permisos o usuarios asociados.")->warning();
//            return redirect()->route('grupousuario.index');
//        } else {
        $naturaleza = Naturaleza::find($id);
        $result = $naturaleza->delete();
        if ($result) {
            $aud = new Matriculaauditoria();
            $u = Auth::user();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ELIMINAR";
            $str = "ELIMINACIÓN DE LA NATURALEZA. DATOS ELIMINADOS: ";
            foreach ($naturaleza->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("La Naturaleza <strong>" . $naturaleza->nombre . "</strong> fue eliminada de forma exitosa!")->success();
            return redirect()->route('naturaleza.index');
        } else {
            flash("La Naturaleza <strong>" . $naturaleza->nombre . "</strong> no pudo ser eliminada. Error: " . $result)->error();
            return redirect()->route('naturaleza.index');
        }
//        }
    }
   public function materias($id) {
        $naturaleza = Naturaleza::find($id);
        $naturalezas = $naturaleza->naturalezas;
        if (count($naturalezas) > 0) {
            $naturalezasf = null;
            foreach ($naturalezas as $value) {
                $obj["id"] = $value->id;
                $obj["value"] = $value->nombre;
                $naturalezasf[] = $obj;
            }
            return json_encode($naturalezasf);
        } else {
            return "null";
        }
    }
    
       
   }
