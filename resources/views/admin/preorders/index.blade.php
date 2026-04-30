@extends('admin.layout')
@section('title', 'Manajemen Preorder')
@section('header_title', 'Daftar Preorder')

@section('content')
<div class="section-header">
    <h2>Monitoring Pesanan Masuk</h2>
    <p>Lihat dan kelola status pengambilan makanan dari preorder pelanggan.</p>
</div>

<div class="card">
    <div style="overflow-x:auto;">
        <table>
            <thead><tr>
                <th>No. Pesanan</th>
                <th>Pelanggan</th>
                <th>Menu</th>
                <th>Jumlah</th>
                <th>Tgl Ambil</th>
                <th>Status Pesanan</th>
                <th>Pembayaran</th>
                <th style="text-align:right;">Aksi</th>
            </tr></thead>
            <tbody>
                @forelse($preorders as $po)
                <tr>
                    <td>
                        <strong style="color: #b91c1c; font-family: monospace;">{{ $po->order_number ?? 'LEGACY' }}</strong>
                    </td>
                    <td>
                        @if($po->user)
                            <strong>{{ $po->user->name }}</strong><br>
                            <span style="font-size:11px; color:#9198a8;">{{ $po->user->email }}</span>
                        @else
                            <strong>{{ $po->customer_name }}</strong> <span class="badge badge-gray" style="font-size:9px;">GUEST</span><br>
                            <span style="font-size:11px; color:#9198a8;">{{ $po->customer_phone }}</span>
                        @endif
                    </td>
                    <td><strong>{{ $po->menu->name }}</strong></td>
                    <td>{{ $po->quantity }} Porsi</td>
                    <td>{{ \Carbon\Carbon::parse($po->preorder_date)->format('d M Y') }}</td>
                    <td>
                        <span style="font-size:11px; color:#1a1d23; font-weight:600;">{{ strtoupper($po->payment_method) }}</span><br>
                        <span class="badge {{ $po->payment_status == 'paid' ? 'badge-green' : 'badge-yellow' }}" style="font-size:9px;">
                            {{ strtoupper($po->payment_status) }}
                        </span>
                    </td>
                    <td>
                        <span style="background: {{ $statusBg ?? '#e5e7eb' }}; color: {{ $statusColor ?? '#374151' }}; padding: 4px 10px; border-radius: 99px; font-size: 10px; font-weight: 800; text-transform: uppercase;">
                            {{ $po->status }}
                        </span>
                    </td>
                    <td>
                        @if($po->payment_status == 'paid')
                            <span style="color: #059669; font-weight: 800; font-size: 11px;">PAID ✓</span>
                        @elseif($po->payment_status == 'pending_verification')
                            <div style="display: flex; flex-direction: column; gap: 4px;">
                                <a href="{{ asset('storage/' . $po->payment_proof) }}" target="_blank" style="color: #6366f1; font-size: 11px; font-weight: 700;">Lihat Bukti</a>
                                <form action="{{ route('admin.preorders.verify_payment', $po) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="btn btn-primary btn-sm" style="padding: 2px 8px; font-size: 10px;">Verifikasi</button>
                                </form>
                            </div>
                        @else
                            <span style="color: #64748b; font-size: 11px; font-weight: 700;">{{ strtoupper($po->payment_method) }} (UNPAID)</span>
                        @endif
                    </td>
                    <td style="text-align:right;">
                        @if($po->status == 'pending')
                        <div style="display:flex; justify-content:flex-end; gap:8px;">
                            <form action="{{ route('admin.preorders.status', $po) }}" method="POST">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="completed">
                                <button type="submit" class="btn btn-success btn-sm">Selesai</button>
                            </form>
                            <form action="{{ route('admin.preorders.status', $po) }}" method="POST">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="cancelled">
                                <button type="submit" class="btn btn-danger btn-sm">Batal</button>
                            </form>
                        </div>
                        @else
                            <span style="font-size:12px; color:#9198a8;">Sudah diproses</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" style="text-align:center; padding:48px; color:#9198a8;">Belum ada pesanan masuk.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
