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
        "id_usuario",
        "id_inventario",
        "cantidad",
        "descripcion",
        "fecha"
    ];

    public function usuario(){
        return $this->belongsTo(Usuario::class, "id_usuario");
    }

    public function inventario(){
        return $this->belongsTo(Inventario::class, "id_inventario");
    }

    public function aditorias(){
        return $this->hasMany(Auditoria::class, "id_solicitud");
    }

}
