<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'medicine_id',
        'batch_number',
        'quantity',
        'expiry_date'
    ];

    protected $casts = [
        'expiry_date' => 'date', // Ini penting untuk bisa pakai ->format()
    ];

    // Relasi ke obat
    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }
}
