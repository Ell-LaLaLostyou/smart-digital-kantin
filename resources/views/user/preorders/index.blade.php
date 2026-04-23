@extends('user.layout')
@section('title', 'Preorder')

@section('content')
<div style="margin-bottom: 32px;">
    <h1 style="font-size: 24px; font-weight: 800; color: #1a1d23; margin-bottom: 8px;">Daftar Menu</h1>
    <p style="color: #6b7280; font-size: 15px;">Pilih menu favoritmu untuk dinikmati hari esok.</p>
</div>

<!-- Menu Grid -->
<div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 24px; margin-bottom: 48px;">
    @foreach($menus as $menu)
    <div class="card" style="padding: 0; overflow: hidden; display: flex; flex-direction: column;">
        <div style="height: 180px; background: #eff0ff; overflow: hidden;">
            @if($menu->image)
                <img src="{{ asset('storage/'.$menu->image) }}" alt="{{ $menu->name }}" style="width: 100%; h-full; object-fit: cover;">
            @else
                <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; color: #4f46e5;">
                    <svg width="48" height="48" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6a7.5 7.5 0 107.5 7.5h-7.5V6z"/><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 10.5H21A7.5 7.5 0 0013.5 3v7.5z"/></svg>
                </div>
            @endif
        </div>
        <div style="padding: 20px; flex: 1; display: flex; flex-direction: column;">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 8px;">
                <h3 style="font-size: 16px; font-weight: 700; color: #1a1d23;">{{ $menu->name }}</h3>
                <span style="font-size: 14px; font-weight: 700; color: #4f46e5;">Rp{{ number_format($menu->price, 0, ',', '.') }}</span>
            </div>
            <p style="font-size: 13px; color: #6b7280; margin-bottom: 20px; line-height: 1.5; flex: 1;">{{ $menu->description ?? 'Menu spesial pilihan koki kami untuk menemani harimu.' }}</p>
            
            <form action="{{ route('preorders.store') }}" method="POST">
                @csrf
                <input type="hidden" name="menu_id" value="{{ $menu->id }}">
                <input type="hidden" name="preorder_date" value="{{ \Carbon\Carbon::tomorrow()->format('Y-m-d') }}">
                
                <div style="display: flex; flex-direction: column; gap: 8px;">
                    <div style="display: flex; gap: 8px;">
                        <select name="quantity" style="flex: 1; padding: 8px; border: 1px solid #e2e4ea; border-radius: 8px; font-size: 13px; background: #f9fafb;">
                            @for($i=1; $i<=5; $i++) <option value="{{ $i }}">{{ $i }} Porsi</option> @endfor
                        </select>
                        <select name="payment_method" style="flex: 1.5; padding: 8px; border: 1px solid #e2e4ea; border-radius: 8px; font-size: 13px; background: #f9fafb;">
                            <option value="cash">Tunai (Bayar Ditempat)</option>
                            <option value="transfer">Transfer Bank</option>
                            <option value="ewallet">E-Wallet (OVO/Gopay)</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary" style="width: 100%; padding: 10px; font-size: 13px;">Konfirmasi & Preorder</button>
                </div>
            </form>
        </div>
    </div>
    @endforeach
</div>

<!-- History -->
<div class="card">
    <div class="card-title">Riwayat Preorder Saya</div>
    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr>
                    <th style="text-align: left; padding: 12px; font-size: 11px; font-weight: 700; color: #94a3b8; text-transform: uppercase; border-bottom: 1px solid #e8eaf0;">Menu</th>
                    <th style="text-align: left; padding: 12px; font-size: 11px; font-weight: 700; color: #94a3b8; text-transform: uppercase; border-bottom: 1px solid #e8eaf0;">Tanggal</th>
                    <th style="text-align: left; padding: 12px; font-size: 11px; font-weight: 700; color: #94a3b8; text-transform: uppercase; border-bottom: 1px solid #e8eaf0;">Jumlah</th>
                    <th style="text-align: left; padding: 12px; font-size: 11px; font-weight: 700; color: #94a3b8; text-transform: uppercase; border-bottom: 1px solid #e8eaf0;">Pembayaran</th>
                    <th style="text-align: left; padding: 12px; font-size: 11px; font-weight: 700; color: #94a3b8; text-transform: uppercase; border-bottom: 1px solid #e8eaf0;">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($myPreorders as $preorder)
                <tr>
                    <td style="padding: 12px; border-bottom: 1px solid #f8fafc; font-weight: 600;">{{ $preorder->menu->name }}</td>
                    <td style="padding: 12px; border-bottom: 1px solid #f8fafc; color: #6b7280;">{{ \Carbon\Carbon::parse($preorder->preorder_date)->format('d/m/Y') }}</td>
                    <td style="padding: 12px; border-bottom: 1px solid #f8fafc; color: #6b7280;">{{ $preorder->quantity }} Porsi</td>
                    <td style="padding: 12px; border-bottom: 1px solid #f8fafc;">
                        <span style="font-size:11px; color:#6b7280;">{{ strtoupper($preorder->payment_method) }}</span><br>
                        <span class="badge {{ $preorder->payment_status == 'paid' ? 'badge-green' : 'badge-yellow' }}" style="font-size:9px;">
                            {{ strtoupper($preorder->payment_status) }}
                        </span>
                    </td>
                    <td style="padding: 12px; border-bottom: 1px solid #f8fafc;">
                        <span class="badge {{ $preorder->status == 'pending' ? 'badge-yellow' : ($preorder->status == 'completed' ? 'badge-green' : 'badge-blue') }}">
                            {{ $preorder->status }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" style="text-align: center; padding: 32px; color: #94a3b8;">Belum ada riwayat pesanan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
