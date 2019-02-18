<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MenuController extends Controller
{
    public function generado(){
        $a['name']      =   "";
        $a['icon']      =   "fa fa-home";
        $a['url']       =   route('home');
        $aux[]          =   $a;
        unset($a);

        $a['name']      =   "E-Voto";
        $a['icon']      =   "fa fa-check";
        $a['url']       =   '#';
        $a['items'][]   =   [
            'name'  =>  "Nueva Asociación",
            'url'   =>  'empleo fijo',
            'icon'  =>  'fa fa-building',
        ];
        $a['items'][]   =   [
            'name'  =>  "Nueva Elección",
            'url'   =>  'Pasantías',
            'icon'  =>  'fa fa-newspaper',
        ];
        $a['items'][]   =   [
            'name'  =>  "Elecciones FEUCE-Q",
            'url'   =>  'Pasantías',
            'label' =>  '3h',
        ];

        $aux[]          =   $a;
        unset($a);

        return response([
            'menu'  =>  $aux,
            'user'  =>  Auth::user(),
            'notifications' =>  Auth::user()->unreadNotifications
        ]);
    }
}
