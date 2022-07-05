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

    public function pengaju()
    {
        return $this->belongsTo(User::class, 'pengaju_id');
    }
    public function forward()
    {
        return $this->hasMany(Forward::class, 'masalah_id');
    }

    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }

    public function diketahui()
    {
        return $this->belongsTo(User::class, 'ygmengetahui_id');
    }

    public function getKotakMasuk()
    {
        $data = [];
        $masalah = auth()->user()->unit->masalah;
        foreach ($masalah as $item) {
            if ($item->jawaban->count() == 0) {
                $item->color = $this->getUrgensiColor($item->urgensi);
                $item->text_status = $this->getStatusText($item->status);
                $item->target = $this->getDefaultTarget($item->urgensi);
                $data[] = $item;
            }
        }
        return $data;
    }
}
