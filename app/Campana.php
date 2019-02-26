<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Date\Date;

class Campana extends Model
{
    protected $primaryKey       =       "id_ca";
    public $incrementing        =       false;


    protected $hidden           =       ['id_us'];

    protected $casts            =       ['estado_ca'=>'bool'];

    protected $appends          =       ['dia','desde','hasta'];


    public function getDiaAttribute(){
        return Date::createFromFormat('Y-m-d H:i:s',$this->attributes['desde_ca'])->format('l, d \\d\\e F \\d\\e\\l Y');
    }

    public function getDesdeAttribute(){
        return Date::createFromFormat('Y-m-d H:i:s',$this->attributes['desde_ca'])->toTimeString();
    }
    public function getHastaAttribute(){
        return Date::createFromFormat('Y-m-d H:i:s',$this->attributes['vence_ca'])->toTimeString();
    }

    public function padron(){
        return $this->hasMany(Padron::class,'id_ca','id_ca');
    }


}
