<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Carbon\Carbon;
use PDF;

class ReportController extends Controller
{
    public function weekly(Request $request)
    {
        $week = $request->get('week', 1);
        $now = Carbon::now();
        $startOfMonth = $now->copy()->startOfMonth();
        $startDate = $startOfMonth->copy()->addWeeks($week - 1);
        $endDate = $startDate->copy()->addDays(6)->endOfDay();

        $transactions = Transaction::whereBetween('transaction_date', [$startDate, $endDate])
            ->with('user')
            ->paginate(10);

        return view('reports.index', [
            'transactions' => $transactions,
            'title' => "Weekly Report - Week $week",
            'type' => 'weekly',
            'filters' => range(1, 4),
            'selected' => $week
        ]);
    }

    public function exportWeekly(Request $request)
    {
        $week = $request->get('week', 1);
        $now = Carbon::now();
        $startOfMonth = $now->copy()->startOfMonth();
        $startDate = $startOfMonth->copy()->addWeeks($week - 1);
        $endDate = $startDate->copy()->addDays(6)->endOfDay();

        $transactions = Transaction::whereBetween('transaction_date', [$startDate, $endDate])
            ->with(['saleitems.batch.medicine'])
            ->get();

        $pdf = PDF::loadView('reports.pdf_weekly', [
            'transactions' => $transactions,
            'title' => "Weekly Report - Week $week",
            'startDate' => $startDate,
            'endDate' => $endDate,
        ]);

        return $pdf->download("weekly_report_week_{$week}.pdf");
    }


    public function monthly(Request $request)
    {
        $month = $request->get('month', now()->month);
        $year = $request->get('year', now()->year);

        $allowedYears = [now()->year, now()->subYear()->year];
        if (!in_array($year, $allowedYears)) {
            abort(403, 'Year not allowed');
        }

        $startDate = Carbon::create($year, $month, 1)->startOfMonth();
        $endDate = $startDate->copy()->endOfMonth();

        $transactions = Transaction::whereBetween('transaction_date', [$startDate, $endDate])
            ->with('user')
            ->paginate(10);

        return view('reports.index', [
            'transactions' => $transactions,
            'title' => "Monthly Report - $month/$year",
            'type' => 'monthly',
            'filters' => [
                'months' => range(1, 12),
                'years' => $allowedYears
            ],
            'selected' => ['month' => $month, 'year' => $year]
        ]);
    }

    public function exportMonthly(Request $request)
    {
        $month = $request->get('month', now()->month);
        $year = $request->get('year', now()->year);

        $allowedYears = [now()->year, now()->subYear()->year];
        if (!in_array($year, $allowedYears)) {
            abort(403, 'Year not allowed');
        }

        $startDate = Carbon::create($year, $month, 1)->startOfMonth();
        $endDate = $startDate->copy()->endOfMonth();

        $transactions = Transaction::whereBetween('transaction_date', [$startDate, $endDate])
            ->with(['saleitems.batch.medicine'])
            ->get();

        $pdf = PDF::loadView('reports.pdf_monthly', [
            'transactions' => $transactions,
            'title' => "Monthly Report - $month/$year",
            'startDate' => $startDate,
            'endDate' => $endDate,
        ]);

        return $pdf->download("monthly_report_{$month}_{$year}.pdf");
    }

    public function annual(Request $request)
    {
        $year = $request->get('year', now()->year);
        $allowedYears = range(2023, 2025);

        if (!in_array($year, $allowedYears)) {
            abort(403, 'Year not allowed');
        }

        $startDate = Carbon::create($year)->startOfYear();
        $endDate = Carbon::create($year)->endOfYear();

        $transactions = Transaction::whereBetween('transaction_date', [$startDate, $endDate])
            ->with('user')
            ->paginate(10);

        return view('reports.index', [
            'transactions' => $transactions,
            'title' => "Annual Report - $year",
            'type' => 'annual',
            'filters' => $allowedYears,
            'selected' => $year
        ]);
    }

    public function exportAnnual(Request $request)
    {
        $year = $request->get('year', now()->year);
        $allowedYears = range(2023, 2025);

        if (!in_array($year, $allowedYears)) {
            abort(403, 'Year not allowed');
        }

        $startDate = Carbon::create($year)->startOfYear();
        $endDate = Carbon::create($year)->endOfYear();

        $transactions = Transaction::whereBetween('transaction_date', [$startDate, $endDate])
            ->with(['saleitems.batch.medicine'])
            ->get();

        $pdf = PDF::loadView('reports.pdf_annual', [
            'transactions' => $transactions,
            'title' => "Annual Report - $year",
            'startDate' => $startDate,
            'endDate' => $endDate,
        ]);

        return $pdf->download("annual_report_{$year}.pdf");
    }
}
