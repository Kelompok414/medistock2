<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;

class Medicine extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

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

    protected static function booted()
    {
        static::deleting(function ($medicine) {
            // Hapus batch secara soft delete
            $medicine->batches()->delete();
        });

        static::restoring(function ($medicine) {
            // Kembalikan batch yang terhapus saat medicine direstore
            $medicine->batches()->withTrashed()->restore();
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function batches()
    {
        return $this->hasMany(Batch::class);
    }

    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }
}
