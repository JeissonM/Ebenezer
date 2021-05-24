<?php

namespace App\Http\Controllers;

use App\Gradomateria;
use App\Periodoacademico;
use App\Unidad;
use Illuminate\Http\Request;
use App\Docente;
use Illuminate\Support\Facades\Auth;
use App\Auditoriaacademico;
use App\Personanatural;
use App\Situacionadministrativa;
use Illuminate\Support\Facades\DB;

class DocenteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $docentes = Docente::all();
        $sit = Situacionadministrativa::all();
        $situaciones = null;
        if (count($sit) > 0) {
            foreach ($sit as $s) {
                $situaciones[$s->id] = $s->nombre . " - " . $s->descripcion;
            }
        }
        return view('academico.registro_academico.docentes.list')
            ->with('location', 'academico')
            ->with('docentes', $docentes)
            ->with('situaciones', $situaciones);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $sit = Situacionadministrativa::all();
        $situaciones = null;
        if (count($sit) > 0) {
            foreach ($sit as $s) {
                $situaciones[$s->id] = $s->nombre . " - " . $s->descripcion;
            }
        }
        return view('academico.registro_academico.docentes.create')
            ->with('location', 'academico')
            ->with('situaciones', $situaciones);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //
    }

    /*
     * consulta de personas
     */

    public function busqueda($tp, $clave, $valor) {
        switch ($tp) {
            case 'NATURAL':
                return $this->buscarNatural($clave, $valor);
                break;
            case 'JURIDICA':
                //return $this->buscarJuridica($clave, $valor);
                break;
            case 'ESTUDIANTE':
                //return $this->buscarEstudiante($clave, $valor);
                break;
        }
    }

    /*
     * busca persona natural
     */

    public function buscarNatural($clave, $valor) {
        switch ($clave) {
            case 'IDENTIFICACION':
                $personas = Personanatural::all();
                if (count($personas) > 0) {
                    $pens = null;
                    foreach ($personas as $pn) {
                        if (stripos($pn->persona->numero_documento, $valor) !== false) {
                            $n = null;
                            $n['tipo'] = "N";
                            $n['id'] = $pn->id;
                            $n['ident'] = $pn->persona->numero_documento;
                            $n['persona'] = $pn->primer_nombre . " " . $pn->segundo_nombre . " " . $pn->primer_apellido . " " . $pn->segundo_apellido;
                            $n['situacion'] = "";
                            $pens[] = $n;
                        }
                    }
                    if ($pens !== null) {
                        return json_encode($pens);
                    } else {
                        return "null";
                    }
                } else {
                    return "null";
                }
                break;
            case 'NOMBRES':
                $personas = Personanatural::all();
                if (count($personas) > 0) {
                    $pens = null;
                    foreach ($personas as $pn) {
                        $texto = $pn->primer_nombre . " " . $pn->segundo_nombre . " " . $pn->primer_apellido . " " . $pn->segundo_apellido;
                        if (stripos($texto, $valor) !== false) {
                            $n = null;
                            $n['tipo'] = "N";
                            $n['id'] = $pn->id;
                            $n['ident'] = $pn->persona->numero_documento;
                            $n['persona'] = $texto;
                            $n['situacion'] = "";
                            $pens[] = $n;
                        }
                    }
                    if ($pens !== null) {
                        return json_encode($pens);
                    } else {
                        return "null";
                    }
                } else {
                    return "null";
                }
                break;
            default:
                return "null";
                break;
        }
    }

    //almacenar
    public function docente($pn, $s) {
        $d = new Docente();
        $d->personanatural_id = $pn;
        $d->situacionadministrativa_id = $s;
        $u = Auth::user();
        $d->user_change = $u->identificacion;
        if ($d->save()) {
            $this->setAuditoria('INSERTAR', 'CREAR DOCENTE. DATOS NUEVOS: ', $d);
            flash('La persona fue asignada como docente')->success();
            return redirect()->route('docente.index');
        } else {
            flash('La persona no pudo ser asignada como docente')->error();
            return redirect()->route('docente.index');
        }
    }

    //auditoria
    public function setAuditoria($operacion, $title, $obj) {
        $u = Auth::user();
        $aud = new Auditoriaacademico();
        $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
        $aud->operacion = $operacion;
        $str = $title;
        foreach ($obj->attributesToArray() as $key => $value) {
            $str = $str . ", " . $key . ": " . $value;
        }
        $aud->detalles = $str;
        $aud->save();
    }

    //cambiar situacion
    public function cambiarSituacion($d, $s) {
        $doc = Docente::find($d);
        $doc->situacionadministrativa_id = $s;
        $u = Auth::user();
        $doc->user_change = $u->identificacion;
        if ($doc->save()) {
            $this->setAuditoria('ACTUALIZAR', 'CTUALOZAR SITUACIÓN DOCENTE. DATOS NUEVOS: ', $doc);
            flash('La situación fue cambiada con exito')->success();
            return redirect()->route('docente.index');
        } else {
            flash('La situación no pudo ser cambiada')->error();
            return redirect()->route('docente.index');
        }
    }

    //reporte listado general de docentes

    /**
     * @param $unidad
     * @param $periodo
     *
     */
    public function listadoGeneralDocente() {
        $docentes = Docente::all();
        if (count($docentes) <= 0) {
            flash('No se encontraron docentes')->warning();
            return redirect()->back();
        }
        $response = [];
        foreach ($docentes as $doc) {
            $persona = $this->llenarDocente($doc->id);
            $response[] = $persona;
        }
        if (count($response) <= 0) {
            flash('No se encontraron docentes')->warning();
            return redirect()->back();
        }

        $encabezado = null;
        $cabeceras = ['Identificación', 'Nombre', 'Edad', 'Situación Administrativa'];
        $filtros = [];
        $titulo = "REPORTES DE DOCENTES - LISTADO DE GENERAL DE DOCENTES";
        $nombre = "Docentes_general.pdf";
        $array = ReportesController::orderMultiDimensionalArray($response, 'nombre', false);
        return ReportesController::imprimirPdf($array, $cabeceras, $filtros, $titulo, $nombre);
    }

    /**
     * @param $unidad
     * @param $periodo
     * SELECT DISTINCT grupomateriadocentes.docente_id FROM `grupos`
     * INNER JOIN grupomateriadocentes ON grupomateriadocentes.grupo_id = grupos.id
     * WHERE grupos.unidad_id = 1 AND grupos.periodoacademico_id = 3
     *
     *  SELECT gradomaterias.id AS 'gradomateria-id', materias.codigomateria, materias.nombre,
     * (SELECT areas.nombre FROM `areas` WHERE areas.id = materias.area_id) as 'areanombre',
     * (SELECT grados.etiqueta FROM grados WHERE grados.id = gradomaterias.grado_id) AS 'grado',
     * (SELECT grupos.nombre FROM grupos WHERE grupos.id = grupomateriadocentes.grupo_id) AS 'grupo',
     * grupomateriadocentes.docente_id, grupomateriadocentes.grupo_id, grupomateriadocentes.id AS 'grupomatdoc-id',
     * CONCAT(personanaturals.primer_nombre,' ',personanaturals.segundo_nombre,' ',personanaturals.primer_apellido,' ',personanaturals.segundo_apellido) AS 'docente'
     * FROM `materias`
     * INNER JOIN gradomaterias ON gradomaterias.materia_id = materias.id
     * INNER JOIN grupomateriadocentes ON grupomateriadocentes.gradomateria_id = gradomaterias.id
     * INNER JOIN docentes ON docentes.id = grupomateriadocentes.docente_id
     * INNER JOIN personanaturals ON personanaturals.id = docentes.personanatural_id
     * WHERE gradomaterias.unidad_id = 1 AND gradomaterias.periodoacademico_id = 3 AND grupomateriadocentes.docente_id IS NOT NULL
     */
    public function cargaDocente($unidad, $periodo) {
        $query = DB::table('materias')
            ->join('gradomaterias', 'gradomaterias.materia_id', '=', 'materias.id')
            ->join('grupomateriadocentes', 'grupomateriadocentes.gradomateria_id', '=', 'gradomaterias.id')
            ->join('docentes', 'docentes.id', '=', 'grupomateriadocentes.docente_id')
            ->join('personanaturals', 'personanaturals.id', '=', 'docentes.personanatural_id')
            ->select('materias.codigomateria as codigo', 'materias.nombre as materia',
                DB::raw("(SELECT areas.nombre FROM areas WHERE areas.id = materias.area_id) as area"),
                DB::raw("(SELECT grados.etiqueta FROM grados WHERE grados.id = gradomaterias.grado_id) as grado"),
                DB::raw("(SELECT grupos.nombre FROM grupos WHERE grupos.id = grupomateriadocentes.grupo_id) as grupo"),
                DB::raw("CONCAT(personanaturals.primer_nombre,' ',personanaturals.segundo_nombre,' ',personanaturals.primer_apellido,' ',personanaturals.segundo_apellido) as docente"))
                    ->whereNotNull('grupomateriadocentes.docente_id')->get();

        if ($unidad == 0 && $periodo != 0) {
            $query = DB::table('materias')
                ->join('gradomaterias', 'gradomaterias.materia_id', '=', 'materias.id')
                ->join('grupomateriadocentes', 'grupomateriadocentes.gradomateria_id', '=', 'gradomaterias.id')
                ->join('docentes', 'docentes.id', '=', 'grupomateriadocentes.docente_id')
                ->join('personanaturals', 'personanaturals.id', '=', 'docentes.personanatural_id')
                ->select('materias.codigomateria as codigo', 'materias.nombre as materia',
                    DB::raw("(SELECT areas.nombre FROM areas WHERE areas.id = materias.area_id) as area"),
                    DB::raw("(SELECT grados.etiqueta FROM grados WHERE grados.id = gradomaterias.grado_id) as grado"),
                    DB::raw("(SELECT grupos.nombre FROM grupos WHERE grupos.id = grupomateriadocentes.grupo_id) as grupo"),
                    DB::raw("CONCAT(personanaturals.primer_nombre,' ',personanaturals.segundo_nombre,' ',personanaturals.primer_apellido,' ',personanaturals.segundo_apellido) as docente"))
                        ->where('gradomaterias.periodoacademico_id', $periodo)
                        ->whereNotNull('grupomateriadocentes.docente_id')->get();
        }
        if ($periodo == 0 && $unidad != 0) {
            $query = DB::table('materias')
                ->join('gradomaterias', 'gradomaterias.materia_id', '=', 'materias.id')
                ->join('grupomateriadocentes', 'grupomateriadocentes.gradomateria_id', '=', 'gradomaterias.id')
                ->join('docentes', 'docentes.id', '=', 'grupomateriadocentes.docente_id')
                ->join('personanaturals', 'personanaturals.id', '=', 'docentes.personanatural_id')
                ->select('materias.codigomateria as codigo', 'materias.nombre as materia',
                    DB::raw("(SELECT areas.nombre FROM areas WHERE areas.id = materias.area_id) as area"),
                    DB::raw("(SELECT grados.etiqueta FROM grados WHERE grados.id = gradomaterias.grado_id) as grado"),
                    DB::raw("(SELECT grupos.nombre FROM grupos WHERE grupos.id = grupomateriadocentes.grupo_id) as grupo"),
                    DB::raw("CONCAT(personanaturals.primer_nombre,' ',personanaturals.segundo_nombre,' ',personanaturals.primer_apellido,' ',personanaturals.segundo_apellido) as docente"))
                        ->where('gradomaterias.unidad_id', $unidad)
                        ->whereNotNull('grupomateriadocentes.docente_id')->get();
        }

        if ($unidad != 0 && $periodo != 0) {
            $query = DB::table('materias')
                ->join('gradomaterias', 'gradomaterias.materia_id', '=', 'materias.id')
                ->join('grupomateriadocentes', 'grupomateriadocentes.gradomateria_id', '=', 'gradomaterias.id')
                ->join('docentes', 'docentes.id', '=', 'grupomateriadocentes.docente_id')
                ->join('personanaturals', 'personanaturals.id', '=', 'docentes.personanatural_id')
                ->select('materias.codigomateria as codigo', 'materias.nombre as materia',
                    DB::raw("(SELECT areas.nombre FROM areas WHERE areas.id = materias.area_id) as area"),
                    DB::raw("(SELECT grados.etiqueta FROM grados WHERE grados.id = gradomaterias.grado_id) as grado"),
                    DB::raw("(SELECT grupos.nombre FROM grupos WHERE grupos.id = grupomateriadocentes.grupo_id) as grupo"),
                    DB::raw("CONCAT(personanaturals.primer_nombre,' ',personanaturals.segundo_nombre,' ',personanaturals.primer_apellido,' ',personanaturals.segundo_apellido) as docente"))
                ->where([['gradomaterias.unidad_id', $unidad], ['gradomaterias.periodoacademico_id', $periodo]])
                ->whereNotNull('grupomateriadocentes.docente_id')->get();
        }
        if (count($query) <= 0){
            flash('No hay carga académica para los parametros seleccionados.')->warning();
            return redirect()->back();
        }

        $data = $query->groupBy('docente');
        $unidad = $unidad != 0 ? Unidad::findOrFail($unidad)->nombre : 'TODO';
        $periodo = $periodo != 0 ? Periodoacademico::findOrFail($periodo)->etiqueta : 'TODO';
        $encabezado = null;
        $cabeceras = ['Codigo', 'Materia', 'Área', 'Grado', 'Grupo', 'Docente'];
        $filtros = ['UNIDAD' => $unidad, 'PERÍODO ACADÉMICO' => $periodo];
        $titulo = "REPORTES DE DOCENTES - CARGA ACADÉMICA DE DOCENTES";
        $nombre = "Carga_académica_docente.pdf";
        return ReportesController::imprimirPdf($data, $cabeceras, $filtros, $titulo, $nombre, 2);
    }

    public function llenarDocente($doc, $obj = false) {
        if (!$obj)
            $doc = Docente::findOrFail($doc);
        $data['identificacion'] = $doc->personanatural->persona->tipodoc->abreviatura . '-' . $doc->personanatural->persona->numero_documento;
        $data['nombre'] = $doc->personanatural->primer_nombre . " " . $doc->personanatural->segundo_nombre . " " . $doc->personanatural->primer_apellido . " " . $doc->personanatural->segundo_apellido;
        $data['edad'] = $doc->personanatural->edad;
        $data['situacion'] = $doc->situacionadministrativa->nombre;
        return $data;
    }
}
