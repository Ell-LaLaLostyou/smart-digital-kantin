<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $canteen->name }} — Smart Canteen</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <style>
        body { font-family: 'Inter', sans-serif; background: #f8fafc; color: #1e293b; margin: 0; }
        .navbar { background: white; border-bottom: 1px solid #e2e8f0; position: sticky; top: 0; z-index: 50; }
        
        /* Grid Menu */
        .menu-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 24px;
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 24px;
        }

        .card-menu {
            background: white;
            border-radius: 24px;
            border: 1px solid #e2e8f0;
            overflow: hidden;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .card-menu:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        /* Modal Styles */
        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.5);
            backdrop-filter: blur(8px);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 100;
            padding: 20px;
        }

        .modal-container {
            background: white;
            width: 100%;
            max-width: 480px;
            border-radius: 32px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            overflow: hidden;
            animation: modalIn 0.3s ease-out;
        }

        @keyframes modalIn {
            from { opacity: 0; transform: translateY(20px) scale(0.95); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        .modal-header {
            padding: 32px 32px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-body {
            padding: 0 32px 32px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-size: 12px;
            font-weight: 700;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 8px;
        }

        .form-control {
            width: 100%;
            padding: 12px 16px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 500;
            color: #1e293b;
            transition: all 0.2s;
            box-sizing: border-box;
        }

        .form-control:focus {
            outline: none;
            border-color: #b91c1c;
            background: white;
            box-shadow: 0 0 0 4px rgba(185, 28, 28, 0.1);
        }

        .item-preview {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 16px;
            background: #f1f5f9;
            border-radius: 16px;
            margin-bottom: 24px;
        }

        .preview-img {
            width: 64px;
            height: 64px;
            background: #cbd5e1;
            border-radius: 12px;
            object-fit: cover;
        }

        .btn-confirm {
            width: 100%;
            padding: 16px;
            background: #b91c1c;
            color: white;
            border: none;
            border-radius: 16px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s;
            margin-top: 12px;
        }

        .btn-confirm:hover {
            background: #991b1b;
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(185, 28, 28, 0.4);
        }
    </style>
</head>
<body x-data="{ showCheckout: false, selectedMenu: null }">

    <!-- Navbar -->
    <nav class="navbar">
        <div style="max-width: 1200px; margin: 0 auto; padding: 16px 24px; display: flex; justify-content: space-between; align-items: center;">
            <div style="display: flex; align-items: center; gap: 16px;">
                <a href="{{ route('welcome') }}" style="color: #64748b; text-decoration: none; display: flex; align-items: center; gap: 8px;">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    <span style="font-weight: 600; font-size: 14px;">Kembali</span>
                </a>
                <h1 style="font-size: 18px; font-weight: 800; color: #0f172a; margin: 0;">{{ $canteen->name }}</h1>
            </div>
            @auth
                <a href="{{ route('dashboard') }}" style="font-size: 14px; font-weight: 700; color: #b91c1c; text-decoration: none;">Dashboard</a>
            @endauth
        </div>
    </nav>

    <main style="max-width: 1200px; margin: 60px auto; padding: 0 24px;">
        <div style="margin-bottom: 40px;">
            <h2 style="font-size: 36px; font-weight: 800; color: #0f172a; letter-spacing: -0.02em; margin-bottom: 8px;">Daftar Menu</h2>
            <p style="color: #64748b; font-size: 16px;">Pilih menu lezat yang tersedia di {{ $canteen->name }} hari ini.</p>
        </div>

        @if(session('success'))
            <div style="background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; padding: 16px 24px; border-radius: 16px; margin-bottom: 32px; display: flex; align-items: center; gap: 12px;">
                <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                <span style="font-weight: 600;">{{ session('success') }}</span>
            </div>
        @endif

        <div class="menu-grid">
            @forelse($menus as $menu)
                <div class="card-menu">
                    <div style="height: 200px; background: #f1f5f9; overflow: hidden;">
                        @if($menu->image)
                            <img src="{{ asset('storage/' . $menu->image) }}" style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; color: #cbd5e1;">
                                <svg width="48" height="48" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                        @endif
                    </div>
                    <div style="padding: 24px;">
                        <span style="font-size: 11px; font-weight: 800; color: #b91c1c; text-transform: uppercase; letter-spacing: 0.1em;">{{ $menu->category }}</span>
                        <h3 style="font-size: 20px; font-weight: 700; color: #1e293b; margin: 8px 0;">{{ $menu->name }}</h3>
                        <p style="font-size: 14px; color: #64748b; line-height: 1.6; margin-bottom: 24px;">{{ $menu->description }}</p>
                        <div style="display: flex; align-items: center; justify-content: space-between; pt: 16px; border-top: 1px solid #f1f5f9; padding-top: 20px;">
                            <span style="font-size: 20px; font-weight: 800; color: #0f172a;">Rp {{ number_format($menu->price, 0, ',', '.') }}</span>
                            <button @click="selectedMenu = {{ $menu }}; showCheckout = true" style="background: #b91c1c; color: white; padding: 10px 20px; border: none; border-radius: 12px; font-weight: 700; cursor: pointer;">Pesan</button>
                        </div>
                    </div>
                </div>
            @empty
                <div style="grid-column: 1/-1; text-align: center; padding: 80px 0; color: #94a3b8;">
                    <p style="font-weight: 600; font-size: 18px;">Belum ada menu tersedia.</p>
                </div>
            @endforelse
        </div>
    </main>

    <!-- Modal Checkout -->
    <div x-show="showCheckout" class="modal-overlay" style="display: none;">
        <div @click.away="showCheckout = false" class="modal-container">
            <div class="modal-header">
                <h2 style="font-size: 24px; font-weight: 800; color: #0f172a; margin: 0;">Konfirmasi Pesanan</h2>
                <button @click="showCheckout = false" style="background: none; border: none; color: #94a3b8; cursor: pointer; padding: 4px;">
                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <div class="modal-body">
                <form action="{{ route('preorders.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="menu_id" :value="selectedMenu?.id">
                    
                    <!-- Preview Item -->
                    <div class="item-preview">
                        <template x-if="selectedMenu?.image">
                            <img :src="'/storage/' + selectedMenu.image" class="preview-img">
                        </template>
                        <template x-if="!selectedMenu?.image">
                            <div class="preview-img" style="display: flex; align-items: center; justify-content: center; background: #e2e8f0; color: #94a3b8;">
                                <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                        </template>
                        <div>
                            <div style="font-weight: 800; color: #1e293b; font-size: 16px; margin-bottom: 2px;" x-text="selectedMenu?.name"></div>
                            <div style="font-weight: 700; color: #b91c1c; font-size: 14px;" x-text="'Rp ' + (selectedMenu?.price || 0).toLocaleString('id-ID')"></div>
                        </div>
                    </div>

                    @guest
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 20px;">
                            <div class="form-group" style="margin-bottom: 0;">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" name="customer_name" required placeholder="Nama" class="form-control">
                            </div>
                            <div class="form-group" style="margin-bottom: 0;">
                                <label class="form-label">No. HP / Meja</label>
                                <input type="text" name="customer_phone" required placeholder="08..." class="form-control">
                            </div>
                        </div>
                    @endguest

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 20px;">
                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="form-label">Jumlah Porsi</label>
                            <input type="number" name="quantity" value="1" min="1" required class="form-control" style="text-align: center; font-weight: 800;">
                        </div>
                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="form-label">Metode Bayar</label>
                            <select name="payment_method" class="form-control" style="cursor: pointer;">
                                <option value="cash">Tunai</option>
                                <option value="transfer">Transfer</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Tanggal Pengambilan</label>
                        <input type="date" name="preorder_date" value="{{ date('Y-m-d') }}" required class="form-control" style="font-weight: 700;">
                    </div>

                    <button type="submit" class="btn-confirm">
                        Konfirmasi Pesanan
                    </button>
                </form>
            </div>
        </div>
    </div>

</body>
</html>
