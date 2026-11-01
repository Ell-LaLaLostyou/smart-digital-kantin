@extends('admin.layout')
@section('title', 'Manajemen Kantin')
@section('header_title', 'Manajemen Kantin')

@section('content')
<div class="section-header">
    <div style="display:flex; justify-content:space-between; align-items:center;">
        <div>
            <h2>Daftar Kantin</h2>
            <p>Kelola semua kantin yang terdaftar di sistem.</p>
        </div>
        <a href="{{ route('admin.canteens.create') }}" class="btn btn-primary">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
            Tambah Kantin
        </a>
    </div>
</div>

<div class="card">
    <div style="overflow-x:auto;">
        <table>
            <thead>
                <tr>
                    <th>Nama Kantin</th>
                    <th>Slug</th>
                    <th>Menu</th>
                    <th>Admin</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($canteens as $canteen)
                <tr>
                    <td><strong>{{ $canteen->name }}</strong></td>
                    <td><span class="badge badge-gray">{{ $canteen->slug }}</span></td>
                    <td>{{ $canteen->menus_count }} item</td>
                    <td>{{ $canteen->admins_count }} orang</td>
                    <td>
                        <div style="display:flex; gap:8px;">
                            <a href="{{ route('admin.canteens.edit', $canteen) }}" class="btn btn-outline btn-sm">Edit</a>
                            <form action="{{ route('admin.canteens.destroy', $canteen) }}" method="POST" onsubmit="return confirm('Hapus kantin ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align:center; padding:32px; color:#9198a8;">Belum ada kantin.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
