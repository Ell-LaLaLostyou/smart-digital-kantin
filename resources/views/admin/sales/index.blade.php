@extends('admin.layout')
@section('title', 'Penjualan')
@section('header_title', 'Input Penjualan')

@section('content')
<div class="section-header">
    <h2>Catatan Penjualan Harian</h2>
    <p>Input jumlah porsi yang terjual. Sistem akan menghitung <strong>sisa (waste)</strong> secara otomatis.</p>
</div>

<div style="display:grid; grid-template-columns: 320px 1fr; gap:24px;">
    <!-- Form Penjualan -->
    <div class="card" style="height: fit-content;">
        <div class="card-header"><h3>Input Penjualan</h3></div>
        <div class="card-body">
            @if($errors->any())
                <div class="alert alert-error">@foreach($errors->all() as $e) <p>{{ $e }}</p> @endforeach</div>
            @endif
            <form action="{{ route('admin.sales.store') }}" method="POST">
                @csrf
                <div style="margin-bottom: 16px;">
                    <label class="form-label">Menu</label>
                    <select name="menu_id" class="form-input" required>
                        <option value="" disabled selected>Pilih menu...</option>
                        @foreach(\App\Models\Menu::where('status','available')->get() as $menu)
                            <option value="{{ $menu->id }}">{{ $menu->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div style="margin-bottom: 16px;">
                    <label class="form-label">Jumlah Terjual (Porsi)</label>
                    <input type="number" name="quantity_sold" min="0" class="form-input" placeholder="cth: 45" required>
                </div>
                <div style="margin-bottom: 24px;">
                    <label class="form-label">Tanggal Penjualan</label>
                    <input type="date" name="sale_date" class="form-input" value="{{ date('Y-m-d') }}" required>
                </div>
                <div style="padding: 12px; background: #fffbeb; border: 1px solid #fde68a; border-radius: 8px; font-size: 11.5px; color: #92400e; margin-bottom: 20px;">
                    Sisa makanan (food waste) akan langsung tercatat setelah Anda menekan tombol di bawah.
                </div>
                <button type="submit" class="btn btn-success" style="width:100%;">Simpan Penjualan</button>
            </form>
        </div>
    </div>

    <!-- History Penjualan -->
    <div class="card">
        <div class="card-header"><h3>Riwayat Penjualan</h3></div>
        <div style="overflow-x:auto;">
            <table>
                <thead><tr>
                    <th>Tanggal</th>
                    <th>Nama Menu</th>
                    <th>Terjual</th>
                    <th style="text-align:right;">Aksi</th>
                </tr></thead>
                <tbody>
                    @forelse($sales as $sale)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($sale->sale_date)->format('d/m/Y') }}</td>
                        <td><strong>{{ $sale->menu->name }}</strong></td>
                        <td><span class="badge badge-green">{{ $sale->quantity_sold }} Porsi</span></td>
                        <td style="text-align:right;">
                            <form action="{{ route('admin.sales.destroy', $sale) }}" method="POST" onsubmit="return confirm('Hapus data penjualan ini? Waste akan dihitung ulang.')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" style="text-align:center; padding:48px; color:#9198a8;">Belum ada catatan penjualan hari ini.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
