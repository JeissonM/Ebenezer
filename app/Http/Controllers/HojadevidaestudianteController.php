<?php

namespace App\Http\Controllers;

use App\Aspirante;
use App\Auditoriaacademico;
use App\Auditoriaadmision;
use App\Circunscripcion;
use App\Ciudad;
use App\Conquienvive;
use App\Datoscompestudiante;
use App\Entidadsalud;
use App\Estado;
use App\Estrato;
use App\Estudiante;
use App\Etnia;
use App\Pais;
use App\Persona;
use App\Personanatural;
use App\Rangosisben;
use App\Sexo;
use App\Situacionanioanterior;
use App\Tipodoc;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HojadevidaestudianteController extends Controller
{
    public function index()
    {
        $est = Estudiante::all();
        return view('academico.registro_academico.hoja_de_vida_estudiante.list')
            ->with('location', 'academico')
            ->with('estudiantes', $est);
    }

    //muestra form para modificar aspirante
    public function modestudiante($id)
    {
        $a = Estudiante::find($id);
        $pn = $a->personanatural;
        $tipodoc = Tipodoc::all()->pluck('descripcion', 'id');
        $paises = Pais::all()->pluck('nombre', 'id');
        $sexos = Sexo::all()->pluck('nombre', 'id');
        $rh = [
            "A+" => "A+",
            "A-" => "A-",
            "B+" => "B+",
            "B-" => "B-",
            "AB+" => "AB+",
            "AB-" => "AB-",
            "O+" => "O+",
            "O-" => "O-",
        ];
        $estados = Estado::all()->pluck('nombre', 'id');
        $ciudades = Ciudad::all()->pluck('nombre', 'id');
        $estratos = Estrato::all()->pluck('etiqueta', 'id');
        $circunscripciones = null;
        $cir = Circunscripcion::all();
        if (count($cir) > 0) {
            foreach ($cir as $ci) {
                $circunscripciones[$ci->id] = $ci->nombre . " - " . $ci->descripcion;
            }
        }
        return view('academico.registro_academico.hoja_de_vida_estudiante.datos_personales.list')
            ->with('location', 'academico')
            ->with('a', $a)
            ->with('pn',$pn)
            ->with('tipodoc', $tipodoc)
            ->with('paises', $paises)
            ->with('sexos', $sexos)
            ->with('estratos', $estratos)
            ->with('circunscripciones', $circunscripciones)
            ->with('estados', $estados)
            ->with('ciudades', $ciudades)
            ->with('rh', $rh);
    }

    //muestra form para modificar datos complementarios del aspirante
    public function moddatoscomplementarios($id)
    {
        $est = Estudiante::find($id);
        $pn = $est->personanatural;
        $d = $est->datoscompestudiante;
        if ($d == null) {
            flash("El estudiante no tiene información complementaria")->error();
            return redirect()->route('menu.hojadevidaestudiante', $id);
        }
        $etnias = Etnia::all()->pluck('nombre', 'id');
        $sis = Rangosisben::all();
        $sisben = $entidades = $situaciones = null;
        if (count($sis) > 0) {
            foreach ($sis as $s) {
                $sisben[$s->id] = $s->etiqueta . " - " . $s->descripcion;
            }
        }
        $conquienvives = Conquienvive::all()->pluck('descripcion', 'id');
        $enti = Entidadsalud::all();
        if (count($enti) > 0) {
            foreach ($enti as $e) {
                $entidades[$e->id] = $e->codigo . " - " . $e->nombre . " - " . $e->tipoentidad . " - " . $e->sector;
            }
        }
        $situ = Situacionanioanterior::all();
        if (count($situ) > 0) {
            foreach ($situ as $e) {
                $situaciones[$e->id] = $e->etiqueta . " - " . $e->descripcion;
            }
        }
        return view('academico.registro_academico.hoja_de_vida_estudiante.datos_complementarios.edit')
            ->with('location', 'academico')
            ->with('pn',$pn)
            ->with('est',$est)
            ->with('d', $d)
            ->with('etnias', $etnias)
            ->with('sisben', $sisben)
            ->with('entidades', $entidades)
            ->with('situaciones', $situaciones)
            ->with('conquienvives', $conquienvives);
    }

    //modifica los datos del estudiante
    public function modificardatosbasicos(Request $request)
    {
        $a = Estudiante::find($request->estudiante_id);
        $m = new Estudiante($a->attributesToArray());
        foreach ($a->attributesToArray() as $key => $value) {
            if (isset($request->$key)) {
                $a->$key = strtoupper($request->$key);
            }
        }
        $u = Auth::user();
        $a->user_change = $u->identificacion;
        $result = $a->save();
        if ($result) {
            $user = User::where('identificacion',$m->personanatural->persona->numero_documento)->first();
            if($user !=null){
                $user->identificacion = $request->numero_documento;
                $user->save();
            }
            $pn = Personanatural::find($a->personanatural_id);
            foreach ($pn->attributesToArray() as $key => $value) {
                if (isset($request->$key)) {
                    $pn->$key = strtoupper($request->$key);
                }
            }
            $p = Persona::find($pn->persona_id);
            $pn->save();
            foreach ($p->attributesToArray() as $key => $value) {
                if (isset($request->$key)) {
                    $p->$key = strtoupper($request->$key);
                }
            }
            $p->direccion = strtoupper($request->direccion_residencia);
            $p->save();
//            if (isset($request->foto)) {
//                $foto = $request->file('foto');
//                $name = "Imagen_" . $foto->getClientOriginalName();
//                $path = public_path() . "/images/fotos/";
//                $foto->move($path, $name);
//                $a->foto = $name;
//                $a->save();
//            }
            $aud = new Auditoriaacademico();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ACTUALIZAR DATOS";
            $str = "EDICION DE LOS DATOS DEL ESTUDINATE. DATOS NUEVOS: ";
            $str2 = " DATOS ANTIGUOS: ";
            foreach ($m->attributesToArray() as $key => $value) {
                $str2 = $str2 . ", " . $key . ": " . $value;
            }
            foreach ($a->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str . " - " . $str2;
            $aud->save();
            flash("Estudiante modificado de forma exitosa!")->success();
            return redirect()->route('menu.hojadevidaestudiante', $request->estudiante_id);
        } else {
            flash("El Estudiante no pudo ser modificado. Error: " . $result)->error();
            return redirect()->route('menu.hojadevidaestudiante', $request->estudiante_id);
        }
    }

    //modifica datos complementarios del estudiante
    public function modcomplementarios(Request $request){
        $a = Estudiante::find($request->estudiante_id);
        $datos = $a->datoscompestudiante;
        $m = new Datoscompestudiante($datos->attributesToArray());
        foreach ($datos->attributesToArray() as $key => $value) {
            if (isset($request->$key)) {
                $datos->$key = strtoupper($request->$key);
            }
        }
        $u = Auth::user();
        $datos->user_change = $u->identificacion;
        $result = $datos->save();
        if($result){
            $aud = new Auditoriaacademico();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ACTUALIZAR DATOS COMPLEMENTARIOS";
            $str = "EDICION DE LOS DATOS DEL ESTUDINATE. DATOS NUEVOS: ";
            $str2 = " DATOS ANTIGUOS: ";
            foreach ($m->attributesToArray() as $key => $value) {
                $str2 = $str2 . ", " . $key . ": " . $value;
            }
            foreach ($datos->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str . " - " . $str2;
            $aud->save();
            flash("Los datos complemetarios fueron modificados de forma exitosa!")->success();
            return redirect()->route('menu.hojadevidaestudiante', $request->estudiante_id);
        }else{
            flash("Los datos no pudo ser modificados. Error: " . $result)->error();
            return redirect()->route('menu.hojadevidaestudiante', $request->estudiante_id);
        }
    }
}
