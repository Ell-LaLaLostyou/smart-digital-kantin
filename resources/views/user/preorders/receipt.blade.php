<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Digital — {{ $preorder->order_number }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background: #f1f5f9; color: #1e293b; margin: 0; padding: 20px; }
        .receipt-card {
            background: white;
            max-width: 450px;
            margin: 40px auto;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
            position: relative;
        }
        .receipt-card::before, .receipt-card::after {
            content: '';
            position: absolute;
            left: 0; right: 0;
            height: 10px;
            background-image: radial-gradient(circle, #f1f5f9 5px, transparent 6px);
            background-size: 15px 15px;
        }
        .receipt-card::before { top: -5px; }
        .receipt-card::after { bottom: -5px; transform: rotate(180deg); }

        .receipt-header {
            padding: 40px 32px 32px;
            text-align: center;
            border-bottom: 2px dashed #f1f5f9;
        }
        .order-number {
            font-size: 24px;
            font-weight: 800;
            color: #b91c1c;
            margin-bottom: 8px;
            letter-spacing: 0.05em;
        }
        .receipt-body { padding: 32px; }
        .receipt-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 16px;
            font-size: 14px;
        }
        .receipt-label { color: #64748b; font-weight: 500; }
        .receipt-value { color: #1e293b; font-weight: 700; text-align: right; }
        
        .total-section {
            margin-top: 24px;
            padding-top: 24px;
            border-top: 2px solid #f1f5f9;
        }
        .btn-home {
            display: block;
            width: 100%;
            text-align: center;
            padding: 16px;
            background: #1e293b;
            color: white;
            text-decoration: none;
            border-radius: 16px;
            font-weight: 700;
            margin-top: 32px;
        }
        @media print {
            .btn-home { display: none; }
            body { background: white; padding: 0; }
            .receipt-card { box-shadow: none; margin: 0; max-width: 100%; border: 1px solid #eee; }
        }
    </style>
</head>
<body>

    <div class="receipt-card">
        <div class="receipt-header">
            <div style="width: 48px; height: 48px; background: #fef2f2; border-radius: 99px; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;">
                <svg width="24" height="24" fill="none" stroke="#b91c1c" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
            </div>
            <h1 style="font-size: 18px; font-weight: 800; margin: 0 0 4px;">Berhasil Dipesan!</h1>
            <p style="color: #64748b; font-size: 13px; margin: 0;">Silakan tunjukkan struk ini ke petugas kantin.</p>
        </div>

        <div class="receipt-body">
            <div style="text-align: center; margin-bottom: 32px;">
                <div class="receipt-label" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 4px;">Nomor Pesanan</div>
                <div class="order-number">{{ $preorder->order_number }}</div>
            </div>

            <div class="receipt-row">
                <span class="receipt-label">Kantin</span>
                <span class="receipt-value">{{ $preorder->canteen->name }}</span>
            </div>
            <div class="receipt-row">
                <span class="receipt-label">Nama Pemesan</span>
                <span class="receipt-value">{{ $preorder->customer_name }}</span>
            </div>
            <div class="receipt-row">
                <span class="receipt-label">Menu</span>
                <span class="receipt-value">{{ $preorder->menu->name }}</span>
            </div>
            <div class="receipt-row">
                <span class="receipt-label">Jumlah</span>
                <span class="receipt-value">{{ $preorder->quantity }} Porsi</span>
            </div>
            <div class="receipt-row">
                <span class="receipt-label">Tanggal Ambil</span>
                <span class="receipt-value">{{ \Carbon\Carbon::parse($preorder->preorder_date)->format('d M Y') }}</span>
            </div>
            <div class="receipt-row">
                <span class="receipt-label">Metode Bayar</span>
                <span class="receipt-value">{{ strtoupper($preorder->payment_method) }}</span>
            </div>

            <div class="total-section">
                <div class="receipt-row" style="margin-bottom: 0;">
                    <span style="font-weight: 800; font-size: 16px;">Total Bayar</span>
                    <span style="font-weight: 800; font-size: 18px; color: #b91c1c;">Rp {{ number_format($preorder->menu->price * $preorder->quantity, 0, ',', '.') }}</span>
                </div>
            </div>

            @if($preorder->payment_method != 'cash' && !$preorder->payment_proof)
                <div style="margin-top: 32px; padding: 24px; background: #fffbeb; border-radius: 20px; border: 1px solid #fef3c7;">
                    <h3 style="font-size: 14px; font-weight: 800; color: #92400e; margin-bottom: 12px; display: flex; align-items: center; gap: 8px;">
                        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Instruksi Pembayaran
                    </h3>
                    <p style="font-size: 13px; color: #b45309; line-height: 1.5; margin-bottom: 16px;">
                        Silakan transfer ke rekening <strong>BCA 123456789 a/n Kantin SMK PGRI 11</strong> atau scan QRIS yang tersedia di kantin, lalu unggah bukti bayar di bawah ini.
                    </p>
                    
                    <form action="{{ route('preorders.upload_proof', $preorder->order_number) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <label style="display: block; background: white; border: 1px dashed #d1d5db; padding: 12px; border-radius: 12px; cursor: pointer; text-align: center; transition: border 0.2s;">
                            <input type="file" name="payment_proof" style="display: none;" onchange="this.form.submit()">
                            <span style="font-size: 13px; font-weight: 700; color: #4b5563;">Klik untuk Unggah Bukti Bayar</span>
                        </label>
                    </form>
                </div>
            @elseif($preorder->payment_proof)
                <div style="margin-top: 32px; padding: 16px; background: #f0fdf4; border-radius: 16px; border: 1px solid #bbf7d0; text-align: center;">
                    <span style="font-size: 13px; font-weight: 700; color: #166534; display: flex; align-items: center; justify-content: center; gap: 8px;">
                        <svg width="18" height="18" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        Bukti bayar telah diunggah
                    </span>
                </div>
            @endif

            <a href="{{ route('welcome') }}" class="btn-home">Kembali ke Beranda</a>
            <button onclick="window.print()" style="width: 100%; background: none; border: 1px solid #e2e8f0; padding: 12px; border-radius: 16px; margin-top: 12px; font-weight: 600; color: #64748b; cursor: pointer;">Cetak Struk</button>
        </div>
    </div>

    <div style="text-align: center; color: #94a3b8; font-size: 12px;">
        Terima kasih telah berpartisipasi dalam program Zero Waste SMK PGRI 11 Jakarta.
    </div>

</body>
</html>
