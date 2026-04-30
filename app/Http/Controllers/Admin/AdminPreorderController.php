<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Preorder;
use Illuminate\Http\Request;

class AdminPreorderController extends Controller
{
    public function index()
    {
        $preorders = Preorder::with(['user', 'menu'])
            ->orderBy('preorder_date', 'asc')
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('admin.preorders.index', compact('preorders'));
    }

    public function updateStatus(Request $request, Preorder $preorder)
    {
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
        $preorder->update(['payment_status' => 'paid']);
        return back()->with('success', 'Pembayaran berhasil diverifikasi.');
    }
}
