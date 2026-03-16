<?php

namespace App\Http\Controllers;

use App\Mail\ContrasenaNuevaMail;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\UsuarioCreadoMail;
use Illuminate\Support\Facades\Validator;
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
            ->leftJoin("grupos as g","g.id","=","u.id_grupo")
            ->select(
                "u.id",
                "u.nombre_usuario",
                "u.email",
                "u.nombre",
                "u.mantenimiento",
                "u.encargado",
                "u.normal",
                "g.nombre as nombreGrupo",
                "g.grado",
                "g.grupo"
            )
            ->where("u.id_institucion","=",session('id_institucion'))
            ->where("u.admin","!=","1")
            ->orderBy("u.id","ASC")
            ->orderBy("u.created_at","DESC")
            ->get()
        ;

        $grupos = 
            DB::table("grupos as g")
            ->select(
                "g.id",
                "g.nombre",
                "g.grado",
                "g.grupo"
            )
            ->orderBy("g.nombre","ASC")
            ->where("g.id_institucion","=",session('id_institucion'))
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

        $validator = Validator::make($request->all(), [
            "nombre_usuario" => "required|string|max:255",
            "email" => "required|string|max:255",
            "nombre" => "required|string|max:255",
        ],[
            "nombre_usuario.required" => "El Nombre de usuario es Obligatorio",
            "nombre_usuario.max" => "El Nombre de Usuario no puede exceder los 255 caracteres",
            "email.required" => "El Email es obligatorio",
            "email.max" => "El Email no puede exceder los 255 caracteres",
            "nombre.required" => "El Nombre es obligatorio",
            "nombre.max" => "El Nombre no puede exceder los 255 caractres"
        ]);

        $contrasena = Str::random(12);
        $datosUsuario['contrasena'] = Hash::make($contrasena);
        $datosUsuario['admin'] = "0";

        $band = false;

        if ($datosUsuario['mantenimiento'] == "on"){
            $datosUsuario['mantenimiento'] = "1";
            $band = true;
        }else $datosUsuario['mantenimiento'] = "0";

        if ($datosUsuario['encargado'] == "on"){
            $datosUsuario['encargado'] = "1";
            $band = true;
        }else $datosUsuario['encargado'] = "0";

        if ($datosUsuario['normal'] == "on"){
            $datosUsuario['normal'] = "1";
            $band = true;
        }else{
            $datosUsuario['normal'] = "0";
            $datosUsuario['id_grupo'] = null;
        }

        $validator->after(function ($validator) use ($band) {
            if (!$band) {
                $validator->errors()->add("Tipo", "Debes seleccionar mínimo un tipo de usuario");
            }
        });


        if ($validator->fails()){
            return redirect()->route('admin.usuarios.index')->withErrors($validator);
        }
        
        Usuario::create($datosUsuario);

        Mail::to($datosUsuario['email'])->send(new UsuarioCreadoMail($datosUsuario['nombre_usuario'],$contrasena)->from('jeduardoorozco06@gmail.com','Administracion'));

        return redirect()->route('admin.usuarios.index')->with('success',"Usuario creado correctamente");
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

        $validator = Validator::make($request->all(), [
            "nombre_usuario" => "required|string|max:255",
            "email" => "required|string|max:255",
            "nombre" => "required|string|max:255",
        ],[
            "nombre_usuario.required" => "El Nombre de usuario es Obligatorio",
            "nombre_usuario.max" => "El Nombre de Usuario no puede exceder los 255 caracteres",
            "email.required" => "El Email es obligatorio",
            "email.max" => "El Email no puede exceder los 255 caracteres",
            "nombre.required" => "El Nombre es obligatorio",
            "nombre.max" => "El Nombre no puede exceder los 255 caractres"
        ]);

        $band = false;

        if ($datosUsuario['mantenimiento'] == "on"){
            $datosUsuario['mantenimiento'] = "1";
            $band = true;
        }else $datosUsuario['mantenimiento'] = "0";

        if ($datosUsuario['encargado'] == "on"){
            $datosUsuario['encargado'] = "1";
            $band = true;
        }else $datosUsuario['encargado'] = "0";

        if ($datosUsuario['normal'] == "on"){
            $datosUsuario['normal'] = "1";
            $band = true;
        }else{
            $datosUsuario['normal'] = "0";
            $datosUsuario['id_grupo'] = null;
        }

        $validator->after(function ($validator) use ($band) {
            if (!$band) {
                $validator->errors()->add("Tipo", "Debes seleccionar mínimo un tipo de usuario");
            }
        });

        if ($validator->fails()){
            return redirect()->route('admin.usuarios.index')->withErrors($validator);
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

        Usuario::where("id","=",$id)->update(['contrasena' => Hash::make($nuevaContrasena)]);

        Mail::to($usuario['email'])->send(new ContrasenaNuevaMail($usuario['nombre_usuario'],$nuevaContrasena)->from('jeduardoorozco06@gmail.com','Administracion'));

        return response()->json([
            'message' => 'Contraseña cambiada correctamente'
        ]);
    }
}
