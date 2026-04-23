@extends('admin.layout')
@section('title', 'Donasi')
@section('header_title', 'Log Donasi')

@section('content')
<div class="section-header">
    <h2>Daftar Makanan Didonasikan</h2>
    <p>Data makanan sisa yang telah disalurkan untuk donasi sosial.</p>
</div>

<div class="card">
    <div style="overflow-x:auto;">
        <table>
            <thead><tr>
                <th>Tanggal Donasi</th>
                <th>Nama Menu</th>
                <th>Penerima Donasi</th>
                <th>Jumlah Sisa</th>
                <th>Tingkat Kelayakan</th>
                <th style="text-align:right;">Aksi</th>
            </tr></thead>
            <tbody>
                @forelse($donations as $donation)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($donation->donation_date)->format('d/m/Y') }}</td>
                    <td><strong>{{ $donation->foodWaste->menu->name ?? '—' }}</strong></td>
                    <td>
                        @if($donation->recipient)
                            <strong>{{ $donation->recipient->name }}</strong><br>
                            <span class="badge {{ $donation->recipient->need_level == 'high' ? 'badge-red' : ($donation->recipient->need_level == 'medium' ? 'badge-yellow' : 'badge-green') }}" style="font-size:9px; padding:1px 6px;">
                                PRIORITY: {{ strtoupper($donation->recipient->need_level) }}
                            </span>
                        @else
                            <span style="color:#94a3b8;">Umum</span>
                        @endif
                    </td>
                    <td><strong>{{ $donation->foodWaste->quantity_waste ?? 0 }}</strong> <span style="font-size:11px; color:#9198a8;">Porsi</span></td>
                    <td>
                        <span class="badge {{ $donation->status=='layak' ? 'badge-green' : ($donation->status=='hampir_kadaluarsa' ? 'badge-yellow' : 'badge-red') }}">
                            {{ str_replace('_',' ', strtoupper($donation->status)) }}
                        </span>
                    </td>
                    <td style="text-align:right;">
                        <form action="{{ route('admin.donations.destroy', $donation) }}" method="POST" onsubmit="return confirm('Hapus catatan donasi ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" style="text-align:center; padding:48px; color:#9198a8;">Belum ada catatan donasi.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
