# Smart Digital Kantin

Aplikasi web manajemen kantin sekolah yang gua kembangkan untuk SMK PGRI 11 Jakarta. Awalnya masalahnya sederhana: antrean panjang pas istirahat dan makanan yang sering terbuang karena produksi cuma ditebak-tebak. Aplikasi ini dibuat buat ngurangin dua hal itu.

## Fitur

- **Pre-order**: siswa pesan makanan sebelum jam istirahat, jadi gak perlu antre lama.
- **Verifikasi QR Code**: tiap pesanan punya QR, tinggal discan petugas kantin pas pengambilan.
- **Pencatatan sisa makanan**: kantin bisa nyatat makanan yang gak laku/terbuang per hari.
- **Rekomendasi produksi (DSS)**: dari data pesanan dan sisa makanan, sistem kasih saran jumlah yang sebaiknya dimasak besok.
- **Laporan**: rekap pesanan, penjualan, dan sisa makanan.

## Tech Stack

- Laravel 13
- MySQL
- Tailwind CSS

## Cara Install

```bash
git clone [URL_REPO]
cd [NAMA_FOLDER]
composer install
npm install && npm run build
cp .env.example .env
php artisan key:generate
```

Atur koneksi database di `.env`, lalu:

```bash
php artisan migrate --seed
php artisan serve
```

Buka `http://localhost:8000`.

## Akun Demo

| Role | Email | Password |
|------|-------|----------|
| Admin | [ISI] | [ISI] |
| Petugas Kantin | [ISI] | [ISI] |
| Siswa | [ISI] | [ISI] |

## Struktur Database

Ada 11 tabel. ERD dan spesifikasi tiap tabel ada di folder `docs/`.

## Screenshot

[TARUH 3-4 SCREENSHOT: halaman pre-order, scan QR, dashboard, laporan]

## Dokumentasi Lain

- Laporan PSI (arsitektur sistem, tahapan pengembangan, spesifikasi database)
- Paper audit tata kelola TI menggunakan COBIT 2019 (DSS01, DSS03, BAI02, BAI07)

## Catatan

Dikembangkan sebagai proyek praktik sistem informasi. Masih terbuka untuk pengembangan, misalnya integrasi pembayaran digital.