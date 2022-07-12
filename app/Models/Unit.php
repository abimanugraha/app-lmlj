<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function user()
    {
        return $this->hasMany(User::class);
    }
    public function masalah()
    {
        return $this->hasMany(Masalah::class);
    }
    public function jawaban()
    {
        return $this->hasMany(Jawaban::class);
    }
    public function from()
    {
        return $this->belongsTo(Forward::class);
    }
}
