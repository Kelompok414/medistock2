<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSetting extends Model
{
    use HasFactory;

    protected $table = 'user_settings';

    protected $fillable = [
        'username',
        'email',
        'phone',
        'password',
        'dob',
        'gender',
        'two_step_verification',
        'device',
        'recovery_email',
        'recovery_phone',
        'security_notification',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'dob' => 'date',
        'two_step_verification' => 'boolean',
        'security_notification' => 'boolean',
    ];
}
