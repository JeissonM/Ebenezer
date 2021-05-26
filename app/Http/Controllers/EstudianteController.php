<?php

namespace App\Http\Controllers;

use App\Categoria;
use App\Estudiante;
use App\Periodoacademico;
use App\Persona;
use App\Situacionestudiante;
use App\Unidad;
use Illuminate\Http\Request;

class EstudianteController extends Controller
{
    public function getEStudiante($id) {
        $persona = Persona::where('numero_documento', $id)->first();
        $response = null;
        $response["error"] = "SI";
        $p1 = $p2 = null;
        if ($persona != null) {
            $pn = $persona->personanatural;
            if ($pn != null) {
                $est = $pn->estudiante;
                if ($est != null) {
                    $o['id'] = $est->id;
                    $o["identificacion"] = $id;
                    $o["nombres"] = $pn->primer_nombre . " " . $pn->segundo_nombre;
                    $o["apellidos"] = $pn->primer_apellido . " " . $pn->segundo_apellido;
                    $o["mail"] = $persona->mail;
                    $p1[] = $o;
                    $p2[$est->id] = $pn->primer_nombre . " " . $pn->segundo_nombre . " " . $pn->primer_apellido . " " . $pn->segundo_apellido . " - FECHA REGISTRO:" . $pn->created_at;
                }
                if ($p1 != null) {
                    $response["error"] = "NO";
                    $response["data1"] = $p1;
                    $response["data2"] = $p2;
                } else {
                    $response["msg"] = "La persona con Identificación " . $id . " no es un estudiante.";
                }
            } else {
                $response["msg"] = "La persona con Identificación " . $id . " no es una persona natural.";
            }
        } else {
            $response["msg"] = "Ninguna coincidencia encontrada para Identificación: " . $id;
        }
        return json_encode($response);
    }


    public function listadoEstudiante($unidad, $periodo, $situacion, $categoria, $exportar) {
        $estudiantes = Estudiante::where([['unidad_id', $unidad], ['periodoacademico_id', $periodo]])->get();
        if ($situacion == 0 && $categoria != 0)
            $estudiantes = Estudiante::where([['unidad_id', $unidad], ['periodoacademico_id', $periodo], ['categoria_id', $categoria]])->get();

        if ($categoria == 0 && $situacion != 0)
            $estudiantes = Estudiante::where([['unidad_id', $unidad], ['periodoacademico_id', $periodo], ['situacionestudiante_id', $situacion]])->get();

        if ($situacion != 0 && $categoria != 0)
            $estudiantes = Estudiante::where([['unidad_id', $unidad], ['periodoacademico_id', $periodo], ['situacionestudiante_id', $situacion], ['categoria_id', $categoria]])->get();

        if (count($estudiantes) <= 0) {
            flash('No hay carga académica para los parametros seleccionados.')->warning();
            return redirect()->back();
        }

        $response = [];
        foreach ($estudiantes as $estudiante) {
            $persona = $this->llenarEstudiante($estudiante);
            $response[] = $persona;
        }
        if (count($response) <= 0) {
            flash('No hay estudiantes para los parametros seleccionados.')->warning();
            return redirect()->back();
        }

        $unidad = Unidad::findOrFail($unidad)->nombre;
        $periodo = Periodoacademico::findOrFail($periodo)->etiqueta;
        $situacion = $situacion != 0 ? Situacionestudiante::findOrFail($situacion)->nombre : 'TODO';
        $categoria = $categoria != 0 ? Categoria::findOrFail($categoria)->nombre : 'TODO';
        $filtros = ['UNIDAD' => $unidad, 'PERÍODO ACADÉMICO' => $periodo, 'SITUACIÓN' => $situacion, 'CATEGORÍA' => $categoria];
        $titulo = "REPORTES DE ESTUDIANTES - LISTADO GENERAL DE ESTUDIANTES";
        $data = ReportesController::orderMultiDimensionalArray($response, 'nombre');
        $cabeceras = ['Identificación', 'Nombre', 'Grado', 'Situación', 'Categoría'];
        if ($exportar == 'pdf') {
            $nombre = "Listao_general_estudiante.pdf";
            return ReportesController::imprimirPdf($data, $cabeceras, $filtros, $titulo, $nombre);
        } else {
            $filtros = ['FILTROS', 'UNIDAD: ' . $unidad, 'PERÍDO ACADÉMICO: ' . $periodo, 'SITUACIÓN: ' . $situacion, 'CATEGORÍA: ' . $categoria];
//            $aux = json_decode(json_encode($query), true);
            $nombre = "Listado_general_estudiantes.xlsx";
            return ReportesController::exportarExcel($data, $cabeceras, $filtros, $titulo, $nombre);
        }
    }

