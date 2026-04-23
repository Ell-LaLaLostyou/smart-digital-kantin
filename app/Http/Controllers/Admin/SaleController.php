<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Production;
use App\Models\Sale;
use App\Models\FoodWaste;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function index()
    {
        $sales = Sale::with('menu')->orderBy('sale_date', 'desc')->get();
        return view('admin.sales.index', compact('sales'));
    }

    public function create()
    {
        $menus = Menu::where('status', 'available')->get();
        return view('admin.sales.create', compact('menus'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'menu_id' => 'required|exists:menus,id',
            'quantity_sold' => 'required|integer|min:0',
            'sale_date' => 'required|date',
        ]);

        $sale = Sale::create($validated);

        // Auto Calculate Waste
        $this->calculateWaste($sale->menu_id, $sale->sale_date);

        return redirect()->route('admin.sales.index')->with('success', 'Sale recorded and waste calculated automatically.');
    }

    public function destroy(Sale $sale)
    {
        $menu_id = $sale->menu_id;
        $date = $sale->sale_date;
        $sale->delete();
        
        // Recalculate waste after deletion
        $this->calculateWaste($menu_id, $date);

        return redirect()->route('admin.sales.index')->with('success', 'Sale deleted successfully.');
    }

    private function calculateWaste($menu_id, $date)
    {
        $production = Production::where('menu_id', $menu_id)->where('production_date', $date)->sum('quantity');
        $sold = Sale::where('menu_id', $menu_id)->where('sale_date', $date)->sum('quantity_sold');

        $waste = max(0, $production - $sold);

        FoodWaste::updateOrCreate(
            ['menu_id' => $menu_id, 'production_date' => $date],
            ['quantity_waste' => $waste]
        );
    }
}
