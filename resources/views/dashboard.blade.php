@extends('user.layout')
@section('title', 'Dashboard')

@section('content')
<div style="margin-bottom: 32px;">
    <h1 style="font-size: 24px; font-weight: 800; color: #1a1d23; margin-bottom: 8px;">Halo, {{ auth()->user()->name }}! 👋</h1>
    <p style="color: #6b7280; font-size: 15px;">Selamat datang di portal preorder Kantin. Pesan makananmu lebih awal untuk hari esok.</p>
</div>

<!-- Stats -->
<div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 32px;">
    <div class="card" style="border-left: 4px solid #4f46e5;">
        <div style="font-size: 12px; font-weight: 600; color: #94a3b8; text-transform: uppercase; margin-bottom: 8px;">Total Pesanan</div>
        <div style="font-size: 32px; font-weight: 800; color: #1a1d23;">{{ auth()->user()->preorders()->count() }}</div>
    </div>
    <div class="card" style="border-left: 4px solid #f59e0b;">
        <div style="font-size: 12px; font-weight: 600; color: #94a3b8; text-transform: uppercase; margin-bottom: 8px;">Menunggu</div>
        <div style="font-size: 32px; font-weight: 800; color: #1a1d23;">{{ auth()->user()->preorders()->where('status', 'pending')->count() }}</div>
    </div>
    <div class="card" style="border-left: 4px solid #10b981;">
        <div style="font-size: 12px; font-weight: 600; color: #94a3b8; text-transform: uppercase; margin-bottom: 8px;">Besok</div>
        <div style="font-size: 32px; font-weight: 800; color: #1a1d23;">{{ auth()->user()->preorders()->whereDate('preorder_date', \Carbon\Carbon::tomorrow())->count() }}</div>
    </div>
</div>

<!-- Banner CTA -->
<div class="card" style="background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%); border: none; padding: 40px; text-align: center; color: #fff;">
    <h2 style="font-size: 20px; font-weight: 700; margin-bottom: 12px;">Lapar untuk Besok?</h2>
    <p style="font-size: 14px; opacity: 0.9; margin-bottom: 24px; max-width: 400px; margin-left: auto; margin-right: auto;">Lihat menu tersedia dan lakukan preorder sekarang untuk menghindari kehabisan stok!</p>
    <a href="{{ route('preorders.index') }}" class="btn" style="background: #fff; color: #4f46e5;">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
        Pesan Sekarang
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
@endsection
