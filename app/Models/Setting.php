<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        "user_id",
        'language',
        'text_size',
        'font_family',
        'dark_mode',
    ];

        protected $casts = [
        'dark_mode' => 'boolean',
    ];

    public function user()
{
    return $this->belongsTo(User::class);
}

}
