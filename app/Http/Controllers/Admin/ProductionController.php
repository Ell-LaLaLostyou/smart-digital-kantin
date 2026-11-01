<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Production;
use Illuminate\Http\Request;

class ProductionController extends Controller
{
    public function index()
    {
        $query = Production::with('menu')->orderBy('production_date', 'desc');
        if (auth()->user()->role !== 'super_admin') {
            $query->where('canteen_id', auth()->user()->canteen_id);
        }
        $productions = $query->get();
        return view('admin.productions.index', compact('productions'));
    }

    public function create()
    {
        $query = Menu::where('status', 'available');
        if (auth()->user()->role !== 'super_admin') {
            $query->where('canteen_id', auth()->user()->canteen_id);
        }
        $menus = $query->get();
        return view('admin.productions.create', compact('menus'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'menu_id' => 'required|exists:menus,id',
            'quantity' => 'required|integer|min:1',
            'production_date' => 'required|date',
        ]);

        if (auth()->user()->role !== 'super_admin') {
            $validated['canteen_id'] = auth()->user()->canteen_id;
        }

        Production::create($validated);
        return redirect()->route('admin.productions.index')->with('success', 'Production recorded successfully.');
    }

    public function destroy(Production $production)
    {
        if (auth()->user()->role !== 'super_admin' && $production->canteen_id !== auth()->user()->canteen_id) {
            abort(403);
        }
        $production->delete();
        return redirect()->route('admin.productions.index')->with('success', 'Production deleted successfully.');
    }
}
