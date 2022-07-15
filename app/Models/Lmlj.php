<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lmlj extends Model
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

    public function pengaju()
    {
        return $this->belongsTo(User::class, 'pengaju_id');
    }

    public function diketahui()
    {
        return $this->belongsTo(User::class, 'spv_pengaju_id');
    }

    public function tembusan()
    {
        return $this->hasMany(Tembusan::class);
    }
}
