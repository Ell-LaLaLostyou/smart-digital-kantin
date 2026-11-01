@extends('admin.layout')
@section('title', 'Tambah Kantin')
@section('header_title', 'Tambah Kantin')

@section('content')
<div class="card" style="max-width: 600px;">
    <div class="card-header">
        <h3>Informasi Kantin</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.canteens.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div style="margin-bottom: 16px;">
                <label class="form-label">Nama Kantin</label>
                <input type="text" name="name" class="form-input" placeholder="Contoh: Kantin Sehat" required>
            </div>
            <div style="margin-bottom: 16px;">
                <label class="form-label">Deskripsi</label>
                <textarea name="description" class="form-input" rows="3" placeholder="Deskripsi singkat kantin..."></textarea>
            </div>
            <div style="margin-bottom: 16px;">
                <label class="form-label">Foto Kantin (Optional)</label>
                <input type="file" name="image_url" class="form-input" accept="image/png, image/jpeg, image/jpg" style="padding-top: 8px;">
                <span style="font-size: 12px; color: #6b7280;">Format yang didukung: PNG, JPG, JPEG. Maksimal 2MB.</span>
            </div>
            <div style="margin-bottom: 16px;">
                <label class="form-label">URL QR Pembayaran / QRIS (Optional)</label>
                <input type="url" name="payment_qr_url" class="form-input" placeholder="https://image-link.com/qris.png">
            </div>
            <div style="display:flex; justify-content:flex-end; gap:12px; margin-top:24px;">
                <a href="{{ route('admin.canteens.index') }}" class="btn btn-outline">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan Kantin</button>
            </div>
        </form>
    </div>
</div>
@endsection
