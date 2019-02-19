<?php

namespace App\Http\Controllers;

use App\Notifications\EnvioContrasena;
use App\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class AdministradorController extends Controller
{
    public function __construct()
    {
        $this->middleware('adm');
    }


    public function formulario(){
        return view('voto.admin');
    }

    public function nuevaAso(Request $datos){
        $validacion =   Validator::make($datos->all(),[
            'email'     =>  'required|email|unique:users',
            'siglas'    =>  'required',
            'detalle'   =>  'required',
        ]);
        if ($validacion->fails()) {
            $mensaje="";
            foreach ($validacion->errors()->all() as $item)
                $mensaje.="$item</br>";
            return (['val'=>false,'mensaje'=>$mensaje,'errores'=>$validacion->errors()->all()]);
        }else{
            $contra             =   str_random(8);
            $usuario            =   new User();
            $usuario->name      =   $datos->siglas;
            $usuario->email     =   strtolower($datos->email);
            $usuario->details   =   $datos->detalle;
            $usuario->id_ro     =   2;
            $usuario->password  =   Hash::make($contra);
            $usuario->save();
            $usuario->notify(new EnvioContrasena($contra));
            //event(new Registered($usuario));
            return (['val'=>true,'mensaje'=>'Se ha guardado correctamente']);
        }
    }

    public function listaAso(){
        return User::where('id_ro',2)->get();
    }
}
