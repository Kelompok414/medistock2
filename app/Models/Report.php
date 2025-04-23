<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanKasir extends Model
{
    use HasFactory;
    
    protected $table = 'laporan_kasirs';
    
    protected $fillable = [
        'total_transaksi',
        'persentase_bulan',
        'obat_terlaris',
        'total_terjual',
        'stok_rendah'
    ];
}