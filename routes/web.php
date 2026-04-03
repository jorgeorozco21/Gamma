<?php

use App\Http\Controllers\AuditoriaController;
use App\Http\Controllers\AuditoriaComputoController;
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
use App\Http\Controllers\SolicitudEliminadaController;
use App\Http\Controllers\SolicitudesComputoController;
use App\Http\Controllers\SolicitudesController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

use function Laravel\Prompts\select;

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

Route::get('/usuario/normal/laboratorios', function(){

    $labAcceso = 
        DB::table('usuarios as u')
        ->join('grupos as g','g.id','=','u.id_grupo')
        ->select(
            'g.laboratorios'
        )
        ->where('u.id','=',session('id_usuario'))
        ->first()
    ;

    $idLaboratorios = explode(',',$labAcceso->laboratorios);

    $laboratorios = [];
    foreach ($idLaboratorios as $id){
        $infoLab = 
            DB::table('laboratorios as l')
            ->select(
                'l.id',
                'l.nombre',
                'l.tipo'
            )
            ->where('l.id','=',$id)
            ->first()
        ;

        $laboratorios[] = $infoLab;
    }

    return view('Normal.laboratorios', compact('laboratorios'));
})->name('laboratorios');

Route::get('/usuario/normal/laboratorios/{id}-laboratorio-normal', function($id){

    $laboratorio =
        DB::table('laboratorios as l')
        ->select(
            'l.id',
            'l.nombre'
        )
        ->where('l.id','=',$id)
        ->first()
    ;

    $materiales = 
        DB::table('inventarios as i')
        ->join('materiales as m','m.id','=','i.id_material')
        ->select(
            'i.id',
            'i.cantidad_disponible',
            'i.cantidad_total',
            'm.nombre',
            'm.descripcion',
            'm.tipo'
        )
        ->where('i.id_laboratorio','=',$id)
        ->get()
    ;

    $usuario = 
        DB::table('usuarios as u')
        ->join('grupos as g','g.id','=','u.id_grupo')
        ->select(
            "u.id",
            "u.nombre",
            "u.email",
            "g.grado",
            "g.grupo",
            "g.nombre as nombreGrupo"
        )
        ->where('u.id','=',session("id_usuario"))
        ->first()
    ;

    return view('Normal.materiales',compact('laboratorio','materiales','usuario'));
})->name('materiales');

Route::get('/usuario/normal/materiales', function (Illuminate\Http\Request $request){

    $materiales = 
        DB::table('inventarios as i')
        ->join('materiales as m','m.id','=','i.id_material')
        ->select(
            'i.id',
            'i.cantidad_disponible',
            'i.cantidad_total',
            'm.nombre',
            'm.descripcion',
            'm.tipo'
        )
        ->where('m.nombre','ilike','%'.$request->texto.'%')
        ->where('i.id_laboratorio','=',$request->idLab)
        ->get()
    ;

    return response()->json($materiales);
});

Route::get('/usuario/normal/laboratorios/{id}-solicitudes', function($id){

    $laboratorio =
        DB::table('laboratorios as l')
        ->select(
            'l.id',
            'l.nombre'
        )
        ->where('l.id','=',$id)
        ->first()
    ;

    $solicitudes_eliminadas = 
        DB::table('solicitudes_eliminadas as s')
        ->select(
            's.id',
            's.id_solicitud',
            's.fecha'
        )
        ->where('s.id_usuario','=',session('id_usuario'))
        ->where('s.id_laboratorio','=',$id)
        ->get()
    ;

    $solicitudes = 
        DB::table('solicitudes as s')
        ->leftJoin('auditoria as a', function($join) {
            $join->on('s.id', '=', 'a.id_solicitud')
                ->whereRaw('a.id = (SELECT MAX(id) FROM auditoria WHERE id_solicitud = s.id)');
        })
        ->select(
            's.id',
            's.fecha',
            'a.estado'
        )
        ->where('s.info_usuario->idLaboratorio','=',$id)
        ->where('s.info_usuario->id','=',session('id_usuario'))
        ->get()
    ;

    return view('Normal.solicitudes',compact('laboratorio','solicitudes','solicitudes_eliminadas'));
})->name('solicitudes');

Route::get('/usuario/normal/laboratorio/informacion-solicitud', function (Illuminate\Http\Request $request){

    $materiales = 
        DB::table('solicitudes as s')
        ->select(
            's.info_material'
        )
        ->where('s.id','=',$request->id)
        ->first()
    ;

    return response()->json($materiales);

});

