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
use App\Models\Analisa;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        function penyebut($nilai)
        {
            $nilai = abs($nilai);
            $huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
            $temp = "";
            if ($nilai < 12) {
                $temp = "" . $huruf[$nilai];
            } else if ($nilai < 20) {
                $temp = penyebut($nilai - 10) . " belas";
            } else if ($nilai < 100) {
                $temp = penyebut($nilai / 10) . " puluh" . penyebut($nilai % 10);
            } else if ($nilai < 200) {
                $temp = " seratus" . penyebut($nilai - 100);
            } else if ($nilai < 1000) {
                $temp = penyebut($nilai / 100) . " ratus" . penyebut($nilai % 100);
            } else if ($nilai < 2000) {
                $temp = " seribu" . penyebut($nilai - 1000);
            } else if ($nilai < 1000000) {
                $temp = penyebut($nilai / 1000) . " ribu" . penyebut($nilai % 1000);
            } else if ($nilai < 1000000000) {
                $temp = penyebut($nilai / 1000000) . " juta" . penyebut($nilai % 1000000);
            } else if ($nilai < 1000000000000) {
                $temp = penyebut($nilai / 1000000000) . " milyar" . penyebut(fmod($nilai, 1000000000));
            } else if ($nilai < 1000000000000000) {
                $temp = penyebut($nilai / 1000000000000) . " trilyun" . penyebut(fmod($nilai, 1000000000000));
            }
            return $temp;
        }


        for ($i = 1; $i < 11; $i++) {
            $user = new User;
            $user->nama = 'Nama CC ' . penyebut($i);
            $user->username = penyebut($i) . 'cc';
            $user->password = bcrypt('12345');
            $user->role_id = 2;
            $user->unit_id = $i;
            $user->picture = 'user.png';
            $user->save();
        }
        for ($i = 1; $i < 11; $i++) {
            $user = new User;
            $user->nama = 'Nama ' . penyebut($i);
            $user->username = penyebut($i);
            $user->password = bcrypt('12345');
            $user->role_id = 1;
            $user->unit_id = $i;
            $user->picture = 'user.png';
            $user->save();
        }

        for ($i = 1; $i < 11; $i++) {
            DB::table('units')->insert([
                'unit' => penyebut($i),
                'kanit' => "Kanit " . penyebut($i),
            ]);
        }

        Produk::factory(10)->create();
        Komponen::factory(50)->create();

        // Media::factory(200)->create();
        // DetailMasalah::factory(30)->create();
        // Masalah::factory(15)->create();
        // Jawaban::factory(50)->create();
        // Perbaikan::factory(100)->create();
        // Analisa::factory(100)->create();
    }
}
