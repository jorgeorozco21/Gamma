<?php

namespace App\Http\Controllers;

use App\Mail\ContrasenaNuevaMail;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\UsuarioCreadoMail;
use Illuminate\Support\Facades\DB;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $usuarios = 
            DB::table("usuarios as u")
            ->leftJoin("grupos as g","g.id","=","u.ID_Grupo")
            ->select(
                "u.id",
                "u.Nombre_Usuario",
                "u.Email",
                "u.Nombre",
                "u.Tipo_Usuario",
                "g.Nombre as nombreGrupo",
                "g.Grado",
                "g.Grupo"
            )
            ->where("u.ID_Institucion","=",session('id_institucion'))
            ->where("u.Tipo_Usuario","!=","Admin")
            ->orderBy("u.Nombre","ASC")
            ->orderBy("u.created_at","DESC")
            ->get()
        ;

        $grupos = 
            DB::table("grupos as g")
            ->select(
                "g.id",
                "g.Nombre",
                "g.Grado",
                "g.Grupo"
            )
            ->orderBy("g.Nombre","ASC")
            ->where("g.ID_Institucion","=",session('id_institucion'))
            ->orderBy("g.created_at","DESC")
            ->get()
        ;

        return view('Admin.Usuario.index',compact('usuarios','grupos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $datosUsuario = $request->except('_token');

        $request->validate([
            "Nombre_Usuario" => "required|string|max:255",
            "Email" => "required|string|max:255",
            "Nombre" => "required|string|max:255",
        ],[
            "Nombre_Usuario.required" => "El Nombre de usuario es Obligatorio",
            "Nombre_Usuario.max" => "El Nombre de Usuario no puede exceder los 255 caracteres",
            "Email.required" => "El Email es obligatorio",
            "Email.max" => "El Email no puede exceder los 255 caracteres",
            "Nombre.required" => "El Nombre es obligatorio",
            "Nombre.max" => "El Nombre no puede exceder los 255 caractres"
        ]);

        $contrasena = Str::random(12);
        $datosUsuario['Contrasena'] = Hash::make($contrasena);

        Usuario::create($datosUsuario);

        Mail::to($datosUsuario['Email'])->send(new UsuarioCreadoMail($datosUsuario['Nombre_Usuario'],$contrasena)->from('jeduardoorozco06@gmail.com','Administracion'));

        return redirect()->route('admin.usuarios.index')->with('success',"Usuario creado correctamente");

        //return response()->json($datosUsuario);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $datosUsuario = $request->except("_token","_method");

        $request->validate([
            "Nombre_Usuario" => "required|string|max:255",
            "Email" => "required|string|max:255",
            "Nombre" => "required|string|max:255",
        ],[
            "Nombre_Usuario.required" => "El Nombre de usuario es Obligatorio",
            "Nombre_Usuario.max" => "El Nombre de Usuario no puede exceder los 255 caracteres",
            "Email.required" => "El Email es obligatorio",
            "Email.max" => "El Email no puede exceder los 255 caracteres",
            "Nombre.required" => "El Nombre es obligatorio",
            "Nombre.max" => "El Nombre no puede exceder los 255 caractres"
        ]);
        
        if ($datosUsuario['Tipo_Usuario'] != "Normal"){
            $datosUsuario["ID_Grupo"] = null;
        }

        Usuario::where("id","=",$id)->update($datosUsuario);

        return redirect()->route('admin.usuarios.index')->with('success','Informacion editada correctamente');

        //return response()->json($datosUsuario);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $usuario = Usuario::findOrFail($id);

        $usuario->delete();

        return redirect()->route('admin.usuarios.index')->with('success','Usuario borrado correctamente');
    }

    /**
     * Funcion para cambio de contrasena
     */
    public function cambioContrasena(string $id)
    {
        $nuevaContrasena = Str::random(12);

        $usuario = Usuario::findOrFail($id);

        Usuario::where("id","=",$id)->update(['Contrasena' => Hash::make($nuevaContrasena)]);

        Mail::to($usuario['Email'])->send(new ContrasenaNuevaMail($usuario['Nombre_Usuario'],$nuevaContrasena)->from('jeduardoorozco06@gmail.com','Administracion'));

        return response()->json([
            'message' => 'Contraseña cambiada correctamente'
        ]);
    }
}
