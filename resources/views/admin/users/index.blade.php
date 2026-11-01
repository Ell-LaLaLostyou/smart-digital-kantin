@extends('admin.layout')

@section('title', 'Manajemen User')
@section('header_title', 'Manajemen User')

@section('content')
<div class="section-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
    <div>
        <h2>Daftar User & Staff</h2>
        <p>Kelola akses admin dan unit kantin yang dikelola.</p>
    </div>
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 8px;">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
        Tambah User Baru
    </a>
</div>

<!-- Interactive Filtering & Search Controls using AlpineJS -->
<div x-data="{ 
    search: '', 
    activeFilter: 'all',
    users: [
        @foreach($users as $user)
        {
            id: {{ $user->id }},
            name: '{{ addslashes($user->name) }}',
            email: '{{ addslashes($user->email) }}',
            role: '{{ $user->role }}',
            canteen_name: '{{ $user->canteen ? addslashes($user->canteen->name) : 'Tidak ada (Global)' }}',
            created_at: '{{ $user->created_at->format('d M Y') }}',
            edit_url: '{{ route('admin.users.edit', $user) }}',
            delete_url: '{{ route('admin.users.destroy', $user) }}',
            is_self: {{ $user->id === auth()->id() ? 'true' : 'false' }}
        },
        @endforeach
    ],
    get filteredUsers() {
        return this.users.filter(u => {
            const matchesSearch = u.name.toLowerCase().includes(this.search.toLowerCase()) || 
                                  u.email.toLowerCase().includes(this.search.toLowerCase()) ||
                                  u.canteen_name.toLowerCase().includes(this.search.toLowerCase());
            
            const matchesFilter = this.activeFilter === 'all' || 
                                  (this.activeFilter === 'super_admin' && u.role === 'super_admin') ||
                                  (this.activeFilter === 'admin' && u.role === 'admin') ||
                                  (this.activeFilter === 'user' && u.role === 'user');
            
            return matchesSearch && matchesFilter;
        });
    }
}">
    <!-- Controls Bar -->
    <div style="display: flex; justify-content: space-between; align-items: center; gap: 16px; margin-bottom: 20px; flex-wrap: wrap; background: #ffffff; padding: 16px; border-radius: 12px; border: 1px solid #e8eaf0; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.01);">
        <!-- Filter Tabs -->
        <div style="display: flex; gap: 8px; flex-wrap: wrap;">
            <button @click="activeFilter = 'all'" 
                    :style="activeFilter === 'all' ? 'background: #b91c1c; color: white; border-color: #b91c1c;' : 'background: #f8fafc; color: #64748b; border-color: #e2e8f0;'" 
                    class="btn btn-outline btn-sm" style="border-radius: 99px; font-size: 12px; font-weight: 600; padding: 6px 16px; transition: all 0.15s;">
                Semua (<span x-text="users.length"></span>)
            </button>
            <button @click="activeFilter = 'super_admin'" 
                    :style="activeFilter === 'super_admin' ? 'background: #b91c1c; color: white; border-color: #b91c1c;' : 'background: #f8fafc; color: #64748b; border-color: #e2e8f0;'" 
                    class="btn btn-outline btn-sm" style="border-radius: 99px; font-size: 12px; font-weight: 600; padding: 6px 16px; transition: all 0.15s;">
                Core Admin (<span x-text="users.filter(u => u.role === 'super_admin').length"></span>)
            </button>
            <button @click="activeFilter = 'admin'" 
                    :style="activeFilter === 'admin' ? 'background: #b91c1c; color: white; border-color: #b91c1c;' : 'background: #f8fafc; color: #64748b; border-color: #e2e8f0;'" 
                    class="btn btn-outline btn-sm" style="border-radius: 99px; font-size: 12px; font-weight: 600; padding: 6px 16px; transition: all 0.15s;">
                Admin Kantin (<span x-text="users.filter(u => u.role === 'admin').length"></span>)
            </button>
            <button @click="activeFilter = 'user'" 
                    :style="activeFilter === 'user' ? 'background: #b91c1c; color: white; border-color: #b91c1c;' : 'background: #f8fafc; color: #64748b; border-color: #e2e8f0;'" 
                    class="btn btn-outline btn-sm" style="border-radius: 99px; font-size: 12px; font-weight: 600; padding: 6px 16px; transition: all 0.15s;">
                Pelanggan/Siswa (<span x-text="users.filter(u => u.role === 'user').length"></span>)
            </button>
        </div>

        <!-- Search Input -->
        <div style="position: relative; width: 280px;">
            <span style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #94a3b8; display: flex; align-items: center;">
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </span>
            <input type="text" x-model="search" placeholder="Cari nama, email, kantin..." 
                   style="width: 100%; padding: 8px 12px 8px 34px; border: 1px solid #cbd5e1; border-radius: 99px; font-size: 13px; color: #1e293b; outline: none; transition: border-color 0.15s;"
                   onfocus="this.style.borderColor='#b91c1c'"
                   onblur="this.style.borderColor='#cbd5e1'">
        </div>
    </div>

    <!-- Table Card -->
    <div class="card">
        <div style="overflow-x: auto;">
            <table>
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Unit Kantin</th>
                        <th>Terdaftar Pada</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Empty State -->
                    <tr x-show="filteredUsers.length === 0" style="display: none;">
                        <td colspan="6" style="text-align: center; padding: 48px; color: #94a3b8;">
                            <div style="font-size: 32px; margin-bottom: 12px;">🔍</div>
                            <h4 style="margin: 0; font-size: 14px; font-weight: 700; color: #64748b;">Tidak Ada User Ditemukan</h4>
                            <p style="margin: 4px 0 0 0; font-size: 12px; color: #94a3b8;">Silakan sesuaikan filter pencarian atau kategori Anda.</p>
                        </td>
                    </tr>

                    <!-- User Row Template -->
                    <template x-for="user in filteredUsers" :key="user.id">
                        <tr>
                            <td>
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <div class="avatar" style="width: 32px; height: 32px; font-size: 12px;" x-text="user.name.charAt(0).toUpperCase()"></div>
                                    <strong x-text="user.name"></strong>
                                </div>
                            </td>
                            <td x-text="user.email"></td>
                            <td>
                                <span class="badge" 
                                      :class="user.role === 'super_admin' ? 'badge-red' : (user.role === 'admin' ? 'badge-blue' : 'badge-gray')"
                                      x-text="user.role === 'super_admin' ? 'SUPER ADMIN' : (user.role === 'admin' ? 'ADMIN KANTIN' : 'USER')">
                                </span>
                            </td>
                            <td>
                                <span x-text="user.canteen_name" :style="user.canteen_name === 'Tidak ada (Global)' ? 'color: #94a3b8; font-style: italic;' : 'color: #1e293b; font-weight: 500;'"></span>
                            </td>
                            <td x-text="user.created_at"></td>
                            <td>
                                <div style="display: flex; gap: 8px;">
                                    <a :href="user.edit_url" class="btn btn-outline btn-sm">Edit</a>
                                    
                                    <!-- Prevent deleting self -->
                                    <template x-if="!user.is_self">
                                        <form :action="user.delete_url" method="POST" onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button type="submit" class="btn btn-sm" style="color: #ef4444; border: 1px solid #fee2e2; background: #fef2f2;">Hapus</button>
                                        </form>
                                    </template>
                                </div>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
