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
        "nombre",
        "tipo",
        "cantidad_computadoras",
        "id_institucion"
    ];

    public function institucion(){
        return $this->belongsTo(Institucion::class, "id_institucion");
    }

    public function inventarios(){
        return $this->belongsTo(Inventario::class, "id_laboratorio");
    }
}
