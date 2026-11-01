<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Preorder;
use Illuminate\Http\Request;

class AdminPreorderController extends Controller
{
    public function index()
    {
        $query = Preorder::with(['user', 'menu'])
            ->orderBy('preorder_date', 'asc')
            ->orderBy('created_at', 'desc');

        if (auth()->user()->role !== 'super_admin') {
            $query->where('canteen_id', auth()->user()->canteen_id);
        }

        $preorders = $query->get();
            
        return view('admin.preorders.index', compact('preorders'));
    }

    public function updateStatus(Request $request, Preorder $preorder)
    {
        if (auth()->user()->role !== 'super_admin' && $preorder->canteen_id !== auth()->user()->canteen_id) {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:pending,completed,cancelled',
        ]);

        $updateData = ['status' => $request->status];

        // Jika pesanan selesai, otomatis anggap sudah bayar
        if ($request->status == 'completed') {
            $updateData['payment_status'] = 'paid';
        }

        $preorder->update($updateData);

        return back()->with('success', 'Status pesanan dan pembayaran berhasil diperbarui.');
    }

    public function verifyPayment(Preorder $preorder)
    {
        if (auth()->user()->role !== 'super_admin' && $preorder->canteen_id !== auth()->user()->canteen_id) {
            abort(403);
        }
        $preorder->update(['payment_status' => 'paid']);
        return back()->with('success', 'Pembayaran berhasil diverifikasi.');
    }
}
