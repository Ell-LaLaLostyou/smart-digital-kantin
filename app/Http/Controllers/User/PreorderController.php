<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Preorder;
use Illuminate\Http\Request;
use Kreait\Firebase\Contract\Database;

class PreorderController extends Controller
{
    protected $database;

    public function __construct(Database $database)
    {
        $this->database = $database;
    }
    public function index()
    {
        $menus = Menu::where('status', 'available')->get();
        $myPreorders = Preorder::with('menu')->where('user_id', auth()->id())->orderBy('preorder_date', 'desc')->get();
        return view('user.preorders.index', compact('menus', 'myPreorders'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'menu_id' => 'required|exists:menus,id',
            'quantity' => 'required|integer|min:1',
            'preorder_date' => 'required|date|after:today',
            'payment_method' => 'required|in:cash,transfer,ewallet',
        ]);

        $preorder = Preorder::create([
            'user_id' => auth()->id(),
            'menu_id' => $request->menu_id,
            'quantity' => $request->quantity,
            'preorder_date' => $request->preorder_date,
            'status' => 'pending',
            'payment_method' => $request->payment_method,
            'payment_status' => $request->payment_method == 'cash' ? 'unpaid' : 'paid', // Simulate auto-pay for digital
        ]);

        // Push to Firebase for Real-time notification
        try {
            $this->database->getReference('notifications/preorders')->push([
                'user_name' => auth()->user()->name,
                'menu_name' => $preorder->menu->name,
                'quantity' => $preorder->quantity,
                'timestamp' => now()->toIso8601String(),
                'status' => 'new'
            ]);
        } catch (\Exception $e) {
            // Silently fail if firebase is not reachable
        }

        return redirect()->route('preorders.index')->with('success', 'Preorder submitted successfully.');
    }
}
