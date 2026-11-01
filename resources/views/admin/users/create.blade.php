@extends('admin.layout')

@section('title', 'Tambah User Baru')
@section('header_title', 'Tambah User Baru')

@section('content')
<div class="card" style="max-width: 600px; margin: 0 auto;">
    <div class="card-header">
        <h3>Informasi User & Hak Akses</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf
            
            <div class="form-group" style="margin-bottom: 20px;">
                <label style="display: block; font-size: 13px; font-weight: 600; color: #475569; margin-bottom: 8px;">Nama Lengkap</label>
                <input type="text" name="name" class="form-control" placeholder="Masukkan nama lengkap" required value="{{ old('name') }}">
                @error('name') <span style="color: #ef4444; font-size: 12px;">{{ $message }}</span> @enderror
            </div>

            <div class="form-group" style="margin-bottom: 20px;">
                <label style="display: block; font-size: 13px; font-weight: 600; color: #475569; margin-bottom: 8px;">Email Address</label>
                <input type="email" name="email" class="form-control" placeholder="admin@kantin.com" required value="{{ old('email') }}">
                @error('email') <span style="color: #ef4444; font-size: 12px;">{{ $message }}</span> @enderror
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 20px;">
                <div class="form-group">
                    <label style="display: block; font-size: 13px; font-weight: 600; color: #475569; margin-bottom: 8px;">Password</label>
                    <input type="password" name="password" class="form-control" required placeholder="Minimal 8 karakter">
                    @error('password') <span style="color: #ef4444; font-size: 12px;">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label style="display: block; font-size: 13px; font-weight: 600; color: #475569; margin-bottom: 8px;">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" class="form-control" required placeholder="Ulangi password">
                </div>
            </div>

            <div class="form-group" style="margin-bottom: 20px;">
                <label style="display: block; font-size: 13px; font-weight: 600; color: #475569; margin-bottom: 8px;">Role / Hak Akses</label>
                <select name="role" class="form-control" required>
                    @foreach($roles as $value => $label)
                        <option value="{{ $value }}" {{ old('role') == $value ? 'selected' : '' }}>{{ $label }} ({{ $value }})</option>
                    @endforeach
                </select>
                @error('role') <span style="color: #ef4444; font-size: 12px;">{{ $message }}</span> @enderror
            </div>

            <div class="form-group" style="margin-bottom: 32px;">
                <label style="display: block; font-size: 13px; font-weight: 600; color: #475569; margin-bottom: 8px;">Tugaskan ke Kantin</label>
                <select name="canteen_id" class="form-control">
                    <option value="">-- Tidak Ada (Super Admin / Pelanggan) --</option>
                    @foreach($canteens as $canteen)
                        <option value="{{ $canteen->id }}" {{ old('canteen_id') == $canteen->id ? 'selected' : '' }}>{{ $canteen->name }}</option>
                    @endforeach
                </select>
                <p style="font-size: 11px; color: #94a3b8; margin-top: 4px;">Kosongkan jika user ini adalah Pelanggan atau Super Admin.</p>
                @error('canteen_id') <span style="color: #ef4444; font-size: 12px;">{{ $message }}</span> @enderror
            </div>

            <div style="display: flex; gap: 12px; justify-content: flex-end;">
                <a href="{{ route('admin.users.index') }}" class="btn btn-outline">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan User</button>
            </div>
        </form>
    </div>
</div>
@endsection
