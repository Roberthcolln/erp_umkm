<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\KategoriProduk;

class KategoriProdukForm extends Component
{
    public $nama_kategori_produk;
    public $kategoriList;
    public $editMode = false;
    public $kategoriId;

    protected $rules = [
        'nama_kategori_produk' => 'required|string|max:255',
    ];

    public function mount()
    {
        $this->loadKategori();
    }

    public function loadKategori()
    {
        $this->kategoriList = KategoriProduk::orderByDesc('id_kategori_produk')->get();
    }

    public function save()
    {
        $this->validate();

        if ($this->editMode) {
            $kategori = KategoriProduk::find($this->kategoriId);
            $kategori->update(['nama_kategori_produk' => $this->nama_kategori_produk]);
            session()->flash('message', 'Kategori berhasil diupdate.');
        } else {
            KategoriProduk::create(['nama_kategori_produk' => $this->nama_kategori_produk]);
            session()->flash('message', 'Kategori berhasil ditambahkan.');
        }

        $this->resetForm();
        $this->loadKategori();
    }

    public function edit($id)
    {
        $kategori = KategoriProduk::find($id);
        $this->kategoriId = $kategori->id_kategori_produk;
        $this->nama_kategori_produk = $kategori->nama_kategori_produk;
        $this->editMode = true;
    }

    public function delete($id)
    {
        KategoriProduk::destroy($id);
        session()->flash('message', 'Kategori berhasil dihapus.');
        $this->loadKategori();
    }

    public function resetForm()
    {
        $this->nama_kategori_produk = '';
        $this->editMode = false;
        $this->kategoriId = null;
    }

    public function render()
    {
        return view('livewire.kategori-produk-form');
    }
}
