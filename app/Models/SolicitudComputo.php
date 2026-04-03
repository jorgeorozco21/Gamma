<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SolicitudComputo extends Model
{
    use HasFactory;

    protected $table = 'solicitudes_computo';

    protected $fillable = [
        'id_laboratorio',
        'numero_computadora',
        'descripcion',
        'fecha'
    ];

    public function laboratorio(){
        return $this->belongsTo(Laboratorio::class, 'id_laboratorio');
    }

    public function auditorias(){
        return $this->hasMany(AuditoriaComputo::class, 'id_solicitud');
    }
}
