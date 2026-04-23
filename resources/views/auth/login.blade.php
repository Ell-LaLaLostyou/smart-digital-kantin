<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Kantin — Masuk</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Inter', sans-serif; box-sizing: border-box; }
        body { background: #f5f6fa; min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        .card { background: #fff; border: 1px solid #e8eaf0; border-radius: 16px; padding: 36px; width: 100%; max-width: 400px; box-shadow: 0 4px 24px rgba(0,0,0,0.06); }
        .logo { display: flex; align-items: center; gap: 10px; margin-bottom: 28px; }
        .logo-icon { width: 40px; height: 40px; background: linear-gradient(135deg, #6366f1, #8b5cf6); border-radius: 12px; display: flex; align-items: center; justify-content: center; }
        h1 { font-size: 22px; font-weight: 700; color: #1a1d23; margin-bottom: 4px; }
        .sub { font-size: 13.5px; color: #9198a8; margin-bottom: 24px; }
        label { display: block; font-size: 12.5px; font-weight: 600; color: #374151; margin-bottom: 6px; }
        input { width: 100%; padding: 10px 13px; border: 1px solid #d1d5db; border-radius: 8px; font-size: 14px; font-family: 'Inter', sans-serif; color: #1a1d23; transition: border-color 0.15s; margin-bottom: 16px; }
        input:focus { outline: none; border-color: #6366f1; box-shadow: 0 0 0 3px rgba(99,102,241,0.1); }
        input::placeholder { color: #9ca3af; }
        .btn { width: 100%; padding: 11px; background: #4f46e5; color: #fff; border: none; border-radius: 8px; font-size: 14px; font-weight: 600; font-family: 'Inter', sans-serif; cursor: pointer; margin-top: 4px; transition: background 0.15s; }
        .btn:hover { background: #4338ca; }
        .footer-link { text-align: center; margin-top: 20px; font-size: 13px; color: #9198a8; }
        .footer-link a { color: #4f46e5; font-weight: 600; text-decoration: none; }
        .alert { padding: 10px 14px; border-radius: 8px; font-size: 13px; margin-bottom: 16px; }
        .alert-error { background: #fff1f2; border: 1px solid #fecdd3; color: #9f1239; }
        .alert-success { background: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46; }
        .row { display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px; }
        .row label { margin-bottom: 0; display: flex; align-items: center; gap: 6px; cursor: pointer; font-weight: 400; color: #6b7280; }
        .row input[type="checkbox"] { width: auto; margin-bottom: 0; }
        .row a { font-size: 12.5px; color: #4f46e5; text-decoration: none; font-weight: 500; }
    </style>
</head>
<body>
    <div class="card">
        <div class="logo">
            <div class="logo-icon">
                <svg width="20" height="20" fill="none" stroke="white" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
            </div>
            <div>
                <div style="font-size:16px; font-weight:700; color:#1a1d23;">Smart Kantin</div>
                <div style="font-size:11px; color:#9198a8;">Decision Support System</div>
            </div>
        </div>

        <h1>Selamat datang!</h1>
        <p class="sub">Masuk ke akun Anda untuk melanjutkan.</p>

        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif
        @if ($errors->any())
            <div class="alert alert-error">@foreach ($errors->all() as $e)<p>{{ $e }}</p>@endforeach</div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <label for="email">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="nama@email.com">
            <label for="password">Password</label>
            <input id="password" type="password" name="password" required placeholder="••••••••">
            <div class="row">
                <label><input type="checkbox" name="remember"> Ingat saya</label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}">Lupa password?</a>
                @endif
            </div>
            <button type="submit" class="btn">Masuk</button>
        </form>

        <p class="footer-link">Belum punya akun? <a href="{{ route('register') }}">Daftar gratis</a></p>
    </div>
</body>
</html>
