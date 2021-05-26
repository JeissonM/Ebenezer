<?php

namespace App\Http\Controllers;

use App\Categoria;
use App\Export\ExportData;
use App\Jornada;
use App\Periodoacademico;
use App\Situacionestudiante;
use App\Unidad;
use Maatwebsite\Excel\Facades\Excel;
use niklasravnsborg\LaravelPdf\Facades\Pdf;
use Illuminate\Http\Request;

class ReportesController extends Controller
{
    public function ViewCargaDocente() {
        $periodos = $unidades = null;
        $perds = Periodoacademico::all()->sortByDesc('anio');
        if (count($perds) > 0) {
            foreach ($perds as $p) {
                $periodos[$p->id] = $p->etiqueta . " - " . $p->anio;
            }
        } else {
            flash("No hay períodos académicos")->error();
            return redirect()->route('menu.reportes');
        }
        $unds = Unidad::all();
        if (count($unds) > 0) {
            foreach ($unds as $u) {
                $unidades[$u->id] = $u->nombre . " - " . $u->descripcion . " - " . $u->ciudad->nombre;
            }
        } else {
            flash("No hay unidades o sedes definidas")->error();
            return redirect()->route('menu.reportes');
        }
        return view('reportes.carga_docente')
            ->with('location', 'reportes')
            ->with('unidades', $unidades)
            ->with('periodos', $periodos);
    }

    public function viewListadoEstudiante() {
        $periodos = $unidades = null;
        $perds = Periodoacademico::all()->sortByDesc('anio');
        if (count($perds) > 0) {
            foreach ($perds as $p) {
                $periodos[$p->id] = $p->etiqueta . " - " . $p->anio;
            }
        } else {
            flash("No hay períodos académicos")->error();
            return redirect()->route('menu.reportes');
        }
        $unds = Unidad::all();
        if (count($unds) > 0) {
            foreach ($unds as $u) {
                $unidades[$u->id] = $u->nombre . " - " . $u->descripcion . " - " . $u->ciudad->nombre;
            }
        } else {
            flash("No hay unidades o sedes definidas")->error();
            return redirect()->route('menu.reportes');
        }
        $situacines = Situacionestudiante::all()->pluck('nombre', 'id');
        $categorias = Categoria::all()->pluck('nombre', 'id');
        return view('reportes.listado_general_estudiante')
            ->with('location', 'reportes')
            ->with('unidades', $unidades)
            ->with('periodos', $periodos)
            ->with('situaciones', $situacines)
            ->with('categorias', $categorias);
    }

    public function viewEstudiantesInscritos() {
        $periodos = $unidades = null;
        $perds = Periodoacademico::all()->sortByDesc('anio');
        if (count($perds) > 0) {
            foreach ($perds as $p) {
                $periodos[$p->id] = $p->etiqueta . " - " . $p->anio;
            }
        } else {
            flash("No hay períodos académicos")->error();
            return redirect()->route('menu.reportes');
        }
        $unds = Unidad::all();
        if (count($unds) > 0) {
            foreach ($unds as $u) {
                $unidades[$u->id] = $u->nombre . " - " . $u->descripcion . " - " . $u->ciudad->nombre;
            }
        } else {
            flash("No hay unidades o sedes definidas")->error();
            return redirect()->route('menu.reportes');
        }
        return view('reportes.estudiantes_inscritos')
            ->with('location', 'reportes')
            ->with('unidades', $unidades)
            ->with('periodos', $periodos);
    }

