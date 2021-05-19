<?php

namespace App\Http\Controllers;

use App\Auditoriaacademico;
use App\Estudiante;
use App\Http\Requests\ResponsablefestudianteRequest;
use App\Ocupacion;
use App\Pais;
use App\Persona;
use App\Personanatural;
use App\Resposablefestudiante;
use App\Sexo;
use App\Tipodoc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResponsablefestudianteController extends Controller
{
    public function inicio($id)
    {
        $est = Estudiante::find($id);
        $pn = $est->personanatural;
        $res = $est->resposablefestudiante;
        return view('academico.registro_academico.hoja_de_vida_estudiante.responsable_financiero.list')
            ->with('location', 'academico')
            ->with('a', $est)
            ->with('pn', $pn)
            ->with('res', $res);
    }

    public function crear($id)
    {
        $est = Estudiante::find($id);
        $pn = $est->personanatural;
        $tipodoc = Tipodoc::all()->pluck('descripcion', 'id');
        $paises = Pais::all()->pluck('nombre', 'id');
        $sexos = Sexo::all()->pluck('nombre', 'id');
        $profesions = Ocupacion::all()->pluck('descripcion', 'id');
        $personan = Personanatural::all();
        return view('academico.registro_academico.hoja_de_vida_estudiante.responsable_financiero.create')
            ->with('location', 'academico')
            ->with('a', $est)
            ->with('pn', $pn)
            ->with('personas', $personan)
            ->with('tipodoc', $tipodoc)
            ->with('paises', $paises)
            ->with('sexos', $sexos)
            ->with('rh', [
                "A+" => "A+",
                "A-" => "A-",
                "B+" => "B+",
                "B-" => "B-",
                "AB+" => "AB+",
                "AB-" => "AB-",
                "O+" => "O+",
                "O-" => "O-"
            ])
            ->with('profesions', $profesions);
    }

    public function store(Request $request)
    {
        $responsable = new Resposablefestudiante($request->all());
        foreach ($responsable->attributesToArray() as $key => $value) {
            if (isset($request->$key)) {
                $responsable->$key = strtoupper($request->$key);
            }
        }
        $u = Auth::user();
        $responsable->user_change = $u->identificacion;
        $result = $responsable->save();
        if ($result) {
            $aud = new Auditoriaacademico();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "INSERTAR";
            $str = "CREACIÓN DE RESPONSABLE FINANCIERO DE ESTUDIANTE. DATOS: ";
            foreach ($responsable->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("El Responsable financiero fue agregado de forma exitosa")->success();
            return redirect()->route('responsablefestudiante.inicio', $request->estudiante_id);
        } else {
            flash("El Responsable financiero no fue agragado correctamente. Error!" . $result)->error();
            return redirect()->route('responsablefestudiante.inicio', $request->estudiante_id);
        }
    }

    public function destroy($id)
    {
        $responsable = Resposablefestudiante::find($id);
        $result = $responsable->delete();
        if ($result) {
            $aud = new Auditoriaacademico();
            $u = Auth::user();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ELIMINAR";
            $str = "ELIMINACIÓN DE RESPONSABLE FINANCIERO ESTUDINATE. DATOS ELIMINADOS: ";
            foreach ($responsable->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("El Responsable financiero fue eliminado de forma exitosa")->success();
            return redirect()->route('responsablefestudiante.inicio', $responsable->estudiante_id);
        } else {
            flash("El Responsable financiero no pudo ser eliminado de forma correcta. Error!" . $result)->success();
            return redirect()->route('responsablefestudiante.inicio', $responsable->estudiante_id);
        }
    }
}
