<?php

namespace App\Http\Controllers;

use App\Models\Canteen;
use App\Models\Menu;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
    {
        $canteens = Canteen::all();
        return view('welcome', compact('canteens'));
    }

    public function showCanteen(Canteen $canteen)
    {
        // For public viewing, we disable the CanteenScope or use the relation
        $menus = $canteen->menus()->where('status', 'available')->get();
        return view('user.canteens.show', compact('canteen', 'menus'));
    }
}
