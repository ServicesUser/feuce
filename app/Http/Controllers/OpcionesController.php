<?php

namespace App\Http\Controllers;

use App\Dignidad;
use App\Movimiento;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class OpcionesController extends Controller
{
    public function movimientos(){
        return Movimiento::select('id_mo AS id','titulo_mo AS name','logo_mo AS logo')->get();
    }

    public function dignidades(){
        return Dignidad::select('id_tc AS id','titulo_tc AS name')->where('id_tc','!=',1)->orderBy('orden_tc')->get();
    }

    public function nuevaDig(Request $datos){
        $validacion =   Validator::make($datos->all(),[
            'name'      =>  'required|string|max:255|unique:tipo_candidato,titulo_tc',
            'order'     =>  'required|integer',
        ]);
        if ($validacion->fails()) {
            $mensaje="";
            foreach ($validacion->errors()->all() as $item)
                $mensaje.="$item</br>";
            return (['val'=>false,'mensaje'=>$mensaje,'errores'=>$validacion->errors()->all()]);
        }else{
            $dignidad               =   new Dignidad();
            $dignidad->titulo_tc    =   $datos->name;
            $dignidad->orden_tc     =   $datos->order;
            $dignidad->save();
            return (['val'=>true,'mensaje'=>$datos->name.' se ha guardado']);
        }
    }

    public function nuevoMov(Request $datos){
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
            'name'      =>  'required|string|max:255',
            'foto'      =>  'required|base64image',
        ],[
            'foto.base64image'  =>  'Suba un archivo de imagen válido'
        ]);
        if ($validacion->fails()) {
            $mensaje="";
            foreach ($validacion->errors()->all() as $item)
                $mensaje.="$item</br>";
            return (['val'=>false,'mensaje'=>$mensaje,'errores'=>$validacion->errors()->all()]);
        }else{
            $movimiento             =   new Movimiento();
            $movimiento->titulo_mo  =   $datos->name;
            $movimiento->logo_mo    =   'logo';
            $movimiento->save();

            $filename   =   md5($movimiento->id_mo);
            $img        =   Image::make($datos->foto)->encode('jpg');
            $save       =   Storage::disk('movimientos')->put($filename,$img);
            $url        =   route('get.logo',$filename);

            $movimiento->logo_mo    =   $url;
            $movimiento->save();

            return (['val'=>true,'mensaje'=>$datos->name.' se ha guardado correctamente']);
        }
    }

    public function buscarLogo($token=null){
        try {
            $archivo = Storage::disk('movimientos')->get($token);
            return Image::make($archivo)->response();
        } catch (FileNotFoundException $e) {
            abort(404);
        }
    }

}
