<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\Concerns\Has;

class LoginController extends Controller
{
    public function index()
    {
        return view('Login.index');
    }

    public function login(Request $request)
    {
        $usuario = 
            DB::table("usuarios as u")
            ->select(
                "u.id",
                "u.Nombre_Usuario",
                "u.Contrasena",
                "u.Nombre",
                "u.Tipo_Usuario",
                "u.ID_Institucion"
            )
            ->where("u.Nombre_Usuario","=",$request->nombre_usuario)
            ->first()
        ;

        if (!$usuario){
            return redirect()->route('login.index')->with("error",'Usuario y/o Contraseña incorrecta')->withInput();
        }

        if (Hash::check($request->contrasena, $usuario->Contrasena)){
            if ($usuario->Tipo_Usuario == "Admin"){

                session([
                    "id_usuario" => $usuario->id,
                    "id_institucion" => $usuario->ID_Institucion
                ]);

                return redirect('/Admin');
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
