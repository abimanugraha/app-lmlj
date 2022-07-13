<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLmljsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lmljs', function (Blueprint $table) {
            $table->id();
            $table->string('nolmlj');
            $table->foreignId('unit_pengaju_id');
            $table->foreignId('pengaju_id');
            $table->foreignId('spv_pengaju_id');
            $table->tinyInteger('status');
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
        Schema::dropIfExists('lmljs');
    }
}