Route::get('/usuario/normal/actualizar-solicitudes', function (Illuminate\Http\Request $request){

    $datos['solicitudes'] = 
        DB::table('solicitudes as s')
        ->leftJoin('auditoria as a', function($join) {
            $join->on('s.id', '=', 'a.id_solicitud')
                ->whereRaw('a.id = (SELECT MAX(id) FROM auditoria WHERE id_solicitud = s.id)');
        })
        ->select(
            's.id',
            's.fecha',
            'a.estado'
        )
        ->where('s.info_usuario->idLaboratorio','=',$request->id)
        ->where('s.info_usuario->id','=',session('id_usuario'))
        ->get()
    ;

    $datos['solicitudes_eliminadas'] = 
        DB::table('solicitudes_eliminadas as s')
        ->select(
            's.id',
            's.id_solicitud',
            's.fecha'
        )
        ->where('s.id_usuario','=',session('id_usuario'))
        ->where('s.id_laboratorio','=',$request->id)
        ->get()
    ;

    return response()->json($datos);
});

Route::post('/usuario/normal/crear-solicitud', [SolicitudesController::class, 'store']);

Route::delete('/usuario/normal/eliminar-solicitud/{id}', [SolicitudesController::class, 'destroy']);

Route::delete('/usuario/normal/eliminar-solicitud-eliminada/{id}', [SolicitudEliminadaController::class, 'destroy']);

Route::get('/usuario/normal/laboratorios/{id}-laboratorio-computo', function($id){

    $infoLaboratorio = 
        DB::table('laboratorios as l')
        ->select(
            'l.id',
            'l.nombre',
            'l.cantidad_computadoras'
        )
        ->where('l.id','=',$id)
        ->first()
    ;

    $reportes = 
        DB::table('solicitudes_computo as s')
        ->select(
            's.numero_computadora',
            DB::raw('COUNT(*) as cantidad_reportes')
        )
        ->whereNotExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('auditoria_computo as a')
                ->whereColumn('a.id_solicitud', 's.id')
                ->where('a.estado', '=', 'completado');
        })
        ->where('s.id_laboratorio','=',$id)
        ->groupBy('s.numero_computadora')
        ->get()
        ->pluck('cantidad_reportes','numero_computadora')
    ;

    return view('Normal.solicitudes-computo', compact('infoLaboratorio', 'reportes'));
})->name('solicitudes-computo');

Route::get('/usuario/normal/laboratorios/obtener-reportes-computo', function (Illuminate\Http\Request $request){
    
    $reportes = 
        DB::table('solicitudes_computo as s')
        ->select(
            's.descripcion'
        )
        ->where('s.numero_computadora','=',$request->id)
        ->where('s.id_laboratorio','=',$request->idLaboratorio)
        ->whereNotExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('auditoria_computo as a')
                ->whereColumn('a.id_solicitud', 's.id')
                ->where('a.estado', '=', 'completado');
        })
        ->get()
    ;

    return response()->json($reportes);
});

Route::post('/usuario/normal/laboratorios/solicitud-computo', [SolicitudesComputoController::class, 'store']);

Route::get('/usuario/encargado/solicitudes-pendientes', function(){

    $laboratorios = 
        DB::table('laboratorios as l')
        ->select(
            'l.id',
            'l.nombre'
        )
        ->where('l.id_institucion','=',session('id_institucion'))
        ->where('l.tipo','=','prestamos')
        ->get()
    ;

    $usuario = 
        DB::table('usuarios as u')
        ->select(
            'u.id',
            'u.nombre',
            'u.email'
        )   
        ->where("u.id","=",session('id_usuario'))
        ->first()
    ;

    $solicitudes = 
        DB::table('solicitudes as s')
        ->join('laboratorios as l', function($join) {
            $join->on(
                DB::raw("CAST(s.info_usuario->>'idLaboratorio' AS INTEGER)"), 
                '=', 
                'l.id'
            );
        })
        ->select(
            's.id',
            's.fecha',
            's.info_usuario',
            's.info_material'
        )
        ->where('l.id_institucion', '=', session('id_institucion'))
        ->whereNotExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('auditoria as a')
                ->whereColumn('a.id_solicitud', 's.id');
        })
        ->get()
    ;

    return view('Encargado_Area.solicitudes-pendientes', compact('solicitudes','usuario','laboratorios'));
})->name('solicitudes-pendientes');

