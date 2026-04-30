@extends('user.layout')
@section('title', 'Pesanan Saya')

@section('content')
<div style="margin-bottom: 40px; display: flex; justify-content: space-between; align-items: flex-end;">
    <div>
        <h1 style="font-size: 28px; font-weight: 800; color: #0f172a; margin-bottom: 8px;">Riwayat Pesanan</h1>
        <p style="color: #64748b; font-size: 15px;">Pantau semua pesanan makananmu di sini.</p>
    </div>
    <a href="{{ route('welcome') }}" class="btn btn-primary" style="background: #b91c1c; border-radius: 12px; font-weight: 700;">
        + Buat Pesanan Baru
    </a>
</div>

@if(session('success'))
    <div style="background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; padding: 16px 20px; border-radius: 12px; margin-bottom: 24px; display: flex; align-items: center; gap: 12px;">
        <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
        <span style="font-weight: 600;">{{ session('success') }}</span>
    </div>
@endif

<div class="card" style="padding: 0; overflow: hidden;">
    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #f8fafc; border-bottom: 1px solid #e2e8f0;">
                    <th style="padding: 16px 24px; text-align: left; font-size: 11px; font-weight: 800; color: #64748b; text-transform: uppercase; letter-spacing: 0.1em;">No. Pesanan</th>
                    <th style="padding: 16px 24px; text-align: left; font-size: 11px; font-weight: 800; color: #64748b; text-transform: uppercase; letter-spacing: 0.1em;">Item</th>
                    <th style="padding: 16px 24px; text-align: left; font-size: 11px; font-weight: 800; color: #64748b; text-transform: uppercase; letter-spacing: 0.1em;">Kantin</th>
                    <th style="padding: 16px 24px; text-align: left; font-size: 11px; font-weight: 800; color: #64748b; text-transform: uppercase; letter-spacing: 0.1em;">Status</th>
                    <th style="padding: 16px 24px; text-align: right; font-size: 11px; font-weight: 800; color: #64748b; text-transform: uppercase; letter-spacing: 0.1em;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($myPreorders as $po)
                    <tr style="border-bottom: 1px solid #f1f5f9; transition: background 0.2s;">
                        <td style="padding: 20px 24px;">
                            <span style="font-family: monospace; font-weight: 800; color: #b91c1c; background: #fee2e2; padding: 4px 10px; border-radius: 6px; font-size: 13px;">
                                {{ $po->order_number ?? 'LEGACY' }}
                            </span>
                        </td>
                        <td style="padding: 20px 24px;">
                            <div style="font-weight: 700; color: #1e293b; margin-bottom: 2px;">{{ $po->menu->name }}</div>
                            <div style="font-size: 12px; color: #94a3b8;">{{ $po->quantity }} Porsi • Rp {{ number_format($po->menu->price * $po->quantity, 0, ',', '.') }}</div>
                        </td>
                        <td style="padding: 20px 24px;">
                            <div style="font-size: 14px; font-weight: 600; color: #475569;">{{ $po->canteen->name }}</div>
                        </td>
                        <td style="padding: 20px 24px;">
                            @php
                                $statusColor = $po->status == 'pending' ? '#d97706' : ($po->status == 'completed' ? '#059669' : '#dc2626');
                                $statusBg = $po->status == 'pending' ? '#fffbeb' : ($po->status == 'completed' ? '#f0fdf4' : '#fef2f2');
                            @endphp
                            <span style="background: {{ $statusBg }}; color: {{ $statusColor }}; padding: 4px 12px; border-radius: 99px; font-size: 11px; font-weight: 800; text-transform: uppercase;">
                                {{ $po->status }}
                            </span>
                        </td>
                        <td style="padding: 20px 24px; text-align: right;">
                            <a href="{{ route('preorders.receipt', $po->order_number) }}" style="display: inline-flex; align-items: center; gap: 6px; text-decoration: none; font-size: 13px; font-weight: 700; color: #6366f1; border: 1px solid #e0e7ff; padding: 8px 16px; border-radius: 10px; transition: all 0.2s;">
                                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                Lihat Struk
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="padding: 80px 24px; text-align: center;">
                            <div style="font-size: 40px; margin-bottom: 16px;">🥡</div>
                            <div style="font-size: 16px; font-weight: 700; color: #1e293b; margin-bottom: 4px;">Belum ada pesanan</div>
                            <p style="color: #64748b; font-size: 14px;">Ayo mulai pesan makanan dari kantin favoritmu!</p>
                            <a href="{{ route('welcome') }}" class="btn btn-primary" style="margin-top: 24px; display: inline-block;">Pilih Kantin</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
