@extends('admin.layout')
@section('title', 'Dashboard')
@section('header_title', 'Dashboard')

@section('content')
@if($isSuper)
<div class="alert alert-success" style="background: #eff6ff; border-color: #bfdbfe; color: #1e40af; margin-bottom: 24px;">
    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
    <strong>Mode Admin Core Aktif:</strong> Anda sedang melihat monitoring sistem secara global (seluruh kantin).
</div>

<!-- System Overview Section (Super Admin Only) -->
<div class="section-header">
    <h2>Ikhtisar Sistem</h2>
    <p>Status operasional seluruh unit kantin.</p>
</div>

<div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 16px; margin-bottom: 32px;">
    @foreach($canteens as $canteen)
    <div class="card" style="border-left: 4px solid #4f46e5;">
        <div class="card-body">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 12px;">
                <h4 style="font-weight: 700; color: #1e293b;">{{ $canteen->name }}</h4>
                <span class="badge badge-green">Online</span>
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px;">
                <div style="background: #f8fafc; padding: 8px; border-radius: 6px; text-align: center;">
                    <div style="font-size: 10px; color: #94a3b8; text-transform: uppercase;">Menu</div>
                    <div style="font-size: 16px; font-weight: 700; color: #4f46e5;">{{ $canteen->menus_count }}</div>
                </div>
                <div style="background: #f8fafc; padding: 8px; border-radius: 6px; text-align: center;">
                    <div style="font-size: 10px; color: #94a3b8; text-transform: uppercase;">Staff</div>
                    <div style="font-size: 16px; font-weight: 700; color: #4f46e5;">{{ $canteen->admins_count }}</div>
                </div>
            </div>
            <a href="{{ route('admin.canteens.edit', $canteen) }}" style="display: block; text-align: center; margin-top: 12px; font-size: 12px; color: #6366f1; text-decoration: none; font-weight: 600;">Kelola Kantin →</a>
        </div>
    </div>
    @endforeach
    <a href="{{ route('admin.canteens.create') }}" style="display: flex; align-items: center; justify-content: center; border: 2px dashed #e2e8f0; border-radius: 12px; text-decoration: none; color: #94a3b8; transition: all 0.2s;" onmouseover="this.style.borderColor='#4f46e5'; this.style.color='#4f46e5';" onmouseout="this.style.borderColor='#e2e8f0'; this.style.color='#94a3b8';">
        <div style="text-align: center;">
            <div style="font-size: 24px; margin-bottom: 4px;">+</div>
            <div style="font-size: 13px; font-weight: 600;">Tambah Kantin Baru</div>
        </div>
    </a>
</div>
@endif

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

    @if(!$isSuper)
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
    @endif
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
@if(!$isSuper && auth()->user()->canteen)
<div class="card" style="margin-top: 16px;">
    <div class="card-header">
        <h3>QRIS Pembayaran Kantin</h3>
        <div style="font-size: 18px;">💸</div>
    </div>
    <div class="card-body" style="text-align: center;">
        @if(auth()->user()->canteen->payment_qr_url)
            <img src="{{ auth()->user()->canteen->payment_qr_url }}" alt="QRIS {{ auth()->user()->canteen->name }}" style="max-width: 200px; border-radius: 12px; border: 1px solid #e2e8f0; margin-bottom: 12px;">
            <p style="font-size: 13px; color: #64748b;">QRIS ini akan tampil di struk digital pelanggan saat mereka memilih metode bayar non-tunai.</p>
        @else
            <div style="padding: 24px; background: #f8fafc; border-radius: 12px; border: 1px dashed #cbd5e1; margin-bottom: 12px;">
                <p style="font-size: 13px; color: #94a3b8; font-style: italic;">Belum ada QRIS pembayaran yang diatur.</p>
            </div>
            <p style="font-size: 12px; color: #64748b;">Hubungi **Admin Core** untuk mengunggah link gambar QRIS kantin Anda agar pelanggan bisa membayar secara cashless.</p>
        @endif
    </div>
</div>
@endif

<!-- Security / Passkeys -->
<div class="card" style="margin-top: 16px;">
    <div class="card-header">
        <h3>Keamanan Biometrik (Face ID)</h3>
        <div style="font-size: 18px;">🛡️</div>
    </div>
    <div class="card-body">
        <p style="color: #6b7280; font-size: 13px; margin-bottom: 16px;">Gunakan Face ID atau sidik jari untuk login admin yang lebih cepat dan aman.</p>
        
        <div id="passkey-list" style="margin-bottom: 16px;">
            @if(auth()->user()->passkeys->count() > 0)
                @foreach(auth()->user()->passkeys as $passkey)
                    <div style="display: flex; align-items: center; justify-content: space-between; padding: 10px; background: #f8fafc; border-radius: 8px; margin-bottom: 8px; border: 1px solid #e8eaf0;">
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <svg width="16" height="16" fill="none" stroke="#64748b" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A10.003 10.003 0 0112 3c1.788 0 3.454.467 4.9 1.282m-4.63 15.818c1.744-2.772 2.753-6.054 2.753-9.571 0-1.127-.094-2.233-.275-3.312m-3.13 12.883a10.004 10.004 0 01-4.708-3.935m11.233-10.3c1.446 1.022 2.593 2.41 3.284 4.034m-1.545 10.224a10.003 10.003 0 01-4.708 3.935m-1.245-4.951a5.003 5.003 0 01-5.753-5.753m11.506 0a5.003 5.003 0 01-5.753 5.753"></path></svg>
                            <span style="font-size: 13px; font-weight: 500; color: #334155;">{{ $passkey->name }}</span>
                        </div>
                        <form action="/user/passkeys/{{ $passkey->id }}" method="POST" style="margin: 0;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="background: none; border: none; color: #ef4444; font-size: 11px; cursor: pointer; font-weight: 600;">Hapus</button>
                        </form>
                    </div>
                @endforeach
            @else
                <p style="font-size: 13px; color: #94a3b8; font-style: italic; margin-bottom: 16px;">Belum ada perangkat biometrik terdaftar.</p>
            @endif
        </div>

        <button type="button" id="register-passkey" style="background: #1a1d23; color: #fff; border: none; padding: 10px 16px; border-radius: 8px; font-size: 13px; font-weight: 600; cursor: pointer; transition: opacity 0.15s;">
            Daftarkan Perangkat Ini
        </button>
    </div>
</div>

<script>
    document.getElementById('register-passkey').addEventListener('click', async () => {
        const name = prompt('Beri nama perangkat ini (misal: Laptop Kerja, iPhone Admin):', 'Perangkat Admin');
        if (!name) return;

        try {
            await window.Passkeys.register({ name: name });
            window.location.reload();
        } catch (error) {
            console.error('Passkey registration failed:', error);
            alert('Gagal mendaftarkan perangkat. Pastikan browser lu dukung Face ID / Passkey.');
        }
    });
</script>
@endsection