Route::get('/api/usuario/encargado/solicitudes-pendientes', function(Illuminate\Http\Request $request){
    $consulta = 
        DB::table('solicitudes as s')
        ->join('laboratorios as l', function($join) {
            $join->on(
                DB::raw("CAST(s.info_usuario->>'idLaboratorio' AS INTEGER)"), 
                '=', 
                'l.id'
            );
        })
        ->select(
            's.id',
            's.fecha',
            's.info_usuario',
            's.info_material'
        )
        ->where('l.id_institucion', '=', session('id_institucion'))
        ->whereNotExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('auditoria as a')
                ->whereColumn('a.id_solicitud', 's.id');
        })
    ;

    if ($request->filtro != "Sin Filtro"){
        $consulta->where(DB::raw("s.info_usuario->>'idLaboratorio'"), '=', $request->filtro);
    }

    if ($request->texto) {
        $consulta->where(function($q) use ($request) {
            $term = '%' . $request->texto . '%';
            $q->where(DB::raw("CAST(s.id AS TEXT)"), 'ilike', $term)
            ->orWhere(DB::raw("s.info_usuario->>'nombre'"), 'ilike', $term);
        });
    }

    $solicitudes = $consulta->get();

    return response()->json($solicitudes);
});

Route::post('/usuario/encargado/actualizar-solicitudes', [AuditoriaController::class, 'store']);

Route::post('/usuario/encargado/rechazar-solicitud-prestamos/{id}', [SolicitudEliminadaController::class, 'store']);

Route::get('/usuario/encargado/solicitudes-aceptadas', function(){

    $laboratorios = 
        DB::table('laboratorios as l')
        ->select(
            'l.id',
            'l.nombre'
        )
        ->where('l.id_institucion','=',session('id_institucion'))
        ->where('l.tipo','=','prestamos')
        ->get()
    ;

    $usuario = 
        DB::table('usuarios as u')
        ->select(
            'u.id',
            'u.nombre',
            'u.email'
        )   
        ->where("u.id","=",session('id_usuario'))
        ->first()
    ;

    $solicitudes = 
        DB::table('solicitudes as s')
        ->join('auditoria as a', function($join) {
            $join->on('s.id', '=', 'a.id_solicitud')
                ->whereRaw('a.id = (SELECT MAX(id) FROM auditoria WHERE id_solicitud = s.id)');
        })
        ->join('laboratorios as l', function($join) {
            $join->on(
                DB::raw("CAST(s.info_usuario->>'idLaboratorio' AS INTEGER)"), 
                '=', 
                'l.id'
            );
        })
        ->select(
            's.id',
            's.fecha',
            's.info_usuario',
            's.info_material',
            'a.estado'
        )
        ->where('a.estado','!=','recibido')
        ->where('l.id_institucion', '=', session('id_institucion'))
        ->get()
    ;

    return view('Encargado_Area.solicitudes-aceptadas', compact('laboratorios','solicitudes','usuario'));
})->name('solicitudes-aceptadas');

Route::get('/api/usuario/encargado/solicitudes-aceptadas', function(Illuminate\Http\Request $request){
    $consulta = 
        DB::table('solicitudes as s')
        ->join('auditoria as a', function($join) {
            $join->on('s.id', '=', 'a.id_solicitud')
                ->whereRaw('a.id = (SELECT MAX(id) FROM auditoria WHERE id_solicitud = s.id)');
        })
        ->join('laboratorios as l', function($join) {
            $join->on(
                DB::raw("CAST(s.info_usuario->>'idLaboratorio' AS INTEGER)"), 
                '=', 
                'l.id'
            );
        })
        ->select(
            's.id',
            's.fecha',
            's.info_usuario',
            's.info_material',
            'a.estado'
        )
        ->where('a.estado','!=','recibido')
        ->where('l.id_institucion', '=', session('id_institucion'))
    ;

    if ($request->filtro != "Sin Filtro"){
        $consulta->where(DB::raw("s.info_usuario->>'idLaboratorio'"), '=', $request->filtro);
    }

    if ($request->texto) {
        $consulta->where(function($q) use ($request) {
            $term = '%' . $request->texto . '%';
            $q->where(DB::raw("CAST(s.id AS TEXT)"), 'ilike', $term)
            ->orWhere(DB::raw("s.info_usuario->>'nombre'"), 'ilike', $term);
        });
    }

    $solicitudes = $consulta->get();

    return response()->json($solicitudes);
});

