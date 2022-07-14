<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tujuan extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public function masalah()
    {
        return $this->belongsTo(Masalah::class);
    }
    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }
}
