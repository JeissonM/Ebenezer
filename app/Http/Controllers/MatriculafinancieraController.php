<?php

namespace App\Http\Controllers;

use App\Auditoriaacademico;
use App\Estudiante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MatriculafinancieraController extends Controller
{
    //index
    public function index()
    {
        $est = Estudiante::all();
        return view('academico.registro_academico.matricula_financiera.list')
            ->with('location', 'academico')
            ->with('estudiantes', $est);
    }

    //permite registrar el pago
    public function show($id)
    {
        $e = Estudiante::find($id);
        $e->pago = "PAGADO";
        $u = Auth::user();
        $e->user_change = $u->identificacion;
        if ($e->save()) {
            $this->setAuditoria('ACTUALIZAR', 'REGISTRAR PAGO A ESTUDIANTE. DATOS ACTUALIZADOS: ', $e);
            flash('Pago registrado con exito.')->success();
            return redirect()->route('matriculafinanciera.index');
        } else {
            flash('El pago no pudo ser registrado.')->error();
            return redirect()->route('matriculafinanciera.index');
        }
    }

    //auditoria
    public function setAuditoria($operacion, $title, $obj)
    {
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
}
