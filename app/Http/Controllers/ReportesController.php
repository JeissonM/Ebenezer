<?php

namespace App\Http\Controllers;

use App\Export\ExportData;
use App\Periodoacademico;
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

    static function exportarExcel($response, $cabeceras, $filtros, $titulo, $nombre, $encabezado = null) {
        $hoy = getdate();
        $fechar = $hoy["year"] . "/" . $hoy["mon"] . "/" . $hoy["mday"] . "  Hora: " . $hoy["hours"] . ":" . $hoy["minutes"] . ":" . $hoy["seconds"];
        return Excel::download(new ExportData($titulo,$cabeceras,$response,$filtros),$nombre);
//        Excel::create($nombre, function ($excel) use ($response, $cabeceras, $encabezado, $fechar, $filtros,$titulo) {
//            $excel->sheet('Reporte', function ($sheet) use ($response, $cabeceras, $encabezado, $fechar, $filtros,$titulo) {
//                $sheet->row(1, [$titulo]);
//                $sheet->row(2, ["FECHA REPORTE: " . $fechar]);
//                $sheet->row(3, "");
//                $sheet->row(4, $encabezado);
//                $sheet->row(5, $filtros);
//                $sheet->row(6, "");
//                $sheet->row(7, $cabeceras);
//                $i = 7;
//                foreach ($response as $key => $value) {
//                    $i = $i + 1;
//                    $sheet->row($i, $this->to_array($value));
//                }
//            });
//        })->download('xlsx')
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
