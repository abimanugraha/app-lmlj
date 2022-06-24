<?php

namespace Database\Seeders;

use App\Models\DetailMasalah;
use App\Models\Jawaban;
use App\Models\Komponen;
use App\Models\Masalah;
use App\Models\Media;
use App\Models\Perbaikan;
use App\Models\Produk;
use Illuminate\Database\Seeder;
use \App\Models\User;
use \App\Models\Role;
use App\Models\Unit;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory(10)->create();
        Role::factory(3)->create();
        Unit::factory(10)->create();
        Media::factory(60)->create();
        DetailMasalah::factory(30)->create();
        Produk::factory(10)->create();
        Komponen::factory(20)->create();
        Masalah::factory(14)->create();
        Jawaban::factory(26)->create();
        Perbaikan::factory(48)->create();
    }
}
