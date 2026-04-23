<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Portal — Smart Kantin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Inter', sans-serif; box-sizing: border-box; margin: 0; padding: 0; }
        body { background: #f8fafc; color: #1a1d23; font-size: 14px; min-height: 100vh; display: flex; flex-direction: column; }

        /* Nav */
        nav { background: #fff; border-bottom: 1px solid #e8eaf0; height: 64px; display: flex; align-items: center; position: sticky; top: 0; z-index: 50; }
        .nav-inner { max-width: 1100px; margin: 0 auto; width: 100%; padding: 0 24px; display: flex; align-items: center; justify-content: space-between; }
        .logo { display: flex; align-items: center; gap: 10px; text-decoration: none; }
        .logo-icon { width: 32px; height: 32px; background: linear-gradient(135deg, #6366f1, #8b5cf6); border-radius: 8px; display: flex; align-items: center; justify-content: center; }
        .logo-text { font-weight: 700; font-size: 16px; color: #1a1d23; }
        .nav-links { display: flex; align-items: center; gap: 24px; }
        .nav-link { text-decoration: none; color: #6b7280; font-weight: 500; font-size: 14px; transition: color 0.15s; }
        .nav-link:hover, .nav-link.active { color: #4f46e5; }
        
        /* User Info */
        .user-menu { display: flex; align-items: center; gap: 12px; padding-left: 20px; border-left: 1px solid #f0f1f5; }
        .avatar { width: 32px; height: 32px; border-radius: 50%; background: #eff0ff; color: #4f46e5; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 12px; }

        /* Main Content */
        main { flex: 1; max-width: 1100px; margin: 0 auto; width: 100%; padding: 32px 24px; }

        /* Cards */
        .card { background: #fff; border: 1px solid #e8eaf0; border-radius: 12px; padding: 24px; }
        .card-title { font-size: 16px; font-weight: 700; margin-bottom: 16px; color: #1a1d23; }

        /* Buttons */
        .btn { display: inline-flex; align-items: center; gap: 8px; padding: 10px 20px; border-radius: 8px; font-size: 14px; font-weight: 600; cursor: pointer; border: none; transition: all 0.15s; text-decoration: none; }
        .btn-primary { background: #4f46e5; color: #fff; }
        .btn-primary:hover { background: #4338ca; transform: translateY(-1px); }
        .btn-outline { background: transparent; color: #6b7280; border: 1px solid #e2e4ea; }
        .btn-outline:hover { background: #f9fafb; color: #1a1d23; }

        /* Badge */
        .badge { display: inline-flex; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 600; text-transform: uppercase; }
        .badge-green { background: #ecfdf5; color: #059669; }
        .badge-blue { background: #eff6ff; color: #2563eb; }
        .badge-yellow { background: #fffbeb; color: #d97706; }

        /* Alerts */
        .alert { padding: 12px 16px; border-radius: 10px; font-size: 14px; margin-bottom: 24px; display: flex; align-items: center; gap: 8px; }
        .alert-success { background: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46; }

        footer { padding: 32px; text-align: center; color: #94a3b8; font-size: 13px; border-top: 1px solid #e8eaf0; background: #fff; }
    </style>
    @stack('styles')
</head>
<body>

    <nav>
        <div class="nav-inner">
            <a href="{{ route('dashboard') }}" class="logo">
                <div class="logo-icon">
                    <svg width="18" height="18" fill="none" stroke="white" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
                <span class="logo-text">Smart Kantin</span>
            </a>
            
            <div class="flex items-center gap-6">
                <div class="nav-links">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">Home</a>
                    <a href="{{ route('preorders.index') }}" class="nav-link {{ request()->routeIs('preorders.*') ? 'active' : '' }}">Pesanan Saya</a>
                </div>
                
                <div class="user-menu">
                    <div class="avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-outline btn-sm" style="padding: 4px 10px; font-size: 12px;">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <main>
        @if(session('success'))
            <div class="alert alert-success">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                {{ session('success') }}
            </div>
        @endif

        @yield('content')
    </main>

    <footer>
        &copy; {{ date('Y') }} Smart Kantin — Sistem Preorder Cerdas
    </footer>

    @stack('scripts')
</body>
</html>