Route::get('/usuario/encargado/solicitudes-pendientes-computo', function(){

    $laboratorios = 
        DB::table('laboratorios as l')
        ->select(
            'l.id',
            'l.nombre'
        )
        ->where('l.id_institucion','=',session('id_institucion'))
        ->where('l.tipo','=','computo')
        ->get()
    ;

    $usuario = 
        DB::table('usuarios as u')
        ->select(
            'u.id',
            'u.nombre',
            'u.email'
        )   
        ->where("u.id","=",session('id_usuario'))
        ->first()
    ;

    $reportes = 
        DB::table('solicitudes_computo as s')
        ->join('laboratorios as l','l.id','=','s.id_laboratorio')
        ->select(
            's.id',
            's.numero_computadora',
            'l.nombre',
            's.descripcion',
            's.fecha'
        )
        ->where('l.id_institucion','=',session('id_institucion'))
        ->whereNotExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('auditoria_computo as a')
                ->whereColumn('a.id_solicitud', 's.id');
        })
        ->get()
    ;

    return view('Encargado_Area.solicitudes-pendientes-computo', compact('laboratorios','reportes','usuario'));
})->name('solicitudes-pendientes-computo');

Route::get('/usuario/encargado/reportes-computo', function(Illuminate\Http\Request $request){

    $reportes = 
        DB::table('solicitudes_computo as s')
        ->select(
            's.descripcion'
        )
        ->where('s.numero_computadora','=',$request->id)
        ->where('s.id','<',$request->idSolicitud)
        ->where(function($query) {
        $query->selectRaw('count(*)')
                ->from('auditoria_computo as a')
                ->whereColumn('a.id_solicitud', 's.id');
        }, '<', 3)
        ->get()
    ;

    return response()->json($reportes);
});

Route::post('/usuario/encargado/actualizar-solicitudes-computo', [AuditoriaComputoController::class, 'store']);

Route::delete('/usuario/encargado/rechazar-solicitud-computo/{id}', [SolicitudesComputoController::class, 'destroy']);

Route::get('/api/usuario/encargado/solicitudes-pendientes-computo', function (Illuminate\Http\Request $request){
    $consulta = 
        DB::table('solicitudes_computo as s')
        ->join('laboratorios as l','l.id','=','s.id_laboratorio')
        ->select(
            's.id',
            's.numero_computadora',
            'l.nombre',
            's.descripcion',
            's.fecha'
        )
        ->where('l.id_institucion','=',session('id_institucion'))
        ->whereNotExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('auditoria_computo as a')
                ->whereColumn('a.id_solicitud', 's.id');
        })
    ;

    if ($request->filtro != "Sin Filtro"){
        $consulta->where(DB::raw("s.id_laboratorio"), '=', $request->filtro);
    }

    if ($request->texto) {
        $consulta->where(function($q) use ($request) {
            $term = '%' . $request->texto . '%';
            $q->where(DB::raw("CAST(s.id AS TEXT)"), 'ilike', $term)
            ->orWhere(DB::raw("s.numero_computadora"), 'ilike', $term);
        });
    }

    $reportes = $consulta->get();

    return response()->json($reportes);
});

Route::get('/solicitudes-aceptadas-computo', function(){

    $laboratorios = 
        DB::table('laboratorios as l')
        ->select(
            'l.id',
            'l.nombre'
        )
        ->where('l.id_institucion','=',session('id_institucion'))
        ->where('l.tipo','=','computo')
        ->get()
    ;

    $usuario = 
        DB::table('usuarios as u')
        ->select(
            'u.id',
            'u.nombre',
            'u.email'
        )   
        ->where("u.id","=",session('id_usuario'))
        ->first()
    ;

    $reportes = 
        DB::table('solicitudes_computo as s')
        ->join('laboratorios as l','l.id','=','s.id_laboratorio')
        ->select(
            's.id',
            's.numero_computadora',
            'l.nombre',
            's.descripcion',
            's.fecha',
            DB::raw('(SELECT estado FROM auditoria_computo 
                WHERE id_solicitud = s.id 
                ORDER BY id DESC LIMIT 1) as estado')
        )
        ->where('l.id_institucion','=',session('id_institucion'))
        ->whereRaw('(SELECT estado FROM auditoria_computo 
                WHERE id_solicitud = s.id 
                ORDER BY id DESC LIMIT 1) != ?', ['completado'])
        ->whereExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('auditoria_computo as a')
                ->whereColumn('a.id_solicitud', 's.id');
        })
        ->get()
    ;

    return view('Encargado_Area.solicitudes-aceptadas-computo', compact('laboratorios','usuario','reportes'));
})->name('solicitudes-aceptadas-computo');

