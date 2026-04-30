<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Canteen — SMK PGRI 11 Jakarta</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
            color: #1e293b;
            margin: 0;
        }

        .navbar {
            background: white;
            border-bottom: 1px solid #e2e8f0;
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .hero-section {
            background: white;
            padding: 60px 0;
            border-bottom: 1px solid #e2e8f0;
        }

        .hero-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 24px;
            display: flex;
            align-items: center;
            gap: 48px;
        }

        .hero-content {
            flex: 1;
        }

        .hero-image-container {
            flex: 1;
            height: 350px;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }

        .hero-image-container img {
            width: 100%;
            height: 100%;
            object-cover: cover;
        }

        .canteen-grid {
            max-width: 1200px;
            margin: 60px auto;
            padding: 0 24px;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 32px;
        }

        .card-kantin {
            background: white;
            border-radius: 20px;
            border: 1px solid #e2e8f0;
            overflow: hidden;
            transition: all 0.3s ease;
            text-decoration: none;
            color: inherit;
        }

        .card-kantin:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 30px rgba(0,0,0,0.05);
            border-color: #cbd5e1;
        }

        .card-img {
            height: 200px;
            background: #f1f5f9;
            position: relative;
        }

        .card-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .badge-status {
            position: absolute;
            top: 16px;
            right: 16px;
            background: rgba(255,255,255,0.9);
            backdrop-filter: blur(4px);
            padding: 4px 12px;
            border-radius: 99px;
            font-size: 11px;
            font-weight: 700;
            color: #059669;
        }

        .btn-primary {
            background: #b91c1c;
            color: white;
            padding: 12px 24px;
            border-radius: 12px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: background 0.2s;
        }

        .btn-primary:hover {
            background: #991b1b;
        }

        .btn-outline {
            border: 1px solid #e2e8f0;
            padding: 10px 20px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            color: #475569;
            transition: all 0.2s;
        }

        .btn-outline:hover {
            background: #f8fafc;
            border-color: #cbd5e1;
        }

        @media (max-width: 768px) {
            .hero-container {
                flex-direction: column;
                text-align: center;
            }
            .hero-image-container {
                width: 100%;
                height: 250px;
            }
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar">
        <div style="max-width: 1200px; margin: 0 auto; padding: 16px 24px; display: flex; justify-content: space-between; align-items: center;">
            <a href="/" style="display: flex; align-items: center; gap: 12px; text-decoration: none;">
                <div style="width: 36px; height: 36px; background: #b91c1c; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white;">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
                <span style="font-weight: 800; font-size: 18px; color: #1e293b; letter-spacing: -0.02em;">SmartCanteen</span>
            </a>
            
            <div style="display: flex; align-items: center; gap: 12px;">
                @auth
                    <a href="{{ route('dashboard') }}" class="btn-primary" style="padding: 10px 20px; font-size: 14px;">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="btn-outline">Masuk</a>
                    <a href="{{ route('register') }}" class="btn-primary" style="padding: 10px 20px; font-size: 14px;">Daftar Akun</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Hero -->
    <section class="hero-section">
        <div class="hero-container">
            <div class="hero-content">
                <div style="color: #b91c1c; font-weight: 700; font-size: 14px; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 16px;">Portal Kantin Digital</div>
                <h1 style="font-size: 48px; font-weight: 800; color: #0f172a; line-height: 1.1; margin-bottom: 20px;">Pesan Makan Siang <span style="color: #b91c1c;">Tanpa Antre</span></h1>
                <p style="font-size: 18px; color: #64748b; line-height: 1.6; margin-bottom: 32px; max-width: 500px;">
                    Nikmati kemudahan memesan makanan dari berbagai kantin di SMK PGRI 11 Jakarta secara online atau melalui scan QR di meja.
                </p>
                <div style="display: flex; gap: 16px;">
                    <a href="#pilih-kantin" class="btn-primary">Pilih Kantin Sekarang</a>
                    <a href="#cara-pesan" class="btn-outline" style="padding: 12px 24px;">Cara Kerja</a>
                </div>
            </div>
            <div class="hero-image-container">
                <img src="{{ asset('images/hero.png') }}" alt="Canteen Hero">
            </div>
        </div>
    </section>

    <!-- Canteen Selection -->
    <div id="pilih-kantin" style="background: #f8fafc; padding: 80px 0;">
        <div style="max-width: 1200px; margin: 0 auto; padding: 0 24px; margin-bottom: 40px;">
            <h2 style="font-size: 28px; font-weight: 800; color: #0f172a; margin-bottom: 8px;">Daftar Kantin Tersedia</h2>
            <p style="color: #64748b; font-weight: 500;">Pilih salah satu kantin di bawah ini untuk melihat menu dan memesan.</p>
        </div>

        <div class="canteen-grid">
            @foreach($canteens as $canteen)
                <a href="{{ route('canteen.show', $canteen->slug) }}" class="card-kantin">
                    <div class="card-img">
                        @if($canteen->image_url)
                            <img src="{{ asset('storage/' . $canteen->image_url) }}" alt="{{ $canteen->name }}">
                        @else
                            <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #b91c1c, #dc2626); color: white; font-size: 48px; font-weight: 800;">
                                {{ substr($canteen->name, 0, 1) }}
                            </div>
                        @endif
                        <div class="badge-status">BUKA SEKARANG</div>
                    </div>
                    <div style="padding: 24px;">
                        <h3 style="font-size: 20px; font-weight: 700; color: #1e293b; margin-bottom: 8px;">{{ $canteen->name }}</h3>
                        <p style="font-size: 14px; color: #64748b; line-height: 1.5; margin-bottom: 20px; min-height: 42px;">
                            {{ $canteen->description ?? 'Kantin terpercaya dengan berbagai pilihan menu makanan sehat dan higienis.' }}
                        </p>
                        <div style="display: flex; align-items: center; justify-content: space-between; border-top: 1px solid #f1f5f9; pt: 20px; margin-top: 20px; padding-top: 20px;">
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <div style="width: 24px; height: 24px; background: #fee2e2; border-radius: 99px; display: flex; align-items: center; justify-content: center;">
                                    <svg class="w-3.5 h-3.5 text-red-600" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                </div>
                                <span style="font-size: 13px; font-weight: 700; color: #1e293b;">4.8</span>
                            </div>
                            <span style="font-size: 14px; font-weight: 700; color: #b91c1c;">Lihat Menu &rarr;</span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>

    <!-- Footer -->
    <footer style="background: white; border-top: 1px solid #e2e8f0; padding: 60px 0;">
        <div style="max-width: 1200px; margin: 0 auto; padding: 0 24px; display: flex; flex-direction: column; align-items: center; text-align: center;">
            <div style="font-weight: 800; font-size: 24px; color: #0f172a; margin-bottom: 16px;">SmartCanteen</div>
            <p style="color: #64748b; max-width: 400px; margin-bottom: 32px; font-size: 14px;">Platform pengelolaan dan pemesanan makanan digital untuk ekosistem sekolah yang lebih baik.</p>
            <div style="display: flex; gap: 24px; margin-bottom: 40px;">
                <a href="#" style="text-decoration: none; color: #64748b; font-size: 14px; font-weight: 600;">Beranda</a>
                <a href="#" style="text-decoration: none; color: #64748b; font-size: 14px; font-weight: 600;">Tentang Kami</a>
                <a href="#" style="text-decoration: none; color: #64748b; font-size: 14px; font-weight: 600;">Syarat & Ketentuan</a>
            </div>
            <p style="color: #94a3b8; font-size: 12px;">&copy; {{ date('Y') }} SmartCanteen SMK PGRI 11 Jakarta. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>
