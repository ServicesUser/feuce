<?php

namespace App\Jobs;

use App\Notifications\AvisoEleccion;
use App\Padron;
use App\User;
use Exception;
use App\Campana;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class ProcesarEleccion implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $eleccion;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Campana $nueva)
    {
        $this->eleccion=$nueva;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->eleccion->padron as $votante){
            $usuario    =   User::where('dni',$votante->ci_us)->whereNotNull('dni')->first();
            if($usuario){
                Padron::where('id_ca',$votante->id_ca)
                    ->where('ci_us',$votante->ci_us)
                    ->update([
                        'id_us' =>  $usuario->id
                    ]);
            }else{
                $usuario            =   new User();
                $usuario->name      =   $votante->ci_us;
                $usuario->dni       =   $votante->ci_us;
                $usuario->email     =   $votante->email_us;
                $usuario->password  =   Hash::make(str_random(200));
                $usuario->save();
            }
            $usuario->notify(new AvisoEleccion($this->eleccion));
        }
    }

    /**
     * The job failed to process.
     *
     * @param  Exception  $exception
     * @return void
     */
    public function failed(Exception $exception)
    {
        Log::emergency($exception);
    }
}
