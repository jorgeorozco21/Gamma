<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SolicitudComputo extends Model
{
    use HasFactory;

    protected $table = 'solicitudes_computo';

    protected $fillable = [
        'id_computadora',
        'tipo',
        'descripcion',
        'fecha'
    ];

    public function auditorias(){
        return $this->hasMany(AuditoriaComputo::class, 'id_solicitud');
    }

    public function computadora(){
        return $this->belongsTo(Computadora::class, 'id_computadora');
    }
}
