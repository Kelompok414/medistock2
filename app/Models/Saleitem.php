<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Saleitem extends Model
{
    /** @use HasFactory<\Database\Factories\SaleitemFactory> */
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['id', 'transaction_id', 'batch_id', 'quantity', 'price_per_unit'];
}
