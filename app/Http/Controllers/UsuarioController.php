<?php

namespace App\Http\Controllers;

use App\Auditoriaacademico;
use Illuminate\Http\Request;
use App\Http\Requests\UsuarioRequest;
use App\User;
use App\Grupousuario;
use App\Pagina;
use App\Modulo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Auditoriausuario;
use App\Docente;
use App\Estudiante;

class UsuarioController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usuarios = User::all();
        $usuarios->each(function ($usuario) {
            $usuario->grupousuarios;
        });
        return view('usuarios.usuarios.list')
            ->with('location', 'usuarios')
            ->with('usuarios', $usuarios);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $grupos = Grupousuario::all()->sortBy('nombre')->pluck('nombre', 'id');
        return view('usuarios.usuarios.create')
            ->with('location', 'usuarios')
            ->with('grupos', $grupos);
    }

    /**
     * Show the form for make operations width a resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function operaciones()
    {
        $user = User::where('identificacion', $_POST["id"])->first();
        if ($user === null) {
            flash("<strong>El usuario</strong> consultado no se encuentra registrado!")->error();
            return redirect()->route('menu.usuarios');
        }
        $user->grupousuarios;
        $grupos = Grupousuario::all()->sortBy('nombre')->pluck('nombre', 'id');
        return view('usuarios.usuarios.edit')
            ->with('location', 'usuarios')
            ->with('grupos', $grupos)
            ->with('user', $user);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UsuarioRequest $request)
    {
        $user = new User($request->all());
        foreach ($user->attributesToArray() as $key => $value) {
            if ($key === 'email') {
                $user->$key = $value;
            } elseif ($key === 'password') {
                $user->$key = bcrypt($value);
            } else {
                $user->$key = strtoupper($value);
            }
        }
        $u = Auth::user();
        $user->user_change = $u->identificacion;
        $result = $user->save();
        $user->grupousuarios()->sync($request->grupos);
        if ($result) {
            $aud = new Auditoriausuario();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "INSERTAR";
            $str = "CREACIÓN DE USUARIO. DATOS: ";
            foreach ($user->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("El usuario <strong>" . $user->nombres . "</strong> fue almacenado de forma exitosa!")->success();
            return redirect()->route('menu.usuarios');
        } else {
            flash("El usuario <strong>" . $user->nombres . "</strong> no pudo ser almacenado. Error: " . $result)->error();
            return redirect()->route('menu.usuarios');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $m = new User($user->attributesToArray());
        foreach ($user->attributesToArray() as $key => $value) {
            if (isset($request->$key)) {
                if ($key === 'email') {
                    $user->$key = $request->$key;
                } elseif ($key !== 'password') {
                    $user->$key = strtoupper($request->$key);
                }
            }
        }
        $u = Auth::user();
        $user->user_change = $u->identificacion;
        $result = $user->save();
        $user->grupousuarios()->sync($request->grupos);
        if ($result) {
            $aud = new Auditoriausuario();
            $u = Auth::user();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ACTUALIZAR DATOS";
            $str = "EDICION DE USUARIO. DATOS NUEVOS: ";
            $str2 = " DATOS ANTIGUOS: ";
            foreach ($m->attributesToArray() as $key => $value) {
                $str2 = $str2 . ", " . $key . ": " . $value;
            }
            foreach ($user->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str . " - " . $str2;
            $aud->save();
            flash("El usuario <strong>" . $user->nombres . "</strong> fue modificado de forma exitosa!")->success();
            return redirect()->route('menu.usuarios');
        } else {
            flash("El usuario <strong>" . $user->nombres . "</strong> no pudo ser modificado. Error: " . $result)->error();
            return redirect()->route('menu.usuarios');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $result = $user->delete();
        DB::table('grupousuario_user')->where('user_id', '=', $id)->delete();
        if ($result) {
            $aud = new Auditoriausuario();
            $u = Auth::user();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ELIMINAR";
            $str = "ELIMINACIÓN DE USUARIO. DATOS ELIMINADOS: ";
            foreach ($user->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("El usuario <strong>" . $user->nombres . "</strong> fue eliminado de forma exitosa!")->success();
            return redirect()->route('menu.usuarios');
        } else {
            flash("El usuario <strong>" . $user->nombres . "</strong> no pudo ser eliminado. Error: " . $result)->error();
            return redirect()->route('menu.usuarios');
        }
    }

    public function getUser($e)
    {
        $u = new User();
        $u->identificacion = $e->estudiante->personanatural->persona->numero_documento;
        $u->nombres = strtoupper($e->estudiante->personanatural->primer_nombre . " " . $e->estudiante->personanatural->segundo_nombre);
        $u->apellidos = strtoupper($e->estudiante->personanatural->primer_apellido . " " . $e->estudiante->personanatural->segundo_apellido);
        $u->email = $e->estudiante->personanatural->persona->mail;
        $u->password = bcrypt('0000');
        $u->estado = "ACTIVO";
        return $u;
    }

    public function getUser2($pn, $p)
    {
        $u = new User();
        $u->identificacion = $p->numero_documento;
        $u->nombres = strtoupper($pn->primer_nombre . " " . $pn->segundo_nombre);
        $u->apellidos = strtoupper($pn->primer_apellido . " " . $pn->segundo_apellido);
        $u->email = $p->mail;
        $u->password = bcrypt('0000');
        $u->estado = "ACTIVO";
        return $u;
    }

    /*
     * vista para cambiar la contraseña
     */

    public function vistacontrasenia()
    {
        return view('pass')->with('location', '');
    }

    /*
     * cambia la contraseña
     */

    public function cambiarcontrasenia(Request $request)
    {
        $u = Auth::user();
        if ($u !== null) {
            if (Hash::check($request->pass0, $u->password)) {
                if (strlen($request->pass1) < 6 or strlen($request->pass2) < 6) {
                    flash('La nueva contraseña no puede tener menos de 6 caracteres.')->error();
                    return redirect()->route('usuario.vistacontrasenia');
                } else {
                    if ($request->pass1 !== $request->pass2) {
                        flash('Las contraseñas no coinciden.')->error();
                        return redirect()->route('usuario.vistacontrasenia');
                    } else {
                        $u->password = bcrypt($request->pass1);
                        if ($u->save()) {
                            $aud = new Auditoriaacademico();
                            $u = Auth::user();
                            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
                            $aud->operacion = "ACTUALIZACIÓN DE DATOS";
                            $str = "CAMBIO DE CONTRASEÑA DE USUARIO. DATOS ELIMINADOS: ";
                            foreach ($grupo->attributesToArray() as $key => $value) {
                                $str = $str . ", " . $key . ": " . $value;
                            }
                            $aud->detalles = $str;
                            $aud->save();
                            flash('Contraseña cambiada con exito.')->success();
                            return redirect()->route('usuario.vistacontrasenia');
                        } else {
                            flash('La contraseña no pudo ser cambiada.')->error();
                            return redirect()->route('usuario.vistacontrasenia');
                        }
                    }
                }
            } else {
                flash('La contraseña actual ingresada no es correcta.')->error();
                return redirect()->route('usuario.vistacontrasenia');
            }
        } else {
            flash('No se ha podido establecer el usuario, no se cambio la contraseña.')->error();
            return redirect()->route('usuario.vistacontrasenia');
        }
    }

    //cambia la contraseña de cualquier usuario
    public function cambiarPass(Request $request)
    {
        if (strlen($request->pass1) < 6 or strlen($request->pass2) < 6) {
            flash('La nueva contraseña no puede tener menos de 6 caracteres.')->error();
            return redirect()->route('menu.usuarios');
        } else {
            if ($request->pass1 !== $request->pass2) {
                flash('Las contraseñas no coinciden.')->error();
                return redirect()->route('menu.usuarios');
            } else {
                $us = User::where('identificacion', $request->identificacion2)->first();
                $us->password = bcrypt($request->pass1);
                $u = Auth::user();
                $us->user_change = $u->identificacion;
                if ($us->save()) {
                    $aud = new Auditoriausuario();
                    $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
                    $aud->operacion = "ACTUALIZACIÓN DE DATOS";
                    $str = "CAMBIO DE CONTRASEÑA DE USUARIO. DATOS ELIMINADOS: ";
                    foreach ($us->attributesToArray() as $key => $value) {
                        $str = $str . ", " . $key . ": " . $value;
                    }
                    $aud->detalles = $str;
                    $aud->save();
                    flash('Contraseña cambiada con exito.')->success();
                    return redirect()->route('menu.usuarios');
                } else {
                    flash('La contraseña no pudo ser cambiada.')->error();
                    return redirect()->route('menu.usuarios');
                }
            }
        }
    }

    //index para creacion de usuarios masivos estudiantes

    public function automaticoEstudianteIndex()
    {
        return $this->automaticoIndex('ESTUDIANTE');
    }

    //index para creacion de usuarios masivos docentes

    public function automaticoDocenteIndex()
    {
        return $this->automaticoIndex('DOCENTE');
    }

    //vista index usuarios masivos segun actor
    public function automaticoIndex($actor)
    {
        $view = null;
        $grupos = Grupousuario::all()->sortBy('nombre')->pluck('nombre', 'id');
        $data['grupos'] = $grupos;
        $data['actor'] = $actor;
        switch ($actor) {
            case 'ESTUDIANTE':
                $view = 'usuarios.convertir.general';
                $data['route'] = 'usuariosautomaticos.store';
                break;
            case 'DOCENTE':
                $view = 'usuarios.convertir.general';
                $data['route'] = 'usuariosautomaticos.store';
                break;
        }
        if ($view != null) {
            return view($view)
                ->with('location', 'usuarios')
                ->with('data', $data);
        } else {
            flash('No se pudo establecer el actor a convertir')->error();
            return redirect()->route('menu.usuarios');
        }
    }

    //metodo para generar de forma automatica usuarios a los actores indicados
    public function automaticostore(Request $request)
    {
        $hoy = getdate();
        $fecha = $hoy["year"] . "/" . $hoy["mon"] . "/" . $hoy["mday"];
        $response[] = "*********************************************************************************************************";
        $response[] = "PROCESO MASIVO - CREACIÓN DE USUARIOS A " . $request->actor . ". FECHA: " . $fecha;
        $response[] = "*********************************************************************************************************";
        $response[] = "                                                                        ";
        $response[] = "                                                                        ";
        switch ($request->actor) {
            case 'ESTUDIANTE':
                $estudiantes = Estudiante::all();
                if (count($estudiantes) > 0) {
                    foreach ($estudiantes as $e) {
                        $pn = $e->personanatural;
                        $p = $pn->persona;
                        $response[] = "ESTUDIANTE CON IDENTIFICACIÓN " . $p->numero_documento;
                        $response[] = $this->setUser($p->numero_documento, $pn->primer_nombre . " " . $pn->segundo_nombre, $pn->perimer_apellido . " " . $pn->segundo_apellido, $p->mail, $request->grupos, $request->actor);
                        $response[] = "*********************************************************************************************************";
                        $response[] = "                                                                                          ";
                    }
                }
                break;
            case 'DOCENTE':
                $docentes = Docente::all();
                if (count($docentes) > 0) {
                    foreach ($docentes as $d) {
                        $pn = $d->personanatural;
                        $p = $pn->persona;
                        $response[] = "DOCENTE CON IDENTIFICACIÓN " . $p->numero_documento;
                        $response[] = $this->setUser($p->numero_documento, $pn->primer_nombre . " " . $pn->segundo_nombre, $pn->perimer_apellido . " " . $pn->segundo_apellido, $p->mail, $request->grupos, $request->actor);
                        $response[] = "*********************************************************************************************************";
                        $response[] = "                                                                                          ";
                    }
                }
                break;
        }
        //creo el archivo fisico
        $archivo = "CREACION-AUTOMATICA-DE-USUARIOS-" . $request->actor . "_" .  $hoy["year"] . $hoy["mon"] . $hoy["mday"] . $hoy["hours"] . $hoy["minutes"] . $hoy["seconds"] . ".txt";
        $file = fopen(public_path() . "/documentos/log/" . $archivo, 'w+');
        foreach ($response as $value) {
            fwrite($file, $value . PHP_EOL);
        }
        fclose($file);
        $response["archivo"] = $archivo;
        $response["resultado"] = $response;
        return view('usuarios.convertir.resultados')
            ->with('location', 'usuarios')
            ->with('response', $response)
            ->with('actor', $request->actor);
    }

    //crea un usuario
    public function setUser($id, $nombres, $apellidos, $email, $r, $actor)
    {
        $old = User::where('identificacion', $id)->get();
        if (count($old) > 0) {
            return "[x] EL USUARIO CON IDENTIFICACIÓN " . $id . " YA SE ENCUENTRA REGISTRADO EN EL SISTEMA";
        }
        $old2 = User::where('email', $email)->get();
        if (count($old2) > 0) {
            return "[x] EL USUARIO CON CORREO " . $email . " YA SE ENCUENTRA REGISTRADO EN EL SISTEMA";
        }
        $user = new User();
        $user->identificacion = $id;
        $user->nombres = ($nombres == '' || $nombres == null) ? '--' : $nombres;
        $user->apellidos = ($apellidos == '' || $apellidos == null) ? '--' : $apellidos;
        $user->email = ($email == '' || $email == null) ? '--' : $email;
        $user->password = Hash::make($id);
        $user->estado = "ACTIVO";
        $u = Auth::user();
        $user->user_change = $u->identificacion;
        if ($user->save()) {
            $user->grupousuarios()->sync($r);
            $aud = new Auditoriausuario();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "INSERTAR";
            $str = "CREACIÓN DE USUARIO. DATOS: ";
            foreach ($user->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            return  "[OK] LOS DATOS DEL USUARIO PARA EL/LA " . $actor . " CON ID " . $id . " HAN SIDO ALMACENADOS CON EXITO";
        } else {
            return "[x] EL USUARIO PARA EL/LA " . $actor . " CON ID " . $id . " NO PUDO SER CREADO, DEBE REPETIR EL PROCESO O CREARLO MANUAL";
        }
    }
}
