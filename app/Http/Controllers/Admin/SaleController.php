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
        $query = Sale::with('menu')->orderBy('sale_date', 'desc');
        if (auth()->user()->role !== 'super_admin') {
            $query->where('canteen_id', auth()->user()->canteen_id);
        }
        $sales = $query->get();
        return view('admin.sales.index', compact('sales'));
    }

    public function create()
    {
        $query = Menu::where('status', 'available');
        if (auth()->user()->role !== 'super_admin') {
            $query->where('canteen_id', auth()->user()->canteen_id);
        }
        $menus = $query->get();
        return view('admin.sales.create', compact('menus'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'menu_id' => 'required|exists:menus,id',
            'quantity_sold' => 'required|integer|min:0',
            'sale_date' => 'required|date',
        ]);

        if (auth()->user()->role !== 'super_admin') {
            $validated['canteen_id'] = auth()->user()->canteen_id;
        }

        $sale = Sale::create($validated);

        // Auto Calculate Waste
        $this->calculateWaste($sale->menu_id, $sale->sale_date, $sale->canteen_id);

        return redirect()->route('admin.sales.index')->with('success', 'Sale recorded and waste calculated automatically.');
    }

    public function destroy(Sale $sale)
    {
        if (auth()->user()->role !== 'super_admin' && $sale->canteen_id !== auth()->user()->canteen_id) {
            abort(403);
        }
        $menu_id = $sale->menu_id;
        $date = $sale->sale_date;
        $canteen_id = $sale->canteen_id;
        $sale->delete();
        
        // Recalculate waste after deletion
        $this->calculateWaste($menu_id, $date, $canteen_id);

        return redirect()->route('admin.sales.index')->with('success', 'Sale deleted successfully.');
    }

    private function calculateWaste($menu_id, $date, $canteen_id = null)
    {
        $productionQuery = Production::where('menu_id', $menu_id)->where('production_date', $date);
        $saleQuery = Sale::where('menu_id', $menu_id)->where('sale_date', $date);

        if ($canteen_id) {
            $productionQuery->where('canteen_id', $canteen_id);
            $saleQuery->where('canteen_id', $canteen_id);
        }

        $production = $productionQuery->sum('quantity');
        $sold = $saleQuery->sum('quantity_sold');

        $waste = max(0, $production - $sold);

        FoodWaste::updateOrCreate(
            ['menu_id' => $menu_id, 'production_date' => $date, 'canteen_id' => $canteen_id],
            ['quantity_waste' => $waste]
        );
    }
}
