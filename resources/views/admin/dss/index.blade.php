@extends('admin.layout')
@section('title', 'DSS')
@section('header_title', 'Rekomendasi DSS')

@section('content')
<div class="section-header flex items-center justify-between">
    <div>
        <h2>Sistem Pendukung Keputusan</h2>
        <p>Analisis cerdas berdasarkan data historis untuk mengoptimalkan jumlah produksi.</p>
    </div>
    <form action="{{ route('admin.dss.calculate') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-primary">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
            Jalankan Analisis
        </button>
    </form>
</div>

<!-- Legend -->
<div style="display:grid; grid-template-columns: repeat(3, 1fr); gap:16px; margin-bottom:24px;">
    <div style="padding:16px; background:#fff1f2; border:1px solid #fecdd3; border-radius:12px;">
        <div style="font-size:11px; font-weight:700; color:#e11d48; text-transform:uppercase; margin-bottom:4px;">KURANGI</div>
        <div style="font-size:12px; color:#9f1239;">Waste tinggi (>30%) & preorder rendah.</div>
    </div>
    <div style="padding:16px; background:#ecfdf5; border:1px solid #a7f3d0; border-radius:12px;">
        <div style="font-size:11px; font-weight:700; color:#059669; text-transform:uppercase; margin-bottom:4px;">TAMBAH</div>
        <div style="font-size:12px; color:#065f46;">Penjualan tinggi (>80%) atau preorder naik.</div>
    </div>
    <div style="padding:16px; background:#eff6ff; border:1px solid #bfdbfe; border-radius:12px;">
        <div style="font-size:11px; font-weight:700; color:#2563eb; text-transform:uppercase; margin-bottom:4px;">TETAP</div>
        <div style="font-size:12px; color:#1e40af;">Kondisi produksi sudah optimal.</div>
    </div>
</div>

<div class="card">
    <div class="card-header"><h3>Hasil Rekomendasi Terbaru</h3></div>
    <div style="overflow-x:auto;">
        <table>
            <thead><tr>
                <th>Nama Menu</th>
                <th>Tanggal</th>
                <th>Rekomendasi</th>
                <th>Detail Alasan</th>
            </tr></thead>
            <tbody>
                @forelse($results as $result)
                <tr>
                    <td><strong>{{ $result->menu->name }}</strong></td>
                    <td>{{ \Carbon\Carbon::parse($result->calculation_date)->format('d/m/Y') }}</td>
                    <td>
                        <span class="badge {{ $result->recommendation=='TAMBAH' ? 'badge-green' : ($result->recommendation=='KURANGI' ? 'badge-red' : 'badge-blue') }}">
                            {{ $result->recommendation }}
                        </span>
                    </td>
                    <td style="font-size:12.5px; color:#6b7280;">{{ $result->reason }}</td>
                </tr>
                @empty
                <tr><td colspan="4" style="text-align:center; padding:48px; color:#9198a8;">Belum ada hasil analisis. Klik tombol di atas untuk memulai.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
