<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FoodWaste;
use App\Models\Donation;
use Illuminate\Http\Request;

class FoodWasteController extends Controller
{
    public function index()
    {
        $wastes = FoodWaste::with('menu', 'donations')->orderBy('production_date', 'desc')->get();
        $recipients = \App\Models\Recipient::all();
        return view('admin.food_wastes.index', compact('wastes', 'recipients'));
    }

    public function donate(Request $request, FoodWaste $foodWaste)
    {
        $request->validate([
            'status' => 'required|in:layak,hampir_kadaluarsa,tidak_layak',
            'recipient_id' => 'nullable|exists:recipients,id',
        ]);

        if ($foodWaste->quantity_waste <= 0) {
            return back()->with('error', 'Cannot donate, no waste available.');
        }

        Donation::create([
            'food_waste_id' => $foodWaste->id,
            'recipient_id' => $request->recipient_id,
            'status' => $request->status,
            'donation_date' => now()->format('Y-m-d'),
        ]);

        return redirect()->route('admin.food-wastes.index')->with('success', 'Food marked for donation.');
    }
}
