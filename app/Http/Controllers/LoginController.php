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
                "u.email",
                "u.admin",
                "u.mantenimiento",
                "u.encargado",
                "u.normal",
                "u.id_institucion"
            )
            ->where("u.nombre_usuario","=",$request->nombre_usuario)
            ->first()
        ;

        if (!$usuario || !Hash::check($request->contrasena, $usuario->contrasena)) {
            return redirect()->route('login.index')->with("error", 'Usuario y/o Contraseña incorrecta')->withInput();
        }

        session([
            "id_usuario" => $usuario->id,
            "nombre_usuario" => $usuario->nombre_usuario,
            "nombre" => $usuario->nombre,
            "email" => $usuario->email,
            "id_institucion" => $usuario->id_institucion
        ]);

        if ($usuario->admin == "1") {
            session(["tipo" => "admin"]);
            return redirect('/admin');
        }
        
        if ($usuario->normal == "1") session(["normal" => true]);
        if ($usuario->encargado == "1") session(["encargado" => true]);
        if ($usuario->mantenimiento == "1") session(["mantenimiento" => true]);
        
        return redirect('/seleccionar-tipo-usuario');
    }

    public function logout(Request $request)
    {
        $request->session()->invalidate();      
        $request->session()->regenerateToken();

        return redirect()->route('login.index');
    }

    public function activarRol($rol)
    {

        if (!session("$rol")){
            return redirect('/seleccionar-tipo-usuario')->with('error', 'Acceso no autorizado.');
        }

        session(['tipo' => $rol]);

        return match ($rol){
            'normal' => redirect('/usuario/normal/laboratorios'),
            'encargado' => redirect('/usuario/encargado/solicitudes-pendientes'),
            'mantenimiento' => redirect('/usuario/mantenimiento/reportes-computo')
        };
    }
}
