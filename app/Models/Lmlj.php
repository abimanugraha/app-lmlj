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
}
