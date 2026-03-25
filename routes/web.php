<?php

use App\Http\Controllers\CargaInventarioController;
use App\Http\Controllers\CargaLaboratoriosController;
use App\Http\Controllers\CargaMaterialesController;
use App\Http\Controllers\CargaUsuariosController;
use App\Http\Controllers\GrupoController;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\LaboratorioController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

Route::middleware('check.login')->group(function (){

    Route::get('/admin', function(){
        return view('Admin.indexAdmin');
    });

    Route::resource('/admin/usuarios', UsuarioController::class)->names('admin.usuarios');

    Route::post('/admin/usuarios/{id}/cambiar-contrasena',[UsuarioController::class, 'cambioContrasena'])->name('admin.usuarios.cambiarContrasena');

    Route::get('/api/usuarios', function (Illuminate\Http\Request $request){
        $query = 
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
            ->where(function ($buscador) use ($request){
                $buscador->where("u.nombre_usuario","ilike","%".$request->texto."%")
                ->orWhere("u.email","ilike","%".$request->texto."%")
                ->orWhere("u.nombre","ilike","%".$request->texto."%");
            })
        ;

        if ($request->tipoUsuario != "Sin Filtro"){
            $query->where("u.".$request->tipoUsuario,"=","1");
        }

        if ($request->grupo != "Sin Filtro"){
            $query->where("u.id_grupo","=",$request->grupo);
        }

        $query->where('u.id_institucion',"=",session("id_institucion"));
        $query->where("u.admin","!=","1");

        $query->orderBy("u.id","ASC")->orderBy("u.created_at","DESC");

        $usuarios = $query->get();
            
        return response()->json($usuarios);
    });

    Route::get('/api/usuarios/editar', function (Illuminate\Http\Request $request){

        $datos["usuario"] =
            DB::table("usuarios as u")
            ->leftJoin("grupos as g","g.id","=","u.id_grupo")
            ->select(
                "u.id",
                "u.nombre_usuario",
                "u.nombre",
                "u.email",
                "u.normal",
                "u.encargado",
                "u.mantenimiento",
                "u.id_grupo",
                "g.nombre as nombreGrupo"
            )
            ->where("u.id","=",$request->id)
            ->first()
        ;

        $datos["grupos"] = 
            DB::table("grupos as g")
            ->select(
                "g.id",
                "g.nombre",
                "g.grado",
                "g.grupo"
            )
            ->where("g.id_institucion","=",session("id_institucion"))
            ->get()
        ;

        return response()->json($datos);
    });

    Route::resource('/admin/laboratorios', LaboratorioController::class)->names('admin.laboratorios');

    Route::get('/api/laboratorios', function(Illuminate\Http\Request $request){

        $query = 
            DB::table("laboratorios as l")
            ->select(
                "l.id",
                "l.nombre",
                "l.tipo",
                "l.cantidad_computadoras"
            )
            ->where("l.nombre","ilike","%".$request->texto."%")
        ;

        if ($request->tipo != "Sin Filtro"){
            $query->where("l.tipo","=",$request->tipo);
        }

        $query->where("l.id_institucion","=",session("id_institucion"));

        $query->orderBy("l.nombre","ASC")->orderBy("l.created_at","DESC");

        $laboratorios = $query->get();

        return response()->json($laboratorios);
    });

    Route::get('/api/laboratorios/editar', function (Illuminate\Http\Request $request){

        $laboratorio = 
            DB::table("laboratorios as l")
            ->select(
                "l.id",
                "l.nombre",
                "l.tipo",
                "l.cantidad_computadoras"
            )
            ->where("l.id","=",$request->id)
            ->first()
        ;

        return response()->json($laboratorio);
    });

    Route::resource('/admin/grupos', GrupoController::class)->names('admin.grupos');

    Route::get('/api/grupos/laboratorio', function (Illuminate\Http\Request $request){
        $laboratorio = 
            DB::table("laboratorios as l")
            ->select(
                "l.nombre"
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
                "g.nombre",
                "g.grado",
                "g.grupo",
                "g.laboratorios"
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
                "g.nombre",
                "g.grado",
                "g.grupo",
                "g.laboratorios"
            )
            ->where("g.id_institucion","=",session("id_institucion"))
            ->where(function ($buscador) use ($request){
                $buscador->where("g.nombre","ilike","%".$request->texto."%")
                ->orwhere("g.grado","ilike","%".$request->texto."%")
                ->orwhere("g.grupo","ilike","%".$request->texto."%");
            })
            ->orderBy("g.nombre","ASC")
            ->orderBy("g.created_at","DESC")
            ->get()
        ;

        return response()->json($grupos);
    });

    Route::resource('/admin/materiales', MaterialController::class)->names('admin.materiales');

    Route::get('/api/materiales/editar', function (Illuminate\Http\Request $request){

        $material = 
            DB::table("materiales as m")
            ->select(
                "m.id",
                "m.nombre",
                "m.descripcion",
                "m.tipo"
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
                "m.nombre",
                "m.descripcion",
                "m.tipo"
            )
            ->where("m.nombre","ilike","%".$request->texto."%")
            ->where("m.id_institucion","=",session("id_institucion"))
        ;

        if ($request->filtro != "Sin Filtro"){
            $query->where("m.tipo","=",$request->filtro);
        }

        $query->orderBy("m.nombre","ASC")->orderBy("m.created_at","DESC");

        $materiales = $query->get();

        return response()->json($materiales);
    });

    Route::resource('/admin/inventario', InventarioController::class)->names('admin.inventario');

    Route::get('/api/inventario/editar', function (Illuminate\Http\Request $request){
        $datos["inventario"] = 
            DB::table("inventarios as i")
            ->select(
                "i.id",
                "i.id_material",
                "i.id_laboratorio",
                "i.cantidad_disponible",
                "i.cantidad_total"
            )
            ->where("i.id","=",$request->id)
            ->first()
        ;

        $datos["materiales"] = 
            DB::table("materiales as m")
            ->select(
                "m.id",
                "m.nombre"
            )
            ->where("m.id_institucion","=",session("id_institucion"))
            ->orderBy("m.nombre","ASC")
            ->orderBy("m.created_at","DESC")
            ->get()
        ;

        $datos["laboratorios"] = 
            DB::table("laboratorios as l")
            ->select(
                "l.id",
                "l.nombre"
            )
            ->where('l.id_institucion',"=",session("id_institucion"))
            ->where("l.tipo","=","prestamos")
            ->orderBy("l.nombre","ASC")
            ->orderBy("l.created_at","DESC")
            ->get()
        ;

        return response()->json($datos);
    });

    Route::get('/api/inventario', function (Illuminate\Http\Request $request){

        $query = 
            DB::table("inventarios as i")
            ->join("materiales as m","m.id","=","i.id_material")
            ->join("laboratorios as l","l.id","=","i.id_laboratorio")
            ->select(
                "i.id",
                "m.nombre as nombreMaterial",
                "i.cantidad_total",
                "l.nombre as nombreLaboratorio"
            )
            ->where("m.nombre","ilike","%".$request->texto."%")
        ;

        if ($request->filtro != "Sin Filtro"){
            $query->where("i.id_laboratorio","=",$request->filtro);
        }

        $query->where("l.id_institucion","=",session("id_institucion"));

        $query->orderBy("l.nombre","ASC")->orderBy("m.nombre","ASC")->orderBy("i.created_at","DESC");

        $inventarios = $query->get();

        return response()->json($inventarios);
    });

    Route::post('/carga-usuario', [CargaUsuariosController::class, 'cargaMasivaUsuarios']);

    Route::post('/carga-laboratorio', [CargaLaboratoriosController::class, 'cargaMasivaLaboratorios']);

    Route::post('/carga-materiales', [CargaMaterialesController::class, 'cargaMasivaMateriales']);

    Route::post('/carga-inventario', [CargaInventarioController::class, 'cargaMasivaInventario']);

    Route::get('/archivo-inventario', [InventarioController::class, 'archivoCarga']);

    Route::get('/archivo-materiales', [MaterialController::class, 'archivoCarga']);

    Route::get('/archivo-laboratorios', [LaboratorioController::class, 'archivoCarga']);

    Route::get('/archivo-usuarios', [UsuarioController::class, 'archivoCarga']);
});

