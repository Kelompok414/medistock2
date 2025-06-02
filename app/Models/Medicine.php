<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Medicine extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'medicines';

    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'id',
        'category_id',
        'name',
        'code',
        'dosage',
        'price',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function batches() {
        return $this->hasMany(Batch::class);
    }

    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }
}