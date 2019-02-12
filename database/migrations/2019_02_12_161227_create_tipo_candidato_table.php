<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTipoCandidatoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipo_candidato', function (Blueprint $table) {
            $table->increments('id_tc');
            $table->string('titulo_tc');
        });
        DB::table('tipo_candidato')->insert([
            [
                'id_tc'=>   1,
                'titulo_tc'=>   'Blanco/Nulo'
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tipo_candidato');
    }
}
