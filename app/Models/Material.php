<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Institucion;
use App\Models\Inventario;

class Material extends Model
{
    
    use HasFactory;

    protected $table = "materiales";

    protected $fillable = [
        "Nombre",
        "Descripcion",
        "Tipo",
        "ID_Institucion"
    ];

    public function institucion(){
        return $this->belongsTo(Institucion::class, "ID_Institucion");
    }

    public function inventarios(){
        return $this->hasMany(Inventario::class, "ID_Material");
    }

}
