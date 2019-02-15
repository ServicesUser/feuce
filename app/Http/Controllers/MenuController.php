<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function generado(){
        $a['name']      =   "Publicaciones";
        $a['icon']      =   "icon-briefcase";
        $a['url']       =   '#';
        $a['items'][]   =   [
            'name'  =>  "Empleo fijo",
            'url'   =>  'empleo fijo',
        ];
        $a['items'][]   =   [
            'name'  =>  "Pasantías",
            'url'   =>  'Pasantías',
            'icon'  =>  'la la-meh-o',
            'label' =>  2,
        ];
        $a['items'][]   =   [
            'name'  =>  "Practicas pre-profesionales",
            'url'   =>  '#',
        ];
        $a['items'][]   =   [
            'name'  =>  "Internacional",
            'url'   =>  'Internacional',
        ];
        $a['items'][]   =   [
            'name'  =>  "Todos",
            'url'   =>  'Todos',
        ];
        $aux[]          =   $a;
        unset($a);

        $a['name']      =   "Foro";
        $a['icon']      =   "icon-layers";
        $a['url']       =   'a asdasd';
        $a['items']     =   null;
        $aux[]          =   $a;
        unset($a);

        return response($aux);
    }
}
