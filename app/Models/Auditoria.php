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
        "ID_Solicitud",
        "Estado",
        "ID_Usuario",
        "Fecha"
    ];

    public function solicitud(){
        return $this->belongsTo(Solicitud::class, "ID_Solicitud");
    }

    public function usuario(){
        return $this->belongsTo(Usuario::class, "ID_Usuario");
    }
}
