<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditoriaComputo extends Model
{
    
    use HasFactory;

    protected $table = "auditoria_computo";

    protected $fillable = [
        'id_solicitud',
        'estado',
        'info_usuario'
    ];

    protected $casts = [
        "info_usuario" => "array"
    ];

    public function solicitud(){
        return $this->belongsTo(SolicitudComputo::class, 'id_solicitud');
    }

}
