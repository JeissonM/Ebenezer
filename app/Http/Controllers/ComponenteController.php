<?php

namespace App\Http\Controllers;

use App\Competencia;
use App\Componentecompetencia;
use App\Http\Requests\ComponenteRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ComponenteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return CrudController::index('App\Componente', 'documental.componentes.list', 'documental');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return CrudController::create('documental.componentes.create', 'documental', ['App\Area' => ['valor' => 'nombre', 'clave' => 'id']]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ComponenteRequest $request)
    {
        return CrudController::store($request, 'App\Componente', 'componente.index', ['componente', 'descripcion'], 'App\Auditoriaacademico');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return CrudController::edit($id, 'App\Componente', 'documental.componentes.edit', 'documental', ['App\Area' => ['valor' => 'nombre', 'clave' => 'id']]);
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
        return CrudController::update($request, $id, 'App\Componente', 'componente.index', ['componente', 'descripcion'], 'App\Auditoriaacademico');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return CrudController::destroy($id, 'App\Componente', 'componente.index', ['componentecompetencias'], 'App\Auditoriaacademico');
    }

    /**
     * gestiona las competencias sobre los componentes
     */
    public function competencias()
    {
        $data = app('App\Componente')->all();
        $competencias = Competencia::all();
        return view('documental.componentes.competencias')
            ->with('location', 'documental')
            ->with('data', $data)
            ->with('competencias', $competencias);
    }

    /**
     * asigna una competencia a un componente
     */
    public function addcompetencias($componente_id, $competencia_id)
    {
        $modelo = new Componentecompetencia();
        $modelo->componente_id = $componente_id;
        $modelo->competencia_id = $competencia_id;
        if ($modelo->save()) {
            $u = Auth::user();
            $a['usuario'] = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $a['operacion'] = "INSERTAR";
            $str = "CREACIÓN DE ASIGNAR COMPETENCIA A COMPONENTE. DATOS: ";
            foreach ($modelo->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $a['detalles'] = $str;
            app('App\Auditoriaacademico')->create($a);
            flash("El registro fue almacenado de forma exitosa!")->success();
            return redirect()->route('componente.competencias');
        } else {
            flash("Error al guardar el registro")->error();
            return redirect()->route('componente.competencias');
        }
    }

    /**
     * elimina una competencia de un componente
     */
    public function deletecompetencias($id)
    {
        $modelo = Componentecompetencia::find($id);
        if ($modelo->delete()) {
            $u = Auth::user();
            $a['usuario'] = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $a['operacion'] = "ELIMINAR";
            $str = "ELIMINACIÓN DE COMPETENCIA DE UN COMPONENTE. DATOS: ";
            foreach ($modelo->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $a['detalles'] = $str;
            app('App\Auditoriaacademico')->create($a);
            flash("El registro fue eliminado de forma exitosa!")->success();
            return redirect()->route('componente.competencias');
        } else {
            flash("Error al eliminar el registro")->error();
            return redirect()->route('componente.competencias');
        }
    }
}
