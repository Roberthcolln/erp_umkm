<div>
    @if (session()->has('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Form Input Pengeluaran -->
    <div class="card mb-4 p-3 border">
        <form wire:submit.prevent="simpan">
            <div class="form-group mb-3">
                <label>Tanggal</label>
                <input type="date" wire:model="tanggal" class="form-control">
                @error('tanggal') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="form-group mb-3">
                <label>Nama Barang</label>
                <input type="text" wire:model="nama_barang" class="form-control">
                @error('nama_barang') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="form-group mb-3">
                <label>Jumlah</label>
                <input type="number" wire:model="jumlah" class="form-control">
                @error('jumlah') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="form-group mb-3">
                <label>Harga Satuan</label>
                <input type="number" step="0.01" wire:model="harga_satuan" class="form-control">
                @error('harga_satuan') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="form-group mb-3">
                <label>Keterangan</label>
                <textarea wire:model="keterangan" class="form-control"></textarea>
            </div>

            <button type="submit" class="btn btn-success">
                {{ $editId ? 'Update' : 'Simpan' }}
            </button>

        </form>
    </div>
    <div class="mb-3">
        <label>Filter Tanggal</label>
        <div class="d-flex gap-2">
            <input type="date" wire:model="filterTanggalAwal" class="form-control" placeholder="Tanggal Awal">
            <input type="date" wire:model="filterTanggalAkhir" class="form-control" placeholder="Tanggal Akhir">
            <button wire:click="loadPengeluaran" class="btn btn-primary">Filter</button>
            <button wire:click="resetFilter" class="btn btn-secondary">Reset</button>
        </div>
    </div>

    <!-- Tabel Pengeluaran -->
    <div class="card p-3 border">
        
        <table class="table table-bordered table-striped mt-3">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Tanggal</th>
                    <th>Nama</th>
                    <th>Jumlah</th>
                    <th>Harga Satuan</th>
                    <th>Total</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php $totalHargaKeseluruhan = 0; @endphp
                @forelse ($pengeluarans as $i => $p)
                @php $totalHargaKeseluruhan += $p->total_harga; @endphp
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($p->tanggal)->format('d-m-Y') }}</td>
                    <td>{{ $p->nama_barang }}</td>
                    <td>{{ $p->jumlah }}</td>
                    <td>Rp {{ number_format($p->harga_satuan, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($p->total_harga, 0, ',', '.') }}</td>
                    <td>{{ $p->keterangan }}</td>
                    <td>
                        <button wire:click="edit({{ $p->id }})" class="btn btn-sm btn-warning">Edit</button>
                        <button wire:click="hapus({{ $p->id }})" class="btn btn-sm btn-danger" onclick="confirm('Yakin hapus data ini?') || event.stopImmediatePropagation()">Hapus</button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center text-muted">Belum ada data pengeluaran.</td>
                </tr>
                @endforelse
                @if($pengeluarans->count())
                <tr class="table-secondary">
                    <td colspan="5" class="text-end fw-bold">Total Biaya Pengeluaran:</td>
                    <td><strong>Rp {{ number_format($totalHargaKeseluruhan, 0, ',', '.') }}</strong></td>
                    <td colspan="2"></td>
                </tr>
                @endif
            </tbody>

        </table>
    </div>
</div>