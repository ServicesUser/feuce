<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dignidad extends Model
{
    protected $table        =       "tipo_candidato";
    protected $primaryKey   =       "id_tc";
    public $timestamps      =       false;
}
