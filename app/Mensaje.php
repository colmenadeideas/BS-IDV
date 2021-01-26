<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mensaje extends Model
{
    protected $table = 'mensaje';
    protected $fillable = [ 'id_user', 'tipo','mensaje', 'id_user', 'tipo','id_conversacion'];
}
