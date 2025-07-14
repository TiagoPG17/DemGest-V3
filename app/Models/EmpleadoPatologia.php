<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class EmpleadoPatologia extends Pivot
{
    protected $table = 'empleado_patologia';

    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'empleado_id',
        'patologia_id',
    ];
}
