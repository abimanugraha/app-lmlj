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
            $table->foreignId('lmlj_id');
            $table->foreignId('unit_tujuan_id'); // Unit Tujuan
            $table->foreignId('komponen_id')->nullable();
            $table->text('masalah')->nullable();
            $table->text('nilai_tambah')->nullable();
            $table->tinyInteger('urgensi')->nullable();
            $table->tinyInteger('status');
            $table->string('keterangan');
            $table->string('nolmlj')->nullable();
            // $table->foreignId('produk_id')->nullable();
            // $table->foreignId('unit_id')->nullable(); // Unit Tujuan
            // $table->foreignId('pengaju_id')->nullable();
            // $table->foreignId('ygmengetahui_id')->nullable();
            $table->timestamp('tanggal_acc')->nullable();
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
