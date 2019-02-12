<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCandidatosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('candidatos', function (Blueprint $table) {
            $table->increments('id_cn');
            $table->unsignedInteger('id_tc');
            $table->unsignedInteger('id_mo')->nullable();
            $table->char('id_ca',4);
            $table->string('nombres_cn',300);
            $table->string('imagen_cn',300);
            $table->timestamps();

            $table->foreign('id_ca')->references('id_ca')->on('campanas');
            $table->foreign('id_tc')->references('id_tc')->on('tipo_candidato');
            $table->foreign('id_mo')->references('id_mo')->on('movimientos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('candidatos', function (Blueprint $table) {
            $table->dropForeign(['id_ca','id_tc','id_mo']);
        });
    }
}
