<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Grupo;
use App\Models\Institucion;
use App\Models\Solicitud;
use App\Models\Auditoria;

class Usuario extends Model
{
    use HasFactory;

    protected $table = "usuarios";

    protected $fillable = [
        "Nombre_Usuario",
        "Email",
        "Contrasena",
        "Nombre",
        "Tipo_Usuario",
        "ID_Grupo",
        "ID_Institucion"
    ];

    public function grupo(){
        return $this->belongsTo(Grupo::class, 'ID_Grupo');
    }

    public function institucion(){
        return $this->belongsTo(Institucion::class, 'ID_Institucion');
    }

    public function solicitudes(){
        return $this->hasMany(Solicitud::class, 'ID_Usuario');
    }

    public function auditorias(){
        return $this->hasMany(Auditoria::class, "ID_Usuario");
    }
}