Route::get('/api/usuario/encargado/solicitudes-aceptadas-computo', function (Illuminate\Http\Request $request){

    $consulta = 
        DB::table('solicitudes_computo as s')
        ->join('laboratorios as l','l.id','=','s.id_laboratorio')
        ->select(
            's.id',
            's.numero_computadora',
            'l.nombre',
            's.descripcion',
            's.fecha',
            DB::raw('(SELECT estado FROM auditoria_computo 
                WHERE id_solicitud = s.id 
                ORDER BY id DESC LIMIT 1) as estado')
        )
        ->where('l.id_institucion','=',session('id_institucion'))
        ->whereRaw('(SELECT estado FROM auditoria_computo 
                WHERE id_solicitud = s.id 
                ORDER BY id DESC LIMIT 1) != ?', ['completado'])
        ->whereExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('auditoria_computo as a')
                ->whereColumn('a.id_solicitud', 's.id');
        })
    ;

    if ($request->filtro != 'Sin Filtro'){
        $consulta->where('l.id','=',$request->filtro);
    }

    if ($request->texto){
        $consulta->where(function($q) use ($request) {
            $term = '%' . $request->texto . '%';
            $q->where(DB::raw("CAST(s.id AS TEXT)"), 'ilike', $term)
            ->orWhere(DB::raw("s.numero_computadora"), 'ilike', $term);
        });
    }

    $reportes = $consulta->get();

    return response()->json($reportes);
});

Route::get('/usuario/mantenimiento/reportes-computo', function(){

    $usuario = 
        DB::table('usuarios as u')
        ->select(
            'u.id',
            'u.nombre',
            'u.email'
        )   
        ->where("u.id","=",session('id_usuario'))
        ->first()
    ;

    $reportes = 
        DB::table('solicitudes_computo as s')
        ->join('laboratorios as l','l.id','=','s.id_laboratorio')
        ->select(
            's.id',
            's.numero_computadora',
            'l.nombre',
            's.descripcion',
            's.fecha',
            DB::raw('(SELECT estado FROM auditoria_computo 
                WHERE id_solicitud = s.id 
                ORDER BY id DESC LIMIT 1) as estado')
        )
        ->where('l.id_institucion','=',session('id_institucion'))
        ->whereRaw('(SELECT estado FROM auditoria_computo 
                WHERE id_solicitud = s.id 
                ORDER BY id DESC LIMIT 1) NOT IN (?, ?)', ['reparado', 'completado'])
        ->whereExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('auditoria_computo as a')
                ->whereColumn('a.id_solicitud', 's.id');
        })
        ->get()
    ;

    return view('Encargado_Mantenimiento.reportes', compact('usuario','reportes'));
})->name('reportes');

Route::get('/usuario/mantenimiento/actualizar-informacion-reportes', function(){

    $reportes = 
        DB::table('solicitudes_computo as s')
        ->join('laboratorios as l','l.id','=','s.id_laboratorio')
        ->select(
            's.id',
            's.numero_computadora',
            'l.nombre',
            's.descripcion',
            's.fecha',
            DB::raw('(SELECT estado FROM auditoria_computo 
                WHERE id_solicitud = s.id 
                ORDER BY id DESC LIMIT 1) as estado')
        )
        ->where('l.id_institucion','=',session('id_institucion'))
        ->whereRaw('(SELECT estado FROM auditoria_computo 
                WHERE id_solicitud = s.id 
                ORDER BY id DESC LIMIT 1) NOT IN (?, ?)', ['reparado', 'completado'])
        ->whereExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('auditoria_computo as a')
                ->whereColumn('a.id_solicitud', 's.id');
        })
        ->get()
    ;

    return response()->json($reportes);
});

Route::get('/login', [LoginController::class, 'index'])->name('login.index');

Route::post('/login', [LoginController::class, 'login'])->name('login.login');

Route::post('/logout', [LoginController::class, 'logout'])->middleware('check.login');