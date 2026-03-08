<?php

use App\Http\Controllers\CargaUsuariosController;
use App\Http\Controllers\GrupoController;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\LaboratorioController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\LoginController;
use App\Models\Inventario;
use App\Models\Laboratorio;
use App\Models\Usuario;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

Route::middleware('check.login')->group(function (){

    Route::get('/Admin', function(){
        return view('Admin.indexAdmin');
    });

    Route::resource('/Admin/Usuarios', UsuarioController::class)->names('admin.usuarios');

    Route::post('/Admin/Usuarios/{id}/cambiar-contrasena',[UsuarioController::class, 'cambioContrasena'])->name('admin.usuarios.cambiarContrasena');

    Route::get('/api/usuarios', function (Illuminate\Http\Request $request){
        $query = 
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
            ->where(function ($buscador) use ($request){
                $buscador->where("u.Nombre_Usuario","ilike","%".$request->texto."%")
                ->orWhere("u.Email","ilike","%".$request->texto."%")
                ->orWhere("u.Nombre","ilike","%".$request->texto."%");
            })
        ;

        if ($request->tipoUsuario != "Sin Filtro"){
            $query->where("u.Tipo_Usuario","=",$request->tipoUsuario);
        }

        if ($request->grupo != "Sin Filtro"){
            $query->where("u.ID_Grupo","=",$request->grupo);
        }

        $query->where('u.ID_Institucion',"=",session("id_institucion"));
        $query->where("u.Tipo_Usuario","!=","Admin");

        $query->orderBy("u.id","ASC")->orderBy("u.created_at","DESC");

        $usuarios = $query->get();
            
        return response()->json($usuarios);
    });

    Route::get('/api/usuarios/editar', function (Illuminate\Http\Request $request){

        $datos["usuario"] =
            DB::table("usuarios as u")
            ->leftJoin("grupos as g","g.id","=","u.ID_Grupo")
            ->select(
                "u.id",
                "u.Nombre_Usuario",
                "u.Nombre",
                "u.Email",
                "u.Tipo_Usuario",
                "u.ID_Grupo",
                "g.Nombre as nombreGrupo"
            )
            ->where("u.id","=",$request->id)
            ->first()
        ;

        $datos["grupos"] = 
            DB::table("grupos as g")
            ->select(
                "g.id",
                "g.Nombre",
                "g.Grado",
                "g.Grupo"
            )
            ->where("g.ID_Institucion","=",session("id_institucion"))
            ->get()
        ;

        return response()->json($datos);
    });

    Route::resource('/Admin/Laboratorios', LaboratorioController::class)->names('admin.laboratorios');

    Route::get('/api/laboratorios', function(Illuminate\Http\Request $request){

        $query = 
            DB::table("laboratorios as l")
            ->select(
                "l.id",
                "l.Nombre",
                "l.Tipo",
                "l.Cantidad_Computadoras"
            )
            ->where("l.Nombre","ilike","%".$request->texto."%")
        ;

        if ($request->tipo != "Sin Filtro"){
            $query->where("l.Tipo","=",$request->tipo);
        }

        $query->where("l.ID_Institucion","=",session("id_institucion"));

        $query->orderBy("l.Nombre","ASC")->orderBy("l.created_at","DESC");

        $laboratorios = $query->get();

        return response()->json($laboratorios);
    });

    Route::get('/api/laboratorios/editar', function (Illuminate\Http\Request $request){

        $laboratorio = 
            DB::table("laboratorios as l")
            ->select(
                "l.id",
                "l.Nombre",
                "l.Tipo",
                "l.Cantidad_Computadoras"
            )
            ->where("l.id","=",$request->id)
            ->first()
        ;

        return response()->json($laboratorio);
    });

    Route::resource('/Admin/Grupos', GrupoController::class)->names('admin.grupos');

    Route::get('/api/grupos/laboratorio', function (Illuminate\Http\Request $request){
        $laboratorio = 
            DB::table("laboratorios as l")
            ->select(
                "l.Nombre"
            )
            ->where("l.id","=",$request->id)
            ->first()
        ;

        return response()->json($laboratorio);
    });

    Route::get('/api/grupos/editar', function (Illuminate\Http\Request $request){
        $grupo = 
            DB::table("grupos as g")
            ->select(
                "g.id",
                "g.Nombre",
                "g.Grado",
                "g.Grupo",
                "g.Laboratorios"
            )
            ->where("g.id","=",$request->id)
            ->first()
        ;

        return response()->json($grupo);
    });

    Route::get('/api/grupos', function (Illuminate\Http\Request $request){
        $grupos = 
            DB::table("grupos as g")
            ->select(
                "g.id",
                "g.Nombre",
                "g.Grado",
                "g.Grupo",
                "g.Laboratorios"
            )
            ->where("g.ID_Institucion","=",session("id_institucion"))
            ->where(function ($buscador) use ($request){
                $buscador->where("g.Nombre","ilike","%".$request->texto."%")
                ->orwhere("g.Grado","ilike","%".$request->texto."%")
                ->orwhere("g.Grupo","ilike","%".$request->texto."%");
            })
            ->orderBy("g.Nombre","ASC")
            ->orderBy("g.created_at","DESC")
            ->get()
        ;

        return response()->json($grupos);
    });

    Route::resource('/Admin/Materiales', MaterialController::class)->names('admin.materiales');

    Route::get('/api/materiales/editar', function (Illuminate\Http\Request $request){

        $material = 
            DB::table("materiales as m")
            ->select(
                "m.id",
                "m.Nombre",
                "m.Descripcion",
                "m.Tipo"
            )
            ->where("m.id","=",$request->id)
            ->first()
        ;

        return response()->json($material);
    });

    Route::get('/api/materiales', function (Illuminate\Http\Request $request){

        $query = 
            DB::table("materiales as m")
            ->select(
                "m.id",
                "m.Nombre",
                "m.Descripcion",
                "m.Tipo"
            )
            ->where("m.Nombre","ilike","%".$request->texto."%")
            ->where("m.ID_Institucion","=",session("id_institucion"))
        ;

        if ($request->filtro != "Sin Filtro"){
            $query->where("m.Tipo","=",$request->filtro);
        }

        $query->orderBy("m.Nombre","ASC")->orderBy("m.created_at","DESC");

        $materiales = $query->get();

        return response()->json($materiales);
    });

    Route::resource('/Admin/Inventario', InventarioController::class)->names('admin.inventario');

    Route::get('/api/inventario/editar', function (Illuminate\Http\Request $request){
        $datos["inventario"] = 
            DB::table("inventarios as i")
            ->select(
                "i.id",
                "i.ID_Material",
                "i.ID_Laboratorio",
                "i.Cantidad_Disponible",
                "i.Cantidad_Total"
            )
            ->where("i.id","=",$request->id)
            ->first()
        ;

        $datos["materiales"] = 
            DB::table("materiales as m")
            ->select(
                "m.id",
                "m.Nombre"
            )
            ->where("m.ID_Institucion","=",session("id_institucion"))
            ->orderBy("m.Nombre","ASC")
            ->orderBy("m.created_at","DESC")
            ->get()
        ;

        $datos["laboratorios"] = 
            DB::table("laboratorios as l")
            ->select(
                "l.id",
                "l.Nombre"
            )
            ->where('l.ID_Institucion',"=",session("id_institucion"))
            ->where("l.Tipo","=","Prestamos")
            ->orderBy("l.Nombre","ASC")
            ->orderBy("l.created_at","DESC")
            ->get()
        ;

        return response()->json($datos);
    });

    Route::get('/api/inventario', function (Illuminate\Http\Request $request){

        $query = 
            DB::table("inventarios as i")
            ->join("materiales as m","m.id","=","i.ID_Material")
            ->join("laboratorios as l","l.id","=","i.ID_Laboratorio")
            ->select(
                "i.id",
                "m.Nombre as nombreMaterial",
                "i.Cantidad_Total",
                "l.Nombre as nombreLaboratorio"
            )
            ->where("m.Nombre","ilike","%".$request->texto."%")
        ;

        if ($request->filtro != "Sin Filtro"){
            $query->where("i.ID_Laboratorio","=",$request->filtro);
        }

        $query->where("l.ID_Institucion","=",session("id_institucion"));

        $query->orderBy("l.Nombre","ASC")->orderBy("m.Nombre","ASC")->orderBy("i.created_at","DESC");

        $inventarios = $query->get();

        return response()->json($inventarios);
    });

    Route::post('/cargaUsuario', [CargaUsuariosController::class, 'cargarMasivaUsuarios']);
});

Route::get('/Generar/Hash/Contrasenas/Administradores', function(){
    $contrasena = Hash::make('hola');
    
    return response()->json($contrasena);
});

Route::get('/Login', [LoginController::class, 'index'])->name('login.index');

Route::post('/Login', [LoginController::class, 'login'])->name('login.login');

Route::post('/Logout', [LoginController::class, 'logout'])->middleware('check.login');