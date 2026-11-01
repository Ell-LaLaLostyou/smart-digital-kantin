@extends('admin.layout')
@section('title', 'Edit Kantin')
@section('header_title', 'Edit Kantin')

@section('content')
<div class="card" style="max-width: 600px;">
    <div class="card-header">
        <h3>Edit Informasi Kantin: {{ $canteen->name }}</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.canteens.update', $canteen) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <div style="margin-bottom: 16px;">
                <label class="form-label">Nama Kantin</label>
                <input type="text" name="name" class="form-input" value="{{ $canteen->name }}" required>
            </div>
            <div style="margin-bottom: 16px;">
                <label class="form-label">Deskripsi</label>
                <textarea name="description" class="form-input" rows="3">{{ $canteen->description }}</textarea>
            </div>
            <div style="margin-bottom: 16px;">
                <label class="form-label">Foto Kantin (Optional)</label>
                @if($canteen->image_url)
                    <div style="margin-bottom: 8px;">
                        <img src="{{ asset('storage/' . $canteen->image_url) }}" alt="Foto Kantin" style="height: 60px; border-radius: 8px; object-fit: cover;">
                    </div>
                @endif
                <input type="file" name="image_url" class="form-input" accept="image/png, image/jpeg, image/jpg" style="padding-top: 8px;">
                <span style="font-size: 12px; color: #6b7280;">Format yang didukung: PNG, JPG, JPEG. Maksimal 2MB. Kosongkan jika tidak ingin mengubah foto.</span>
            </div>
            <div style="margin-bottom: 16px;">
                <label class="form-label">URL QR Pembayaran / QRIS (Optional)</label>
                <input type="url" name="payment_qr_url" class="form-input" value="{{ $canteen->payment_qr_url }}" placeholder="https://image-link.com/qris.png">
            </div>
            <div style="display:flex; justify-content:flex-end; gap:12px; margin-top:24px;">
                <a href="{{ route('admin.canteens.index') }}" class="btn btn-outline">Batal</a>
                <button type="submit" class="btn btn-primary">Update Kantin</button>
            </div>
        </form>
    </div>
</div>
@endsection