Route::get('/Generar/Hash/Contrasenas/Administradores', function(){
    $contrasena = Hash::make('hola');
    
    return response()->json($contrasena);
});

Route::get('/', function () {
    session()->forget(['id_usuario', 'id_institucion']);
    
    return view('index');
});

Route::get('/materiales', function(){
    return view('Normal.materiales');
})->name('materiales');

Route::get('/solicitudes', function(){
    return view('Normal.solicitudes');
})->name('solicitudes');

Route::get('/laboratorios', function(){
    return view('Normal.laboratorios');
})->name('laboratorios');

Route::get('/reportes', function(){
    return view('Encargado_Mantenimiento.index');
})->name('reportes');

Route::get('/solicitudes-pendientes', function(){
    return view('Encargado_Area.solicitudes-pendientes');
})->name('solicitudes-pendientes');

Route::get('/solicitudes-aceptadas', function(){
    return view('Encargado_Area.solicitudes-aceptadas');
})->name('solicitudes-aceptadas');

Route::get('/solicitudes-pendientes-computo', function(){
    return view('Encargado_Area.solicitudes-pendientes-computo');
})->name('solicitudes-pendientes-computo');

Route::get('/solicitudes-aceptadas-computo', function(){
    return view('Encargado_Area.solicitudes-aceptadas-computo');
})->name('solicitudes-aceptadas-computo');

Route::get('/login', [LoginController::class, 'index'])->name('login.index');

Route::post('/login', [LoginController::class, 'login'])->name('login.login');

Route::post('/logout', [LoginController::class, 'logout'])->middleware('check.login');