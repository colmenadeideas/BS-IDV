<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nota extends Model
{
    protected $table = 'evaluacion';
    protected $fillable = [ 'nota', 'nombre', 'tipo', 'porcentaje'    ];
    public $timestamps = false;
}
