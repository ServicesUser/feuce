<?php

namespace App\Http\Controllers;

use App\Campana;
use App\Candidato;
use App\Jobs\ProcesarEleccion;
use App\Padron;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use Maatwebsite\Excel\Facades\Excel;

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
            'miembros.*.dignidad.id'=>  'required|exists:tipo_candidato,id_tc',
            'miembros.*.movimiento' =>  'required|exists:movimientos,id_mo',
            'miembros.*.nombre'     =>  'required|max:250',
            'miembros.*.foto'       =>  'required|base64image',
            'miembros.*.nombre2'    =>  'nullable|max:250',
            'miembros.*.foto2'      =>  'nullable|base64image',
        ],[
            'miembros.*.foto.base64image'   =>  "Suba un archivo de imagen válido",
            'miembros.*.foto2.base64image'  =>  "Suba un archivo de imagen válido"
        ]);
        if ($validacion->fails()) {
            $mensaje="";
            foreach ($validacion->errors()->all() as $item)
                $mensaje.="$item</br>";
            return (['val'=>false,'mensaje'=>$mensaje,'errores'=>$validacion->errors()->all()]);
        }else{
            DB::beginTransaction();
            try {
                $fecha                  =   date('Y-m-d', strtotime($datos->fecha));
                $inicio                 =   date('H:i:s', strtotime($datos->inicio));
                $fin                    =   date('H:i:s', strtotime($datos->fin));


                $numero                 =   count(Auth::user()->campanas);
                $campana                =   new Campana();
                $campana->detalle_ca    =   $datos->detalle;
                $campana->desde_ca      =   "$fecha $inicio";
                $campana->vence_ca      =   "$fecha $fin";
                $campana->id_us         =   Auth::user()->id;
                $campana->id_ca         =   hash('fnv1a32',$numero.Auth::user()->id);
                $campana->save();

                $aux=[];
                foreach ($datos->miembros as $miembro){
                    $candidato                =   new Candidato();
                    $candidato->id_tc         =   $miembro['dignidad']['id'];
                    $candidato->id_mo         =   $miembro['movimiento'];
                    $candidato->id_ca         =   $campana->id_ca;
                    $candidato->nombres_cn    =   $miembro['nombre'];
                    $candidato->imagen_cn     =   1;//$miembro['foto'];
                    $candidato->nombres_s_cn  =   @$miembro['nombre2'];
                    $candidato->save();

                    $filename   =   md5($candidato->id_cn."A");
                    $img        =   Image::make($miembro['foto'])->encode('jpg');
                    $save       =   Storage::disk('candidatos')->put($filename,$img);
                    $url        =   route('get.foto',$filename);
                    $candidato->imagen_cn     =    $url;
                    unset($filename,$img,$save,$url);
                    if(@$miembro['nombre2']){
                        $filename   =   md5($candidato->id_cn."B");
                        $img        =   Image::make($miembro['foto2'])->encode('jpg');
                        $save       =   Storage::disk('candidatos')->put($filename,$img);
                        $url        =   route('get.foto',$filename);
                        $candidato->imagen_s_cn     =    $url;
                    }
                    $candidato->save();
                }
                //nulo y blanco
                $candidato                =   new Candidato();
                $candidato->id_tc         =   1;
                $candidato->id_ca         =   $campana->id_ca;
                $candidato->nombres_cn    =   "Blanco";
                $candidato->imagen_cn     =   0;
                $candidato->save();

                $candidato                =   new Candidato();
                $candidato->id_tc         =   1;
                $candidato->id_ca         =   $campana->id_ca;
                $candidato->nombres_cn    =   "Nulo";
                $candidato->imagen_cn     =   0;
                $candidato->save();

                //padron
                $path           =   collect(Storage::disk('local')->files(Auth::user()->id))->first();
                $archivo        =   Storage::disk('local')->get($path);
                $filename       =   basename($path);
                Storage::disk('excels')->put($campana->id_ca."/".$filename, $archivo);

                $address=storage_path('excel/'.$campana->id_ca."/$filename");
                $resultado=Excel::load($address, function($reader) {
                    return $reader->get();
                });


                $aux=[];
                foreach ($resultado->parsed as $fila){
                    $a['id_ca']     =   $campana->id_ca;
                    $a['ci_us']     =   $fila->ci;
                    $a['email_us']  =   @$fila->email;
                    $aux[]          =   $a;
                    unset($a);
                }
                Padron::insert($aux);
                //->allOnQueue('podcasts')
                ProcesarEleccion::dispatch($campana)->delay(now()->addMinutes(5));
                Storage::disk('local')->deleteDirectory(Auth::user()->id);
                DB::commit();
                return (['val'=>true,'mensaje'=>'Se ha guardado correctamente']);
            } catch (\Exception $e) {
                DB::rollback();
                return (['val' => false, 'mensaje' => $e]);
            }
        }
    }
}
