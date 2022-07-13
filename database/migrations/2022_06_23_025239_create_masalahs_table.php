<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasalahsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('masalahs', function (Blueprint $table) {
            $table->id();
            $table->string('nolmlj');
            $table->foreignId('lmlj_id');
            $table->foreignId('produk_id');
            $table->foreignId('komponen_id')->nullable();
            $table->foreignId('unit_id'); // Unit Tujuan
            // $table->foreignId('media_id');
            // $table->foreignId('detail_id');
            $table->text('masalah');
            $table->text('nilai_tambah')->nullable();
            $table->tinyInteger('urgensi');
            $table->foreignId('pengaju_id');
            $table->foreignId('ygmengetahui_id')->nullable();
            $table->timestamp('tanggal_diterima');
            $table->tinyInteger('status');
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
        Schema::dropIfExists('masalahs');
    }
}
