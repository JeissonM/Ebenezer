<?php

namespace App\Http\Controllers;

use App\Persona;
use Illuminate\Http\Request;

class EstudianteController extends Controller
{
    public function getEStudiante($id)
    {
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
}
