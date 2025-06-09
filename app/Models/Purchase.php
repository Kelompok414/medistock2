<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    /** @use HasFactory<\Database\Factories\PurchaseFactory> */
    use HasFactory;

    public $incrementing = false;  // important supaya Laravel tahu primary key bukan auto increment
    protected $keyType = 'string'; // primary key adalah string (UUID)

    protected $fillable = [
        'id',
        'user_id',
        'supplier_name',
        'purchase_date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(PurchaseItem::class);
    }
}
