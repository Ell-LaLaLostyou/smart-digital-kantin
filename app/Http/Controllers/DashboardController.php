<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        if ($user->role === 'admin' || $user->role === 'super_admin') {
            $isSuper = $user->role === 'super_admin';
            
            $queryMenus      = \App\Models\Menu::query();
            $querySales      = \App\Models\Sale::query();
            $queryWaste      = \App\Models\FoodWaste::query();
            $queryProd       = \App\Models\Production::query();
            $queryPreorders  = \App\Models\Preorder::query();
            $queryDss        = \App\Models\DssResult::with('menu');

            if (!$isSuper) {
                $canteenId = $user->canteen_id;
                $queryMenus->where('canteen_id', $canteenId);
                $querySales->where('canteen_id', $canteenId);
                $queryWaste->where('canteen_id', $canteenId);
                $queryProd->where('canteen_id', $canteenId);
                $queryPreorders->where('canteen_id', $canteenId);
                $queryDss->where('canteen_id', $canteenId);
            }

            $totalMenus     = $queryMenus->count();
            $todaySales     = $querySales->whereDate('sale_date', today())->sum('quantity_sold');
            $todayWaste     = $queryWaste->whereDate('production_date', today())->sum('quantity_waste');
            $todayProd      = $queryProd->whereDate('production_date', today())->sum('quantity');
            $tomorrowPO     = $queryPreorders->whereDate('preorder_date', \Carbon\Carbon::tomorrow())->sum('quantity');
            $efficiencyRate = $todayProd > 0 ? round(($todaySales / $todayProd) * 100) : 0;
            $latestDss      = $queryDss->orderBy('calculation_date','desc')->take(5)->get();
            
            $canteens = [];
            if ($isSuper) {
                $canteens = \App\Models\Canteen::withCount(['menus', 'admins'])->get();
            }

            return view('admin.dashboard', compact(
                'totalMenus', 'todaySales', 'todayWaste', 'todayProd', 
                'tomorrowPO', 'efficiencyRate', 'latestDss', 'isSuper', 'canteens'
            ));
        }

        return view('dashboard');
    }
}
