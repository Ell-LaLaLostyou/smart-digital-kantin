@extends('admin.layout')
@section('title', 'Simulasi')
@section('header_title', 'Simulasi Produksi')

@section('content')
<div class="section-header">
    <h2>Analisis What-If</h2>
    <p>Simulasikan jumlah produksi untuk memprediksi potensi efisiensi dan food waste.</p>
</div>

<div style="display:grid; grid-template-columns: 320px 1fr; gap:24px;">
    <!-- Form Simulasi -->
    <div class="card" style="height: fit-content;">
        <div class="card-header"><h3>Input Parameter</h3></div>
        <div class="card-body">
            <form action="{{ route('admin.simulations.store') }}" method="POST">
                @csrf
                <div style="margin-bottom: 16px;">
                    <label class="form-label">Menu</label>
                    <select name="menu_id" class="form-input" required>
                        <option value="" disabled selected>Pilih menu...</option>
                        @foreach($menus as $menu)
                            <option value="{{ $menu->id }}">{{ $menu->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div style="margin-bottom: 24px;">
                    <label class="form-label">Rencana Produksi</label>
                    <input type="number" name="simulated_production" min="1" class="form-input" placeholder="cth: 100" required>
                </div>
                <div style="padding: 12px; background: #f5f3ff; border: 1px solid #ddd6fe; border-radius: 8px; font-size: 11.5px; color: #5b21b6; margin-bottom: 20px;">
                    Sistem menggunakan <strong>historical rate</strong> dari 14 hari terakhir untuk prediksi.
                </div>
                <button type="submit" class="btn btn-primary" style="width:100%; background: #7c3aed;">Jalankan Simulasi</button>
            </form>
        </div>
    </div>

    <!-- Hasil Simulasi -->
    <div class="card">
        <div class="card-header"><h3>Hasil Prediksi</h3></div>
        <div style="overflow-x:auto;">
            <table>
                <thead><tr>
                    <th>Menu</th>
                    <th>Rencana</th>
                    <th>Prediksi Jual</th>
                    <th>Prediksi Sisa</th>
                    <th>Efisiensi</th>
                </tr></thead>
                <tbody>
                    @forelse($simulations as $sim)
                    <tr>
                        <td><strong>{{ $sim->menu->name }}</strong></td>
                        <td><strong>{{ $sim->simulated_production }}</strong></td>
                        <td style="color:#059669; font-weight:600;">{{ $sim->expected_sales }}</td>
                        <td style="color:#e11d48; font-weight:600;">{{ $sim->expected_waste }}</td>
                        <td>
                            <div style="display:flex; align-items:center; gap:8px;">
                                <div class="progress" style="width: 60px;">
                                    <div class="progress-fill" style="width:{{ min($sim->efficiency, 100) }}%; background:{{ $sim->efficiency>=70 ? '#10b981' : ($sim->efficiency>=40 ? '#f59e0b' : '#f43f5e') }};"></div>
                                </div>
                                <span style="font-size:12px; font-weight:700; color:#1a1d23;">{{ number_format($sim->efficiency, 1) }}%</span>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" style="text-align:center; padding:48px; color:#9198a8;">Gunakan form di kiri untuk memulai simulasi.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
