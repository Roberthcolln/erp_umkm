<div>
    <h3 class="mb-3">{{ $editMode ? 'Edit Kategori Produk' : 'Tambah Kategori Produk' }}</h3>

    @if (session()->has('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif

    <form wire:submit.prevent="save">
        <div class="form-group">
            <input type="text" wire:model="nama_kategori_produk" class="form-control" placeholder="Nama Kategori Produk">
            @error('nama_kategori_produk') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <button class="btn btn-primary mt-2" type="submit">
            {{ $editMode ? 'Update' : 'Simpan' }}
        </button>
        @if ($editMode)
            <button type="button" wire:click="resetForm" class="btn btn-secondary mt-2">Batal</button>
        @endif
    </form>

    <hr>

    <h5>Daftar Kategori Produk</h5>
    <table class="table table-bordered mt-2">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Kategori</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($kategoriList as $index => $kategori)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $kategori->nama_kategori_produk }}</td>
                    <td>
                        <button wire:click="edit({{ $kategori->id_kategori_produk }})" class="btn btn-sm btn-info">Edit</button>
                        <button wire:click="delete({{ $kategori->id_kategori_produk }})" class="btn btn-sm btn-danger" onclick="return confirm('Yakin?')">Hapus</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
