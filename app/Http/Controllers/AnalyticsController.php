<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Saleitem;
use App\Models\Medicine;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    // Menampilkan halaman analytics
    public function index()
    {
        // Mengambil 5 produk terlaris berdasarkan jumlah penjualan (quantity terbanyak)
        $topProducts = Saleitem::select('medicines.id', 'medicines.name', DB::raw('SUM(saleitems.quantity) as total_quantity'))
            ->join('batches', 'saleitems.batch_id', '=', 'batches.id')
            ->join('medicines', 'batches.medicine_id', '=', 'medicines.id')
            ->groupBy('medicines.id', 'medicines.name')
            ->orderByDesc('total_quantity')
            ->limit(5)
            ->get();

        // Mengambil 5 produk yang paling sedikit terjual (tetapi pernah terjual)
        $leastProducts = Saleitem::select('medicines.id', 'medicines.name', DB::raw('SUM(saleitems.quantity) as total_quantity'))
            ->join('batches', 'saleitems.batch_id', '=', 'batches.id')
            ->join('medicines', 'batches.medicine_id', '=', 'medicines.id')
            ->groupBy('medicines.id', 'medicines.name')
            ->havingRaw('SUM(saleitems.quantity) > 0') // hanya produk yang pernah terjual
            ->orderBy('total_quantity')
            ->limit(5)
            ->get();

        // Mengirim data ke view analytics.index untuk ditampilkan di frontend (termasuk label dan data chart)
        return view('analytics.index', [
            'topProducts' => $topProducts,
            'leastProducts' => $leastProducts,
            'topChartLabels' => $topProducts->pluck('name'),
            'topChartData' => $topProducts->pluck('total_quantity'),
            'leastChartLabels' => $leastProducts->pluck('name'),
            'leastChartData' => $leastProducts->pluck('total_quantity'),
        ]);
    }

    // Mengambil data tren penjualan berdasarkan rentang waktu: mingguan, bulanan, atau tahunan
    public function getTrend($range)
    {
        $now = Carbon::now(); // waktu saat ini
        $data = [];

        // Jika rentang mingguan, ambil total penjualan per minggu dalam bulan ini
        if ($range === 'mingguan') {
            $start = $now->copy()->startOfMonth();
            for ($i = 0; $i < 4; $i++) {
                $weekStart = $start->copy()->addWeeks($i);
                $weekEnd = $weekStart->copy()->addDays(6)->endOfDay();

                $total = Transaction::whereBetween('transaction_date', [$weekStart, $weekEnd])
                    ->sum('total_price');

                $data[] = [
                    'label' => 'Minggu ' . ($i + 1),
                    'total' => $total,
                ];
            }

        // Jika rentang bulanan, ambil total penjualan setiap bulan dalam 1 tahun
        } elseif ($range === 'bulanan') {
            for ($i = 1; $i <= 12; $i++) {
                $start = Carbon::create($now->year, $i, 1)->startOfMonth();
                $end = $start->copy()->endOfMonth();

                $total = Transaction::whereBetween('transaction_date', [$start, $end])
                    ->sum('total_price');

                $data[] = [
                    'label' => $start->translatedFormat('F'), // Nama bulan lokal
                    'total' => $total,
                ];
            }

        // Jika rentang tahunan, ambil total penjualan per tahun selama 3 tahun terakhir
        } elseif ($range === 'tahunan') {
            for ($i = 0; $i < 3; $i++) {
                $year = $now->year - $i;
                $start = Carbon::create($year, 1, 1)->startOfYear();
                $end = Carbon::create($year, 12, 31)->endOfYear();

                $total = Transaction::whereBetween('transaction_date', [$start, $end])
                    ->sum('total_price');

                $data[] = [
                    'label' => (string) $year,
                    'total' => $total,
                ];
            }

            // Urutkan agar tahun paling lama di depan
            $data = array_reverse($data);
        }

        // Kembalikan data dalam format JSON untuk digunakan di frontend (Chart.js misalnya)
        return response()->json($data);
    }
}
