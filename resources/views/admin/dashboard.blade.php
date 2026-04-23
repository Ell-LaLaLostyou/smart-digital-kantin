@extends('admin.layout')
@section('title', 'Dashboard')
@section('header_title', 'Dashboard')

@section('content')
@php
    $totalMenus     = \App\Models\Menu::count();
    $todaySales     = \App\Models\Sale::whereDate('sale_date', today())->sum('quantity_sold');
    $todayWaste     = \App\Models\FoodWaste::whereDate('production_date', today())->sum('quantity_waste');
    $todayProd      = \App\Models\Production::whereDate('production_date', today())->sum('quantity');
    $tomorrowPO     = \App\Models\Preorder::whereDate('preorder_date', \Carbon\Carbon::tomorrow())->sum('quantity');
    $efficiencyRate = $todayProd > 0 ? round(($todaySales / $todayProd) * 100) : 0;
    $latestDss      = \App\Models\DssResult::with('menu')->orderBy('calculation_date','desc')->take(5)->get();
@endphp

<!-- KPI Cards -->
<div class="kpi-grid">
    <div class="kpi-card">
        <div class="kpi-label">Total Menu</div>
        <div class="kpi-value" style="color:#4f46e5">{{ $totalMenus }}</div>
        <div class="kpi-sub">menu aktif & nonaktif</div>
    </div>
    <div class="kpi-card">
        <div class="kpi-label">Terjual Hari Ini</div>
        <div class="kpi-value" style="color:#059669">{{ $todaySales }}</div>
        <div class="kpi-sub">dari {{ $todayProd }} produksi</div>
    </div>
    <div class="kpi-card">
        <div class="kpi-label">Food Waste Hari Ini</div>
        <div class="kpi-value" style="color:#e11d48">{{ $todayWaste }}</div>
        <div class="kpi-sub">porsi terbuang</div>
    </div>
    <div class="kpi-card">
        <div class="kpi-label">Preorder Besok</div>
        <div class="kpi-value" id="po-tomorrow-count" style="color:#2563eb">{{ $tomorrowPO }}</div>
        <div class="kpi-sub">porsi dipesan</div>
    </div>
</div>

