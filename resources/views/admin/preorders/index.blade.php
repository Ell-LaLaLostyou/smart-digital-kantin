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
                <th>Pelanggan</th>
                <th>Menu</th>
                <th>Jumlah</th>
                <th>Tgl Ambil</th>
                <th>Pembayaran</th>
                <th>Status</th>
                <th style="text-align:right;">Aksi</th>
            </tr></thead>
            <tbody>
                @forelse($preorders as $po)
                <tr>
                    <td>
                        <strong>{{ $po->user->name }}</strong><br>
                        <span style="font-size:11px; color:#9198a8;">{{ $po->user->email }}</span>
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
                        <span class="badge {{ $po->status == 'pending' ? 'badge-yellow' : ($po->status == 'completed' ? 'badge-green' : 'badge-red') }}">
                            {{ strtoupper($po->status) }}
                        </span>
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
