<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MenuController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function votosMenu(){
        return view('voto.index');
    }

    public function generado(){
        $usuario=Auth::user();
        $a['name']      =   "";
        $a['icon']      =   "fa fa-home";
        $a['url']       =   route('home');
        $aux[]          =   $a;
        unset($a);

        $a['name']      =   "E-Voto";
        $a['icon']      =   "fa fa-check";
        $a['url']       =   route('voto.index');
        if($usuario->id_ro===1){
            $a['items'][]   =   [
                'name'  =>  "Nueva Asociación",
                'url'   =>  route('voto.admin'),
                'icon'  =>  'fa fa-building',
            ];
        }
        if($usuario->id_ro===2){
            $a['items'][]   =   [
                'name'  =>  "Nueva Elección",
                'url'   =>  'Pasantías',
                'icon'  =>  'fa fa-newspaper',
            ];
        }
        if($usuario->id_ro===3){
            $a['items'][]   =   [
                'name'  =>  "Elecciones FEUCE-Q",
                'url'   =>  'Pasantías',
                'label' =>  '3h',
            ];

        }
        $aux[]          =   $a;
        unset($a);

        return response([
            'menu'  =>  $aux,
            'user'  =>  $usuario,
            'notifications' =>  Auth::user()->unreadNotifications
        ]);
    }
}
