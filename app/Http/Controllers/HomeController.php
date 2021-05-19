<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Grupousuario;

class HomeController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index() {
        $user = Auth::user();
        $user->grupousuarios;
        $grupos = $user->grupousuarios;
        $total = count($grupos);
        if ($total == 1) {
            foreach ($grupos as $value) {
                session(['ROL' => $value->nombre]);
                $paginas = $value->paginas;
                $modulos = $value->modulos;
                foreach ($modulos as $modulo) {
                    session([$modulo->nombre => $modulo->nombre]);
                }
                foreach ($paginas as $pagina) {
                    session([$pagina->nombre => $pagina->nombre]);
                }
            }
            return view('home')->with('location', 'home');
        } elseif ($total > 1) {
            return view('auth.rol')->with('grupos', $grupos->pluck('nombre', 'id'));
        } else {
            Auth::logout();
            return "<p style='position: absolute; top:50%; left:50%; width:400px; margin-left:-200px; height:150px; margin-top:-150px; border:3px solid #2c3e50; background-color:#f0f3f4; padding:40px; font-size:20px; color:#18bc9c;'>Usted no posee permisos para ingresar al sistema. Contácte al administrador.<br/><br/><a href='javascript:history.back(1)'>Volver al inicio de sessión</a></p>";
        }
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function confirmaRol() {
        $grupo = Grupousuario::find($_POST["grupo"]);
        $paginas = $grupo->paginas;
        $modulos = $grupo->modulos;
        session(['ROL' => $grupo->nombre]);
        foreach ($paginas as $value) {
            session([$value->nombre => $value->nombre]);
        }
        foreach ($modulos as $value) {
            session([$value->nombre => $value->nombre]);
        }
        return view('home')->with('location', 'home');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function inicio() {
        return view('home')->with('location', 'home');
    }

}
