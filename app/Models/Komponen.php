<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Komponen extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function masalah()
    {
        return $this->hasMany(Masalah::class);
    }
    
    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }
}
