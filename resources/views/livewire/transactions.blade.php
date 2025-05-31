<div wire:poll.3s>
    {{-- FILTER TANGGAL --}}
    <div class="row mb-3">
        <div class="col-md-4">
            <input type="date" class="form-control" wire:model.defer="startDate">
        </div>
        <div class="col-md-4">
            <input type="date" class="form-control" wire:model.defer="endDate">
        </div>
        <div class="col-md-2">
            <button class="btn btn-primary btn-block" wire:click="filterTanggal">
                <i class="fas fa-filter"></i> Filter
            </button>
        </div>
        <div class="col-md-2">
            <button class="btn btn-secondary btn-block" wire:click="resetFilter">
                <i class="fas fa-sync-alt"></i> Reset
            </button>
        </div>
    </div>

    {{-- TOTAL PENDAPATAN --}}
    <div class="alert alert-success text-center font-weight-bold">
        💵 Total Pendapatan: Rp{{ number_format($totalPendapatan, 0, ',', '.') }}
    </div>

    {{-- JIKA TIDAK ADA TRANSAKSI --}}
    @if($orders->isEmpty())
        <div class="alert alert-info text-center">
            Belum ada transaksi.
        </div>
    @else
        {{-- DAFTAR ORDER --}}
        @foreach($orders as $order)
        <div class="card mb-4 shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <strong>Order ID: {{ $order->id }}</strong><br>
                    👤 {{ $order->user->name ?? 'Guest' }}<br>
                    💰 <strong>Rp {{ number_format($order->total, 0, ',', '.') }}</strong><br>
                    📅 {{ \Carbon\Carbon::parse($order->created_at)->isoFormat('dddd, D MMMM Y [⏱️] HH:mm') }}
                </div>
                <div class="text-right">
                    <span class="badge badge-{{ $order->status === 'paid' ? 'success' : 'warning' }}">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>
            </div>

            <div class="card-body">
                <table class="table table-sm table-bordered mb-3">
                    <thead class="thead-light">
                        <tr>
                            <th>Produk</th>
                            <th>Harga</th>
                            <th>Qty</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->items as $item)
                        <tr>
                            <td>@ {{ $item->produk->nama_produk ?? 'Produk tidak ditemukan' }}</td>
                            <td>Rp{{ number_format($item->harga, 0, ',', '.') }}</td>
                            <td>{{ $item->jumlah }}</td>
                            <td>Rp{{ number_format($item->harga * $item->jumlah, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                        <tr class="font-weight-bold">
                            <td colspan="3" class="text-right"><strong>Total Bayar:</strong></td>
                            <td><strong>Rp{{ number_format($order->total, 0, ',', '.') }}</strong></td>
                        </tr>
                    </tbody>
                </table>

                {{-- FORM PEMBAYARAN --}}
                @if($order->status === 'pending')
                <div class="row">
                    <div class="col-md-4">
                        <input type="number" class="form-control" placeholder="Jumlah Bayar"
                            wire:model.defer="jumlahBayar.{{ $order->id }}">
                    </div>
                    <div class="col-md-4">
                        <input type="text" class="form-control" placeholder="Kembalian" readonly
                            value="Rp{{ number_format($kembalian[$order->id] ?? 0, 0, ',', '.') }}">
                    </div>
                    <div class="col-md-4">
                        <button class="btn btn-success btn-block" wire:click="bayar({{ $order->id }})">
                            <i class="fas fa-money-bill-wave"></i> Bayar Sekarang
                        </button>
                    </div>
                </div>
                @elseif($order->status === 'paid')
                <div class="row mt-3">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Jumlah Dibayar:</label>
                            <input type="text" class="form-control" readonly
                                value="Rp{{ number_format($order->jumlah_bayar, 0, ',', '.') }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Kembalian:</label>
                            <input type="text" class="form-control" readonly
                                value="Rp{{ number_format($order->kembalian, 0, ',', '.') }}">
                        </div>
                    </div>
                    <div class="col-md-4 text-right d-flex align-items-end justify-content-end">
                        <a href="{{ route('cetak-struk', $order->id) }}" target="_blank" class="btn btn-primary btn-sm">
                            <i class="fas fa-print"></i> Cetak Struk
                        </a>
                    </div>
                </div>
                @endif
            </div>
        </div>
        @endforeach
    @endif
</div>