    /**
     * @param $unidad
     * @param $periodo
     * @param $estado
     * @param $exportar
     * devuelve el listado de estudiantes por un estado
     */
    public function estudiantesMatriculados($unidad, $periodo, $estado, $exportar) {
        if ($estado == 'MATRICULADO') {
            $estudiante = Estudiante::where([['unidad_id', $unidad], ['periodoacademico_id', $periodo], ['estado', $estado], ['pago', 'PAGADO']])->get();
        } else {
            $estudiante = Estudiante::where([['unidad_id', $unidad], ['periodoacademico_id', $periodo], ['estado', $estado]])->get();
        }
        if (count($estudiante) <= 0) {
            flash('No hay resultados para los parametros seleccionados.')->warning();
            return redirect()->back();
        }
        $response = [];
        foreach ($estudiante as $item) {
            $persona = $this->llenarEstudiante($item);
            $persona['estado'] = $item->estado;
            $persona['pago'] = $item->pago;
            $response[] = $persona;
        }
        if (count($response) <= 0) {
            flash('No hay estudiantes para los parametros seleccionados.')->warning();
            return redirect()->back();
        }
        $unidad = Unidad::findOrFail($unidad)->nombre;
        $periodo = Periodoacademico::findOrFail($periodo)->etiqueta;
        $filtros = ['UNIDAD' => $unidad, 'PERÍODO ACADÉMICO' => $periodo, 'ESTADO' => $estado];
        $titulo = "REPORTES DE ESTUDIANTES - LISTADO DE ESTUDIANTES " . $estado;
        $data = ReportesController::orderMultiDimensionalArray($response, 'nombre');
        $cabeceras = ['Identificación', 'Nombre', 'Grado', 'Situación', 'Categoría', 'Estado', 'Pago'];
        $encabezado = ['TOTAL ESTUDIANTES' => count($response)];
        if ($exportar == 'pdf') {
            $nombre = "Listao_estudiante_estado.pdf";
            return ReportesController::imprimirPdf($data, $cabeceras, $filtros, $titulo, $nombre, 1, $encabezado);
        } else {
            $filtros = ['FILTROS', 'UNIDAD: ' . $unidad, 'PERÍDO ACADÉMICO: ' . $periodo, 'ESTADO: ' . $estado];
            $encabezado = ['TOTAL ESTUDIANTES: ' . count($response)];
//            $aux = json_decode(json_encode($query), true);
            $nombre = "Listado_estudiantes_estado.xlsx";
            return ReportesController::exportarExcel($data, $cabeceras, $filtros, $titulo, $nombre, $encabezado);
        }
    }

    private function llenarEstudiante($estudiante) {
        $pn = $estudiante->personanatural;
        $per['identificacion'] = $pn->persona->tipodoc->abreviatura . '-' . $pn->persona->numero_documento;
        $per['nombre'] = $pn->primer_nombre . " " . $pn->segundo_nombre . " " . $pn->primer_apellido . " " . $pn->segundo_apellido;
        $per['grado'] = $estudiante->grado->etiqueta;
        $per['situacion'] = $estudiante->situacionestudiante->nombre;
        $per['categoria'] = $estudiante->categoria->nombre;
        return $per;
    }
}
