<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Estudiante extends Model
{
    protected $table = 'estudiante';
     protected $fillable = [ 'curriculum', 'fecha_inicio', 'fecha_fin'];
    public $timestamps = false;
}
