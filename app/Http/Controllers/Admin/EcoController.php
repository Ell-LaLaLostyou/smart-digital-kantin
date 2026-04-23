<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FoodWaste;
use App\Models\Donation;
use App\Models\Sale;
use App\Models\Production;
use Illuminate\Http\Request;

class EcoController extends Controller
{
    public function index()
    {
        // Calculate Total Impact
        $totalDonated = Donation::join('food_wastes', 'donations.food_waste_id', '=', 'food_wastes.id')
            ->sum('food_wastes.quantity_waste');

        $totalSales = Sale::sum('quantity_sold');
        $totalProduction = Production::sum('quantity');
        $totalWasteActual = FoodWaste::sum('quantity_waste');
        
        // Meals saved = Total Donated + (Total Production - Total Waste Actual - Total Sales ??? No)
        // Actually, meals saved from bin = Total Donated.
        // And we can also count "Waste prevented by DSS" if we have history, but let's keep it simple.
        
        $mealsSaved = $totalDonated;
        
        // Eco Conversion Factors (Estimates)
        // 1 portion approx 0.4kg. 
        // 1kg food waste = 2.5kg CO2. -> 1 portion = 1kg CO2.
        // 1kg food waste = 1000 Liters water. -> 1 portion = 400L Water.
        
        $co2Saved = $mealsSaved * 1.0; // in kg
        $waterSaved = $mealsSaved * 400; // in liters
        
        $impactHistory = Donation::with('foodWaste.menu')
            ->orderBy('donation_date', 'desc')
            ->take(10)
            ->get();

        return view('admin.eco.index', compact(
            'mealsSaved', 'co2Saved', 'waterSaved', 'impactHistory'
        ));
    }
}
