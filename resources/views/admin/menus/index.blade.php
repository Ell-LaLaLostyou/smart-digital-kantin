@extends('admin.layout')
@section('title', 'Menu')
@section('header_title', 'Manajemen Menu')

@section('content')
<div class="section-header flex items-center justify-between">
    <div>
        <h2>Daftar Menu</h2>
        <p>Kelola semua menu makanan dan minuman yang tersedia.</p>
    </div>
    <button onclick="document.getElementById('add-menu-form').scrollIntoView({behavior: 'smooth'})" class="btn btn-primary">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
        Tambah Menu
    </button>
</div>

<!-- Form Tambah -->
<div class="card" id="add-menu-form" style="margin-bottom: 32px;">
    <div class="card-header"><h3>Tambah Menu Baru</h3></div>
    <div class="card-body">
        <form action="{{ route('admin.menus.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-grid" style="margin-bottom: 16px;">
                <div>
                    <label class="form-label">Nama Menu</label>
                    <input type="text" name="name" class="form-input" placeholder="cth: Nasi Goreng" required value="{{ old('name') }}">
                </div>
                <div>
                    <label class="form-label">Harga (Rp)</label>
                    <input type="number" name="price" class="form-input" placeholder="15000" required value="{{ old('price') }}">
                </div>
                <div>
                    <label class="form-label">Kategori</label>
                    <select name="category" class="form-input" required>
                        <option value="">Pilih Kategori</option>
                        <option value="Makanan" {{ old('category')=='Makanan'?'selected':'' }}>Makanan</option>
                        <option value="Minuman" {{ old('category')=='Minuman'?'selected':'' }}>Minuman</option>
                        <option value="Snack"   {{ old('category')=='Snack'?'selected':'' }}>Snack</option>
                    </select>
                </div>
                <div>
                    <label class="form-label">Status</label>
                    <select name="status" class="form-input" required>
                        <option value="available">Tersedia</option>
                        <option value="unavailable">Tidak Tersedia</option>
                    </select>
                </div>
            </div>
            <div style="margin-bottom: 20px;">
                <label class="form-label">Deskripsi Singkat</label>
                <input type="text" name="description" class="form-input" placeholder="Opsional: Deskripsi menu" value="{{ old('description') }}">
            </div>
            <div style="margin-bottom: 20px;">
                <label class="form-label">Gambar Menu (Opsional)</label>
                <input type="file" name="image" class="form-input" accept="image/png, image/jpeg, image/jpg" style="padding-top: 8px;">
                <span style="font-size: 12px; color: #6b7280;">Format yang didukung: PNG, JPG, JPEG. Maksimal 2MB.</span>
            </div>
            @if($errors->any())
                <div class="alert alert-error" style="margin-bottom: 16px;">
                    <ul style="margin-left: 20px;">@foreach($errors->all() as $e) <li>{{ $e }}</li> @endforeach</ul>
                </div>
            @endif
            <button type="submit" class="btn btn-primary">Simpan Menu</button>
        </form>
    </div>
</div>

<!-- Tabel Menu -->
<div class="card">
    <div style="overflow-x:auto;">
        <table>
            <thead><tr>
                <th>Foto</th>
                <th>Nama Menu</th>
                <th>Kategori</th>
                <th>Harga</th>
                <th>Status</th>
                <th style="text-align:right;">Aksi</th>
            </tr></thead>
            <tbody>
                @forelse($menus as $menu)
                <tr>
                    <td>
                        @if($menu->image)
                            <img src="{{ asset('storage/'.$menu->image) }}" alt="{{ $menu->name }}" style="width: 48px; height: 48px; border-radius: 8px; object-fit: cover;">
                        @else
                            <div style="width: 48px; height: 48px; border-radius: 8px; background: #f3f4f6; display: flex; align-items: center; justify-content: center; color: #9ca3af;">
                                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                        @endif
                    </td>
                    <td><strong>{{ $menu->name }}</strong><br><span style="font-size:11px; color:#9198a8;">{{ $menu->description ?? 'Tidak ada deskripsi' }}</span></td>
                    <td><span class="badge badge-gray">{{ $menu->category }}</span></td>
                    <td><strong>Rp {{ number_format($menu->price,0,',','.') }}</strong></td>
                    <td>
                        <span class="badge {{ $menu->status == 'available' ? 'badge-green' : 'badge-red' }}">
                            {{ $menu->status == 'available' ? 'Tersedia' : 'Nonaktif' }}
                        </span>
                    </td>
                    <td style="text-align:right;">
                        <div style="display:flex; justify-content:flex-end; gap:8px;">
                            <form action="{{ route('admin.menus.update', $menu) }}" method="POST">
                                @csrf @method('PATCH')
                                <input type="hidden" name="name" value="{{ $menu->name }}">
                                <input type="hidden" name="price" value="{{ $menu->price }}">
                                <input type="hidden" name="category" value="{{ $menu->category }}">
                                <input type="hidden" name="description" value="{{ $menu->description }}">
                                <input type="hidden" name="status" value="{{ $menu->status=='available' ? 'unavailable' : 'available' }}">
                                <button type="submit" class="btn btn-outline btn-sm">
                                    {{ $menu->status=='available' ? 'Off' : 'On' }}
                                </button>
                            </form>
                            <form action="{{ route('admin.menus.destroy', $menu) }}" method="POST" onsubmit="return confirm('Hapus menu ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" style="text-align:center; padding:48px; color:#9198a8;">Belum ada menu yang ditambahkan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
