<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePadronesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('padrones', function (Blueprint $table) {
            $table->char('id_ca',8);
            $table->unsignedInteger('id_us')->nullable();
            $table->string('ci_us',20);
            $table->string('email_us')->nullable();
            $table->timestamps();

            $table->foreign('id_us')->references('id')->on('users');
            $table->foreign('id_ca')->references('id_ca')->on('campanas');
        });
        DB::unprepared('ALTER TABLE `padrones` ADD PRIMARY KEY ( `id_ca` ,`ci_us` )');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('padrones', function (Blueprint $table) {
            $table->dropForeign(['id_us','id_ca']);
        });
    }
}
