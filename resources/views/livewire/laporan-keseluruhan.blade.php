<div>


    <div class="row mb-3">
        <div class="col-md-3 mb-2">
            <input type="date" wire:model="startDate" class="form-control" placeholder="Dari tanggal">
        </div>
        <div class="col-md-3 mb-2">
            <input type="date" wire:model="endDate" class="form-control" placeholder="Sampai tanggal">
        </div>
        <div class="col-md-3 mb-2">
            <button wire:click="resetFilter" class="btn btn-secondary w-100">
                🔄 Reset
            </button>
        </div>
        <div class="col-md-3 mb-2">
            @php
            $start = $startDate;
            $end = $endDate;
            @endphp

            <a href="{{ route('laporan.pdf', ['start' => $start, 'end' => $end]) }}" target="_blank" class="btn btn-danger w-100">
                🖨️ Cetak PDF
            </a>

        </div>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h5>💰 Total Pendapatan: <strong class="text-success">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</strong></h5>
            <h5>📉 Total Pengeluaran: <strong class="text-danger">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</strong></h5>
            <h5>📈 Keuntungan Bersih:
                <strong class="{{ ($totalPendapatan - $totalPengeluaran) >= 0 ? 'text-success' : 'text-danger' }}">
                    Rp {{ number_format($totalPendapatan - $totalPengeluaran, 0, ',', '.') }}
                </strong>
            </h5>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <strong>📦 Stok Produk Saat Ini</strong>
        </div>
        <div class="card-body p-0">
            <table class="table table-bordered mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Nama Produk</th>
                        <th>Kategori</th>
                        <th>Stok</th>
                        <th>Harga Jual</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($stokProduk as $produk)
                    <tr>
                        <td>{{ $produk->nama_produk }}</td>
                        <td>{{ $produk->kategoriProduk->nama_kategori_produk ?? '-' }}</td>
                        <td>{{ $produk->stok }}</td>
                        <td>Rp {{ number_format($produk->harga_jual, 0, ',', '.') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center">Tidak ada produk tersedia.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>