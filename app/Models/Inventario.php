<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Material;
use App\Models\Laboratorio;
use App\Models\Solicitud;

class Inventario extends Model
{
    
    use HasFactory;

    protected $table = "inventarios";

    protected $fillable = [
        "ID_Material",
        "Cantidad_Disponible",
        "Cantidad_Total",
        "ID_Laboratorio"
    ];

    public function material(){
        return $this->belongsTo(Material::class, "ID_Material");
    }

    public function laboratorio(){
        return $this->belongsTo(Laboratorio::class, "ID_Laboratorio");
    }

    public function solicitudes(){
        return $this->hasMany(Solicitud::class, "ID_Inventario");
    }
}
