<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LembarMasalah extends Model
{
    use HasFactory;
    protected $table="lm";
    protected $guarded = ["id"];
    // protected $fillable = [
    //     'nolmlj', 
    //     'namaproduk',
    //     'nomorproduk',
    //     'namakomponen',
    //     'nomorkomponen',
    //     'unittujuan',
    //     'masalah',
    //     'fotomasalah',
    //     'detailmasalah',
    //     'nilaitambah',
    //     'urgensi',
    //     'namapembuat',
    //     'unitpembuat',
    //     'tanggaldibuat',
    //     'namapenerima',
    //     'tanggalditerima',
    //     'status',
    //     'keterangan',
    // ];
}
