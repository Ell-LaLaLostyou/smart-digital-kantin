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
        $query = DssResult::with('menu')->orderBy('calculation_date', 'desc');
        if (auth()->user()->role !== 'super_admin') {
            $query->where('canteen_id', auth()->user()->canteen_id);
        }
        $results = $query->get();
        return view('admin.dss.index', compact('results'));
    }

    public function calculate()
    {
        $user = auth()->user();
        $isSuper = $user->role === 'super_admin';
        
        $queryMenus = Menu::where('status', 'available');
        if (!$isSuper) {
            $queryMenus->where('canteen_id', $user->canteen_id);
        }
        $menus = $queryMenus->get();
        
        $date = now()->format('Y-m-d');
        // Calculate based on last 7 days data
        $startDate = now()->subDays(7)->format('Y-m-d');

        foreach ($menus as $menu) {
            $canteenId = $menu->canteen_id;
            
            $totalProduction = Production::where('menu_id', $menu->id)
                ->where('canteen_id', $canteenId)
                ->whereBetween('production_date', [$startDate, $date])
                ->sum('quantity');
            $totalSales = Sale::where('menu_id', $menu->id)
                ->where('canteen_id', $canteenId)
                ->whereBetween('sale_date', [$startDate, $date])
                ->sum('quantity_sold');
            $totalWaste = FoodWaste::where('menu_id', $menu->id)
                ->where('canteen_id', $canteenId)
                ->whereBetween('production_date', [$startDate, $date])
                ->sum('quantity_waste');
            
            // Upcoming preorders for tomorrow
            $tomorrow = now()->addDay()->format('Y-m-d');
            $upcomingPreorder = Preorder::where('menu_id', $menu->id)
                ->where('canteen_id', $canteenId)
                ->where('preorder_date', $tomorrow)
                ->sum('quantity');

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
                ['menu_id' => $menu->id, 'calculation_date' => $date, 'canteen_id' => $canteenId],
                [
                    'recommendation' => $recommendation,
                    'reason' => implode(' ', $reasons)
                ]
            );
        }

        return redirect()->route('admin.dss.index')->with('success', 'DSS Analysis completed successfully.');
    }
}
