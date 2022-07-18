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
    public function penerima()
    {
        return $this->belongsTo(User::class, 'penerima_id');
    }
    public function pic()
    {
        return $this->belongsTo(User::class, 'pic_id');
    }
    public function unit_tujuan()
    {
        return $this->belongsTo(Unit::class, 'unit_tujuan_id');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function analisas()
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

    public function forward()
    {
        return $this->hasMany(Forward::class);
    }
}
