<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Usuario;
use App\Models\Grupo;
use App\Models\Laboratorio;
use App\Models\Material;

class Institucion extends Model
{
    use HasFactory;

    protected $table = "instituciones";

    protected $fillable = [
        "Nombre",
        "Clave"
    ];

    public function usuarios(){
        return $this->hasMany(Usuario::class, 'ID_Institucion');
    }

    public function grupos(){
        return $this->hasMany(Grupo::class, 'ID_Institucion');
    }

    public function laboratorios(){
        return $this->hasMany(Laboratorio::class, "ID_Institucion");
    }

    public function materiales(){
        return $this->hasMany(Material::class, "ID_Institucion");
    }
}
