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
        "id_material",
        "cantidad_disponible",
        "cantidad_total",
        "id_laboratorio"
    ];

    public function material(){
        return $this->belongsTo(Material::class, "id_material");
    }

    public function laboratorio(){
        return $this->belongsTo(Laboratorio::class, "id_laboratorio");
    }
}
