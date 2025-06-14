<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Font extends Model
{
    use HasFactory;

    protected $table = 'fonts';

    protected $fillable = [
        'name',
        'css_family',
        'google_font_name',
    ];
}
