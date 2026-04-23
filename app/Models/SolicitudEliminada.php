<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SolicitudEliminada extends Model
{
    use HasFactory;

    protected $table = "solicitudes_eliminadas";

    protected $fillable = [
        "id_solicitud",
        "id_usuario",
        "id_laboratorio"
    ];

    public function usuario(){
        return $this->belongsTo(Usuario::class, "id_usuario");
    }

    public function laboratorio(){
        return $this->belongsTo(Laboratorio::class, "id_laboratorio");
    }
}
