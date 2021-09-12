<?php

namespace App\Http\Controllers;

use App\Acudiente;
use App\Estudiante;
use App\Persona;
use App\Personanatural;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MenuController extends Controller
{

    /**
     * return the view for the manipulation of the users
     */
    public function usuarios()
    {
        return view('menu.usuarios')->with('location', 'usuarios');
    }

    /**
     * return the view for the manipulation of the admisions process
     */
    public function admisiones()
    {
        return view('menu.admisiones')->with('location', 'admisiones');
    }

    /**
     * return the view for the manipulation of the enrollment process
     */
    public function matricula()
    {
        return view('menu.matricula')->with('location', 'matricula');
    }

    /**
     * return the view for the manipulation of the subscribe process
     */
    public function inscripcion()
    {
        return view('menu.inscripcion')->with('location', 'inscripcion');
    }

    //menu cuestionarioentrevista
    public function cuestionarioentrevista()
    {
        return view('menu.cuestionarioentrevista')->with('location', 'admisiones');
    }

    //menu academico
    public function academico()
    {
        return view('menu.academico')->with('location', 'academico');
    }

    //menu aula virtual
    public function aulavirtual()
    {
        return view('menu.aulavirtual')->with('location', 'aulavirtual');
    }

    //hoja de vida estudiante
    public function hojadevidaestudiante($id)
    {
        $estudiante = Estudiante::find($id);
        $pn = $estudiante->personanatural;
        return view('menu.hojadevida')->with('location', 'academico')->with('estudiante', $estudiante)->with('pn', $pn);
    }

    //menu grados
    public function grados()
    {
        return view('menu.grados')->with('location', 'academico');
    }

    //menu documental
    public function documental()
    {
        return view('menu.documental')->with('location', 'documental');
    }

    //menu academico estudiante y acudiente
    public function academico_e_a()
    {
        return view('menu.academico_e_a')->with('location', 'academico_e_a');
    }

    //menu academico acudiente
    public function academicoacudiente()
    {
        $u = Auth::user();
        $persona = Persona::where('numero_documento', $u->identificacion)->first();
        if ($persona) {
            $pn = $persona->personanatural;
            $acudienteest = $pn->acudienteestudiantes;
            $estudientes = null;
            if (count($acudienteest) > 0) {
                foreach ($acudienteest as $item) {
                    $estudientes[$item->estudiante_id] = $item->estudiante->personanatural->persona->tipodoc->abreviatura . ": ss" . $item->estudiante->personanatural->persona->numero_documento . " - " . $item->estudiante->personanatural->primer_nombre . " "
                        . $item->estudiante->personanatural->segundo_nombre . " " . $item->estudiante->personanatural->primer_apellido . " " . $item->estudiante->personanatural->segundo_apellido;
                }
            }
            return view('acudiente.academico.list')->with('location', 'academicoacudiente')->with('estudiantes', $estudientes);
        } else {
            flash("Usted no tiene aspirantes registrados, debe registrar sus datos como acudiente y luego registrar aspirantes")->error();
            return redirect()->back();
        }
    }

    //
    public function menuacudiente($est)
    {
        $estudinate = Estudiante::find($est);
        $pn = $estudinate->personanatural;
        return view('menu.academicoacudiente')->with('location', 'academicoacudiente')->with('a', $estudinate)->with('pn', $pn);
    }
    //menu academico docente
    public function academicodocente()
    {
        return view('menu.academicodocente')->with('location', 'academicodocente');
    }
    //menu reportes
    public function reportes()
    {
        return view('menu.reportes')->with('location', 'reportes');
    }
}
