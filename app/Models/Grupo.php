<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Institucion;

class Grupo extends Model
{
    use HasFactory;

    protected $table = "grupos";

    protected $fillable = [
        "nombre",
        "grado",
        "grupo",
        "laboratorios",
        "id_institucion"
    ];

    public function institucion(){
        return $this->belongsTo(Institucion::class, 'id_institucion');
    }
}
