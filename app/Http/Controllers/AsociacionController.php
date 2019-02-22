<?php

namespace App\Http\Controllers;

use App\Campana;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AsociacionController extends Controller
{
    public function __construct()
    {
        $this->middleware('aso');
    }

    public function vista(){
        return view('voto.aso');
    }

    public function listar(){
        return Auth::user()->campanas;
    }

    public function nuevaCampania(Request $datos){
        Validator::extend('base64image', function ($attribute, $value, $parameters, $validator) {
            $explode = explode(',', $value);
            $allow = ['png', 'jpg', 'jpeg'];
            $format = str_replace(
                [
                    'data:image/',
                    ';',
                    'base64',
                ],
                [
                    '', '', '',
                ],
                $explode[0]
            );
            if (!in_array($format, $allow))
                return false;
            if (!preg_match('%^[a-zA-Z0-9/+]*={0,2}$%', $explode[1]))
                return false;
            return true;
        });

        $validacion =   Validator::make($datos->all(),[
            'detalle'               =>  'nullable|string|max:500',
            'fecha'                 =>  'required|date',
            'inicio'                =>  'required|date',
            'fin'                   =>  'required|date|after:inicio',
            'excel.cantidad'        =>  'required|numeric|min:1',
            'miembros'              =>  'required',
            'miembros.*.dignidad'   =>  'required|exists:tipo_candidato,id_tc',
            'miembros.*.movimiento' =>  'required|exists:movimientos,id_mo',
            'miembros.*.nombre'     =>  'required|max:250',
            'miembros.*.foto'       =>  'required|base64image',
        ],[
            'miembros.*.foto.base64image'   =>  "Suba un archivo de imagen válido"
        ]);
        if ($validacion->fails()) {
            $mensaje="";
            foreach ($validacion->errors()->all() as $item)
                $mensaje.="$item</br>";
            return (['val'=>false,'mensaje'=>$mensaje,'errores'=>$validacion->errors()->all()]);
        }else{
            $numero                 =   count(Auth::user()->campanas);
            $campana                =   new Campana();
            $campana->detalle_ca    =   $datos->detalle;
            $campana->desde_ca      =   $datos->desde;
            $campana->vence_ca      =   $datos->hasta;
            $campana->id_us         =   Auth::user()->id;
            $campana->id_ca         =   hash('fnv1a32',$numero.Auth::user()->id);
            $campana->save();
            return (['val'=>true,'mensaje'=>'Se ha guardado correctamente']);
        }
    }
}
