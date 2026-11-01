<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use Illuminate\Http\Request;

class DonationController extends Controller
{
    public function index()
    {
        $query = Donation::with('foodWaste.menu')->orderBy('donation_date', 'desc');
        if (auth()->user()->role !== 'super_admin') {
            $query->where('canteen_id', auth()->user()->canteen_id);
        }
        $donations = $query->get();
        return view('admin.donations.index', compact('donations'));
    }

    public function destroy(Donation $donation)
    {
        if (auth()->user()->role !== 'super_admin' && $donation->canteen_id !== auth()->user()->canteen_id) {
            abort(403);
        }
        $donation->delete();
        return redirect()->route('admin.donations.index')->with('success', 'Donation record deleted.');
    }
}
