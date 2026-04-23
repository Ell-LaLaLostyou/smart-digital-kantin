@extends('admin.layout')
@section('title', 'Laporan Keuangan')
@section('header_title', 'Laporan Keuangan')

@section('content')
<div class="section-header flex items-center justify-between">
    <div>
        <h2>Analisis Pendapatan & Efisiensi</h2>
        <p>Pantau performa finansial kantin berdasarkan periode waktu.</p>
    </div>
    <div style="display:flex; gap:12px;">
        <form method="GET" style="display:flex; gap:8px; align-items:center; background:#fff; padding:4px 12px; border:1px solid #e8eaf0; border-radius:10px;">
            <input type="date" name="start_date" value="{{ $startDate }}" class="form-input" style="border:none; padding:4px;">
            <span style="color:#94a3b8;">s/d</span>
            <input type="date" name="end_date" value="{{ $endDate }}" class="form-input" style="border:none; padding:4px;">
            <button type="submit" class="btn btn-outline btn-sm">Filter</button>
        </form>
        <a href="{{ route('admin.reports.download', ['start_date' => $startDate, 'end_date' => $endDate]) }}" class="btn btn-primary">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
            Cetak PDF
        </a>
    </div>
</div>

<div class="kpi-grid">
    <div class="kpi-card" style="border-top: 4px solid #4f46e5;">
        <div class="kpi-label">Total Pendapatan</div>
        <div class="kpi-value">Rp{{ number_format($totalRevenue, 0, ',', '.') }}</div>
        <div class="kpi-sub">Total penjualan kotor</div>
    </div>
    <div class="kpi-card" style="border-top: 4px solid #ef4444;">
        <div class="kpi-label">Estimasi Modal</div>
        <div class="kpi-value" style="color:#ef4444;">Rp{{ number_format($totalCost, 0, ',', '.') }}</div>
        <div class="kpi-sub">Biaya produksi (est. 60%)</div>
    </div>
    <div class="kpi-card" style="border-top: 4px solid #f59e0b;">
        <div class="kpi-label">Kerugian Waste</div>
        <div class="kpi-value" style="color:#f59e0b;">Rp{{ number_format($totalWasteLoss, 0, ',', '.') }}</div>
        <div class="kpi-sub">Modal yang terbuang</div>
    </div>
    <div class="kpi-card" style="border-top: 4px solid #10b981;">
        <div class="kpi-label">Laba Bersih</div>
        <div class="kpi-value" style="color:#10b981;">Rp{{ number_format($netProfit, 0, ',', '.') }}</div>
        <div class="kpi-sub">Estimasi keuntungan bersih</div>
    </div>
</div>

<div style="display:grid; grid-template-columns: 1fr 1fr; gap:24px;">
    <!-- Menu Performance -->
    <div class="card">
        <div class="card-header"><h3>Performa Menu (Terjual)</h3></div>
        <div style="overflow-x:auto;">
            <table>
                <thead><tr><th>Menu</th><th style="text-align:right;">Terjual</th></tr></thead>
                <tbody>
                    @foreach($menuStats as $menu)
                    <tr>
                        <td><strong>{{ $menu->name }}</strong></td>
                        <td style="text-align:right;">{{ $menu->total_sold }} porsi</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Latest Transactions -->
    <div class="card">
        <div class="card-header"><h3>Transaksi Terbaru</h3></div>
        <div style="overflow-x:auto;">
            <table>
                <thead><tr><th>Tanggal</th><th>Menu</th><th style="text-align:right;">Total</th></tr></thead>
                <tbody>
                    @foreach($sales->take(8) as $sale)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($sale->sale_date)->format('d/m') }}</td>
                        <td>{{ $sale->menu->name }}</td>
                        <td style="text-align:right;">Rp{{ number_format($sale->quantity_sold * ($sale->menu->price ?? 0), 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
