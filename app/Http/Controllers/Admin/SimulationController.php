<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Simulation;
use App\Models\Production;
use App\Models\Sale;
use Illuminate\Http\Request;

class SimulationController extends Controller
{
    public function index()
    {
        $querySims = Simulation::with('menu')->orderBy('simulation_date', 'desc');
        $queryMenus = Menu::where('status', 'available');
        
        if (auth()->user()->role !== 'super_admin') {
            $querySims->where('canteen_id', auth()->user()->canteen_id);
            $queryMenus->where('canteen_id', auth()->user()->canteen_id);
        }
        
        $simulations = $querySims->get();
        $menus = $queryMenus->get();
        return view('admin.simulations.index', compact('simulations', 'menus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'menu_id' => 'required|exists:menus,id',
            'simulated_production' => 'required|integer|min:1',
        ]);

        $menu_id = $request->menu_id;
        $simulated_production = $request->simulated_production;
        $canteen_id = auth()->user()->role !== 'super_admin' ? auth()->user()->canteen_id : Menu::find($menu_id)->canteen_id;

        // Calculate historical rate (last 14 days)
        $startDate = now()->subDays(14)->format('Y-m-d');
        
        $totalProd = Production::where('menu_id', $menu_id)
            ->where('production_date', '>=', $startDate)
            ->where('canteen_id', $canteen_id)
            ->sum('quantity');
        $totalSales = Sale::where('menu_id', $menu_id)
            ->where('sale_date', '>=', $startDate)
            ->where('canteen_id', $canteen_id)
            ->sum('quantity_sold');

        $conversionRate = $totalProd > 0 ? ($totalSales / $totalProd) : 0;

        $expected_sales = round($simulated_production * $conversionRate);
        // Ensure sales don't exceed production
        $expected_sales = min($expected_sales, $simulated_production);
        $expected_waste = $simulated_production - $expected_sales;
        
        $efficiency = $simulated_production > 0 ? ($expected_sales / $simulated_production) * 100 : 0;

        Simulation::create([
            'menu_id' => $menu_id,
            'simulated_production' => $simulated_production,
            'expected_sales' => $expected_sales,
            'expected_waste' => $expected_waste,
            'efficiency' => $efficiency,
            'simulation_date' => now()->format('Y-m-d'),
            'canteen_id' => $canteen_id,
        ]);

        return redirect()->route('admin.simulations.index')->with('success', 'Simulation generated successfully.');
    }
}
