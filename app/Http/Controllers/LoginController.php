<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function index()
    {
        if (session()->has('id_institucion')) {
            session()->forget(['id_usuario', 'id_institucion']);
        }

        return view('Login.index');
    }

    public function login(Request $request)
    {
        $usuario = 
            DB::table("usuarios as u")
            ->select(
                "u.id",
                "u.nombre_usuario",
                "u.contrasena",
                "u.nombre",
                "u.admin",
                "u.mantenimiento",
                "u.encargado",
                "u.normal",
                "u.id_institucion"
            )
            ->where("u.nombre_usuario","=",$request->nombre_usuario)
            ->first()
        ;

        if (!$usuario){
            return redirect()->route('login.index')->with("error",'Usuario y/o Contraseña incorrecta')->withInput();
        }

        if (Hash::check($request->contrasena, $usuario->contrasena)){
            if ($usuario->admin == "1"){

                session([
                    "id_usuario" => $usuario->id,
                    "id_institucion" => $usuario->id_institucion
                ]);

                return redirect('/admin');
            }
            return view('Login.index');
        }

        return redirect()->route('login.index')->with("error",'Usuario y/o Contraseña incorrecta')->withInput();
    }

    public function logout(Request $request)
    {
        $request->session()->invalidate();      
        $request->session()->regenerateToken();

        return redirect()->route('login.index');
    }
}
