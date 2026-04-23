<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Production;
use App\Models\FoodWaste;
use App\Models\Menu;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', Carbon::now()->toDateString());

        $sales = Sale::with('menu')
            ->whereBetween('sale_date', [$startDate, $endDate])
            ->get();

        $productions = Production::whereBetween('production_date', [$startDate, $endDate])->get();
        $wastes = FoodWaste::whereBetween('production_date', [$startDate, $endDate])->get();

        $totalRevenue = $sales->sum(function($sale) {
            return $sale->quantity_sold * ($sale->menu->price ?? 0);
        });

        // Assuming cost is 60% of price for simulation
        $totalCost = $productions->sum(function($prod) {
            return $prod->quantity * (($prod->menu->price ?? 0) * 0.6);
        });

        $totalWasteLoss = $wastes->sum(function($waste) {
            return $waste->quantity_waste * (($waste->menu->price ?? 0) * 0.6);
        });

        $netProfit = $totalRevenue - $totalCost;

        $menuStats = Menu::withCount(['sales as total_sold' => function($q) use ($startDate, $endDate) {
            $q->whereBetween('sale_date', [$startDate, $endDate]);
        }])->get();

        return view('admin.reports.index', compact(
            'sales', 'totalRevenue', 'totalCost', 'totalWasteLoss', 
            'netProfit', 'startDate', 'endDate', 'menuStats'
        ));
    }

    public function downloadPdf(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', Carbon::now()->toDateString());

        $sales = Sale::with('menu')->whereBetween('sale_date', [$startDate, $endDate])->get();
        $totalRevenue = $sales->sum(function($sale) { return $sale->quantity_sold * ($sale->menu->price ?? 0); });
        
        $productions = Production::whereBetween('production_date', [$startDate, $endDate])->get();
        $totalCost = $productions->sum(function($prod) { return $prod->quantity * (($prod->menu->price ?? 0) * 0.6); });
        
        $wastes = FoodWaste::whereBetween('production_date', [$startDate, $endDate])->get();
        $totalWasteLoss = $wastes->sum(function($waste) { return $waste->quantity_waste * (($waste->menu->price ?? 0) * 0.6); });

        $netProfit = $totalRevenue - $totalCost;

        $pdf = Pdf::loadView('admin.reports.pdf', compact(
            'sales', 'totalRevenue', 'totalCost', 'totalWasteLoss', 
            'netProfit', 'startDate', 'endDate'
        ));

        return $pdf->download('Laporan_Keuangan_Kantin_'.$startDate.'_to_'.$endDate.'.pdf');
    }
}
