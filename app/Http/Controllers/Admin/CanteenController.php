<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Canteen;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CanteenController extends Controller
{
    public function index()
    {
        $canteens = Canteen::withCount(['menus', 'admins'])->get();
        return view('admin.canteens.index', compact('canteens'));
    }

    public function create()
    {
        return view('admin.canteens.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image_url' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'payment_qr_url' => 'nullable|url',
        ]);

        $data = [
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'payment_qr_url' => $request->payment_qr_url,
        ];

        if ($request->hasFile('image_url')) {
            $data['image_url'] = $request->file('image_url')->store('canteens', 'public');
        }

        Canteen::create($data);

        return redirect()->route('admin.canteens.index')->with('success', 'Kantin berhasil ditambahkan.');
    }

    public function edit(Canteen $canteen)
    {
        return view('admin.canteens.edit', compact('canteen'));
    }

    public function update(Request $request, Canteen $canteen)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image_url' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'payment_qr_url' => 'nullable|url',
        ]);

        $data = [
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'payment_qr_url' => $request->payment_qr_url,
        ];

        if ($request->hasFile('image_url')) {
            if ($canteen->image_url) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($canteen->image_url);
            }
            $data['image_url'] = $request->file('image_url')->store('canteens', 'public');
        }

        $canteen->update($data);

        return redirect()->route('admin.canteens.index')->with('success', 'Kantin berhasil diperbarui.');
    }

    public function destroy(Canteen $canteen)
    {
        if ($canteen->image_url) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($canteen->image_url);
        }
        $canteen->delete();
        return redirect()->route('admin.canteens.index')->with('success', 'Kantin berhasil dihapus.');
    }
}
