<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tembusan extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function masalah()
    {
        return $this->belongsTo(Masalah::class);
    }
    public function lmlj()
    {
        return $this->belongsTo(Lmlj::class);
    }
    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }
}
