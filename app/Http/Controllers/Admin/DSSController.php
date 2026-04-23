<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Production;
use App\Models\Sale;
use App\Models\Preorder;
use App\Models\FoodWaste;
use App\Models\DssResult;
use Illuminate\Http\Request;

class DSSController extends Controller
{
    public function index()
    {
        $results = DssResult::with('menu')->orderBy('calculation_date', 'desc')->get();
        return view('admin.dss.index', compact('results'));
    }

    public function calculate()
    {
        $menus = Menu::where('status', 'available')->get();
        $date = now()->format('Y-m-d');
        // Calculate based on last 7 days data
        $startDate = now()->subDays(7)->format('Y-m-d');

        foreach ($menus as $menu) {
            $totalProduction = Production::where('menu_id', $menu->id)->whereBetween('production_date', [$startDate, $date])->sum('quantity');
            $totalSales = Sale::where('menu_id', $menu->id)->whereBetween('sale_date', [$startDate, $date])->sum('quantity_sold');
            $totalWaste = FoodWaste::where('menu_id', $menu->id)->whereBetween('production_date', [$startDate, $date])->sum('quantity_waste');
            
            // Upcoming preorders for tomorrow
            $tomorrow = now()->addDay()->format('Y-m-d');
            $upcomingPreorder = Preorder::where('menu_id', $menu->id)->where('preorder_date', $tomorrow)->sum('quantity');

            // Prevent division by zero
            if ($totalProduction == 0) {
                continue;
            }

            $wastePercentage = ($totalWaste / $totalProduction) * 100;
            $salesPercentage = ($totalSales / $totalProduction) * 100;
            
            // Heuristic thresholds
            $highWaste = 30; // 30%
            $highSales = 80; // 80%
            $lowPreorder = 5; 
            $highPreorder = 20;

            $recommendation = 'TETAP';
            $reasons = [];

            if ($wastePercentage > $highWaste && $upcomingPreorder < $lowPreorder) {
                $recommendation = 'KURANGI';
                $reasons[] = "Sisa makanan tinggi ({$wastePercentage}% dalam 7 hari terakhir).";
                $reasons[] = "Preorder besok rendah ({$upcomingPreorder} porsi).";
            } elseif ($upcomingPreorder > $highPreorder || $salesPercentage > $highSales) {
                $recommendation = 'TAMBAH';
                if ($upcomingPreorder > $highPreorder) $reasons[] = "Preorder besok tinggi ({$upcomingPreorder} porsi).";
                if ($salesPercentage > $highSales) $reasons[] = "Penjualan tinggi ({$salesPercentage}% terjual).";
            } else {
                $recommendation = 'TETAP';
                $reasons[] = "Produksi dan penjualan stabil.";
            }

            DssResult::updateOrCreate(
                ['menu_id' => $menu->id, 'calculation_date' => $date],
                [
                    'recommendation' => $recommendation,
                    'reason' => implode(' ', $reasons)
                ]
            );

            // TODO: Trigger Firebase Notification if recommendation is KURANGI or TAMBAH
        }

        return redirect()->route('admin.dss.index')->with('success', 'DSS Analysis completed successfully.');
    }
}
