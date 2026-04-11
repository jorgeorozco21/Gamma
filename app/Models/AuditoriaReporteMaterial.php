<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditoriaReporteMaterial extends Model
{
    
    use HasFactory;

    protected $table = "auditoria_reportes_materiales";

    protected $fillable = [
        "id_reporte",
        "info_usuario",
        "estado",
        "fecha"
    ];

    protected $casts = [
        "info_usuario" => "array"
    ];

}
