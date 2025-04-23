<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class ManagemenKasir extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'role',
        'email',
        'no_telepon',
        'username',
        'password',
    ];

    protected $hidden = [
        'password',
    ];
}