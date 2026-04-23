<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Kantin DSS — Sistem Cerdas Pengelolaan Kantin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Inter', sans-serif; box-sizing: border-box; margin: 0; padding: 0; }
        body { background: #fff; color: #1a1d23; line-height: 1.5; }
        .container { max-width: 1200px; margin: 0 auto; padding: 0 24px; }
        
        /* Nav */
        nav { 
            border-bottom: 1px solid rgba(255, 255, 255, 0.1); 
            background: rgba(15, 23, 42, 0.8); /* Dark glassmorphism to match hero */
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            position: sticky; 
            top: 0; 
            z-index: 100; 
        }
        .nav-inner { height: 72px; display: flex; align-items: center; justify-content: space-between; }
        .logo { display: flex; align-items: center; gap: 10px; text-decoration: none; }
        .logo-icon { width: 36px; height: 36px; background: linear-gradient(135deg, #6366f1, #8b5cf6); border-radius: 10px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(99, 102, 241, 0.4); }
        .logo-text { font-weight: 700; font-size: 18px; color: #fff; }
        .nav-links { display: flex; align-items: center; gap: 24px; }
        .nav-links a { text-decoration: none; color: #94a3b8; font-weight: 500; font-size: 14px; transition: color 0.15s; }
        .nav-links a:hover { color: #fff; }
        
        /* Hero */
        .hero { 
            padding: 120px 0 160px; 
            position: relative;
            overflow: hidden;
            background: #0f172a; /* Darker background for better glow effect */
            transition: background 0.3s ease;
        }
        .hero-bg-gradient {
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            background: radial-gradient(800px circle at var(--mouse-x, 50%) var(--mouse-y, 50%), rgba(99, 102, 241, 0.15), transparent 80%);
            z-index: 0;
            pointer-events: none;
        }
        .hero-bg-shapes {
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            z-index: 0;
            pointer-events: none;
        }
        .orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.4;
            animation: float 20s infinite alternate ease-in-out;
        }
        .orb-1 { width: 400px; height: 400px; background: #c7d2fe; top: -100px; right: -50px; animation-duration: 25s; }
        .orb-2 { width: 500px; height: 500px; background: #ddd6fe; bottom: -150px; left: -100px; animation-duration: 30s; animation-delay: -5s; }
        .orb-3 { width: 300px; height: 300px; background: #e0e7ff; top: 20%; left: 10%; animation-duration: 20s; animation-delay: -10s; }

        @keyframes float {
            0% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(30px, 50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
            100% { transform: translate(0, 0) scale(1); }
        }

        .hero .container { position: relative; z-index: 2; }

        .floating-food {
            position: absolute;
            z-index: 1;
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            filter: blur(1px);
            opacity: 0.6;
            pointer-events: none;
            animation: float-slow 15s infinite ease-in-out;
        }
        
        .food-1 { top: 15%; left: 5%; animation-duration: 18s; }
        .food-2 { top: 60%; left: 8%; animation-duration: 22s; animation-delay: -3s; }
        .food-3 { top: 10%; right: 10%; animation-duration: 20s; animation-delay: -7s; }
        .food-4 { top: 70%; right: 12%; animation-duration: 25s; animation-delay: -12s; }
        .food-5 { top: 40%; right: 5%; animation-duration: 19s; animation-delay: -5s; }

        @keyframes float-slow {
            0% { transform: translate(0, 0) rotate(0deg); }
            50% { transform: translate(20px, 40px) rotate(10deg); }
            100% { transform: translate(0, 0) rotate(0deg); }
        }

        .badge { display: inline-block; padding: 6px 16px; background: rgba(79, 70, 229, 0.1); color: #4f46e5; border-radius: 999px; font-size: 13px; font-weight: 600; margin-bottom: 24px; border: 1px solid rgba(79, 70, 229, 0.2); }
        h1 { font-size: 56px; font-weight: 800; color: #1a1d23; line-height: 1.1; letter-spacing: -0.02em; margin-bottom: 24px; }
        h1 span { color: #4f46e5; }
        .hero-sub { font-size: 18px; color: #6b7280; max-width: 640px; margin: 0 auto 40px; }
        .btn { display: inline-flex; align-items: center; gap: 8px; padding: 14px 28px; border-radius: 12px; font-size: 16px; font-weight: 600; text-decoration: none; transition: all 0.15s; }
        .btn-primary { background: #4f46e5; color: #fff; }
        .btn-primary:hover { background: #4338ca; transform: translateY(-3px) scale(1.02); box-shadow: 0 12px 32px rgba(79, 70, 229, 0.3); }
        .btn-secondary { background: rgba(255, 255, 255, 0.8); color: #1a1d23; border: 1px solid #e2e4ea; backdrop-filter: blur(8px); }
        .btn-secondary:hover { background: #fff; transform: translateY(-3px) scale(1.02); box-shadow: 0 12px 32px rgba(0,0,0,0.05); }

        .btn-magnetic {
            transition: transform 0.3s cubic-bezier(0.23, 1, 0.32, 1);
            display: inline-flex;
        }

        .hero-card {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(25px);
            -webkit-backdrop-filter: blur(25px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 40px;
            padding: 80px 40px;
            max-width: 900px;
            margin: 0 auto;
            box-shadow: 0 40px 100px rgba(0,0,0,0.5);
            position: relative;
            z-index: 10;
            transform-style: preserve-3d;
            perspective: 1000px;
            transition: transform 0.1s ease-out;
        }

        h1 { font-size: 64px; font-weight: 800; color: #fff; line-height: 1.1; letter-spacing: -0.03em; margin-bottom: 24px; }
        h1 span { 
            background: linear-gradient(135deg, #818cf8, #c084fc);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .hero-sub { font-size: 18px; color: #94a3b8; max-width: 640px; margin: 0 auto 40px; }
        .features { padding: 96px 0; border-top: 1px solid #f0f1f5; }
        .section-tag { font-size: 13px; font-weight: 700; color: #4f46e5; text-transform: uppercase; letter-spacing: 0.1em; text-align: center; margin-bottom: 12px; display: block; }
        .section-title { font-size: 32px; font-weight: 800; text-align: center; margin-bottom: 56px; }
        .feature-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 32px; }
        .feature-card { padding: 32px; border: 1px solid #f0f1f5; border-radius: 20px; transition: all 0.2s; }
        .feature-card:hover { border-color: #e2e4ea; box-shadow: 0 12px 32px rgba(0,0,0,0.04); }
        .feature-icon { width: 48px; height: 48px; border-radius: 12px; background: #eff0ff; display: flex; align-items: center; justify-content: center; margin-bottom: 20px; color: #4f46e5; }
        .feature-title { font-size: 18px; font-weight: 700; margin-bottom: 12px; }
        .feature-desc { color: #6b7280; font-size: 14px; line-height: 1.6; }
        
        /* Stats */
        .stats { padding: 80px 0; background: #fafbfc; border-top: 1px solid #f0f1f5; border-bottom: 1px solid #f0f1f5; }
        .stats-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 48px; text-align: center; }
        .stat-val { font-size: 48px; font-weight: 800; color: #4f46e5; margin-bottom: 4px; }
        .stat-label { font-size: 15px; color: #6b7280; font-weight: 500; }
        
        /* Footer */
        footer { padding: 48px 0; border-top: 1px solid #f0f1f5; color: #9ca3af; font-size: 14px; text-align: center; }
    </style>
</head>
<body>

    <nav>
        <div class="container">
            <div class="nav-inner">
                <a href="/" class="logo">
                    <div class="logo-icon">
                        <svg width="18" height="18" fill="none" stroke="white" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                    <span class="logo-text">Smart Kantin</span>
                </a>
                <div class="nav-links">
                    @auth
                        <a href="{{ route('dashboard') }}" class="btn btn-primary" style="padding: 10px 20px; font-size: 14px;">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}">Masuk</a>
                        <a href="{{ route('register') }}" class="btn btn-primary btn-magnetic" style="padding: 10px 24px; font-size: 14px; background: #6366f1; box-shadow: 0 4px 14px rgba(99, 102, 241, 0.4);">Daftar Gratis</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <section class="hero" id="hero-section">
        <div class="hero-bg-gradient" id="hero-gradient"></div>
        <div class="hero-bg-shapes">
            <div class="orb orb-1"></div>
            <div class="orb orb-2"></div>
            <div class="orb orb-3"></div>
            
            <!-- Floating Food Elements -->
            <img src="{{ asset('storage/menus/nasi_ayam_goreng.png') }}" class="floating-food food-1" alt="">
            <img src="{{ asset('storage/menus/nasi_rendang.png') }}" class="floating-food food-2" alt="">
            <img src="{{ asset('storage/menus/mie_goreng_spesial.png') }}" class="floating-food food-3" alt="">
            <img src="{{ asset('storage/menus/ayam_bakar.png') }}" class="floating-food food-4" alt="">
            <img src="{{ asset('storage/menus/es_teh_manis.png') }}" class="floating-food food-5" alt="">
        </div>
        <div class="container" style="text-align: center;">
            <div class="hero-card">
                <span class="badge">Sistem Pendukung Keputusan (DSS)</span>
                <h1>Kelola Kantin Lebih <span>Cerdas</span> & <span>Zero Waste</span></h1>
                <p class="hero-sub">Platform modern untuk memprediksi produksi, mengelola preorder, dan mengurangi food waste menggunakan analisis data yang akurat.</p>
                <div class="hero-btns">
                    <a href="{{ route('register') }}" class="btn btn-primary btn-magnetic">Mulai Mengelola</a>
                    <a href="#features" class="btn btn-secondary btn-magnetic" style="margin-left: 12px;">Pelajari Fitur</a>
                </div>
            </div>
        </div>
    </section>

    <section class="stats">
        <div class="container">
            <div class="stats-grid">
                <div>
                    <div class="stat-val">40%</div>
                    <div class="stat-label">Efisiensi Produksi</div>
                </div>
                <div>
                    <div class="stat-val">100+</div>
                    <div class="stat-label">Analisis DSS Harian</div>
                </div>
                <div>
                    <div class="stat-val">Realtime</div>
                    <div class="stat-label">Monitoring Firebase</div>
                </div>
            </div>
        </div>
    </section>

    <section id="features" class="features">
        <div class="container">
            <span class="section-tag">Fitur Utama</span>
            <h2 class="section-title">Semua yang Anda Butuhkan dalam Satu Platform</h2>
            <div class="feature-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    </div>
                    <h3 class="feature-title">Rekomendasi DSS</h3>
                    <p class="feature-desc">Engine cerdas yang memberikan saran produksi (Tambah/Kurangi) berdasarkan data penjualan historis.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    </div>
                    <h3 class="feature-title">Preorder Digital</h3>
                    <p class="feature-desc">Memungkinkan pelanggan memesan lebih awal untuk membantu estimasi jumlah produksi yang akurat.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    </div>
                    <h3 class="feature-title">Food Waste Tracking</h3>
                    <p class="feature-desc">Analisis sisa makanan secara otomatis untuk meminimalisir kerugian dan membantu program donasi.</p>
                </div>
            </div>
        </div>
    </section>

    <footer>
        <div class="container">
            <p>&copy; {{ date('Y') }} Smart Kantin DSS. Built for Excellence.</p>
        </div>
    </footer>

    <script>
        const hero = document.getElementById('hero-section');
        const gradient = document.getElementById('hero-gradient');
        
        document.addEventListener('mousemove', (e) => {
            // 1. Parallax & Tilt Food
            const foods = document.querySelectorAll('.floating-food');
            const x = (window.innerWidth / 2 - e.pageX) / 40;
            const y = (window.innerHeight / 2 - e.pageY) / 40;

            foods.forEach((food, index) => {
                const speed = (index + 1) * 0.4;
                const tiltX = (e.pageY - window.innerHeight / 2) / 20;
                const tiltY = (e.pageX - window.innerWidth / 2) / 20;
                food.style.transform = `translate(${x * speed}px, ${y * speed}px) rotateX(${tiltX}deg) rotateY(${tiltY}deg) scale(${1.1})`;
                food.style.filter = `blur(0px) drop-shadow(0 20px 40px rgba(0,0,0,0.3))`;
                food.style.opacity = '0.9';
            });

            // 2. 3D Tilt Hero Card
            const card = document.querySelector('.hero-card');
            const cRect = card.getBoundingClientRect();
            const cX = cRect.left + cRect.width / 2;
            const cY = cRect.top + cRect.height / 2;
            const cRotateX = (cY - e.clientY) / 25;
            const cRotateY = (e.clientX - cX) / 25;
            card.style.transform = `rotateX(${cRotateX}deg) rotateY(${cRotateY}deg)`;

            // 3. Dynamic Gradient Glow
            const rect = hero.getBoundingClientRect();
            const relX = e.clientX - rect.left;
            const relY = e.clientY - rect.top;
            hero.style.setProperty('--mouse-x', `${relX}px`);
            hero.style.setProperty('--mouse-y', `${relY}px`);

            // 4. Magnetic Buttons
            const magnetics = document.querySelectorAll('.btn-magnetic');
            magnetics.forEach(btn => {
                const bRect = btn.getBoundingClientRect();
                const bX = bRect.left + bRect.width / 2;
                const bY = bRect.top + bRect.height / 2;
                const dist = Math.hypot(e.clientX - bX, e.clientY - bY);

                if (dist < 100) {
                    const mX = (e.clientX - bX) * 0.3;
                    const mY = (e.clientY - bY) * 0.3;
                    btn.style.transform = `translate(${mX}px, ${mY}px) scale(1.05)`;
                    btn.style.zIndex = "100";
                } else {
                    btn.style.transform = `translate(0, 0)`;
                    btn.style.zIndex = "1";
                }
            });
        });

        // 4. Click Particle Effect
        document.addEventListener('mousedown', (e) => {
            for (let i = 0; i < 8; i++) {
                const p = document.createElement('div');
                p.style = `
                    position: fixed;
                    top: ${e.clientY}px;
                    left: ${e.clientX}px;
                    width: 6px;
                    height: 6px;
                    background: #4f46e5;
                    border-radius: 50%;
                    pointer-events: none;
                    z-index: 9999;
                    transition: all 0.6s ease-out;
                `;
                document.body.appendChild(p);
                
                const angle = Math.random() * Math.PI * 2;
                const velocity = 50 + Math.random() * 50;
                const tx = Math.cos(angle) * velocity;
                const ty = Math.sin(angle) * velocity;

                setTimeout(() => {
                    p.style.transform = `translate(${tx}px, ${ty}px)`;
                    p.style.opacity = '0';
                    p.style.scale = '0';
                }, 10);

                setTimeout(() => p.remove(), 600);
            }
        });
    </script>
</body>
</html>
