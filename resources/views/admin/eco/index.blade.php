@extends('admin.layout')
@section('title', 'Eco Impact')
@section('header_title', 'Green Dashboard 🌍')

@section('content')
<div class="section-header">
    <h2>Dampak Lingkungan & Sosial</h2>
    <p>Visualisasi kontribusi kantin dalam mengurangi jejak karbon melalui donasi dan efisiensi.</p>
</div>

<div style="display:grid; grid-template-columns: repeat(3, 1fr); gap:20px; margin-bottom:32px;">
    <!-- Meals Saved -->
    <div class="card" style="border-bottom: 4px solid #10b981; text-align:center; padding:32px;">
        <div style="font-size:48px; margin-bottom:16px;">🍱</div>
        <div style="font-size:36px; font-weight:800; color:#059669;">{{ number_format($mealsSaved) }}</div>
        <div style="font-size:14px; font-weight:600; color:#6b7280; text-transform:uppercase; letter-spacing:0.05em;">Porsi Terselamatkan</div>
        <p style="font-size:12px; color:#94a3b8; mt-2">Makanan yang didonasikan & tidak terbuang.</p>
    </div>

    <!-- CO2 Reduced -->
    <div class="card" style="border-bottom: 4px solid #3b82f6; text-align:center; padding:32px;">
        <div style="font-size:48px; margin-bottom:16px;">☁️</div>
        <div style="font-size:36px; font-weight:800; color:#2563eb;">{{ number_format($co2Saved, 1) }} kg</div>
        <div style="font-size:14px; font-weight:600; color:#6b7280; text-transform:uppercase; letter-spacing:0.05em;">CO2 Berhasil Dikurangi</div>
        <p style="font-size:12px; color:#94a3b8; mt-2">Estimasi emisi gas rumah kaca yang dicegah.</p>
    </div>

    <!-- Water Saved -->
    <div class="card" style="border-bottom: 4px solid #06b6d4; text-align:center; padding:32px;">
        <div style="font-size:48px; margin-bottom:16px;">💧</div>
        <div style="font-size:36px; font-weight:800; color:#0891b2;">{{ number_format($waterSaved) }} L</div>
        <div style="font-size:14px; font-weight:600; color:#6b7280; text-transform:uppercase; letter-spacing:0.05em;">Air Berhasil Dihemat</div>
        <p style="font-size:12px; color:#94a3b8; mt-2">Sumber daya air yang digunakan dalam produksi.</p>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3>Log Kebaikan Terbaru</h3>
    </div>
    <div style="overflow-x:auto;">
        <table>
            <thead><tr>
                <th>Tanggal</th>
                <th>Menu</th>
                <th>Jumlah</th>
                <th>Status Donasi</th>
                <th>Dampak</th>
            </tr></thead>
            <tbody>
                @forelse($impactHistory as $item)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($item->donation_date)->format('d M Y') }}</td>
                    <td><strong>{{ $item->foodWaste->menu->name ?? '—' }}</strong></td>
                    <td>{{ $item->foodWaste->quantity_waste ?? 0 }} porsi</td>
                    <td><span class="badge badge-green">Didonasikan</span></td>
                    <td style="color:#059669; font-weight:600;">
                        +{{ ($item->foodWaste->quantity_waste ?? 0) * 1 }} kg CO2 Saved
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" style="text-align:center; padding:48px; color:#94a3b8;">Belum ada data donasi yang tercatat.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div style="margin-top:32px; padding:24px; background:#ecfdf5; border:1px solid #a7f3d0; border-radius:16px; display:flex; align-items:center; gap:20px;">
    <div style="font-size:40px;">🌱</div>
    <div>
        <h4 style="font-size:18px; font-weight:700; color:#065f46; margin-bottom:4px;">Tahukah Anda?</h4>
        <p style="font-size:14px; color:#065f46; line-height:1.5;">Membuang satu porsi makanan sama saja dengan membiarkan keran air menyala selama 10 menit. Dengan mendonasikan sisa makanan, Anda telah membantu bumi sekaligus sesama.</p>
    </div>
</div>
@endsection
