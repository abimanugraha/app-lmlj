<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LembarJawaban extends Model
{
    use HasFactory;
    protected $table="lj";
    protected $guarded = ['id'];
    // protected $fillable = [
    //     'nolmlj', 
    //     'nomor',
    //     'analisamasalah',
    //     'nilaitambah',
    //     'urgensi',
    //     'target',
    //     'perbaikan',
    //     'keputusan',
    //     'lampiran',
    //     'namapembuat',
    //     'status',
    //     'unittujuan',
    //     'namapenerima',
    //     'tanggalditerima',
    // ];
}
