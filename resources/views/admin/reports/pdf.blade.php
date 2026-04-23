<!DOCTYPE html>
<html>
<head>
    <title>Laporan Keuangan Kantin</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; color: #333; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #4f46e5; padding-bottom: 10px; }
        .header h1 { margin: 0; color: #4f46e5; }
        .header p { margin: 5px 0; color: #666; }
        .summary-box { display: block; margin-bottom: 20px; }
        .summary-item { display: inline-block; width: 23%; padding: 10px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 5px; margin-right: 1%; }
        .summary-item h4 { margin: 0; font-size: 10px; color: #94a3b8; text-transform: uppercase; }
        .summary-item p { margin: 5px 0 0; font-size: 14px; font-weight: bold; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { text-align: left; background: #f1f5f9; padding: 10px; font-size: 12px; border-bottom: 1px solid #e2e8f0; }
        td { padding: 10px; font-size: 11px; border-bottom: 1px solid #f1f5f9; }
        .text-right { text-align: right; }
        .footer { margin-top: 40px; font-size: 10px; color: #94a3b8; text-align: center; }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN KEUANGAN KANTIN</h1>
        <p>Periode: {{ $startDate }} s/d {{ $endDate }}</p>
    </div>

    <div class="summary-box">
        <div class="summary-item">
            <h4>Pendapatan</h4>
            <p>Rp{{ number_format($totalRevenue, 0, ',', '.') }}</p>
        </div>
        <div class="summary-item">
            <h4>Total Modal</h4>
            <p>Rp{{ number_format($totalCost, 0, ',', '.') }}</p>
        </div>
        <div class="summary-item">
            <h4>Rugi Waste</h4>
            <p>Rp{{ number_format($totalWasteLoss, 0, ',', '.') }}</p>
        </div>
        <div class="summary-item">
            <h4>Laba Bersih</h4>
            <p>Rp{{ number_format($netProfit, 0, ',', '.') }}</p>
        </div>
    </div>

    <h3>Rincian Penjualan</h3>
    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Menu</th>
                <th>Jumlah</th>
                <th>Harga</th>
                <th class="text-right">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sales as $sale)
            <tr>
                <td>{{ \Carbon\Carbon::parse($sale->sale_date)->format('d/m/Y') }}</td>
                <td>{{ $sale->menu->name }}</td>
                <td>{{ $sale->quantity_sold }} porsi</td>
                <td>Rp{{ number_format($sale->menu->price, 0, ',', '.') }}</td>
                <td class="text-right">Rp{{ number_format($sale->quantity_sold * ($sale->menu->price ?? 0), 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr style="background: #f8fafc;">
                <td colspan="4" class="text-right"><strong>GRAND TOTAL</strong></td>
                <td class="text-right"><strong>Rp{{ number_format($totalRevenue, 0, ',', '.') }}</strong></td>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        Dicetak otomatis oleh Sistem Smart Kantin DSS pada {{ now()->format('d/m/Y H:i') }}
    </div>
</body>
</html>
