<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function komponen()
    {
        return $this->hasMany(Komponen::class);
    }

    public function masalah()
    {
        return $this->hasMany(Masalah::class);
    }

    public function lmlj()
    {
        return $this->hasMany(Lmlj::class);
    }
}
