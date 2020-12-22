<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profesor extends Model
{
    protected $table = 'profesor';
    protected $fillable = [ 'curriculum', 'fecha_inicio', 'fecha_fin'];
    public $timestamps = false;
}
