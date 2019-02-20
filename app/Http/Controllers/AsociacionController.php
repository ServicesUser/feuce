<?php

namespace App\Http\Controllers;

use App\Campana;
use App\Movimiento;
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
        $validacion =   Validator::make($datos->all(),[
            'detalle'   =>  'nullable|string|max:500',
            'desde'     =>  'required|date',
            'hasta'     =>  'required|date|after:desde',
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
            $campana->id_ca         =   hash('fnv1a32 ',$numero.Auth::user()->id);
            $campana->save();
            return (['val'=>true,'mensaje'=>'Se ha guardado correctamente']);
        }
    }

    public function nuevoMovimiento(Request $datos){
        $validacion =   Validator::make($datos->all(),[
            'nombre'    =>  'required|string'
        ]);
        if ($validacion->fails()) {
            $mensaje="";
            foreach ($validacion->errors()->all() as $item)
                $mensaje.="$item</br>";
            return (['val'=>false,'mensaje'=>$mensaje,'errores'=>$validacion->errors()->all()]);
        }else{
            $movimiento             =   new Movimiento();
            $movimiento->titulo_mo  =   $datos->nombre;
            $movimiento->save();
            return (['val'=>true,'mensaje'=>'Se ha guardado correctamente']);
        }
    }
}
