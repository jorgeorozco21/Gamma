<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GrupoLaboratorio extends Model
{
    use HasFactory;

    protected $table = 'grupo_laboratorios';

    protected $fillable = [
        'id_grupo',
        'id_laboratorio'
    ];


    public function grupo(){
        return $this->belongsTo(Grupo::class, 'id_grupo');
    }

    public function laboratorio(){
        return $this->belongsTo(Laboratorio::class, 'id_laboratorio');
    }
}
