<?php

namespace App\Http\Controllers;

use App\Competencia;
use App\Http\Requests\CompetenciaRequest;
use Illuminate\Http\Request;

class CompetenciaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return CrudController::index('App\Competencia', 'documental.competencias.list', 'documental');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return CrudController::create('documental.competencias.create', 'documental', null);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CompetenciaRequest $request)
    {
        return CrudController::store($request, 'App\Competencia', 'competencia.index', ['competencia', 'descripcion'], 'App\Auditoriaacademico');
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
        return CrudController::edit($id, 'App\Competencia', 'documental.competencias.edit', 'documental', null);
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
        return CrudController::update($request, $id, 'App\Competencia', 'competencia.index', ['competencia', 'descripcion'], 'App\Auditoriaacademico');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return CrudController::destroy($id, 'App\Competencia', 'competencia.index', ['componentecompetencias'], 'App\Auditoriaacademico');
    }
}
