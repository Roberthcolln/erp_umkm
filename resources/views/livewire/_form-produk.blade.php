<div class="form-group mb-2">
    <label>Nama Produk</label>
    <input type="text" wire:model.defer="nama_produk" class="form-control">
    @error('nama_produk') <span class="text-danger">{{ $message }}</span> @enderror
</div>

<div class="form-group mb-2">
    <label>Stok</label>
    <input type="number" wire:model.defer="stok" class="form-control" min="0">
    @error('stok') <span class="text-danger">{{ $message }}</span> @enderror
</div>

<div class="form-group mb-2">
    <label>Kategori Produk</label>
    <select wire:model.defer="id_kategori_produk" class="form-control">
        <option value="">-- Pilih Kategori --</option>
        @foreach ($kategori_produk as $kategori)
        <option value="{{ $kategori->id_kategori_produk }}">{{ $kategori->nama_kategori_produk }}</option>
        @endforeach
    </select>
    @error('id_kategori_produk') <span class="text-danger">{{ $message }}</span> @enderror
</div>

<div class="form-group mb-2">
    <label>Harga Produk</label>
    <input type="number" wire:model.defer="harga_produk" class="form-control">
    @error('harga_produk') <span class="text-danger">{{ $message }}</span> @enderror
</div>

<div class="form-group mb-2">
    <label>Harga Jual</label>
    <input type="number" wire:model.defer="harga_jual" class="form-control">
    @error('harga_jual') <span class="text-danger">{{ $message }}</span> @enderror
</div>

<div class="form-group mb-2">
    <label>Deskripsi Produk</label>
    <textarea wire:model.defer="deskripsi_produk" class="form-control" rows="3"></textarea>
    @error('deskripsi_produk') <span class="text-danger">{{ $message }}</span> @enderror
</div>

<div class="form-group mb-3">
    <label>Foto Produk (opsional)</label>
    <input type="file" wire:model="foto_produk" class="form-control">
    @error('foto_produk') <span class="text-danger">{{ $message }}</span> @enderror

    @if ($foto_produk)
    <div class="mt-2">
        Preview: <br>
        <img src="{{ $foto_produk->temporaryUrl() }}" width="150" />
    </div>
    @endif
</div>
