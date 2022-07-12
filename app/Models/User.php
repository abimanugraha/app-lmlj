<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $guarded = ['id'];
    protected $hidden = [
        'password',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function masalah()
    {
        return $this->hasMany(Masalah::class, 'pengaju_id');
    }

    public function mengetahui()
    {
        return $this->hasMany(Masalah::class, 'ygmengetahui_id');
    }

    public function jawaban()
    {
        return $this->hasMany(Jawaban::class);
    }
}
