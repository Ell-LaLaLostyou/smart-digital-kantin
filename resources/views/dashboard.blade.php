@extends('user.layout')
@section('title', 'Dashboard')

@section('content')
<div style="margin-bottom: 32px;">
    <h1 style="font-size: 24px; font-weight: 800; color: #1a1d23; margin-bottom: 8px;">Halo, {{ auth()->user()->name }}! 👋</h1>
    <p style="color: #6b7280; font-size: 15px;">Selamat datang di portal preorder Kantin. Pesan makananmu lebih awal untuk hari esok.</p>
</div>

<!-- Stats -->
<div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; margin-bottom: 32px;">
    <div class="card" style="border-left: 4px solid #6366f1; box-shadow: 0 4px 12px rgba(99, 102, 241, 0.08);">
        <div style="font-size: 11px; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 12px;">Total Pesanan</div>
        <div style="font-size: 36px; font-weight: 800; color: #1e293b; line-height: 1;">{{ auth()->user()->preorders()->count() }}</div>
    </div>
    <div class="card" style="border-left: 4px solid #8b5cf6; box-shadow: 0 4px 12px rgba(139, 92, 246, 0.08);">
        <div style="font-size: 11px; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 12px;">Menunggu</div>
        <div style="font-size: 36px; font-weight: 800; color: #1e293b; line-height: 1;">{{ auth()->user()->preorders()->where('status', 'pending')->count() }}</div>
    </div>
    <div class="card" style="border-left: 4px solid #10b981; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.08);">
        <div style="font-size: 11px; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 12px;">Besok</div>
        <div style="font-size: 36px; font-weight: 800; color: #1e293b; line-height: 1;">{{ auth()->user()->preorders()->whereDate('preorder_date', \Carbon\Carbon::tomorrow())->count() }}</div>
    </div>
</div>

<!-- Banner CTA -->
<div class="card" style="background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%); border: none; padding: 48px; text-align: center; color: #fff; box-shadow: 0 20px 40px rgba(79, 70, 229, 0.2); border-radius: 24px;">
    <h2 style="font-size: 24px; font-weight: 800; margin-bottom: 12px; letter-spacing: -0.02em;">Lapar untuk Besok?</h2>
    <p style="font-size: 15px; opacity: 0.8; margin-bottom: 32px; max-width: 440px; margin-left: auto; margin-right: auto; line-height: 1.6;">Pilih kantin favoritmu di marketplace dan amankan porsi makan siangmu lebih awal.</p>
    <a href="{{ route('welcome') }}" class="btn" style="background: #fff; color: #4f46e5; padding: 12px 32px; font-size: 15px; border-radius: 12px; font-weight: 800;">
        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" style="margin-right: 8px;"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
        Buka Marketplace Kantin
    </a>
</div>

<!-- Green Impact Summary -->
<div class="card" style="margin-top: 24px; background: #f0fdf4; border: 1px solid #bbf7d0; display: flex; align-items: center; gap: 16px; padding: 16px;">
    <div style="font-size: 24px;">🌱</div>
    <div style="flex: 1;">
        <h4 style="font-size: 14px; font-weight: 700; color: #166534;">Kontribusi Komunitas</h4>
        <p style="font-size: 12px; color: #166534; opacity: 0.8;">Kantin kita telah menyelamatkan <strong>{{ \App\Models\Donation::count() * 10 }}</strong> porsi makanan dari pembuangan melalui sistem cerdas ini.</p>
    </div>
    <div style="text-align: right;">
        <span style="font-size: 11px; font-weight: 700; color: #10b981; background: #fff; padding: 4px 8px; border-radius: 6px;">Zero Waste Hero</span>
    </div>
</div>
<!-- Security / Passkeys -->
<div class="card" style="margin-top: 24px;">
    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px;">
        <div>
            <h3 style="font-size: 16px; font-weight: 700; color: #1a1d23; margin-bottom: 4px;">Keamanan Biometrik</h3>
            <p style="color: #6b7280; font-size: 13px;">Gunakan Face ID atau sidik jari untuk login yang lebih cepat dan aman.</p>
        </div>
        <div style="font-size: 20px;">🛡️</div>
    </div>
    
    <div id="passkey-list" style="margin-bottom: 16px;">
        @if(auth()->user()->passkeys->count() > 0)
            @foreach(auth()->user()->passkeys as $passkey)
                <div style="display: flex; align-items: center; justify-content: space-between; padding: 10px; background: #f8fafc; border-radius: 8px; margin-bottom: 8px;">
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
            <p style="font-size: 13px; color: #94a3b8; font-style: italic;">Belum ada perangkat terdaftar.</p>
        @endif
    </div>

    <button type="button" id="register-passkey" class="btn" style="width: auto; padding: 8px 16px; font-size: 13px; background: #1a1d23;">
        Daftarkan Perangkat Ini
    </button>
</div>

<script>
    document.getElementById('register-passkey').addEventListener('click', async () => {
        const name = prompt('Beri nama perangkat ini (misal: iPhone Saya, Laptop Kantor):', 'Perangkat Saya');
        if (!name) return;

        try {
            await window.Passkeys.register({ name: name });
            window.location.reload();
        } catch (error) {
            console.error('Passkey registration failed:', error);
            alert('Gagal mendaftarkan perangkat. Pastikan perangkat Anda mendukung Face ID / Passkey.');
        }
    });
</script>
@endsection
