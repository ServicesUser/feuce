<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

//use Maatwebsite\Excel\Facades\Excel;

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
                'url'   =>  route('voto.aso'),
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

    public function subirExcel(Request $datos){
        $validacion =   Validator::make($datos->all(),[
            'excel'   =>  'mimes:xls,xlsx',
        ]);
        if ($validacion->fails()) {
            $mensaje="";
            foreach ($validacion->errors()->all() as $item)
                $mensaje.="$item</br>";
            return (['val'=>false,'mensaje'=>$mensaje,'errores'=>$validacion->errors()->all()]);
        }else{
            $archivo        =   $datos->file('excel');
            $filename       =   strtotime(now()).'.'.$archivo->getClientOriginalExtension();
            if(Auth::check()) {
                Storage::disk('local')->deleteDirectory(Auth::user()->id);
                $save = Storage::disk('local')->putFileAs(Auth::user()->id, $archivo, $filename);
                $address=storage_path('app/'.Auth::user()->id."/$filename");
                $resultado=Excel::load($address, function($reader) {
                    return $reader->get();
                });
            }
            if(@$save)
                return  (['val'=>true,'mensaje'=>'Se encontraron '.count($resultado->parsed).' cédulas' ,'resultado'=> count($resultado->parsed),'archivo'=>$filename]);
            else
                return  (['val'=>false,'mensaje'=>'No se pudo guardar intente de nuevo']);
        }
    }
}