<!-- Row 2 -->
<div style="display:grid; grid-template-columns: 1fr 1fr; gap:16px; margin-bottom:16px;">

    <!-- Efisiensi -->
    <div class="card">
        <div class="card-header"><h3>Efisiensi Produksi Hari Ini</h3><span style="font-size:22px; font-weight:700; color:{{ $efficiencyRate>=70 ? '#059669' : ($efficiencyRate>=40 ? '#d97706' : '#e11d48') }}">{{ $efficiencyRate }}%</span></div>
        <div class="card-body">
            <div class="progress" style="margin-bottom:16px;">
                <div class="progress-fill" style="width:{{ $efficiencyRate }}%; background:{{ $efficiencyRate>=70 ? '#10b981' : ($efficiencyRate>=40 ? '#f59e0b' : '#f43f5e') }};"></div>
            </div>
            <div style="display:grid; grid-template-columns:repeat(3,1fr); gap:10px; text-align:center;">
                <div style="padding:12px; background:#f8f9fb; border-radius:8px;">
                    <div style="font-size:18px; font-weight:700; color:#2563eb;">{{ $todayProd }}</div>
                    <div style="font-size:11px; color:#9198a8; margin-top:2px;">Produksi</div>
                </div>
                <div style="padding:12px; background:#f8f9fb; border-radius:8px;">
                    <div style="font-size:18px; font-weight:700; color:#059669;">{{ $todaySales }}</div>
                    <div style="font-size:11px; color:#9198a8; margin-top:2px;">Terjual</div>
                </div>
                <div style="padding:12px; background:#f8f9fb; border-radius:8px;">
                    <div style="font-size:18px; font-weight:700; color:#e11d48;">{{ $todayWaste }}</div>
                    <div style="font-size:11px; color:#9198a8; margin-top:2px;">Waste</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="card">
        <div class="card-header"><h3>Aksi Cepat</h3></div>
        <div class="card-body" style="display:flex; flex-direction:column; gap:8px;">
            <a href="{{ route('admin.productions.index') }}" style="display:flex; align-items:center; gap:12px; padding:12px; background:#f8f9fb; border-radius:8px; text-decoration:none; border:1px solid #e8eaf0; transition:all 0.15s;" onmouseover="this.style.borderColor='#c7d2fe'" onmouseout="this.style.borderColor='#e8eaf0'">
                <div style="width:36px; height:36px; background:#eff0ff; border-radius:8px; display:flex; align-items:center; justify-content:center;">
                    <svg width="16" height="16" fill="none" stroke="#4f46e5" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                </div>
                <div><div style="font-size:13.5px; font-weight:600; color:#1a1d23;">Input Produksi</div><div style="font-size:12px; color:#9198a8;">Catat produksi hari ini</div></div>
            </a>
            <a href="{{ route('admin.sales.index') }}" style="display:flex; align-items:center; gap:12px; padding:12px; background:#f8f9fb; border-radius:8px; text-decoration:none; border:1px solid #e8eaf0; transition:all 0.15s;" onmouseover="this.style.borderColor='#a7f3d0'" onmouseout="this.style.borderColor='#e8eaf0'">
                <div style="width:36px; height:36px; background:#ecfdf5; border-radius:8px; display:flex; align-items:center; justify-content:center;">
                    <svg width="16" height="16" fill="none" stroke="#059669" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                </div>
                <div><div style="font-size:13.5px; font-weight:600; color:#1a1d23;">Input Penjualan</div><div style="font-size:12px; color:#9198a8;">Auto hitung food waste</div></div>
            </a>
            <form action="{{ route('admin.dss.calculate') }}" method="POST">
                @csrf
                <button type="submit" style="width:100%; display:flex; align-items:center; gap:12px; padding:12px; background:#f8f9fb; border-radius:8px; text-decoration:none; border:1px solid #e8eaf0; cursor:pointer; text-align:left; transition:all 0.15s;" onmouseover="this.style.borderColor='#fcd34d'" onmouseout="this.style.borderColor='#e8eaf0'">
                    <div style="width:36px; height:36px; background:#fffbeb; border-radius:8px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                        <svg width="16" height="16" fill="none" stroke="#d97706" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    </div>
                    <div><div style="font-size:13.5px; font-weight:600; color:#1a1d23;">Jalankan Analisis DSS</div><div style="font-size:12px; color:#9198a8;">Generate rekomendasi produksi</div></div>
                </button>
            </form>
        </div>
    </div>
</div>

<!-- DSS Results Table -->
<div class="card">
    <div class="card-header">
        <h3>Rekomendasi DSS Terbaru</h3>
        <a href="{{ route('admin.dss.index') }}" style="font-size:12.5px; color:#4f46e5; text-decoration:none; font-weight:500;">Lihat semua →</a>
    </div>
    <div style="overflow-x:auto;">
        <table>
            <thead><tr>
                <th>Menu</th><th>Tanggal</th><th>Rekomendasi</th><th>Alasan</th>
            </tr></thead>
            <tbody>
                @forelse($latestDss as $dss)
                <tr>
                    <td><strong>{{ $dss->menu->name }}</strong></td>
                    <td>{{ \Carbon\Carbon::parse($dss->calculation_date)->format('d M Y') }}</td>
                    <td>
                        <span class="badge {{ $dss->recommendation=='TAMBAH' ? 'badge-green' : ($dss->recommendation=='KURANGI' ? 'badge-red' : 'badge-blue') }}">
                            {{ $dss->recommendation }}
                        </span>
                    </td>
                    <td style="color:#6b7280; max-width:300px;">{{ $dss->reason }}</td>
                </tr>
                @empty
                <tr><td colspan="4" style="text-align:center; padding:32px; color:#9198a8;">
                    Belum ada analisis DSS. <a href="{{ route('admin.dss.index') }}" style="color:#4f46e5;">Jalankan sekarang →</a>
                </td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
