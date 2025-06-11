<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ReportCashierController extends Controller
{
    // ==============================
    // LAPORAN MINGGUAN
    // ==============================

    public function weekly(Request $request)
    {
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $week = $request->get('week', 1);
        $now = Carbon::now();

        $startOfMonth = $now->copy()->startOfMonth();
        $startDate = $startOfMonth->copy()->addWeeks($week - 1);
        $endDate = $startDate->copy()->addDays(6)->endOfDay();

        $transactions = Transaction::with(['saleitems.batch.medicine', 'user'])
            ->where('user_id', Auth::id())
            ->whereBetween('transaction_date', [$startDate, $endDate])
            ->paginate(10);

        return view('reports-cashier.index', [
            'transactions' => $transactions,
            'title' => "Laporan Mingguan - Minggu ke-$week",
            'type' => 'weekly',
            'filters' => range(1, 4),
            'selected' => $week
        ]);
    }

    // ==============================
    // LAPORAN BULANAN
    // ==============================

    public function monthly(Request $request)
    {
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $month = $request->get('month', now()->month);
        $year = $request->get('year', now()->year);

        $allowedYears = [now()->year, now()->subYear()->year];
        if (!in_array($year, $allowedYears)) {
            abort(403, 'Tahun tidak diperbolehkan');
        }

        $startDate = Carbon::create($year, $month, 1)->startOfMonth();
        $endDate = $startDate->copy()->endOfMonth();

        $transactions = Transaction::with(['saleitems.batch.medicine', 'user'])
            ->where('user_id', Auth::id())
            ->whereBetween('transaction_date', [$startDate, $endDate])
            ->paginate(10);

        return view('reports-cashier.index', [
            'transactions' => $transactions,
            'title' => "Laporan Bulanan - $month/$year",
            'type' => 'monthly',
            'filters' => [
                'months' => range(1, 12),
                'years' => $allowedYears
            ],
            'selected' => ['month' => $month, 'year' => $year]
        ]);
    }

    // ==============================
    // LAPORAN TAHUNAN
    // ==============================

    public function annual(Request $request)
    {
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $year = $request->get('year', now()->year);
        $allowedYears = range(2023, 2025);

        if (!in_array($year, $allowedYears)) {
            abort(403, 'Tahun tidak diperbolehkan');
        }

        $startDate = Carbon::create($year)->startOfYear();
        $endDate = Carbon::create($year)->endOfYear();

        $transactions = Transaction::with(['saleitems.batch.medicine', 'user'])
            ->where('user_id', Auth::id())
            ->whereBetween('transaction_date', [$startDate, $endDate])
            ->paginate(10);

        return view('reports-cashier.index', [
            'transactions' => $transactions,
            'title' => "Laporan Tahunan - $year",
            'type' => 'annual',
            'filters' => $allowedYears,
            'selected' => $year
        ]);
    }
}
