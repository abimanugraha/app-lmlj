<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Masalah extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function jawaban()
    {
        return $this->hasMany(Jawaban::class);
    }

    public function detailmasalah()
    {
        return $this->hasMany(DetailMasalah::class);
    }

    public function media()
    {
        return $this->hasMany(Media::class);
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }

    public function komponen()
    {
        return $this->belongsTo(Komponen::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function pengaju()
    {
        return $this->belongsTo(User::class, 'pengaju_id');
    }
    public function forward()
    {
        return $this->hasMany(Forward::class, 'masalah_id');
    }
    public function tembusan()
    {
        return $this->hasMany(Tembusan::class, 'masalah_id');
    }
    public function tujuan()
    {
        return $this->hasMany(Tujuan::class, 'masalah_id');
    }

    public function diketahui()
    {
        return $this->belongsTo(User::class, 'ygmengetahui_id');
    }

    public function lmlj()
    {
        return $this->belongsTo(Lmlj::class);
    }
}
