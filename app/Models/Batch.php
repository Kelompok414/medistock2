<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

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

    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }
    
    public function isExpired()
    {
        return $this->expiry_date->isPast();
    }
    
    public function willExpireSoon()
    {
        return !$this->isExpired() && $this->expiry_date->lte(Carbon::now()->addMonths(3));
    }
    
    public function isLowStock()
    {
        return $this->quantity < 30 && $this->quantity > 0;
    }
}
