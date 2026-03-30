<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Solicitud;
use App\Models\Usuario;

class Auditoria extends Model
{

    use HasFactory;

    protected $table = "auditoria";

    protected $fillable = [
        "id_solicitud",
        "estado",
        "info_usuario",
        "fecha"
    ];

    protected $casts = [
        "info_usuario" => "array",
        "fecha" => "datetime"
    ];

    public function solicitud(){
        return $this->belongsTo(Solicitud::class, "id_solicitud");
    }

    public function usuario(){
        return $this->belongsTo(Usuario::class, "id_usuario");
    }
}
