@extends('admin.layout')
@section('title', 'Food Waste')
@section('header_title', 'Laporan Food Waste')

@section('content')
<div class="section-header">
    <h2>Monitoring Sisa Makanan</h2>
    <p>Data sisa makanan harian (Produksi - Penjualan). Tandai makanan sisa untuk didonasikan.</p>
</div>

<div class="card">
    <div style="overflow-x:auto;">
        <table>
            <thead><tr>
                <th>Tanggal</th>
                <th>Nama Menu</th>
                <th>Sisa (Waste)</th>
                <th>Status Donasi</th>
                <th style="text-align:right;">Aksi Donasi</th>
            </tr></thead>
            <tbody>
                @forelse($wastes as $waste)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($waste->production_date)->format('d M Y') }}</td>
                    <td><strong>{{ $waste->menu->name }}</strong></td>
                    <td>
                        <span style="font-size: 18px; font-weight: 700; color: {{ $waste->quantity_waste > 0 ? '#e11d48' : '#059669' }}">
                            {{ $waste->quantity_waste }} <span style="font-size: 12px; font-weight: 500; color: #9198a8;">Porsi</span>
                        </span>
                    </td>
                    <td>
                        @if($waste->donations->count() > 0)
                            @php $d = $waste->donations->last(); @endphp
                            <span class="badge {{ $d->status=='layak' ? 'badge-green' : ($d->status=='hampir_kadaluarsa' ? 'badge-yellow' : 'badge-red') }}">
                                {{ str_replace('_',' ', strtoupper($d->status)) }}
                            </span>
                        @else
                            <span style="color: #9198a8; font-size: 12px;">Belum didonasikan</span>
                        @endif
                    </td>
                    <td style="text-align:right;">
                        @if($waste->donations->count() == 0 && $waste->quantity_waste > 0)
                        <form action="{{ route('admin.food-wastes.donate', $waste) }}" method="POST" style="display:inline-flex; align-items:center; gap:6px;">
                            @csrf
                            <select name="recipient_id" class="form-input" style="width: 140px; padding: 4px 8px; font-size: 12px;" required>
                                <option value="" disabled selected>Pilih Penerima</option>
                                @foreach($recipients as $recipient)
                                    <option value="{{ $recipient->id }}">{{ $recipient->name }} ({{ strtoupper($recipient->need_level) }})</option>
                                @endforeach
                            </select>
                            <select name="status" class="form-input" style="width: auto; padding: 4px 8px; font-size: 12px;">
                                <option value="layak">Layak</option>
                                <option value="hampir_kadaluarsa">Hampir Kadaluarsa</option>
                            </select>
                            <button type="submit" class="btn btn-primary btn-sm">Donasi</button>
                        </form>
                        @elseif($waste->quantity_waste == 0)
                            <span class="badge badge-green">No Waste 🎉</span>
                        @else
                            <span style="color: #9198a8; font-size: 12px;">Sudah di Donasi</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" style="text-align:center; padding:48px; color:#9198a8;">Belum ada data food waste hari ini.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
