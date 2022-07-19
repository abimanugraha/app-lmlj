<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryKomponen extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function komponenlama()
    {
        return $this->belongsTo(Komponen::class, 'komponen_lama');
    }
    public function komponenbaru()
    {
        return $this->belongsTo(Komponen::class, 'komponen_baru');
    }
}
