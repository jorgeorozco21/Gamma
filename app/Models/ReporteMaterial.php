<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReporteMaterial extends Model
{

    use HasFactory;

    protected $table = "reportes_materiales";

    protected $fillable = [
        "id_inventario",
        'info_usuario',
        "cantidad",
        "descripcion",
        "fecha",
        "id_institucion"
    ];

    protected $casts = [
        "info_usuario" => "array"
    ];
}
