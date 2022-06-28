<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jawaban extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function masalah()
    {
        return $this->belongsTo(Masalah::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function analisa()
    {
        return $this->hasMany(Analisa::class);
    }

    public function perbaikan()
    {
        return $this->hasMany(Perbaikan::class);
    }

    public function media()
    {
        return $this->hasMany(Media::class);
    }
}
