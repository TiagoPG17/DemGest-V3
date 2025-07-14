<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\InformacionLaboral;

class CiudadLaboral extends Model

{
    protected $table = 'ciudades_laborales';
    protected $fillable = ['nombre',];

    public function informacionLaboral()
    {
        return $this->hasMany(InformacionLaboral::class , 'ciudad_laboral_id');
    }

}




