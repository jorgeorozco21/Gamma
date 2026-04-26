<?php

use App\Http\Controllers\AuditoriaController;
use App\Http\Controllers\AuditoriaComputoController;
use App\Http\Controllers\AuditoriaReporteMaterialController;
use App\Http\Controllers\CargaInventarioController;
use App\Http\Controllers\CargaLaboratoriosController;
use App\Http\Controllers\CargaMaterialesController;
use App\Http\Controllers\CargaUsuariosController;
use App\Http\Controllers\ComputadoraController;
use App\Http\Controllers\GrupoController;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\LaboratorioController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ReporteMaterialController;
use App\Http\Controllers\SolicitudEliminadaController;
use App\Http\Controllers\SolicitudesComputoController;
use App\Http\Controllers\SolicitudesController;
use App\Models\Grupo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

use function Laravel\Prompts\select;

Route::middleware('check.login')->group(function (){

    Route::middleware(['tipo:admin'])->group(function (){

        Route::get('/admin', function(){
            $admin = 
                DB::table('usuarios as u')
                ->select(
                    'u.nombre_usuario',
                    'u.email'
                )
                ->where('u.id','=',session('id_usuario'))
                ->first()
            ;

            return view('Admin.indexAdmin', compact('admin'));
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
            ;

            if ($request->texto != '') {
                $query->where(function ($q) use ($request) {
                    $term = "%" . $request->texto . "%";
                    $q->where("u.nombre_usuario", "ilike", $term)
                    ->orWhere("u.email", "ilike", $term)
                    ->orWhere("u.nombre", "ilike", $term);
                });
            }

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
                    DB::raw('(SELECT COUNT(*) FROM computadoras 
                    WHERE id_laboratorio = l.id 
                    AND estado = \'activo\') as cantidad_computadoras')
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
                    DB::raw('(SELECT COUNT(*) FROM computadoras 
                    WHERE id_laboratorio = l.id 
                    AND estado = \'activo\') as cantidad_computadoras')
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
                    "i.cantidad_disponible",
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

        Route::get('/Generar/Hash/Contrasenas/Administradores', function(){
            $contrasena = Hash::make('hola');
            
            return response()->json($contrasena);
        });

        Route::get('/admin/informes/laboratorios', function (){
            $admin = 
                DB::table('usuarios as u')
                ->select(
                    'u.nombre_usuario',
                    'u.email'
                )
                ->where('u.id','=',session('id_usuario'))
                ->first()
            ;

            $laboratorios = 
                DB::table('laboratorios as l')
                ->select(
                    'l.id',
                    'l.nombre',
                    'l.tipo'
                )
                ->where('l.id_institucion','=',session('id_institucion'))
                ->get()
            ;

            return view('Admin.Computadoras.laboratorios', compact('admin','laboratorios'));
        });

        Route::get('/admin/informes/laboratorios/{id}-laboratorio-computo/computadoras', function($id){
            $admin = 
                DB::table('usuarios as u')
                ->select(
                    'u.nombre_usuario',
                    'u.email'
                )
                ->where('u.id','=',session('id_usuario'))
                ->first()
            ;

            $laboratorio = 
                DB::table('laboratorios as l')
                ->select(
                    'l.id',
                    'l.nombre'
                )
                ->where('l.id','=',$id)
                ->first()
            ;

            $computadoras = 
                DB::table('computadoras as c')
                ->select(
                    'c.id',
                    'c.numero_computadora',
                    'c.estado'
                )
                ->where('c.id_laboratorio','=',$id)
                ->orderBy('c.id','ASC')
                ->get()
            ;

            return view('Admin.Computadoras.informacion_computadoras', compact('admin','laboratorio','computadoras'));
        });

        Route::get('/admin/informes/laboratorios/laboratorio-computo/reportes', function (Illuminate\Http\Request $request){

            $reportes = 
                DB::table('solicitudes_computo as s')
                ->select(
                    's.id',
                    's.tipo',
                    's.descripcion'
                )
                ->where('s.id_computadora','=',$request->id)
                ->whereExists(function ($query) {
                    $query->select(DB::raw(1))
                        ->from('auditoria_computo as a')
                        ->whereColumn('a.id_solicitud', 's.id');
                })
                ->get()
            ;

            return response()->json($reportes);
        });

        Route::get('/admin/informes/laboratorios/laboratorio-computo/auditorias', function (Illuminate\Http\Request $request){

            $auditoria =
                DB::table('auditoria_computo as a')
                ->select(
                    'a.estado',
                    'a.info_usuario',
                    'a.fecha'
                )
                ->where('a.id_solicitud','=',$request->id)
                ->get() 
            ;

            return response()->json($auditoria);
        });

        Route::get('/api/admin/informes/laboratorios/laboratorio-computo/buscador', function (Illuminate\Http\Request $request){
            $consulta = 
                DB::table('computadoras as c')
                ->select(
                    'c.id',
                    'c.numero_computadora',
                    'c.estado'
                )
                ->where('c.id_laboratorio','=',$request->idLab)
                ->where('c.numero_computadora','ilike','%'.$request->texto.'%')
            ;

            if ($request->filtro != "Sin Filtro"){
                $consulta->where('c.estado','=',$request->filtro);
            }

            $consulta->orderBy('c.id','ASC');
            $computadoras = $consulta->get();

            return response()->json($computadoras);
        });

        Route::put('/admin/informes/laboratorios/laboratorio-computo/editar-computadora-{id}', [ComputadoraController::class, 'edit']);

        Route::post('/admin/informes/laboratorios/laboratorio-computo/reemplazar-computadora-{id}', [ComputadoraController::class, 'reemplazar']);

        Route::post('/admin/informes/laboratorios/laboratorio-computo/crear-computadora-{id}', [ComputadoraController::class, 'crearComputadora']);
    });

    Route::middleware(['tipo:normal'])->group(function (){

        Route::get('/usuario/normal/laboratorios', function(){
        
            $labAcceso = 
                DB::table('usuarios as u')
                ->join('grupos as g','g.id','=','u.id_grupo')
                ->select(
                    'u.id_grupo',
                    'g.laboratorios'
                )
                ->where('u.id','=',session('id_usuario'))
                ->first()
            ;
        
            $idLaboratorios = explode(',',$labAcceso->laboratorios);
        
            $laboratorios = [];
            $band = false;
            $aux = "";
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


                if (!$infoLab){
                    $band = true;
                }else{
                    $aux .= $id . ",";
                }
        
                $laboratorios[] = $infoLab;
            }

            if ($band){
                $aux = substr($aux,0,-1);

                $grupo = Grupo::where('id', $labAcceso->id_grupo)->first();

                if ($grupo) {
                    $grupo->laboratorios = $aux;
                    $grupo->save(); 
                }
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

            $laboratorio = 
                DB::table('laboratorios as l')
                ->select(
                    'id',
                    'nombre',
                    'cantidad_computadoras'
                )
                ->where('l.id','=',$id)
                ->first()
            ; 
        
            $infoLaboratorio = DB::table('computadoras as c')
            ->leftJoin('solicitudes_computo as s', function($join) {
                $join->on('s.id_computadora', '=', 'c.id')
                    ->whereNotExists(function ($query) {
                        $query->select(DB::raw(1))
                            ->from('auditoria_computo as a')
                            ->whereColumn('a.id_solicitud', 's.id')
                            ->where('a.estado', '=', 'completado');
                    });
            })
            ->select(
                'c.id',
                'c.numero_computadora',
                DB::raw('COUNT(s.id) as cantidad_reportes')
            )
            ->where('c.estado','=','activo')
            ->where('c.id_laboratorio', '=', $id)
            ->where('c.estado', '=', 'activo')
            ->groupBy('c.id', 'c.numero_computadora')
            ->orderBy('c.id','ASC')
            ->get();
        
            return view('Normal.solicitudes-computo', compact('infoLaboratorio','laboratorio'));
        })->name('solicitudes-computo');
        
        Route::get('/api/usuario/normal/laboratorios/buscador-computadora', function (Illuminate\Http\Request $request){
            $computadoras =
                DB::table('computadoras as c')
                ->leftJoin('solicitudes_computo as s', function($join) {
                    $join->on('s.id_computadora', '=', 'c.id')
                        ->whereNotExists(function ($query) {
                            $query->select(DB::raw(1))
                                ->from('auditoria_computo as a')
                                ->whereColumn('a.id_solicitud', 's.id')
                                ->where('a.estado', '=', 'completado');
                        });
                })
                ->select(
                    'c.id',
                    'c.numero_computadora',
                    DB::raw('COUNT(s.id) as cantidad_reportes')
                )
                ->where('c.estado','=','activo')
                ->where('c.id_laboratorio', '=', $request->id)
                ->where('c.numero_computadora','ilike','%'.$request->texto.'%')
                ->where('c.estado', '=', 'activo')
                ->groupBy('c.id', 'c.numero_computadora')
                ->orderBy('c.id','ASC')
                ->get()
            ;

            return response()->json($computadoras);
        });

        Route::get('/usuario/normal/laboratorios/obtener-reportes-computo', function (Illuminate\Http\Request $request){
            
            $reportes = 
                DB::table('solicitudes_computo as s')
                ->select(
                    's.tipo',
                    's.descripcion'
                )
                ->where('s.id_computadora','=',$request->id)
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
        
    });

    Route::middleware(['tipo:encargado'])->group(function (){

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

        Route::get('/api/solicitudes-en-prestamo', function (){
            $solicitudes = 
                DB::table('solicitudes as s')
                ->select(
                    's.id'
                )
                ->whereExists(function ($query) {
                    $query->select(DB::raw(1))
                        ->from('auditoria as a')
                        ->whereColumn('a.id_solicitud', 's.id')
                        ->where('a.estado', '=', 'en prestamo');
                })
                ->whereNotExists(function ($query) {
                    $query->select(DB::raw(1))
                        ->from('auditoria as a')
                        ->whereColumn('a.id_solicitud', 's.id')
                        ->where('a.estado', '=', 'recibido');
                })
                ->get();
            ;

            return response()->json($solicitudes);
        });

        Route::get('/api/info-materiales-solicitud-prestamo', function (Illuminate\Http\Request $request){

            $solicitud = 
                DB::table('solicitudes as s')
                ->select(
                    's.info_material'
                )
                ->where('s.id','=',$request->id)
                ->first()
            ;

            return response()->json($solicitud);
        });

        Route::post('/creacion-reporte-material', [ReporteMaterialController::class, 'store']);
        
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
                ->join('computadoras as c','c.id','=','s.id_computadora')
                ->join('laboratorios as l','l.id','=','c.id_laboratorio')
                ->select(
                    's.id',
                    's.id_computadora',
                    's.tipo',
                    'c.numero_computadora',
                    'l.nombre',
                    's.descripcion',
                    's.fecha'
                )
                ->where('c.estado','=','activo')
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
                    's.tipo',
                    's.descripcion'
                )
                ->where('s.id_computadora','=',$request->id)
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
                ->join('computadoras as c','c.id','=','s.id_computadora')
                ->join('laboratorios as l','l.id','=','c.id_laboratorio')
                ->select(
                    's.id',
                    's.id_computadora',
                    's.tipo',
                    'c.numero_computadora',
                    'l.nombre',
                    's.descripcion',
                    's.fecha'
                )
                ->where('c.estado','=','activo')
                ->where('l.id_institucion','=',session('id_institucion'))
                ->whereNotExists(function ($query) {
                    $query->select(DB::raw(1))
                        ->from('auditoria_computo as a')
                        ->whereColumn('a.id_solicitud', 's.id');
                })
            ;
        
            if ($request->filtro != "Sin Filtro"){
                $consulta->where("c.id_laboratorio", '=', $request->filtro);
            }

            if ($request->filtrotipo != "Sin Filtro"){
                $consulta->where("s.tipo", '=', $request->filtrotipo);
            }
        
            if ($request->texto) {
                $consulta->where(function($q) use ($request) {
                    $term = '%' . $request->texto . '%';
                    $q->where(DB::raw("CAST(s.id AS TEXT)"), 'ilike', $term)
                    ->orWhere(DB::raw("c.numero_computadora"), 'ilike', $term);
                });
            }
        
            $reportes = $consulta->get();
        
            return response()->json($reportes);
        });
        
        Route::get('/usuario/encargado/solicitudes-aceptadas-computo', function(){
        
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
                ->join('computadoras as c','c.id','=','s.id_computadora')
                ->join('laboratorios as l','l.id','=','c.id_laboratorio')
                ->select(
                    's.id',
                    's.id_computadora',
                    's.tipo',
                    'c.numero_computadora',
                    'l.nombre',
                    's.descripcion',
                    's.fecha',
                    DB::raw('(SELECT estado FROM auditoria_computo 
                        WHERE id_solicitud = s.id 
                        ORDER BY id DESC LIMIT 1) as estado')
                )
                ->where('c.estado','=','activo')
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
                ->join('computadoras as c','c.id','=','s.id_computadora')
                ->join('laboratorios as l','l.id','=','c.id_laboratorio')
                ->select(
                    's.id',
                    's.id_computadora',
                    's.tipo',
                    'c.numero_computadora',
                    'l.nombre',
                    's.descripcion',
                    's.fecha',
                    DB::raw('(SELECT estado FROM auditoria_computo 
                        WHERE id_solicitud = s.id 
                        ORDER BY id DESC LIMIT 1) as estado')
                )
                ->where('c.estado','=','activo')
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

            if ($request->filtrotipo != "Sin Filtro"){
                $consulta->where("s.tipo", '=', $request->filtrotipo);
            }
        
            if ($request->texto){
                $consulta->where(function($q) use ($request) {
                    $term = '%' . $request->texto . '%';
                    $q->where(DB::raw("CAST(s.id AS TEXT)"), 'ilike', $term)
                    ->orWhere(DB::raw("c.numero_computadora"), 'ilike', $term);
                });
            }
        
            $reportes = $consulta->get();
        
            return response()->json($reportes);
        });

        Route::get('/usuario/encargado/reportes-materiales', function (){

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

            $reportes = 
                DB::table('reportes_materiales as r')
                ->join('inventarios as i','i.id','=','r.id_inventario')
                ->join('materiales as m','m.id','=','i.id_material')
                ->join('laboratorios as l','l.id','=','i.id_laboratorio')
                ->select(
                    'r.id',
                    'r.id_inventario',
                    'm.nombre',
                    'l.nombre as nombreLaboratorio',
                    'r.cantidad',
                    'r.descripcion',
                    'r.fecha',
                    DB::raw('(SELECT estado FROM auditoria_reportes_materiales
                        WHERE id_reporte = r.id 
                        ORDER BY id DESC LIMIT 1) as estado')
                )
                ->where('r.id_institucion','=',session('id_institucion'))
                ->whereRaw('
                    (SELECT estado FROM auditoria_reportes_materiales
                    WHERE id_reporte = r.id 
                    ORDER BY id DESC LIMIT 1) NOT IN (?, ?) 
                    OR 
                    (SELECT estado FROM auditoria_reportes_materiales
                    WHERE id_reporte = r.id 
                    ORDER BY id DESC LIMIT 1) IS NULL
                ', ['recibido', 'sin reparacion'])
                ->get()
            ;

            return view('Encargado_Area.auditoria-reportes-materiales', compact('laboratorios','usuario','reportes'));
        });

        Route::get('/api/usuario/encargado/reportes-materiales', function (Illuminate\Http\Request $request){
        
            $consulta = 
                DB::table('reportes_materiales as r')
                ->join('inventarios as i','i.id','=','r.id_inventario')
                ->join('materiales as m','m.id','=','i.id_material')
                ->join('laboratorios as l','l.id','=','i.id_laboratorio')
                ->select(
                    'r.id',
                    'm.nombre',
                    'l.nombre as nombreLaboratorio',
                    'r.cantidad',
                    'r.descripcion',
                    'r.fecha',
                    DB::raw('(SELECT estado FROM auditoria_reportes_materiales
                        WHERE id_reporte = r.id 
                        ORDER BY id DESC LIMIT 1) as estado')
                )
                ->where('r.id_institucion','=',session('id_institucion'))
                ->whereRaw('
                    (SELECT estado FROM auditoria_reportes_materiales
                    WHERE id_reporte = r.id 
                    ORDER BY id DESC LIMIT 1) NOT IN (?, ?) 
                    OR 
                    (SELECT estado FROM auditoria_reportes_materiales
                    WHERE id_reporte = r.id 
                    ORDER BY id DESC LIMIT 1) IS NULL
                ', ['recibido', 'sin reparacion'])
            ;
        
            if ($request->filtro != 'Sin Filtro'){
                $consulta->where('l.id','=',$request->filtro);
            }
        
            if ($request->texto){
                $consulta->where(function($q) use ($request) {
                    $term = '%' . $request->texto . '%';
                    $q->where(DB::raw("CAST(r.id AS TEXT)"), 'ilike', $term)
                    ->orWhere(DB::raw("m.nombre"), 'ilike', $term);
                });
            }
        
            $reportes = $consulta->get();
        
            return response()->json($reportes);
        });

        Route::post('/usuario/encargado/actualizar-reportes-materiales', [AuditoriaReporteMaterialController::class, 'completarReporte']);

    });

    Route::middleware(['tipo:mantenimiento'])->group(function (){
    
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
                ->join('computadoras as c','c.id','=','s.id_computadora')
                ->join('laboratorios as l','l.id','=','c.id_laboratorio')
                ->select(
                    's.id',
                    's.id_computadora',
                    's.tipo',
                    'c.numero_computadora',
                    'l.nombre',
                    's.descripcion',
                    's.fecha',
                    DB::raw('(SELECT estado FROM auditoria_computo 
                        WHERE id_solicitud = s.id 
                        ORDER BY id DESC LIMIT 1) as estado')
                )
                ->where('c.estado','=','activo')
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
                ->join('computadoras as c','c.id','=','s.id_computadora')
                ->join('laboratorios as l','l.id','=','c.id_laboratorio')
                ->select(
                    's.id',
                    's.tipo',
                    's.id_computadora',
                    'c.numero_computadora',
                    'l.nombre',
                    's.descripcion',
                    's.fecha',
                    DB::raw('(SELECT estado FROM auditoria_computo 
                        WHERE id_solicitud = s.id 
                        ORDER BY id DESC LIMIT 1) as estado')
                )
                ->where('c.estado','=','activo')
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

        Route::post('/usuario/mantenimiento/actualizar-solicitudes-computo', [AuditoriaComputoController::class, 'store']);

        Route::put('/usuario/matenimiento/editar-computadora-{id}', [ComputadoraController::class, 'edit']);

        Route::get('/usuario/mantenimiento/reportes-materiales', function(){
        
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
                DB::table('reportes_materiales as r')
                ->join('inventarios as i','i.id','=','r.id_inventario')
                ->join('materiales as m','m.id','=','i.id_material')
                ->join('laboratorios as l','l.id','=','i.id_laboratorio')
                ->select(
                    'r.id',
                    'r.id_inventario',
                    'm.nombre',
                    'l.nombre as nombreLaboratorio',
                    'r.cantidad',
                    'r.descripcion',
                    'r.fecha',
                    DB::raw('(SELECT estado FROM auditoria_reportes_materiales
                        WHERE id_reporte = r.id 
                        ORDER BY id DESC LIMIT 1) as estado')
                )
                ->where('r.id_institucion','=',session('id_institucion'))
                ->whereRaw('
                    (SELECT estado FROM auditoria_reportes_materiales
                    WHERE id_reporte = r.id 
                    ORDER BY id DESC LIMIT 1) NOT IN (?, ?, ?)
                    OR 
                    (SELECT estado FROM auditoria_reportes_materiales
                    WHERE id_reporte = r.id 
                    ORDER BY id DESC LIMIT 1) IS NULL
                ', ['reparado', 'recibido', 'sin reparacion'])
                ->get()
            ;
        
            return view('Encargado_Mantenimiento.reportes_materiales', compact('usuario','reportes'));
        })->name('reportes');

        Route::post('/usuario/mantenimiento/actualizar-reportes-materiales', [AuditoriaReporteMaterialController::class, 'store']);

        Route::get('/usuario/mantenimiento/actualizar-informacion-reportes-mateiales', function(){
        
            $reportes = 
                DB::table('reportes_materiales as r')
                ->join('inventarios as i','i.id','=','r.id_inventario')
                ->join('materiales as m','m.id','=','i.id_material')
                ->join('laboratorios as l','l.id','=','i.id_laboratorio')
                ->select(
                    'r.id',
                    'r.id_inventario',
                    'm.nombre',
                    'l.nombre as nombreLaboratorio',
                    'r.cantidad',
                    'r.descripcion',
                    'r.fecha',
                    DB::raw('(SELECT estado FROM auditoria_reportes_materiales
                        WHERE id_reporte = r.id 
                        ORDER BY id DESC LIMIT 1) as estado')
                )
                ->where('r.id_institucion','=',session('id_institucion'))
                ->whereRaw('
                    (SELECT estado FROM auditoria_reportes_materiales
                    WHERE id_reporte = r.id 
                    ORDER BY id DESC LIMIT 1) NOT IN (?, ?, ?)
                    OR 
                    (SELECT estado FROM auditoria_reportes_materiales
                    WHERE id_reporte = r.id 
                    ORDER BY id DESC LIMIT 1) IS NULL
                ', ['reparado', 'recibido', 'sin reparacion'])
                ->get()
            ;
        
            return response()->json($reportes);
        });

        Route::post('/usuario/mantenimiento/reporte-sin-funcionamiento', [AuditoriaReporteMaterialController::class, 'sinFuncionamiento']);

    });
    
    Route::get('/seleccionar-tipo-usuario', function(){
        return view('Paginas.seleccionar-rol');
    })->name('seleccionar-perfil');
    
    Route::get('/perfil', function(){
        $datos['usuario'] = 
            DB::table('usuarios as u')
            ->join('instituciones as i','i.id','=','u.id_institucion')
            ->select(
                'u.id',
                'u.nombre_usuario',
                'u.nombre',
                'u.email',
                'u.normal',
                'i.nombre as nombreInstitucion'
            )
            ->where('u.id','=',session('id_usuario'))
            ->first()
        ;
    
        if ($datos['usuario']->normal == '1'){
            $datos['grupo'] = 
                DB::table('usuarios as u')
                ->join('grupos as g','g.id','=','u.id_grupo')
                ->select(
                    'g.grado',
                    'g.grupo',
                    'g.nombre'
                )
                ->where('u.id','=',session('id_usuario'))
                ->first()
            ;
        }
    
        if (session('tipo') == 'admin'){
            $admin = 
                DB::table('usuarios as u')
                ->select(
                    'u.nombre_usuario',
                    'u.email'
                )
                ->where('u.id','=',session('id_usuario'))
                ->first()
            ;
    
            return view('Paginas.perfil', compact('datos','admin'));
        }
    
        return view('Paginas.perfil', compact('datos'));
    })->name('perfil');
    
    Route::post('/perfil/cambiar-contrasena', [UsuarioController::class, 'actualizarContrasena']);

    Route::get('/activar-rol/{rol}', [LoginController::class, 'activarRol'])->name('activar.rol');
});

Route::get('/', function () {
    session()->forget(['id_usuario', 'id_institucion']);
    
    return view('Paginas.pagina-principal');
})->name('pagina-principal');

Route::get('/login', [LoginController::class, 'index'])->name('login.index');
    
Route::post('/login', [LoginController::class, 'login'])->name('login.login');

Route::post('/logout', [LoginController::class, 'logout'])->middleware('check.login');
