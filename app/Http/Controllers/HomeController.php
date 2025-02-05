<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BonusDetail;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = BonusDetail::select('employee_id')
            ->selectRaw('SUM(nominal) as total_nominal')
            ->groupBy('employee_id')
            ->get();
        if ($employees->isEmpty()) {
            $totalEmployees = 0;
            $totalNominal = 0;
            $highestEmployee = null;
            $lowestEmployee = null;
        } else {
            $totalEmployees = $employees->count();
            $totalNominal = $employees->sum('total_nominal');
            $highestEmployee = $employees->sortByDesc('total_nominal')->first();
            $lowestEmployee = $employees->sortBy('total_nominal')->first();
        }
        $BonusMonthly = BonusDetail::selectRaw('YEAR(created_at) as year')
        ->selectRaw('MONTH(created_at) as month')
        ->selectRaw('SUM(nominal) as total_nominal')
        ->groupBy('year', 'month')
        ->get();

        if ($BonusMonthly->isEmpty()) {
            $xValues = [];
            $yValues = [];
        } else {
            
            // Prepare monthly data in format 'Month = Nominal'
            $monthlyNominals = $BonusMonthly->mapWithKeys(function ($item) {
                // Map months to their names
                $monthNames = [
                    1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni',
                    7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                ];

                // Format as 'Month = Total Nominal'
                return [$monthNames[$item->month] => (int) $item->total_nominal];
            });
            $xValues = $monthlyNominals->keys()->toArray();
            $yValues = $monthlyNominals->values()->toArray();
        }
        return view('home')->with([
            'total_employees' => $totalEmployees,
            'highestEmployee' => $highestEmployee,
            'lowestEmployee' => $lowestEmployee,
            'totalNominal'  => $totalNominal,
            'xValues' => json_encode($xValues),
            'yValues' => json_encode($yValues)
        ]);
    }
}