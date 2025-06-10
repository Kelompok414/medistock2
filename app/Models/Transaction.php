<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    /** @use HasFactory<\Database\Factories\TransactionFactory> */
    use HasFactory, SoftDeletes;

    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['id', 'user_id', 'total_price', 'transaction_date'];
    public $timestamps = true;

    protected $casts = [
        'transaction_date' => 'datetime',
    ];

    protected static function booted()
    {
        static::deleting(function ($transaction) {
            $transaction->saleitems()->delete();
        });

        static::restoring(function ($transaction) {
            $transaction->saleitems()->withTrashed()->restore();
        });
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function saleitems()
    {
        return $this->hasMany(Saleitem::class);
    }
}
