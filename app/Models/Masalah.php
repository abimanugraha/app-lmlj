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
        return $this->belongsTo(komponen::class);
    }
    
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
