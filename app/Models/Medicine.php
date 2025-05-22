<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    use HasFactory;

<<<<<<< HEAD
    protected $fillable = [
        'name',
        'batch',
        'expiry_date',
        'stock',
        'price',
    ];
}
=======
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['id', 'category_id', 'name', 'code', 'dosage', 'description'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function batches() {
        return $this->hasMany(Batch::class);
    }
}
>>>>>>> main
