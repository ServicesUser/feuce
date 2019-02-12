<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVotosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('votos', function (Blueprint $table) {
            $table->unsignedBigInteger('papeleta_vo');
            $table->unsignedInteger('id_us');
            $table->unsignedInteger('id_cn');
            $table->char('id_ca',4);
            $table->char('firma_vo',128)->unique();
            $table->timestamps();

            $table->foreign('id_us')->references('id_us')->on('padrones');
            $table->foreign('id_ca')->references('id_ca')->on('padrones');
            $table->foreign('id_cn')->references('id_cn')->on('candidatos');
        });
        DB::unprepared('ALTER TABLE `votos` ADD PRIMARY KEY( `id_us`, `id_ca` , `id_cn`)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('votos', function (Blueprint $table) {
            $table->dropForeign(['id_us','id_ca','id_cn']);
        });
    }
}