    public function viewHorarioGrupo() {
        $periodos = $unidades = $jornadas = null;
        $perds = Periodoacademico::all()->sortByDesc('anio');
        if (count($perds) > 0) {
            foreach ($perds as $p) {
                $periodos[$p->id] = $p->etiqueta . " - " . $p->anio;
            }
        } else {
            flash("No hay períodos académicos")->error();
            return redirect()->route('menu.reportes');
        }
        $unds = Unidad::all();
        if (count($unds) > 0) {
            foreach ($unds as $u) {
                $unidades[$u->id] = $u->nombre . " - " . $u->descripcion . " - " . $u->ciudad->nombre;
            }
        } else {
            flash("No hay unidades o sedes definidas")->error();
            return redirect()->route('menu.reportes');
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
        return view('reportes.horarioxgrupo')
            ->with('location', 'reportes')
            ->with('unidades', $unidades)
            ->with('periodos', $periodos)
            ->with('jornadas', $jornadas);
    }

    public function viewEstudiantesMatriculados(){
        $periodos = $unidades = null;
        $perds = Periodoacademico::all()->sortByDesc('anio');
        if (count($perds) > 0) {
            foreach ($perds as $p) {
                $periodos[$p->id] = $p->etiqueta . " - " . $p->anio;
            }
        } else {
            flash("No hay períodos académicos")->error();
            return redirect()->route('menu.reportes');
        }
        $unds = Unidad::all();
        if (count($unds) > 0) {
            foreach ($unds as $u) {
                $unidades[$u->id] = $u->nombre . " - " . $u->descripcion . " - " . $u->ciudad->nombre;
            }
        } else {
            flash("No hay unidades o sedes definidas")->error();
            return redirect()->route('menu.reportes');
        }
        return view('reportes.estudiantes_matriculado')
            ->with('location', 'reportes')
            ->with('unidades', $unidades)
            ->with('periodos', $periodos);
    }
    /**
     * @param $response
     * @param $cabeceras
     * @param $filtros
     * @param $titulo
     * @param $nombre
     * @param null $encabezado
     * @return mixed
     */
    static function imprimirPdf($response, $cabeceras, $filtros, $titulo, $nombre, $nivel = 1, $encabezado = null) {
        $hoy = getdate();
        $fechar = $hoy["year"] . "/" . $hoy["mon"] . "/" . $hoy["mday"] . "  Hora: " . $hoy["hours"] . ":" . $hoy["minutes"] . ":" . $hoy["seconds"];
        $date['fecha'] = $fechar;
        $date['encabezado'] = $encabezado;
        $date['cabeceras'] = $cabeceras;
        $date['data'] = $response;
        $date['nivel'] = $nivel;
        $date['titulo'] = $titulo;
        $date['filtros'] = $filtros;
        $pdf = PDF::loadView('reportes.PDF.print_1_2_niveles', $date);
        return $pdf->stream($nombre);
    }

    static function exportarExcel($response, $cabeceras, $filtros, $titulo, $nombre, $encabezado = ['ESP' => '']) {
        $hoy = getdate();
        $fechar = $hoy["year"] . "/" . $hoy["mon"] . "/" . $hoy["mday"] . "  Hora: " . $hoy["hours"] . ":" . $hoy["minutes"] . ":" . $hoy["seconds"];
        $titulo2 = [[$titulo]];
        $fecha = [['FECHA' => 'FECHA REPORTE: ' . $fechar]];
        $encabezado = [$encabezado];
        $filtros = [$filtros];
        $cabeceras = [$cabeceras];
        $row = [['ESP' => '']];
        $data = array_merge($titulo2, $fecha, $row, $encabezado, $filtros, $row, $cabeceras, $response);
//        dd($data);
        return Excel::download(new ExportData($titulo, $cabeceras, $data), $nombre);
    }

    /**
     * @param $toOrderArray
     * @param $field
     * @param false $inverse
     * @return array
     */
    static function orderMultiDimensionalArray($toOrderArray, $field, bool $inverse = false): array {
        $position = array();
        $newRow = array();
        foreach ($toOrderArray as $key => $row) {
            $position[$key] = $row[$field];
            $newRow[$key] = $row;
        }
        if ($inverse) {
            arsort($position);
        } else {
            asort($position);
        }
        $returnArray = array();
        foreach ($position as $key => $pos) {
            $returnArray[] = $newRow[$key];
        }
        return $returnArray;
    }
}
