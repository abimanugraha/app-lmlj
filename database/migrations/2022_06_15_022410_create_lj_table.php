<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLjTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lj', function (Blueprint $table) {
            $table->id();
            $table->string('nolmlj');
            $table->string('nomor');
            $table->string('analisamasalah');
            $table->string('nilaitambah');
            $table->string('urgensi');
            $table->string('target');
            $table->string('perbaikan');
            $table->string('keputusan');
            $table->string('lampiran');
            $table->string('namapembuat');
            $table->string('status');
            $table->string('unittujuan');
            $table->string('namapenerima');
            $table->string('tanggalditerima');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lj');
    }
}
