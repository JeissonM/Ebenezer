<?php

namespace App\Http\Controllers;

use App\Aspirante;
use App\Estado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Persona;
use App\Tipodoc;
use App\Sexo;
use App\Pais;
use App\Ciudad;
use App\Auditoriaadmision;
use App\Circunscripcion;
use App\Entidadsalud;
use App\Etnia;
use App\Rangosisben;
use App\Conquienvive;
use App\Datoscomplementariosaspirante;
use App\Situacionanioanterior;
use App\Estrato;

class AspiranteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $u = Auth::user();
        $p = Persona::where('numero_documento', $u->identificacion)->first();
        if ($p != null) {
            $pn = $p->personanatural;
            if ($pn != null) {
                $acs = $pn->acudientes;
                if (count($acs) > 0) {
                    $aspirantes = null;
                    foreach ($acs as $a) {
                        $aspirantes[] = $a->aspirante;
                    }
                    return view('acudiente.modificar_aspirante.list')
                        ->with('location', 'inscripcion')
                        ->with('aspirantes', $aspirantes);
                } else {
                    flash("Usted no es un acudiente, no puede proceder")->error();
                    return redirect()->route('menu.inscripcion');
                }
            } else {
                flash("Usted no se encuentra registrado en el sistema, no puede proceder")->error();
                return redirect()->route('menu.inscripcion');
            }
        } else {
            flash("Usted no se encuentra registrado en el sistema, no puede proceder")->error();
            return redirect()->route('menu.inscripcion');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Aspirante  $aspirante
     * @return \Illuminate\Http\Response
     */
    public function show(Aspirante $aspirante)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Aspirante  $aspirante
     * @return \Illuminate\Http\Response
     */
    public function edit(Aspirante $aspirante)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Aspirante  $aspirante
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Aspirante $aspirante)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Aspirante  $aspirante
     * @return \Illuminate\Http\Response
     */
    public function destroy(Aspirante $aspirante)
    {
        //
    }

    //menu de modificacion de aspirante
    public function menu($id)
    {
        $a = Aspirante::find($id);
        return view('acudiente.modificar_aspirante.menu')
            ->with('location', 'inscripcion')
            ->with('a', $a);
    }

    //muestra form para modificar aspirante
    public function modaspirante($id)
    {
        $a = Aspirante::find($id);
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
        return view('acudiente.modificar_aspirante.modaspirante')
            ->with('location', 'inscripcion')
            ->with('a', $a)
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
    public function modcomplementarios($id)
    {
        $a = Aspirante::find($id);
        $d = $a->datoscomplementariosaspirante;
        if ($d == null) {
            flash("El aspirante no tiene información complementaria")->error();
            return redirect()->route('aspirante.menu', $id);
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
        return view('acudiente.modificar_aspirante.modcomplementarios')
            ->with('location', 'inscripcion')
            ->with('a', $a)
            ->with('d', $d)
            ->with('etnias', $etnias)
            ->with('sisben', $sisben)
            ->with('entidades', $entidades)
            ->with('situaciones', $situaciones)
            ->with('conquienvives', $conquienvives);
    }

    //modifica los datos del aspirante
    public function modificardp(Request $request)
    {
        $a = Aspirante::find($request->id);
        $m = new Aspirante($a->attributesToArray());
        foreach ($a->attributesToArray() as $key => $value) {
            if (isset($request->$key)) {
                $a->$key = strtoupper($request->$key);
            }
        }
        $u = Auth::user();
        $a->user_change = $u->identificacion;
        $result = $a->save();
        if ($result) {
            if (isset($request->foto)) {
                $foto = $request->file('foto');
                $name = "Imagen_" . $foto->getClientOriginalName();
                $path = public_path() . "/images/fotos/";
                $foto->move($path, $name);
                $a->foto = $name;
                $a->save();
            }
            $aud = new Auditoriaadmision();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ACTUALIZAR DATOS";
            $str = "EDICION DE LOS DATOS DEL ASPIRANTE. DATOS NUEVOS: ";
            $str2 = " DATOS ANTIGUOS: ";
            foreach ($m->attributesToArray() as $key => $value) {
                $str2 = $str2 . ", " . $key . ": " . $value;
            }
            foreach ($a->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str . " - " . $str2;
            $aud->save();
            flash("Aspirante modificado de forma exitosa!")->success();
            return redirect()->route('aspirante.menu', $request->id);
        } else {
            flash("El aspirante no pudo ser modificado. Error: " . $result)->error();
            return redirect()->route('aspirante.menu', $request->id);
        }
    }

    //modifica los datos complementarios del aspirante
    public function modificarcomp(Request $request)
    {
        $a = Aspirante::find($request->id);
        $d = $a->datoscomplementariosaspirante;
        $m = new Datoscomplementariosaspirante($d->attributesToArray());
        foreach ($d->attributesToArray() as $key => $value) {
            if (isset($request->$key)) {
                $d->$key = strtoupper($request->$key);
            }
        }
        $u = Auth::user();
        $d->user_change = $u->identificacion;
        $result = $d->save();
        if ($result) {
            $aud = new Auditoriaadmision();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ACTUALIZAR DATOS";
            $str = "EDICION DE LOS DATOS COMPLEMENTARIOS DEL ASPIRANTE. DATOS NUEVOS: ";
            $str2 = " DATOS ANTIGUOS: ";
            foreach ($m->attributesToArray() as $key => $value) {
                $str2 = $str2 . ", " . $key . ": " . $value;
            }
            foreach ($d->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str . " - " . $str2;
            $aud->save();
            flash("Aspirante modificado de forma exitosa!")->success();
            return redirect()->route('aspirante.menu', $request->id);
        } else {
            flash("El aspirante no pudo ser modificado. Error: " . $result)->error();
            return redirect()->route('aspirante.menu', $request->id);
        }
    }
}
