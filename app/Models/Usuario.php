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
        "nombre_usuario",
        "email",
        "contrasena",
        "nombre",
        "admin",
        "mantenimiento",
        "encargado",
        "normal",
        "id_grupo",
        "id_institucion"
    ];

    public function grupo(){
        return $this->belongsTo(Grupo::class, 'id_grupo');
    }

    public function institucion(){
        return $this->belongsTo(Institucion::class, 'iD_institucion');
    }

    public function solicitudes(){
        return $this->hasMany(Solicitud::class, 'id_usuario');
    }

    public function auditorias(){
        return $this->hasMany(Auditoria::class, "id_usuario");
    }
}
