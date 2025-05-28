<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\SaleItem;
use App\Models\Medicine;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class AnalyticsController extends Controller
{
    public function index()
    {
        // Query Top 5 produk terlaris berdasarkan total quantity
        $topProducts = SaleItem::select('medicines.id', 'medicines.name', DB::raw('SUM(saleitems.quantity) as total_quantity'))
            ->join('batches', 'saleitems.batch_id', '=', 'batches.id')
            ->join('medicines', 'batches.medicine_id', '=', 'medicines.id')
            ->groupBy('medicines.id', 'medicines.name')
            ->orderByDesc('total_quantity')
            ->limit(5)
            ->get();

        // Query Top 5 produk paling tidak laku (terjual sedikit) tapi pernah terjual (total_quantity > 0)
        $leastProducts = SaleItem::select('medicines.id', 'medicines.name', DB::raw('SUM(saleitems.quantity) as total_quantity'))
            ->join('batches', 'saleitems.batch_id', '=', 'batches.id')
            ->join('medicines', 'batches.medicine_id', '=', 'medicines.id')
            ->groupBy('medicines.id', 'medicines.name')
            ->havingRaw('SUM(saleitems.quantity) > 0')
            ->orderBy('total_quantity')
            ->limit(5)
            ->get();

        return view('analytics.index', [
            'topProducts' => $topProducts,
            'leastProducts' => $leastProducts,
            'topChartLabels' => $topProducts->pluck('name'),
            'topChartData' => $topProducts->pluck('total_quantity'),
            'leastChartLabels' => $leastProducts->pluck('name'),
            'leastChartData' => $leastProducts->pluck('total_quantity'),
        ]);
    }
    
    public function getTrend($range)
    {
        $now = Carbon::now();
        $data = [];

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

            // Urutkan tahun dari paling lama ke terbaru
            $data = array_reverse($data);
        }

        return response()->json($data);
    }
}