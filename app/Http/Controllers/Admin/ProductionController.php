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
        $productions = Production::with('menu')->orderBy('production_date', 'desc')->get();
        return view('admin.productions.index', compact('productions'));
    }

    public function create()
    {
        $menus = Menu::where('status', 'available')->get();
        return view('admin.productions.create', compact('menus'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'menu_id' => 'required|exists:menus,id',
            'quantity' => 'required|integer|min:1',
            'production_date' => 'required|date',
        ]);

        Production::create($validated);
        return redirect()->route('admin.productions.index')->with('success', 'Production recorded successfully.');
    }

    public function destroy(Production $production)
    {
        $production->delete();
        return redirect()->route('admin.productions.index')->with('success', 'Production deleted successfully.');
    }
}
