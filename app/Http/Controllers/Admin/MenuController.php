<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        $query = Menu::query();
        if (auth()->user()->role !== 'super_admin') {
            $query->where('canteen_id', auth()->user()->canteen_id);
        }
        $menus = $query->get();
        return view('admin.menus.index', compact('menus'));
    }

    public function create()
    {
        return view('admin.menus.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category' => 'required|string',
            'status' => 'required|in:available,unavailable',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('menus', 'public');
        }

        if (auth()->user()->role !== 'super_admin') {
            $validated['canteen_id'] = auth()->user()->canteen_id;
        }

        Menu::create($validated);
        return redirect()->route('admin.menus.index')->with('success', 'Menu created successfully.');
    }

    public function edit(Menu $menu)
    {
        if (auth()->user()->role !== 'super_admin' && $menu->canteen_id !== auth()->user()->canteen_id) {
            abort(403);
        }
        return view('admin.menus.edit', compact('menu'));
    }

    public function update(Request $request, Menu $menu)
    {
        if (auth()->user()->role !== 'super_admin' && $menu->canteen_id !== auth()->user()->canteen_id) {
            abort(403);
        }
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category' => 'required|string',
            'status' => 'required|in:available,unavailable',
        ]);

        $menu->update($validated);
        return redirect()->route('admin.menus.index')->with('success', 'Menu updated successfully.');
    }

    public function destroy(Menu $menu)
    {
        if (auth()->user()->role !== 'super_admin' && $menu->canteen_id !== auth()->user()->canteen_id) {
            abort(403);
        }

        if ($menu->image) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($menu->image);
        }

        $menu->delete();
        return redirect()->route('admin.menus.index')->with('success', 'Menu deleted successfully.');
    }
}
