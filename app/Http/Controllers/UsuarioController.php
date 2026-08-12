<?php

namespace App\Http\Controllers;

use App\Exports\ArchivoUsuariosExport;
use App\Exports\InformacionUsuariosExport;
use App\Mail\ContrasenaNuevaMail;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\UsuarioCreadoMail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admin = 
            DB::table('usuarios as u')
            ->select(
                'u.nombre_usuario',
                'u.email'
            )
            ->where('u.id','=',session('id_usuario'))
            ->first()
        ;

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
                "g.grupo",
                "g.turno"
            )
            ->where("u.id_institucion","=",session('id_institucion'))
            ->where("u.admin","!=","1")
            ->orderBy('g.turno', 'asc')
            ->orderBy('g.grado', 'asc')
            ->orderBy('g.nombre', 'asc')
            ->orderBy('g.grupo', 'asc')
            ->orderBy('u.nombre', 'asc')
            ->paginate(40)
            ->withQueryString();
        ;

        $grupos = 
            DB::table("grupos as g")
            ->select(
                "g.id",
                "g.nombre",
                "g.grado",
                "g.grupo",
                "g.turno"
            )
            ->where("g.id_institucion","=",session('id_institucion'))
            ->orderBy('g.turno', 'asc')
            ->orderBy('g.grado', 'asc')
            ->orderBy('g.nombre', 'asc')
            ->orderBy('g.grupo', 'asc')
            ->get()
        ;

        return view('Admin.Usuario.index',compact('usuarios','grupos','admin'));
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
            'nombre_usuario' => "required|string|max:255|unique:usuarios,nombre_usuario",
            'email' => "required|email|max:255|unique:usuarios,email",
            'nombre' => "required|string|max:255",
        ],[
            'nombre_usuario.required' => "Nombre de Usuario es obligatorio",
            'nombre_usuario.max' => "Nombre de Usuario no debe de exceder los 255 caracteres",
            'nombre_usuario.unique' => "Nombre de Usuario ya existente",
            'email.required' => "Correo Electronico Obligatorio",
            'email.email' => "Correo Electronico Invalido",
            'email.max' => "El correo electronico no debe exceder los 255 caracteres",
            'email.unique' => "Correo Electronico ya registrado",
            'nombre.required' => "El Nombre es obligatorio",
            'nombre.max' => "El Nombre no debe de exceder los 255 caracteres",
        ]);

        $institucion = 
            DB::table("instituciones as i")
            ->select(
                "i.tag"
            )
            ->where("i.id","=",session('id_institucion'))
            ->first()
        ;

        $tag = $institucion->tag;

        if (!str_starts_with($datosUsuario['nombre_usuario'], $tag) && $datosUsuario['nombre_usuario'] != null){
            $validator->after(function ($validator) use ($tag){
                $validator->errors()->add('nombre_usuario', "El Nombre de Usuario debe iniciar con el prefijo '{$tag}'.");
            });
        }

        if (str_contains($datosUsuario['nombre_usuario'], ' ') && $datosUsuario['nombre_usuario'] != null) {
            $validator->after(function ($validator){
                $validator->errors()->add('nombre_usuario', "El Nombre de Usuario no puede contener espacios.");
            });
        }

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

        //Mail::to($datosUsuario['email'])->send(new UsuarioCreadoMail($datosUsuario['nombre_usuario'],$contrasena)->from('hola.gamma.web@gmail.com','Administracion'));

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
            'nombre_usuario' => "required|string|max:255",
            'nombre' => "required|string|max:255",
        ],[
            'nombre_usuario.required' => "El Nombre de Usuario es obligatorio",
            'nombre_usuario.max' => "El Nombre de Usuario no debe de exceder los 255 caracteres",
            'nombre.required' => "El Nombre es obligatorio",
            'nombre.max' => "El Nombre no debe de exceder los 255 caracteres",
        ]);

        $institucion = 
            DB::table("instituciones as i")
            ->select(
                "i.tag"
            )
            ->where("i.id","=",session('id_institucion'))
            ->first()
        ;

        $tag = $institucion->tag;

        if (!str_starts_with($datosUsuario['nombre_usuario'], $tag) && $datosUsuario['nombre_usuario'] != null){
            $validator->after(function ($validator) use ($tag){
                $validator->errors()->add('nombre_usuario', "El Nombre de Usuario debe iniciar con el prefijo '{$tag}'.");
            });
        }

        $infoAnterior = Usuario::where('id','=',$id)->first();

        $existe = 
            Usuario::where('nombre_usuario',"=",$datosUsuario['nombre_usuario'])->where('nombre_usuario','!=',$infoAnterior['nombre_usuario'])->first();
        ;

        if ($existe){
            $validator->after(function ($validator){
                $validator->errors()->add('nombre_usuario', "Nombre de Usuario ya existente.");
            });
        }

        if (str_contains($datosUsuario['nombre_usuario'], ' ') && $datosUsuario['nombre_usuario'] != null) {
            $validator->after(function ($validator){
                $validator->errors()->add('nombre_usuario', "El Nombre de Usuario no puede contener espacios.");
            });
        }

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

    public function archivoCarga(){

        return Excel::download(new ArchivoUsuariosExport, 'usuarios.xlsx');
    } 

    public function actualizarContrasena(Request $request)
    {
        $request->validate([
            'contrasenaActual' => 'required',
            'nuevaContrasena' => 'required',
            'validarContrasena' => 'required'
        ],[
            'contrasenaActual.required' => 'Debes ingresar la contraseña actual',
            'nuevaContrasena.required' => 'Debes ingresar la nueva contraseña',
            'validarContrasena.required' => 'Debes validar la nueva contraseña'
        ]);

        $usuario = DB::table('usuarios as u')->where('u.id','=',session('id_usuario'))->first();

        if (!Hash::check($request->contrasenaActual, $usuario->contrasena)) return back()->with('error', 'La contrasena actual no es correcta');

        if ($request->nuevaContrasena != $request->validarContrasena) return back()->with('error', 'Error al validar la contraseña');

        DB::table('usuarios')
        ->where('id', session('id_usuario'))
        ->update(['contrasena' => Hash::make($request->nuevaContrasena)]);

        return back()->with('success', '¡Contraseña actualizada correctamente!');
    }

    public function exportarUsuarios()
    {
        
        return Excel::download(new InformacionUsuariosExport(session('id_institucion')), 'informacion_usuarios.xlsx');
    }
}
