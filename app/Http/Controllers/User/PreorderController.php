<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Preorder;
use Illuminate\Http\Request;
use Kreait\Firebase\Contract\Database;

use Illuminate\Support\Str;

class PreorderController extends Controller
{
    protected $database;

    public function __construct(Database $database)
    {
        $this->database = $database;
    }
    public function index()
    {
        $myPreorders = Preorder::with(['menu', 'canteen'])
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('user.preorders.index', compact('myPreorders'));
    }

    public function store(Request $request)
    {
        $rules = [
            'menu_id' => 'required|exists:menus,id',
            'quantity' => 'required|integer|min:1',
            'preorder_date' => 'required|date|after_or_equal:today',
            'payment_method' => 'required|in:cash,transfer,ewallet',
        ];

        if (!auth()->check()) {
            $rules['customer_name'] = 'required|string|max:255';
            $rules['customer_phone'] = 'required|string|max:20';
        }

        $request->validate($rules);

        $menu = Menu::find($request->menu_id);
        
        // Generate Unique Order Number
        $orderNumber = 'ORD-' . date('Ymd') . '-' . strtoupper(Str::random(4));

        $preorder = Preorder::create([
            'order_number' => $orderNumber,
            'user_id' => auth()->id(),
            'canteen_id' => $menu->canteen_id,
            'customer_name' => auth()->check() ? auth()->user()->name : $request->customer_name,
            'customer_phone' => $request->customer_phone,
            'menu_id' => $request->menu_id,
            'quantity' => $request->quantity,
            'preorder_date' => $request->preorder_date,
            'status' => 'pending',
            'payment_method' => $request->payment_method,
            'payment_status' => $request->payment_method == 'cash' ? 'unpaid' : 'paid',
        ]);

        // Push to Firebase for Real-time notification
        try {
            $this->database->getReference('notifications/preorders')->push([
                'user_name' => auth()->check() ? auth()->user()->name : $request->customer_name . ' (Guest)',
                'menu_name' => $preorder->menu->name,
                'quantity' => $preorder->quantity,
                'order_number' => $orderNumber,
                'timestamp' => now()->toIso8601String(),
                'status' => 'new',
                'canteen_id' => $menu->canteen_id
            ]);
        } catch (\Exception $e) {
            // Silently fail if firebase is not reachable
        }

        return redirect()->route('preorders.receipt', $orderNumber)->with('success', 'Pesanan berhasil dikirim!');
    }

    public function receipt($orderNumber)
    {
        $preorder = Preorder::with(['menu', 'canteen'])->where('order_number', $orderNumber)->firstOrFail();
        return view('user.preorders.receipt', compact('preorder'));
    }
    public function uploadProof(Request $request, $orderNumber)
    {
        $request->validate([
            'payment_proof' => 'required|image|max:2048',
        ]);

        $preorder = Preorder::where('order_number', $orderNumber)->firstOrFail();

        if ($request->hasFile('payment_proof')) {
            $path = $request->file('payment_proof')->store('proofs', 'public');
            $preorder->update([
                'payment_proof' => $path,
                'payment_status' => 'pending_verification' // status baru
            ]);
        }

        return back()->with('success', 'Bukti pembayaran berhasil diunggah. Menunggu verifikasi admin.');
    }
}
