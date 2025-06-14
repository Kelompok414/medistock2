<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Saleitem extends Model
{
    /** @use HasFactory<\Database\Factories\SaleitemFactory> */
    use HasFactory, SoftDeletes;

    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['id', 'transaction_id', 'batch_id', 'quantity', 'price_per_unit', 'subtotal'];

    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}
