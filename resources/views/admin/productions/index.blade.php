@extends('admin.layout')
@section('title', 'Produksi')
@section('header_title', 'Produksi Harian')

@section('content')
<div class="section-header">
    <h2>Catatan Produksi</h2>
    <p>Input jumlah porsi yang dimasak untuk setiap menu setiap harinya.</p>
</div>

<div style="display:grid; grid-template-columns: 320px 1fr; gap:24px;">
    <!-- Form Produksi -->
    <div class="card" style="height: fit-content;">
        <div class="card-header"><h3>Input Produksi Baru</h3></div>
        <div class="card-body">
            @if($errors->any())
                <div class="alert alert-error">@foreach($errors->all() as $e) <p>{{ $e }}</p> @endforeach</div>
            @endif
            <form action="{{ route('admin.productions.store') }}" method="POST">
                @csrf
                <div style="margin-bottom: 16px;">
                    <label class="form-label">Pilih Menu</label>
                    <select name="menu_id" class="form-input" required>
                        <option value="" disabled selected>Pilih menu...</option>
                        @foreach(\App\Models\Menu::where('status','available')->get() as $menu)
                            <option value="{{ $menu->id }}">{{ $menu->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div style="margin-bottom: 16px;">
                    <label class="form-label">Jumlah Produksi (Porsi)</label>
                    <input type="number" name="quantity" min="1" class="form-input" placeholder="cth: 50" required>
                </div>
                <div style="margin-bottom: 24px;">
                    <label class="form-label">Tanggal Produksi</label>
                    <input type="date" name="production_date" class="form-input" value="{{ date('Y-m-d') }}" required>
                </div>
                <button type="submit" class="btn btn-primary" style="width:100%;">Simpan Produksi</button>
            </form>
        </div>
    </div>

    <!-- History Produksi -->
    <div class="card">
        <div class="card-header"><h3>Riwayat Produksi Terbaru</h3></div>
        <div style="overflow-x:auto;">
            <table>
                <thead><tr>
                    <th>Tanggal</th>
                    <th>Nama Menu</th>
                    <th>Jumlah</th>
                    <th style="text-align:right;">Aksi</th>
                </tr></thead>
                <tbody>
                    @forelse($productions as $prod)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($prod->production_date)->format('d/m/Y') }}</td>
                        <td><strong>{{ $prod->menu->name }}</strong></td>
                        <td><span class="badge badge-purple">{{ $prod->quantity }} Porsi</span></td>
                        <td style="text-align:right;">
                            <form action="{{ route('admin.productions.destroy', $prod) }}" method="POST" onsubmit="return confirm('Hapus data produksi ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" style="text-align:center; padding:48px; color:#9198a8;">Belum ada catatan produksi hari ini.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
