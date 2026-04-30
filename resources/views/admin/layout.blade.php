<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') — Smart Kantin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Inter', sans-serif; box-sizing: border-box; margin: 0; padding: 0; }
        html, body { height: 100%; }
        body { background: #f5f6fa; color: #1a1d23; font-size: 14px; }

        /* Layout */
        .app { display: flex; height: 100vh; overflow: hidden; }

        /* Sidebar */
        .sidebar {
            width: 240px; flex-shrink: 0;
            background: #ffffff;
            border-right: 1px solid #e8eaf0;
            display: flex; flex-direction: column;
            overflow-y: auto;
        }
        .sidebar-brand {
            padding: 20px 18px 16px;
            border-bottom: 1px solid #f0f1f5;
            display: flex; align-items: center; gap: 10px;
        }
        .brand-icon {
            width: 34px; height: 34px;
            background: linear-gradient(135deg, #b91c1c, #dc2626);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
        }
        .brand-name { font-weight: 700; font-size: 15px; color: #1a1d23; }
        .brand-sub  { font-size: 11px; color: #9198a8; font-weight: 500; }
        .sidebar-section { padding: 16px 10px 4px; }
        .sidebar-label {
            font-size: 10.5px; font-weight: 600;
            text-transform: uppercase; letter-spacing: 0.06em;
            color: #b0b7c3; padding: 0 8px; margin-bottom: 4px;
        }
        .nav-link {
            display: flex; align-items: center; gap: 9px;
            padding: 8px 10px; border-radius: 8px;
            color: #6b7280; font-weight: 500; font-size: 13.5px;
            text-decoration: none; transition: all 0.15s ease;
            margin-bottom: 1px;
        }
        .nav-link:hover { background: #f5f6fa; color: #1a1d23; }
        .nav-link.active { background: #fef2f2; color: #b91c1c; font-weight: 600; }
        .nav-link svg { width: 16px; height: 16px; flex-shrink: 0; opacity: 0.8; }
        .nav-link.active svg { opacity: 1; }

        /* Topbar */
        .topbar {
            background: #fff;
            border-bottom: 1px solid #e8eaf0;
            padding: 0 28px;
            height: 56px;
            display: flex; align-items: center; justify-content: space-between;
            flex-shrink: 0;
        }
        .topbar-title { font-weight: 600; font-size: 15px; color: #1a1d23; }
        .topbar-right { display: flex; align-items: center; gap: 12px; }

        /* Main content */
        .main { flex: 1; display: flex; flex-direction: column; overflow: hidden; }
        .content { flex: 1; overflow-y: auto; padding: 28px; }

        /* Cards */
        .card {
            background: #fff;
            border: 1px solid #e8eaf0;
            border-radius: 12px;
        }
        .card-header {
            padding: 16px 20px;
            border-bottom: 1px solid #f0f1f5;
            display: flex; align-items: center; justify-content: space-between;
        }
        .card-header h3 { font-weight: 600; font-size: 14px; color: #1a1d23; }
        .card-body { padding: 20px; }

        /* KPI */
        .kpi-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 24px; }
        .kpi-card {
            background: #fff;
            border: 1px solid #e8eaf0;
            border-radius: 12px;
            padding: 20px;
        }
        .kpi-label { font-size: 12px; font-weight: 600; color: #9198a8; text-transform: uppercase; letter-spacing: 0.04em; margin-bottom: 8px; }
        .kpi-value { font-size: 28px; font-weight: 700; line-height: 1; margin-bottom: 4px; }
        .kpi-sub { font-size: 12px; color: #9198a8; }

        /* Table */
        table { width: 100%; border-collapse: collapse; }
        th {
            text-align: left; padding: 10px 16px;
            font-size: 11.5px; font-weight: 600;
            text-transform: uppercase; letter-spacing: 0.05em;
            color: #9198a8; background: #f8f9fb;
            border-bottom: 1px solid #e8eaf0;
        }
        td { padding: 12px 16px; border-bottom: 1px solid #f0f1f5; color: #4b5563; }
        tr:last-child td { border-bottom: none; }
        tr:hover td { background: #fafbfc; }
        td strong { color: #1a1d23; font-weight: 600; }

        /* Badges */
        .badge {
            display: inline-flex; align-items: center;
            padding: 3px 10px; border-radius: 20px;
            font-size: 11.5px; font-weight: 600;
        }
        .badge-green  { background: #ecfdf5; color: #059669; }
        .badge-red    { background: #fff1f2; color: #e11d48; }
        .badge-blue   { background: #eff6ff; color: #2563eb; }
        .badge-yellow { background: #fffbeb; color: #d97706; }
        .badge-gray   { background: #f3f4f6; color: #6b7280; }
        .badge-purple { background: #f5f3ff; color: #7c3aed; }

        /* Buttons */
        .btn {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 8px 16px; border-radius: 8px;
            font-size: 13.5px; font-weight: 600;
            cursor: pointer; border: none; transition: all 0.15s;
            text-decoration: none;
        }
        .btn-primary { background: #b91c1c; color: #fff; }
        .btn-primary:hover { background: #991b1b; }
        .btn-success { background: #059669; color: #fff; }
        .btn-success:hover { background: #047857; }
        .btn-outline { background: transparent; color: #6b7280; border: 1px solid #e2e4ea; }
        .btn-outline:hover { background: #f5f6fa; color: #1a1d23; }
        .btn-danger { background: transparent; color: #e11d48; border: 1px solid #fecdd3; font-size: 12px; padding: 5px 10px; }
        .btn-danger:hover { background: #fff1f2; }
        .btn-sm { padding: 5px 12px; font-size: 12px; }

        /* Form inputs */
        .form-label { display: block; font-size: 12.5px; font-weight: 600; color: #374151; margin-bottom: 6px; }
        .form-input {
            width: 100%; padding: 9px 12px;
            background: #fff; border: 1px solid #d1d5db;
            border-radius: 8px; font-size: 13.5px;
            color: #1a1d23; transition: border-color 0.15s;
            font-family: 'Inter', sans-serif;
        }
        .form-input:focus { outline: none; border-color: #6366f1; box-shadow: 0 0 0 3px rgba(99,102,241,0.1); }
        .form-input::placeholder { color: #9ca3af; }
        .form-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 14px; }

        /* Alerts */
        .alert { padding: 12px 16px; border-radius: 8px; font-size: 13.5px; margin-bottom: 20px; display: flex; align-items: center; gap: 8px; }
        .alert-success { background: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46; }
        .alert-error   { background: #fff1f2; border: 1px solid #fecdd3; color: #9f1239; }

        /* Section header */
        .section-header { margin-bottom: 20px; }
        .section-header h2 { font-size: 20px; font-weight: 700; color: #1a1d23; margin-bottom: 4px; }
        .section-header p { font-size: 13.5px; color: #6b7280; }

        /* User avatar */
        .avatar {
            width: 32px; height: 32px; border-radius: 8px;
            background: linear-gradient(135deg, #b91c1c, #dc2626);
            color: white; font-weight: 700; font-size: 13px;
            display: flex; align-items: center; justify-content: center;
        }

        /* Progress bar */
        .progress { height: 6px; background: #e8eaf0; border-radius: 999px; overflow: hidden; }
        .progress-fill { height: 100%; border-radius: 999px; transition: width 0.3s; }

        /* Status dot */
        .dot { width: 8px; height: 8px; border-radius: 50%; display: inline-block; }

        /* Sidebar footer */
        .sidebar-footer {
            margin-top: auto; padding: 12px 10px;
            border-top: 1px solid #f0f1f5;
        }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 4px; height: 4px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 4px; }
    </style>
    @stack('styles')
</head>
<body>
<div class="app">
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-brand">
            <div class="brand-icon">
                <svg width="18" height="18" fill="none" stroke="white" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
            </div>
            <div>
                <div class="brand-name">{{ auth()->user()->canteen->name ?? 'Kantin PGRI 11' }}</div>
                <div class="brand-sub">Admin Dashboard</div>
            </div>
        </div>

        <div class="sidebar-section">
            <div class="sidebar-label">Utama</div>
            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
                Dashboard
            </a>
        </div>

        <div class="sidebar-section">
            <div class="sidebar-label">Operasional</div>
            <a href="{{ route('admin.menus.index') }}" class="nav-link {{ request()->routeIs('admin.menus.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                Menu
            </a>
            <a href="{{ route('admin.productions.index') }}" class="nav-link {{ request()->routeIs('admin.productions.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"/></svg>
                Produksi
            </a>
            <a href="{{ route('admin.sales.index') }}" class="nav-link {{ request()->routeIs('admin.sales.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                Penjualan
            </a>
            <a href="{{ route('admin.preorders.index') }}" class="nav-link {{ request()->routeIs('admin.preorders.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                Daftar Preorder
            </a>
        </div>

        <div class="sidebar-section">
            <div class="sidebar-label">Waste & Donasi</div>
            <a href="{{ route('admin.food-wastes.index') }}" class="nav-link {{ request()->routeIs('admin.food-wastes.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                Food Waste
            </a>
            <a href="{{ route('admin.donations.index') }}" class="nav-link {{ request()->routeIs('admin.donations.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                Donasi
            </a>
        </div>

        <div class="sidebar-section">
            <div class="sidebar-label">Analisis DSS</div>
            <a href="{{ route('admin.dss.index') }}" class="nav-link {{ request()->routeIs('admin.dss.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                Rekomendasi DSS
            </a>
            <a href="{{ route('admin.simulations.index') }}" class="nav-link {{ request()->routeIs('admin.simulations.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                Simulasi
            </a>
            <a href="{{ route('admin.reports.index') }}" class="nav-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Laporan Keuangan
            </a>
            <a href="{{ route('admin.eco.index') }}" class="nav-link {{ request()->routeIs('admin.eco.index') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Eco Impact
            </a>
        </div>

        <div class="sidebar-footer">
            <div style="display:flex; align-items:center; gap:10px; padding: 8px 10px; margin-bottom:4px;">
                <div class="avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                <div style="min-width:0;">
                    <div style="font-size:13px; font-weight:600; color:#1a1d23; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">{{ auth()->user()->name }}</div>
                    <div style="font-size:11px; color:#9198a8;">Administrator</div>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="nav-link" style="width:100%; background:none; border:none; cursor:pointer; color:#e11d48; font-size:13px; justify-content:flex-start;">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    Keluar
                </button>
            </form>
        </div>
    </aside>

    <!-- Main area -->
    <div class="main">
        <div class="topbar">
            <div class="topbar-title">@yield('header_title', 'Dashboard')</div>
            <div class="topbar-right">
                <span style="font-size:12px; color:#9198a8;">{{ now()->isoFormat('D MMM Y') }}</span>
                <span class="badge badge-green" style="font-size:11px;">
                    <span class="dot" style="background:#10b981; margin-right:5px;"></span> Aktif
                </span>
            </div>
        </div>

        <div class="content">
            <!-- Notification Toast Container -->
            <div id="notification-container" style="position: fixed; top: 20px; right: 20px; z-index: 9999; display: flex; flex-direction: column; gap: 10px;"></div>

            @if(session('success'))
                <div class="alert alert-success">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-error">{{ session('error') }}</div>
            @endif
            @yield('content')

    <!-- QR Code & Quick Access Section -->
    <div style="margin-top: 32px; display: grid; grid-template-columns: 2fr 1fr; gap: 24px;">
        <div class="card">
            <div class="card-header">
                <h3>Akses QR Kantin (Untuk Tamu)</h3>
            </div>
            <div class="card-body" style="display: flex; align-items: flex-start; gap: 32px;">
                <div id="qrcode" style="background: white; padding: 12px; border: 1px solid #e2e8f0; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);"></div>
                <div style="flex: 1;">
                    <h4 style="font-size: 14px; font-weight: 700; color: #1e293b; margin-bottom: 8px;">Link Publik Kantin Anda:</h4>
                    <div style="background: #f8fafc; padding: 12px 16px; border-radius: 8px; border: 1px dashed #cbd5e1; font-family: monospace; font-size: 13px; color: #b91c1c; margin-bottom: 16px; word-break: break-all;">
                        {{ url('/' . auth()->user()->canteen->slug) }}
                    </div>
                    <p style="font-size: 13px; color: #64748b; line-height: 1.5; margin-bottom: 20px;">
                        Cetak QR Code ini dan tempelkan di meja atau area kantin. Tamu dapat langsung menscan QR ini untuk melihat menu dan memesan tanpa perlu login.
                    </p>
                    <div style="display: flex; gap: 12px;">
                        <button onclick="downloadQR()" class="btn btn-primary btn-sm">
                            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="margin-right: 4px;"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                            Download QR
                        </button>
                        <button onclick="window.print()" class="btn btn-outline btn-sm">Cetak Halaman</button>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card" style="background: #fffbeb; border-color: #fef3c7;">
            <div class="card-body">
                <div style="font-size: 24px; margin-bottom: 12px;">💡</div>
                <h4 style="font-size: 14px; font-weight: 700; color: #92400e; margin-bottom: 8px;">Tips Penggunaan QR</h4>
                <ul style="font-size: 12px; color: #b45309; padding-left: 20px; line-height: 1.8;">
                    <li>Gunakan kertas foto untuk hasil cetak terbaik.</li>
                    <li>Letakkan QR di tempat yang mudah terlihat.</li>
                    <li>Ingatkan tamu untuk mengisi nomor meja di form.</li>
                </ul>
            </div>
        </div>
    </div>
        </div>
    </div>
</div>
@stack('scripts')

<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script>
    const canteenUrl = "{{ url('/' . (auth()->user()->canteen->slug ?? '')) }}";
    
    // Generate QR Code
    new QRCode(document.getElementById("qrcode"), {
        text: canteenUrl,
        width: 160,
        height: 160,
        colorDark : "#1e293b",
        colorLight : "#ffffff",
        correctLevel : QRCode.CorrectLevel.H
    });

    function downloadQR() {
        const qrCanvas = document.querySelector('#qrcode canvas');
        if (qrCanvas) {
            const link = document.createElement('a');
            link.download = 'QR-Kantin-{{ auth()->user()->canteen->slug ?? "kantin" }}.png';
            link.href = qrCanvas.toDataURL("image/png");
            link.click();
        }
    }
</script>

<!-- Firebase SDK -->
<script src="https://www.gstatic.com/firebasejs/9.22.0/firebase-app-compat.js"></script>
<script src="https://www.gstatic.com/firebasejs/9.22.0/firebase-database-compat.js"></script>

<script>
    // Firebase Configuration from .env via PHP
    const firebaseConfig = {
        databaseURL: "{{ env('FIREBASE_DATABASE_URL') }}"
    };
    
    // Initialize Firebase
    firebase.initializeApp(firebaseConfig);
    const db = firebase.database();

    // Listen for new preorders
    const preorderRef = db.ref('notifications/preorders');
    
    // We only want to notify for NEW additions since the page loaded
    let isInitialLoad = true;
    preorderRef.limitToLast(1).on('child_added', (snapshot) => {
        if (isInitialLoad) {
            isInitialLoad = false;
            return;
        }

        const data = snapshot.val();
        const userCanteenId = {{ auth()->user()->canteen_id ?? 'null' }};
        
        if (userCanteenId && data.canteen_id != userCanteenId) {
            return;
        }

        showNotification(`📦 Preorder Baru!`, `${data.user_name} memesan ${data.quantity} porsi ${data.menu_name}`);
        
        // Update dashboard count if we are on dashboard
        const poCountElement = document.getElementById('po-tomorrow-count');
        if (poCountElement) {
            let current = parseInt(poCountElement.innerText);
            poCountElement.innerText = current + parseInt(data.quantity);
        }
    });

    function showNotification(title, message) {
        const container = document.getElementById('notification-container');
        const toast = document.createElement('div');
        toast.className = 'card';
        toast.style = 'padding: 16px; min-width: 300px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); border-left: 4px solid #4f46e5; animation: slideIn 0.3s ease-out;';
        toast.innerHTML = `
            <div style="display:flex; justify-content:space-between; align-items:flex-start;">
                <div style="font-weight:700; font-size:14px; color:#1a1d23;">${title}</div>
                <button onclick="this.parentElement.parentElement.remove()" style="background:none; border:none; cursor:pointer; color:#94a3b8;">&times;</button>
            </div>
            <div style="font-size:13px; color:#6b7280; margin-top:4px;">${message}</div>
        `;
        container.appendChild(toast);

        // Auto remove after 5 seconds
        setTimeout(() => {
            if (toast.parentElement) toast.remove();
        }, 5000);
    }
</script>

<style>
    @keyframes slideIn {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
</style>
</body>
</html>
