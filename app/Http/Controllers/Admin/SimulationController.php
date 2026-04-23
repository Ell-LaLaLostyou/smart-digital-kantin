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
        $simulations = Simulation::with('menu')->orderBy('simulation_date', 'desc')->get();
        $menus = Menu::where('status', 'available')->get();
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

        // Calculate historical rate (last 14 days)
        $startDate = now()->subDays(14)->format('Y-m-d');
        
        $totalProd = Production::where('menu_id', $menu_id)->where('production_date', '>=', $startDate)->sum('quantity');
        $totalSales = Sale::where('menu_id', $menu_id)->where('sale_date', '>=', $startDate)->sum('quantity_sold');

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
        ]);

        return redirect()->route('admin.simulations.index')->with('success', 'Simulation generated successfully.');
    }
}
