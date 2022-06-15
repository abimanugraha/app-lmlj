<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLmTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lm', function (Blueprint $table) {
            $table->id();
            $table->string('nolmlj');
            $table->string('namaproduk');
            $table->string('nomorproduk');
            $table->string('namakomponen');
            $table->string('nomorkomponen');
            $table->string('unittujuan');
            $table->string('masalah');
            $table->string('fotomasalah');
            $table->text('detailmasalah');
            $table->string('nilaitambah');
            $table->string('urgensi');
            $table->string('namapembuat');
            $table->string('unitpembuat');
            $table->date('tanggaldibuat');
            $table->string('namapenerima');
            $table->date('tanggalditerima');
            $table->string('status');
            $table->string('keterangan');
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
        Schema::dropIfExists('lm');
    }
}
