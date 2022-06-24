<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJawabansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jawabans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('masalah_id')->nullable();            
            $table->text('analisa');            
            $table->tinyInteger('urgensi');            
            $table->tinyInteger('target'); 
            $table->timestamp('tanggal_diterima')->nullable();            
            $table->foreignId('penerima_id')->nullable();   // Nama Penerima            
            // hasMany Perbaikan
            $table->text('nilai_tambah')->nullable();            
            $table->text('keputusan')->nullable();
            // hasMany Lampiran {Media}
            $table->foreignId('pic_id')->nullable();   // Nama Pembuat            
            $table->tinyInteger('status')->nullable();            
            $table->foreignId('user_tujuan_id')->nullable();    // User Tujuan {Forward}            
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
        Schema::dropIfExists('jawabans');
    }
}
