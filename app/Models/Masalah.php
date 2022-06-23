<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Masalah extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function detailmasalahs()
    {
        return $this->hasMany(DetailMasalah::class);
    }
}
