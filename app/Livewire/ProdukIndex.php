<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Produk;
use App\Models\KategoriProduk;
use Livewire\WithFileUploads;
use Stringable;
use Illuminate\Support\Str;

class ProdukIndex extends Component
{
    use WithPagination, WithFileUploads;

    public $filterKategori = null;
    public $editMode = false;
    public $showMode = false;
    public $produkId;
    public $produkTampil;

    // Properti form tambah produk
    public $nama_produk, $stok, $id_kategori_produk, $foto_produk, $harga_produk, $deskripsi_produk, $harga_jual, $slug_produk;

    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['deleteProduk'];

    // Validasi input form tambah
    protected $rules = [
        'nama_produk' => 'required|string|max:255',
        'stok' => 'required|integer|min:0',
        'id_kategori_produk' => 'required|exists:kategori_produk,id_kategori_produk',
        'harga_produk' => 'nullable|integer|min:0',
        'harga_jual' => 'nullable|integer|min:0',
        'deskripsi_produk' => 'nullable|string',
        'foto_produk' => 'nullable|image|max:2048',
        'slug_produk' => 'nullable|string|max:255',

    ];


    public function updatingFilterKategori()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Produk::with('kategoriProduk')->orderByDesc('id_produk');

        if ($this->filterKategori) {
            $query->where('id_kategori_produk', $this->filterKategori);
        }

        $produk = $query->paginate(10);
        $kategori_produk = KategoriProduk::all();

        return view('livewire.produk-index', compact('produk', 'kategori_produk'));
    }

    public function deleteProduk($id)
    {
        $produk = Produk::findOrFail($id);

        $fotoPath = storage_path('app/public/produk/' . $produk->foto_produk);
        if (file_exists($fotoPath)) {
            @unlink($fotoPath);
        }

        $produk->delete();

        session()->flash('Sukses', 'Berhasil Hapus Produk');
    }



    // Tambah method simpan produk baru
    public function simpanProduk()
    {
        $this->validate();

        $fotoNama = null;
        if ($this->foto_produk) {
            $fotoNama = time() . '.' . $this->foto_produk->extension();

            $this->foto_produk->storeAs('produk', $fotoNama, 'public');
        }

        Produk::create([
            'nama_produk' => $this->nama_produk,
            'slug_produk' => $this->slug_produk ?: Str::slug($this->nama_produk),
            'stok' => $this->stok,
            'id_kategori_produk' => $this->id_kategori_produk,
            'foto_produk' => $fotoNama,
            'harga_produk' => $this->harga_produk,
            'harga_jual' => $this->harga_jual,
            'deskripsi_produk' => $this->deskripsi_produk,
        ]);



        $this->reset([
            'nama_produk',
            'stok',
            'id_kategori_produk',
            'foto_produk',
            'harga_produk',
            'harga_jual',
            'deskripsi_produk',
        ]);

        $this->resetPage();

        session()->flash('Sukses', 'Produk berhasil ditambahkan!');
    }

    public function editProduk($id)
    {
        $produk = Produk::findOrFail($id);
        $this->produkId = $produk->id_produk;
        $this->nama_produk = $produk->nama_produk;
        $this->stok = $produk->stok;
        $this->id_kategori_produk = $produk->id_kategori_produk;
        $this->harga_produk = $produk->harga_produk;
        $this->harga_jual = $produk->harga_jual;
        $this->deskripsi_produk = $produk->deskripsi_produk;
        $this->slug_produk = $produk->slug_produk;


        $this->editMode = true;
        $this->showMode = false;
    }

    public function updateProduk()
    {
        $this->validate();

        $produk = Produk::findOrFail($this->produkId);

        // Handle foto baru jika ada
        if ($this->foto_produk) {
            $fotoNama = time() . '.' . $this->foto_produk->extension();
            $this->foto_produk->storeAs('produk', $fotoNama, 'public');

            // hapus foto lama
            if ($produk->foto_produk && file_exists(storage_path('app/public/produk/' . $produk->foto_produk))) {
                @unlink(storage_path('app/public/produk/' . $produk->foto_produk));
            }

            $produk->foto_produk = $fotoNama;
        }

        $produk->update([
            'nama_produk' => $this->nama_produk,
            'slug_produk' => $this->slug_produk ?: Str::slug($this->nama_produk),
            'stok' => $this->stok,
            'id_kategori_produk' => $this->id_kategori_produk,
            'harga_produk' => $this->harga_produk,
            'harga_jual' => $this->harga_jual,
            'deskripsi_produk' => $this->deskripsi_produk,
            'foto_produk' => $produk->foto_produk,
        ]);


        $this->resetForm();
        session()->flash('Sukses', 'Produk berhasil diupdate!');
    }

    public function showProduk($id)
    {
        $this->produkTampil = Produk::with('kategoriProduk')->findOrFail($id);
        $this->showMode = true;
        $this->editMode = false;
    }

    public function resetForm()
    {
        $this->reset([
            'nama_produk',
            'stok',
            'id_kategori_produk',
            'harga_produk',
            'harga_jual',
            'deskripsi_produk',
            'foto_produk',
            'slug_produk',
            'produkId',
            'editMode',
            'showMode',
            'produkTampil'
        ]);
    }
}
