<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCampanasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campanas', function (Blueprint $table) {
            $table->char('id_ca',8)->primary();
            $table->unsignedInteger('id_us');
            $table->string('detalle_ca',500);
            $table->boolean('estado_ca')->default(false);
            $table->dateTime('desde_ca');
            $table->dateTime('vence_ca');
            $table->timestamps();

            $table->foreign('id_us')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('campanas', function (Blueprint $table) {
            $table->dropForeign(['id_us']);
        });
    }
}
