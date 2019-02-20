<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Campana extends Model
{
    protected $primaryKey       =       "id_ca";
    public $incrementing        =       false;


    protected $hidden           =       ['id_us'];

    protected $casts            =       ['estado_ca'=>'bool'];
}
