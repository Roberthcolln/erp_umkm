<div>
    @if (session()->has('Sukses'))
        <div class="alert alert-success">{{ session('Sukses') }}</div>
    @endif

    <!-- Form Tambah Produk -->
    @if (!$editMode && !$showMode)
    <div class="card mb-4 p-3 border">
        <h5>Tambah Produk Baru</h5>
        <form wire:submit.prevent="simpanProduk">
            @include('livewire._form-produk')
            <button type="submit" class="btn btn-success">Tambah Produk</button>
        </form>
    </div>
    @endif

    <!-- Form Edit Produk -->
    @if ($editMode)
    <div class="card mb-4 p-3 border">
        <h5>Edit Produk</h5>
        <form wire:submit.prevent="updateProduk">
            @include('livewire._form-produk')
            <button type="submit" class="btn btn-primary">Update Produk</button>
            <button type="button" class="btn btn-secondary" wire:click="resetForm">Batal</button>
        </form>
    </div>
    @endif

    <!-- Show Produk -->
    @if ($showMode && $produkTampil)
    <div class="card mb-4 p-3 border">
        <h5>Detail Produk</h5>
        <p><strong>Nama:</strong> {{ $produkTampil->nama_produk }}</p>
        <p><strong>Stok:</strong> {{ $produkTampil->stok }}</p>
        <p><strong>Kategori:</strong> {{ $produkTampil->kategoriProduk->nama_kategori_produk ?? '-' }}</p>
        <p><strong>Harga:</strong> Rp {{ number_format($produkTampil->harga_produk, 0, ',', '.') }}</p>
        <p><strong>Harga Jual:</strong> Rp {{ number_format($produkTampil->harga_jual, 0, ',', '.') }}</p>
        <p><strong>Deskripsi:</strong><br> {!! $produkTampil->deskripsi_produk !!}</p>
        @if ($produkTampil->foto_produk)
            <img src="{{ asset('storage/produk/' . $produkTampil->foto_produk) }}" width="150">
        @endif
        <br>
        <button type="button" class="btn btn-secondary mt-2" wire:click="resetForm">Tutup</button>
    </div>
    @endif

    <!-- Filter dan tabel produk tetap seperti sebelumnya -->
    <div class="mb-3">
        <select wire:model="filterKategori" class="form-control" style="width: 200px;">
            <option value="">-- Semua Kategori --</option>
            @foreach ($kategori_produk as $kategori)
            <option value="{{ $kategori->id_kategori_produk }}">{{ $kategori->nama_kategori_produk }}</option>
            @endforeach
        </select>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Produk</th>
                <th>Deskripsi</th>
                <th>Harga Produk</th>
                <th>Harga Jual</th>
                <th>Stok</th>
                <th>Foto</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
    @foreach ($produk as $index => $item)
    <tr class="{{ $item->stok == 0 ? 'table-danger' : ($item->stok <= 5 ? 'table-warning' : '') }}">
        <td>{{ $produk->firstItem() + $index }}</td>
        <td>{{ $item->nama_produk }}</td>
        <td>{!! $item->deskripsi_produk !!}</td>
        <td>Rp. {{ number_format($item->harga_produk, 0, ',', '.') }}</td>
        <td>Rp. {{ number_format($item->harga_jual, 0, ',', '.') }}</td>
        
        <td>
            @if ($item->stok == 0)
                <span class="badge badge-danger">Stok Habis</span>
            @elseif ($item->stok <= 5)
                <span class="badge badge-warning">Stok Menipis ({{ $item->stok }})</span>
            @else
                {{ $item->stok }}
            @endif
        </td>

        <td>
            @if ($item->foto_produk)
                <img src="{{ asset('storage/produk/' . $item->foto_produk) }}" width="100" alt="Foto Produk">
            @else
                <em>Tidak ada foto</em>
            @endif
        </td>

        <td>
            <button wire:click="showProduk({{ $item->id_produk }})" class="btn btn-warning btn-sm">Show</button>
            <button wire:click="editProduk({{ $item->id_produk }})" class="btn btn-primary btn-sm">Edit</button>
            <button onclick="confirmDelete({{ $item->id_produk }})" class="btn btn-danger btn-sm">Hapus</button>
        </td>
    </tr>
    @endforeach
</tbody>

    </table>

    {{ $produk->links() }}
</div>

@push('scripts')
<script>
    function confirmDelete(id) {
        if (confirm('Yakin ingin menghapus produk ini?')) {
            Livewire.dispatch('deleteProduk', { id: id });
        }
    }
</script>
@endpush
