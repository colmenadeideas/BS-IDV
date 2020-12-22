<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PertenceAConversacion extends Model
{
    protected $table = 'user_pertence_conversacion';
    protected $fillable = [ 'id_user', 'id_conversacion'];
}
