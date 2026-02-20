<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Institucion;
use App\Models\Inventario;

class Laboratorio extends Model
{
    use HasFactory;

    protected $table = "laboratorios";

    protected $fillable = [
        "Nombre",
        "Tipo",
        "Cantidad_Computadoras",
        "ID_Institucion"
    ];

    public function institucion(){
        return $this->belongsTo(Institucion::class, "ID_Institucion");
    }

    public function inventarios(){
        return $this->belongsTo(Inventario::class, "ID_Laboratorio");
    }
}
