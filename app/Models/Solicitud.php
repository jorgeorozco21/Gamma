<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Usuario;
use App\Models\Inventario;
use App\Models\Auditoria;

class Solicitud extends Model
{
    
    use HasFactory;

    protected $table = "solicitudes";

    protected $fillable = [
        "ID_Usuario",
        "ID_Inventario",
        "Cantidad",
        "Descripcion",
        "Fecha"
    ];

    public function usuario(){
        return $this->belongsTo(Usuario::class, "ID_Usuario");
    }

    public function inventario(){
        return $this->belongsTo(Inventario::class, "ID_Inventario");
    }

    public function aditorias(){
        return $this->hasMany(Auditoria::class, "ID_Solicitud");
    }

}
